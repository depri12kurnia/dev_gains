<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submissions extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
        $this->load->model('M_submission');
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
        $data['title'] = 'Submission Management | Admin Panel';
        $data['content'] = 'paneladmin/submission/list';
        $this->load->view('layouts/adminlte3', $data);
    }

    public function ajax_list()
    {
        $this->validate_csrf();

        $list = $this->M_submission->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $submission) {
            $no++;
            $row = array();
            $row[] = $no++;
            $row[] = $submission->email;
            $row[] = $submission->institution;
            $row[] = $submission->country;
            $row[] = $submission->category;
            $row[] = $submission->title;

            if ($submission->status == 'submitted') {
                $status_icon = '<i class="fas fa-paper-plane text-primary" title="Submitted"></i>';
            } elseif ($submission->status == 'not selected') {
                $status_icon = '<i class="fas fa-times-circle text-danger" title="Not Selected"></i>';
            } elseif ($submission->status == 'finalist') {
                $status_icon = '<i class="fas fa-check-circle text-success" title="Finalist"></i>';
            } else {
                $status_icon = $submission->status;
            }
            $row[] = $status_icon;
            $row[] = '<a class="btn btn-primary btn-sm" href="javascript:void(0)" title="Verify" onclick="viewSubmission(' . "'" . $submission->id . "'" . ')"><i class="fa fa-eye"></i></a>
                      ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_submission->count_all(),
            "recordsFiltered" => $this->M_submission->count_filtered(),
            "data" => $data,
            "csrf_token" => $this->security->get_csrf_hash()
        );
        echo json_encode($output);
    }

    public function ajax_view($id)
    {
        $data = $this->M_submission->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_verify()
    {
        $this->validate_csrf();

        $id      = $this->input->post('id');
        $status  = $this->input->post('status');
        $comment = $this->input->post('comment');

        $data = ['status' => $status];
        if ($status === 'not selected') {
            $data['comment'] = $comment;
        }

        $this->M_submission->update_submission($id, $data);

        // log
        $user = $this->ion_auth->user()->row();
        $this->M_log_user->save_log($user->id, "Verify submission ID: $id -> $status");

        echo json_encode([
            "status" => TRUE,
            "csrf_token" => $this->security->get_csrf_hash()
        ]);
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
                "message" => "Invalid CSRF"
            ]);
            exit();
        }
    }
}
