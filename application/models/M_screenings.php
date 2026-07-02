<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_screenings extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    var $table = 'submissions';

    // Tambahkan kolom screenings ke column_order & column_search agar bisa di-sort dan di-search via DataTables
    var $column_order = array(
        'submissions.id',
        'submissions.user_id',
        'submissions.team_leader',
        'submissions.leader_titles',
        'submissions.institution',
        'submissions.country',
        'submissions.partType',
        'submissions.crossCollab',
        'submissions.team_members',
        'submissions.category',
        'submissions.title',
        'submissions.focus_area',
        'submissions.alignment_theme',
        'submissions.link',
        'submissions.supporting_links',
        'submissions.status',
        'screenings.total_score',
        'screenings.final_decision'
    );

    var $column_search = array(
        'submissions.user_id',
        'submissions.team_leader',
        'submissions.leader_titles',
        'submissions.institution',
        'submissions.country',
        'submissions.partType',
        'submissions.crossCollab',
        'submissions.team_members',
        'submissions.category',
        'submissions.title',
        'submissions.focus_area',
        'submissions.alignment_theme',
        'submissions.link',
        'submissions.supporting_links',
        'submissions.status',
        'screenings.final_decision'
    );

    var $order = array('submissions.id' => 'desc');

    private function _get_datatables_query()
    {
        // Select kolom submission, email dari user, dan total_score + decision dari hasil screenings berbobot
        $this->db->select('
            submissions.*, 
            users.email, 
            screenings.total_score, 
            screenings.screening_status,
            screenings.notes
        ');
        $this->db->from($this->table);
        // Menggunakan LEFT JOIN karena user_id di tabel submissions diizinkan NULL
        $this->db->join('users', 'users.id = submissions.user_id', 'left');
        // LEFT JOIN ke tabel screenings untuk menarik data skor akhir
        $this->db->join('screenings', 'screenings.submission_id = submissions.id', 'left');

        $i = 0;
        foreach ($this->column_search as $item) {
            if (isset($_POST['search']['value']) && $_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++; // Posisikan i++ di luar if search value agar increment index filter berjalan normal
        }

        // Handle Ordering
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

        // Custom Filter Server-side: Category
        if (!empty($_POST['category'])) {
            $this->db->where('submissions.category', $_POST['category']);
        }

        // Custom Filter Server-side: Status
        if (!empty($_POST['status'])) {
            $this->db->where('submissions.status', $_POST['status']);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if (isset($_POST['length']) && $_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_user($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->get($this->table)
            ->row();
    }

    public function get_by_id($id)
    {
        $this->db->select('submissions.*, users.email, screenings.total_score, screenings.screening_status, screenings.notes');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = submissions.user_id', 'left');
        $this->db->join('screenings', 'screenings.submission_id = submissions.id', 'left');
        $this->db->where('submissions.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    /* =========================================================================
       CORE LOGIC: WEIGHTED SCORE CALCULATION & screenings MANAGEMENT
       ========================================================================= */

    // Mengambil komponen aktif dari tabel master kriteria
    public function get_active_components()
    {
        return $this->db->order_by('id', 'ASC')
            ->get_where('assessment_components', ['is_active' => 1])
            ->result_array();
    }

    public function get_components_by_category($category)
    {
        return $this->db->where('is_active', 1)
            ->where('category_code', $category) // Menyaring kriteria berdasarkan kategori kompetensi aktif
            ->order_by('id', 'ASC')
            ->get('assessment_components')
            ->result_array();
    }

    // Mengambil detail nilai per komponen yang sudah pernah diinput (untuk edit/view)
    public function get_screenings_details($screening_id)
    {
        $this->db->select('screenings_details.*, assessment_components.component_name, assessment_components.weight');
        $this->db->from('screenings_details');
        $this->db->join('assessment_components', 'assessment_components.id = screenings_details.component_id');
        $this->db->where('screenings_details.screening_id', $screening_id);
        return $this->db->get()->result_array();
    }

    // Proses core calculation dan penyimpanan transaksi data multi-tabel
    public function save_screenings($post_data, $user_id = NULL)
    {
        $submission_id      = $post_data['submission_id'];
        $screening_status   = $post_data['screening_status'];
        $notes              = $post_data['notes'];
        $scores             = $post_data['scores'];

        // 1. Ambil bobot komponen aktif untuk basis perhitungan
        $components = $this->get_active_components();
        $component_weights = [];
        foreach ($components as $c) {
            $component_weights[$c['id']] = $c['weight'];
        }

        // 2. Kalkulasi Skor Berbobot (Weighted Score Formula)
        $total_score = 0;
        foreach ($scores as $component_id => $score) {
            if (isset($component_weights[$component_id])) {
                $weight = $component_weights[$component_id];
                // Rumus: (Skor / Skala_Max_5) * Bobot_Komponen
                $weighted_component = ($score / 5) * $weight;
                $total_score += $weighted_component;
            }
        }

        // Penentuan standardisasi kelulusan (Bisa Anda sesuaikan nilainya, misal >= 75)
        $screening_decision = ($total_score >= 70) ? 'Qualified' : 'Not Qualified';

        // Mulai Database Transaction ACID Guard
        $this->db->trans_start();

        // 3. Cek eksistensi screenings (Gunakan mekanisme Upsert)
        $existing = $this->db->get_where('screenings', ['submission_id' => $submission_id])->row();

        $screenings_data = [
            'submission_id'     => $submission_id,
            'user_id'           => $user_id,
            'total_score'       => $total_score,
            'notes'             => $notes,
            'screening_status'  => $screening_decision,
        ];

        if ($existing) {
            $screening_id = $existing->id;
            $this->db->where('id', $screening_id)->update('screenings', $screenings_data);

            // Wipe out detail lama untuk digantikan record kalkulasi baru
            $this->db->where('screening_id', $screening_id)->delete('screenings_details');
        } else {
            $this->db->insert('screenings', $screenings_data);
            $screening_id = $this->db->insert_id();
        }

        // 4. Batch Insert detail skor komponen
        $details = [];
        foreach ($scores as $component_id => $score) {
            $details[] = [
                'screening_id' => $screening_id,
                'component_id'  => $component_id,
                'score'         => (int)$score
            ];
        }
        $this->db->insert_batch('screenings_details', $details);

        // 5. Update status di tabel master submissions secara sinkron
        $status_submission = ($total_score >= 70) ? 'Qualified' : 'Not Qualified';
        $this->db->where('id', $submission_id)->update($this->table, ['status' => $status_submission]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
