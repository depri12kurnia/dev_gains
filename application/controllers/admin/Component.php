<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Component extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
        $this->load->model('M_component');
        $this->load->model('M_log_user');

        if (!$this->ion_auth->in_group('admin')) {
            redirect('page_errors');
        }
    }

    public function index()
    {
        // Ambil filter kategori dari URL parameter (Default ke 'irpc' jika tidak ada)
        $category = $this->input->get('category');
        if (!in_array($category, ['IRPC', 'AHIC', 'E2IPBC', 'GENERAL'])) {
            $category = 'GENERAL';
        }

        $data['current_category'] = $category;
        $data['existing_components'] = $this->M_component->get_components_by_category($category);

        $data['website'] = $this->M_settings->get_all_settings();
        $data['title'] = 'Setup Assessment Components | Admin Panel';
        $data['content'] = 'paneladmin/component/list';
        $this->load->view('layouts/adminlte3', $data);
    }

    public function save_batch()
    {
        $this->validate_csrf();

        $category_code = $this->input->post('category_code');
        $components    = $this->input->post('components');

        if (!empty($category_code) && !empty($components) && is_array($components)) {

            $result = $this->M_component->save_assessment_components_batch($components, $category_code);

            if ($result) {
                $user = $this->ion_auth->user()->row();
                $this->M_log_user->save_log($user->id, "Updated assessment components for category: $category_code");

                echo json_encode([
                    'status' => TRUE,
                    'csrf_token' => $this->security->get_csrf_hash()
                ]);
            } else {
                echo json_encode([
                    'status' => FALSE,
                    'message' => 'Gagal memperbarui komponen ke database.',
                    'csrf_token' => $this->security->get_csrf_hash()
                ]);
            }
        } else {
            echo json_encode([
                'status' => FALSE,
                'message' => 'Tidak ada data kriteria yang valid untuk disimpan.',
                'csrf_token' => $this->security->get_csrf_hash()
            ]);
        }
    }

    private function validate_csrf()
    {
        // Ambil token murni dari HTTP Header (Double Protection Standard)
        $csrf_token = $this->input->server('HTTP_X_CSRF_TOKEN');

        // Jika header kosong, coba ambil fallback dari POST payload
        if (empty($csrf_token)) {
            $csrf_token = $this->input->post('csrf_token_jkt3');
        }

        // Ambil token yang sah saat ini di server
        $valid_token = $this->security->get_csrf_hash();

        if ($csrf_token !== $valid_token) {
            echo json_encode([
                'status' => 'Error',
                'message' => 'Invalid CSRF Token match. Silakan coba simpan kembali.',
                'csrf_token' => $valid_token // Kirim hash segar ke view untuk sinkronisasi otomatis
            ]);
            exit();
        }
    }
}
