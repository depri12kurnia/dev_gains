<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
        $this->load->model('M_report');

        // Proteksi ketat: Hanya Admin Utama yang boleh melihat laporan nilai gabungan
        if (!$this->ion_auth->in_group('admin')) {
            redirect('page_errors');
        }
    }

    public function combined_scores()
    {
        // Tangkap filter kategori jika ada input POST/GET dari user
        $category = $this->input->get('category');
        if (!in_array(strtoupper($category), ['IRPC', 'AHIC', 'E2IPBC'])) {
            $category = ''; // Kosong berarti menampilkan semua kategori gabungan
        }

        $data['current_category'] = $category;

        // Panggil fungsi pencatatan agregat rata-rata dari model
        $data['report_data'] = $this->M_report->get_combined_report($category);

        $data['website'] = $this->M_settings->get_all_settings();
        $data['title']   = 'Combined Jury Score Report | Admin Panel';
        $data['content'] = 'paneladmin/report/scores_view';
        $this->load->view('layouts/adminlte3', $data);
    }

    // untuk sweetalert mengambil data evaluation update total score dan final decision\
    public function get_evaluation_update($evaluation_id)
    {
        echo json_encode($this->M_report->get_evaluation_update($evaluation_id));
    }

    /**
     * URL: admin/report/set_status_finalist
     * Dipanggil via AJAX SweetAlert untuk mengunci keputusan kelulusan finalis
     */
    public function set_status_finalist()
    {
        // Proteksi Token CSRF
        $csrf_post = $this->input->post('csrf_token_jkt3');
        if (empty($csrf_post)) {
            $csrf_post = $this->input->server('HTTP_X_CSRF_TOKEN');
        }
        if ($csrf_post !== $this->security->get_csrf_hash()) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF Token Match.']);
            exit();
        }

        // Ambal parameter input
        $submission_id = $this->input->post('submission_id');
        $decision_type = $this->input->post('decision_type'); // 'finalist' or 'not_selected'

        if (empty($submission_id) || !in_array($decision_type, ['finalist', 'not_selected', 'submitted'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid parameters payload.']);
            exit();
        }

        // Jalankan update transaksional
        $process = $this->M_report->set_final_decision($submission_id, $decision_type);

        if ($process) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Submission status & final decision of all judges has been successfully updated..'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update status to database.'
            ]);
        }
    }

    public function detail_scores($submission_id)
    {
        // 1. Ambil info submission peserta
        $this->db->select('submissions.*, screenings.screening_status');
        $this->db->from('submissions');
        $this->db->join('screenings', 'screenings.submission_id = submissions.id', 'left');
        $this->db->where('submissions.id', $submission_id);
        $data['submission'] = $this->db->get()->row();

        if (!$data['submission']) {
            show_404();
        }

        // 2. Ambil data evaluations juri lengkap dengan nama juri asli
        $raw_evaluations = $this->db->select('e.*, u.first_name, u.last_name, u.email')
            ->from('evaluations e')
            ->join('users u', 'u.id = e.assessor_id', 'inner')
            ->where('e.submission_id', $submission_id)
            ->get()
            ->result_array();

        // 3. Suntikkan detail kriteria nilai 1-5 ke dalam masing-masing juri
        foreach ($raw_evaluations as $key => $eval) {
            $raw_evaluations[$key]['score_details'] = $this->M_report->get_evaluation_details($eval['id']);
        }

        $data['evaluations'] = $raw_evaluations;
        $data['website'] = $this->M_settings->get_all_settings();
        $data['title']   = 'Details of Judges Scores | Admin Panel';
        $data['content'] = 'paneladmin/report/detail_scores_view';
        $this->load->view('layouts/adminlte3', $data);
    }
}
