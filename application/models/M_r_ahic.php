<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_r_ahic extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    var $table = 'submissions';

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
        'evaluations.total_score',
        'evaluations.final_decision'
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
        'evaluations.final_decision'
    );

    var $order = array('submissions.id' => 'desc');

    private function _get_datatables_query()
    {
        // 1. Ambil ID Juri/Assessor yang sedang login dari session Ion Auth secara aman
        $current_user = $this->ion_auth->user()->row();
        $current_assessor_id = $current_user ? $current_user->id : 0;

        $this->db->select('
        submissions.*, 
        users.email, 
        evaluations.total_score, 
        evaluations.final_decision, 
        evaluations.key_strengths,
        evaluations.key_weaknesses,
        evaluations.recommendations,
        evaluations.recommendation_status,
        screenings.screening_status
    ');
        $this->db->from($this->table);

        $this->db->join('users', 'users.id = submissions.user_id', 'left');

        /* * 2. PERBAIKAN UTAMA: Kunci LEFT JOIN menggunakan kondisi ON ganda!
     * Kita batasi agar baris yang di-join HANYA data penilaian milik juri yang sedang login.
     * Ini akan mencegah duplikasi baris meskipun submission sudah dinilai oleh 3-4 juri lain.
     */
        $this->db->join('evaluations', 'evaluations.submission_id = submissions.id AND evaluations.assessor_id = ' . (int)$current_assessor_id, 'left');

        // 3. Join ke tabel committee_screenings hasil validasi administrasi panitia
        $this->db->join('screenings', 'screenings.submission_id = submissions.id', 'left');

        $this->db->where('submissions.category', 'AHIC');
        $this->db->where('screenings.screening_status', 'Qualified');

        // Filter pencarian bawaan DataTables
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
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
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
        $this->db->select('submissions.*, users.email, evaluations.total_score, evaluations.final_decision, evaluations.key_strengths, evaluations.key_weaknesses, evaluations.recommendations, evaluations.recommendation_status');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = submissions.user_id', 'left');
        $this->db->join('evaluations', 'evaluations.submission_id = submissions.id', 'left');
        $this->db->where('submissions.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    /* =========================================================================
       CORE LOGIC: WEIGHTED SCORE CALCULATION & EVALUATION MANAGEMENT
       ========================================================================= */

    public function get_components_by_category($category)
    {
        return $this->db->where('is_active', 1)
            ->where('category_code', strtolower($category))
            ->order_by('id', 'ASC')
            ->get('assessment_components')
            ->result_array();
    }

    public function get_evaluation_details($evaluation_id)
    {
        $this->db->select('evaluation_details.*, assessment_components.component_name, assessment_components.weight');
        $this->db->from('evaluation_details');
        $this->db->join('assessment_components', 'assessment_components.id = evaluation_details.component_id');
        $this->db->where('evaluation_details.evaluation_id', $evaluation_id);
        return $this->db->get()->result_array();
    }

    /**
     * CORE UPSERT & CALCULATION - FIX SECURITY & MULTI JUDGES
     */
    public function save_evaluation($post_data, $assessor_id = NULL)
    {
        if ($assessor_id === NULL) {
            return FALSE;
        }

        $submission_id         = $post_data['submission_id'];
        $key_strengths         = $post_data['key_strengths']; // Sesuaikan dengan key name form terbaru
        $key_weaknesses        = $post_data['key_weaknesses'];
        $recommendations       = $post_data['recommendations'];
        $recommendation_status = $post_data['recommendation_status'];
        $scores                = $post_data['scores'];

        // 1. PERBAIKAN: Ambil data submission untuk tahu kategori pastinya (contoh: 'ahic')
        $submission = $this->db->get_where('submissions', ['id' => $submission_id])->row();
        if (!$submission) return FALSE;

        // 2. PERBAIKAN: Ambil kriteria spesifik kategori aktif saja (menghindari salah kalkulasi bobot)
        $components = $this->get_components_by_category($submission->category);
        $component_weights = [];
        foreach ($components as $c) {
            $component_weights[$c['id']] = $c['weight'];
        }

        // 3. Kalkulasi Skor Berbobot
        $total_score = 0;
        foreach ($scores as $component_id => $score) {
            if (isset($component_weights[$component_id])) {
                $weight = $component_weights[$component_id];
                // Rumus GAINS 2026: (Skor / 5) * Bobot
                $weighted_component = ((int)$score / 5) * $weight;
                $total_score += $weighted_component;
            }
        }

        // // Standardisasi keputusan otomatis
        // if ($total_score >= 75) {
        //     $final_decision = 'Qualified for the Final Round';
        // } elseif ($total_score >= 65) {
        //     $final_decision = 'Qualified with Minor Revisions';
        // } else {
        //     $final_decision = 'Not Qualified';
        // }

        // Mulai Database Transaction Guard
        $this->db->trans_start();

        // 4. PERBAIKAN: Cari data lama berdasarkan kombinasi Submission ID DAN Assessor ID (Multi-Juri Safe)
        $existing = $this->db->get_where('evaluations', [
            'submission_id' => $submission_id,
            'assessor_id'   => $assessor_id
        ])->row();

        $evaluation_data = [
            'submission_id'         => $submission_id,
            'assessor_id'           => $assessor_id,
            'total_score'           => $total_score,
            // 'final_decision'        => $final_decision,
            'key_strengths'         => $key_strengths,
            'key_weaknesses'        => $key_weaknesses,
            'recommendations'       => $recommendations,
            'recommendation_status' => $recommendation_status,
        ];

        if ($existing) {
            $evaluation_id = $existing->id;
            $this->db->where('id', $evaluation_id)->update('evaluations', $evaluation_data);
            // Hapus detail lama milik juri ini saja
            $this->db->where('evaluation_id', $evaluation_id)->delete('evaluation_details');
        } else {
            $this->db->insert('evaluations', $evaluation_data);
            $evaluation_id = $this->db->insert_id();
        }

        // 5. Batch Insert detail skor komponen juri
        $details = [];
        foreach ($scores as $component_id => $score) {
            if (isset($component_weights[$component_id])) {
                $details[] = [
                    'evaluation_id' => $evaluation_id,
                    'component_id'  => $component_id,
                    'score'         => (int)$score
                ];
            }
        }
        if (!empty($details)) {
            $this->db->insert_batch('evaluation_details', $details);
        }

        // 6. Update status progress global berkas peserta
        // if ($recommendation_status == 'Qualified for the Final Round') {
        //     $status_submission = 'finalist';
        //     $status_revisi     = '0';
        // } elseif ($recommendation_status == 'Qualified with Minor Revisions') {
        //     $status_submission = 'revision';
        //     $status_revisi     = '1';
        // } else {
        //     $status_submission = 'not selected';
        //     $status_revisi     = '0';
        // }
        // $this->db->where('id', $submission_id)->update($this->table, [
        //     'status'        => $status_submission,
        //     'status_revisi' => $status_revisi
        // ]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
