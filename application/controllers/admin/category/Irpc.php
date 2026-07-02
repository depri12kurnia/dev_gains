<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Irpc extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
        $this->load->model('M_r_irpc');
        $this->load->model('M_log_user');
        $this->load->model('M_users');

        if (!$this->ion_auth->in_group(array('admin', 'irpc'))) {
            redirect('admin/page_errors');
        }
    }

    public function index()
    {
        $data['website'] = $this->M_settings->get_all_settings();
        $data['groups'] = $this->M_users->get_groups();
        $data['title'] = 'Assessment IRPC Management | Admin Panel';
        $data['content'] = 'paneladmin/r_irpc/list';
        $this->load->view('layouts/adminlte3', $data);
    }

    public function ajax_list()
    {
        $this->validate_csrf();

        // 1. Ambal ID Juri yang sedang login saat ini secara aman
        $current_user = $this->ion_auth->user()->row();
        $current_assessor_id = $current_user->id;

        $list = $this->M_r_irpc->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $submission) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = htmlspecialchars($submission->title);
            $row[] = htmlspecialchars($submission->country);
            $row[] = htmlspecialchars($submission->category);

            // 2. AMBIL STATUS PENILAIAN PERSONAL JURI YANG SEDANG LOG IN
            // Query cepat untuk mengecek apakah juri ini sudah memberikan nilai untuk submission terkait
            $my_evaluation = $this->db->get_where('evaluations', [
                'submission_id' => $submission->id,
                'assessor_id'   => $current_assessor_id
            ])->row();

            // Render Kolom Skor: Menampilkan skor yang diberikan oleh Juri ini sendiri
            if ($my_evaluation) {
                $row[] = '<span class="badge badge-success p-2 font-weight-bold" style="font-size:0.85rem;"><i class="fas fa-check-circle mr-1"></i> ' . number_format($my_evaluation->total_score, 2) . '</span>';
            } else {
                $row[] = '<span class="badge badge-secondary p-2 font-weight-bold" style="font-size:0.85rem;"><i class="fas fa-clock mr-1"></i> Belum Dinilai</span>';
            }

            // Render Kolom Rekomendasi Juri Aktif (Dengan variasi warna kontekstual)
            if ($my_evaluation) {
                $status = $my_evaluation->recommendation_status;
                if ($status == 'Qualified for the Final Round') {
                    $row[] = '<span class="badge badge-success px-2 py-1"><i class="fas fa-trophy mr-1"></i> Final Round</span>';
                } elseif ($status == 'Qualified with Minor Revisions') {
                    $row[] = '<span class="badge badge-warning text-dark px-2 py-1"><i class="fas fa-tools mr-1"></i> Revision Required</span>';
                } else {
                    $row[] = '<span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i> Not Qualified</span>';
                }
            } else {
                $row[] = '<span class="text-muted font-italic">-</span>';
            }

            // Render Kolom Status Screening Panitia (Selalu Qualified karena yang masuk ke juri sudah tersaring)
            $row[] = '<span class="text-xs text-success font-weight-bold"><i class="fas fa-id-card-alt mr-1"></i> Passed Administration</span>';

            // Tombol Aksi Dinamis: Jika sudah dinilai warna tombol berubah menjadi orange "Edit Assessment"
            if ($my_evaluation) {
                $row[] = '<div class="btn-group" style="gap:4px;">
                        <a class="btn btn-info btn-sm shadow-sm" href="javascript:void(0)" title="View Info" onclick="viewSubmission(' . "'" . $submission->id . "'" . ')"><i class="fa fa-eye"></i> View Details</a>
                        <a class="btn btn-warning btn-sm font-weight-bold shadow-sm text-dark" href="' . base_url('admin/category/irpc/assess/' . $submission->id) . '" target="_blank"><i class="fa fa-edit"></i> Edit Score</a>
                      </div>';
            } else {
                $row[] = '<div class="btn-group" style="gap:4px;">
                        <a class="btn btn-info btn-sm shadow-sm" href="javascript:void(0)" title="View Info" onclick="viewSubmission(' . "'" . $submission->id . "'" . ')"><i class="fa fa-eye"></i>View Details</a>
                        <a class="btn btn-primary btn-sm font-weight-bold shadow-sm" href="' . base_url('admin/category/irpc/assess/' . $submission->id) . '" target="_blank"><i class="fa fa-calculator"></i> Assess Now</a>
                      </div>';
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_r_irpc->count_all(),
            "recordsFiltered" => $this->M_r_irpc->count_filtered(),
            "data" => $data,
            "csrf_token" => $this->security->get_csrf_hash()
        );
        echo json_encode($output);
    }

    public function ajax_view($id)
    {
        $data = $this->M_r_irpc->get_by_id($id);
        echo json_encode($data);
    }

    /**
     * URL: admin/category/ahic/assess/[id_submission]
     */
    public function assess($submission_id)
    {
        $submission = $this->M_r_irpc->get_by_id($submission_id);
        if (!$submission) {
            show_404();
        }

        $category = strtolower($submission->category);

        // Ambil kriteria penilaian spesifik kategori AHIC/aktif
        $data['components'] = $this->M_r_irpc->get_components_by_category($category);

        // SINKRONISASI MULTI-JURI: Ambil data nilai yang diinput oleh juri yang sedang login saat ini saja
        $user = $this->ion_auth->user()->row();

        $evaluation = $this->db->get_where('evaluations', [
            'submission_id' => $submission_id,
            'assessor_id'   => $user->id
        ])->row();

        $existing_details = $evaluation ? $this->M_r_irpc->get_evaluation_details($evaluation->id) : [];

        $data['saved_scores'] = [];
        foreach ($existing_details as $detail) {
            $data['saved_scores'][$detail['component_id']] = $detail['score'];
        }

        /* * =========================================================================
     * PERBAIKAN UTAMA: OVERWRITE DATA KOMENTAR SPESIFIK JURI YANG LOG IN
     * =========================================================================
     * Kita timpa properti key_strengths, key_weaknesses, dll pada object $submission 
     * menggunakan data dari $evaluation milik juri yang sedang login saat ini.
     */
        if ($evaluation) {
            $submission->key_strengths         = $evaluation->key_strengths;
            $submission->key_weaknesses        = $evaluation->key_weaknesses;
            $submission->recommendations       = $evaluation->recommendations;
            $submission->recommendation_status = $evaluation->recommendation_status;
        } else {
            // Jika juri ini belum pernah menilai berkas ini, kosongkan nilainya agar tidak bocor dari juri lain
            $submission->key_strengths         = '';
            $submission->key_weaknesses        = '';
            $submission->recommendations       = '';
            $submission->recommendation_status = '';
        }

        $data['submission'] = $submission;
        $data['evaluation'] = $evaluation;

        $data['website'] = $this->M_settings->get_all_settings();
        $data['title']   = 'Form Assessment AHIC | Admin Panel';
        $data['content'] = 'paneladmin/r_ahic/assess_page';
        $this->load->view('layouts/adminlte3', $data);
    }

    /**
     * Memproses Simpan Form Nilai Juri (POST)
     */
    public function store()
    {
        $submission_id = $this->input->post('submission_id');

        if (empty($submission_id)) {
            redirect('admin/category/ahic');
        }

        // Ambil data user/juri yang sedang login secara aman dari session server
        $user = $this->ion_auth->user()->row();

        // Jalankan transaksional upsert multi-juri murni
        $process = $this->M_r_irpc->save_evaluation($this->input->post(), $user->id);

        if ($process) {
            $this->M_log_user->save_log($user->id, "Calculated weighted score for submission ID: $submission_id");
            $this->session->set_flashdata('success', 'Penilaian Weighted Score berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan penilaian ke database.');
        }

        redirect('admin/category/ahic');
    }

    private function get_request_csrf_token()
    {
        $csrf = $this->input->post('csrf_token_jkt3');
        if (empty($csrf)) {
            $csrf = $this->input->server('HTTP_X_CSRF_TOKEN');
        }
        return $csrf;
    }

    private function validate_csrf()
    {
        $csrf = $this->get_request_csrf_token();
        $valid = $this->security->get_csrf_hash();

        if ($csrf !== $valid) {
            echo json_encode([
                "status" => FALSE,
                "message" => "Invalid CSRF Token"
            ]);
            exit();
        }
    }
}
