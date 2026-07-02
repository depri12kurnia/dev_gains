<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_report extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_combined_report($category = null)
    {
        $this->db->select('
            submissions.id AS submission_id,
            submissions.title,
            submissions.team_leader,
            submissions.institution,
            submissions.category,
            submissions.status AS global_status,
            COUNT(evaluations.id) AS total_juri_menilai,
            AVG(evaluations.total_score) AS nilai_rata_rata
        ');
        $this->db->from('submissions');

        // Join ke tabel evaluations untuk menarik nilai juri-juri
        $this->db->join('evaluations', 'evaluations.submission_id = submissions.id', 'left');

        // Join ke screenings panitia untuk memastikan hanya berkas lolos administrasi yang dihitung
        $this->db->join('screenings', 'screenings.submission_id = submissions.id', 'left');
        $this->db->where('screenings.screening_status', 'Qualified');

        // Filter dinamis jika admin memilih kategori tertentu (IRPC / AHIC / E2IPBC)
        if (!empty($category)) {
            $this->db->where('LOWER(submissions.category)', strtolower($category));
        }

        // Kelompokkan data berdasarkan ID Submission agar baris tidak duplikat
        $this->db->group_by('submissions.id');

        // Urutkan berdasarkan nilai rata-rata tertinggi untuk menentukan peringkat juara
        $this->db->order_by('nilai_rata_rata', 'DESC');

        return $this->db->get()->result_array();
    }

    // model untuk mengambil data evaluations berdasarkan ID Submission
    public function get_evaluations_by_submission_id($submission_id)
    {
        return $this->db->get_where('evaluations', ['submission_id' => $submission_id])->result_array();
    }

    public function get_evaluation_update($evaluation_id)
    {
        return $this->db->get_where('evaluations', ['id' => $evaluation_id])->row_array();
    }

    /**
     * Memproses penentuan akhir kelulusan oleh Admin Utama
     * Mengubah status submission menjadi finalist/not selected,
     * serta memperbarui total_score rata-rata dan keputusan final di tabel evaluations.
     */
    public function set_final_decision($submission_id, $decision_type)
    {
        $this->db->trans_start();

        // 1. HITUNG RATA-RATA TOTAL SCORE DARI SEMUA JURI TERLEBIH DAHULU
        // Kita ambil nilai AVG dari juri-juri yang sudah menginput nilai untuk berkas ini
        $this->db->select('AVG(total_score) as rata_rata');
        $this->db->from('evaluations');
        $this->db->where('submission_id', $submission_id);
        $query = $this->db->get()->row();

        // Jika belum ada juri yang menilai sama sekali, set default ke 0.00
        $nilai_gabungan = ($query && $query->rata_rata !== null) ? $query->rata_rata : 0.00;

        // 2. Tentukan pemetaan string status berdasarkan keputusan Admin
        // Tentukan pemetaan string status
        if ($decision_type === 'finalist') {
            $status_submission = 'finalist';
            $final_decision    = 'Qualified for the Final Round';
            $status_revisi     = '0';
        } elseif ($decision_type === 'not_selected') {
            $status_submission = 'not_selected';
            $final_decision    = 'Not Qualified';
            $status_revisi     = '0';
        } else {
            // JIKA DI-RESET KEMBALI KEAWAL (data-action="submitted")
            $status_submission = 'submitted';
            $final_decision    = 'submitted';
            $status_revisi     = '0';
        }

        // 3. Update status global berkas peserta pada tabel submissions
        $this->db->where('id', $submission_id)->update('submissions', [
            'status'        => $status_submission,
            'status_revisi' => $status_revisi
        ]);

        // 4. Update keputusan final DAN total_score rata-rata gabungan di semua penilaian juri terkait
        $this->db->where('submission_id', $submission_id)->update('evaluations', [
            'total_score'    => $nilai_gabungan, // Menyimpan nilai gabungan rata-rata ke semua baris juri berkas ini
            'final_decision' => $final_decision
        ]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_evaluation_details($evaluation_id)
    {
        $this->db->select('evaluation_details.*, assessment_components.component_name, assessment_components.weight');
        $this->db->from('evaluation_details');
        $this->db->join('assessment_components', 'assessment_components.id = evaluation_details.component_id');
        $this->db->where('evaluation_details.evaluation_id', $evaluation_id);
        return $this->db->get()->result_array();
    }
}
