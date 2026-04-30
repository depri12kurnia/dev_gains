<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
        $this->load->model('M_payment');
        $this->load->model('M_log_user');
        $this->load->model('M_users');

        if (!$this->ion_auth->in_group('admin')) {
            redirect('page_errors');
        }
    }

    public function index()
    {
        $data['website'] = $this->M_settings->get_all_settings();
        $data['groups'] = $this->M_users->get_groups();
        $data['title'] = 'Payment Verification | Admin Panel';
        $data['content'] = 'paneladmin/payment/list';
        $this->load->view('layouts/adminlte3', $data);
    }

    public function ajax_list()
    {
        $this->validate_csrf();

        $this->db->select('payments.*, users.username, users.email');
        $this->db->from('payments');
        $this->db->join('users', 'users.id = payments.user_id');

        $list = $this->db->get()->result();

        $data = [];
        $no   = 1;

        foreach ($list as $row) {

            // Status badge
            if ($row->status == 'pending') {
                $status = '<span class="badge badge-warning">Pending</span>';
            } elseif ($row->status == 'approved') {
                $status = '<span class="badge badge-success">Approved</span>';
            } else {
                $status = '<span class="badge badge-danger">Rejected</span>';
            }

            $data[] = [
                $no++,
                $row->username,
                $row->email,
                $row->bank_name,
                $row->sender_name,
                '<a href="' . base_url('uploads/payment/' . $row->proof_file) . '" target="_blank" class="btn btn-info btn-sm">View</a>',
                $status,
                $row[] = '
                    <button class="btn btn-info btn-sm"
                        onclick="previewImage(\'' . base_url('uploads/payment/' . $row->proof_file) . '\')">
                        <i class="fa fa-eye"></i>
                    </button>'
            ];
        }

        echo json_encode([
            "data" => $data,
            "csrf_token" => $this->security->get_csrf_hash()
        ]);
    }

    public function ajax_verify()
    {
        $this->validate_csrf();

        $id     = $this->input->post('id');
        $status = $this->input->post('status');

        $this->M_payment->update_payment($id, [
            'status' => $status
        ]);

        // log
        $user = $this->ion_auth->user()->row();
        $this->M_log_user->save_log($user->id, "Verify payment ID: $id -> $status");

        echo json_encode([
            "status" => TRUE,
            "csrf_token" => $this->security->get_csrf_hash()
        ]);
    }

    private function validate_csrf()
    {
        $csrf = $this->input->post('csrf_token_jkt3');
        $valid = $this->security->get_csrf_hash();

        if ($csrf !== $valid) {
            echo json_encode([
                "status" => FALSE,
                "message" => "Invalid CSRF"
            ]);
            exit();
        }
    }
}
