<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->load->model('M_users');
        $this->load->model('M_log_user');
        $this->load->model('M_payment');
        $this->load->model('M_submission');
        $this->load->model('M_user');
        $this->load->model('M_dashboard');
    }

    public function index()
    {
        $this->load->helper(['url', 'form']);
        $user    = $this->ion_auth->user()->row();
        $user_id = $this->session->userdata('user_id');


        // Panggil model dashboard
        $this->load->model('M_dashboard');
        $data_progress = $this->M_dashboard->get_user_progress($user_id);

        // =========================
        // LOGIC PENENTUAN STATUS
        // =========================
        $status = 'registered';

        if ($data_progress->payment_status) {
            if ($data_progress->payment_status == 'pending') {
                $status = 'pending';
            } elseif ($data_progress->payment_status == 'rejected') {
                $status = 'rejected';
            } elseif ($data_progress->payment_status == 'approved') {
                $status = 'approved'; // Step 2 selesai

                // Cek status submission jika pembayaran sudah approved
                if ($data_progress->submission_status) {
                    $status = $data_progress->submission_status; // 'submitted', 'not selected', atau 'finalist'
                }
            }
        }

        // Persiapkan data untuk View
        $status_label = [
            'registered'    => 'Registered',
            'pending'       => 'Waiting Verification',
            'approved'      => 'Payment Success',
            'rejected'      => 'Payment Rejected',
            'submitted'     => 'Work Submitted',
            'under review'  => 'Under Review',
            'not selected'  => 'Not Selected',
            'finalist'      => 'Finalist'
        ];

        $data['user_status'] = $status;
        $data['label']       = $status_label[$status];
        $data['detail']      = $data_progress;

        $data['user'] = [
            'name'     => $user->first_name,
            'email'    => $user->email,
            'phone'    => $user->phone,
            'initials' => strtoupper(substr($user->first_name, 0, 2)),
            'status'   => $status_label[$status]
        ];

        $data['groups']  = $this->M_users->get_groups();
        $data['website'] = $this->M_settings->get_all_settings();
        $data['title']   = 'Dashboard | User Panel';
        $data['content'] = 'dashboard';

        $this->load->view('layouts/userlte3', $data);
    }

    public function save_payment()
    {
        $user_id = $this->session->userdata('user_id');

        $config = [
            'upload_path'   => 'public/uploads/payment/',
            'allowed_types' => 'jpg|jpeg|png|pdf',
            'max_size'      => 5048,
            'encrypt_name'  => TRUE
        ];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('proof_file')) {

            $file = $this->upload->data();
            $this->session->set_flashdata('uploaded_file', $file['file_name']);

            $data = [
                'user_id'     => $this->session->userdata('user_id'),
                'bank_name'   => $this->input->post('bank_name'),
                'sender_name' => $this->input->post('sender_name'),
                'proof_file'  => $file['file_name'],
                'status'      => 'pending'
            ];

            // 🔥 CEK DATA SUDAH ADA ATAU BELUM
            $existing = $this->M_payment->get_by_user($user_id);

            if ($existing) {

                // OPTIONAL: hapus file lama
                if (!empty($existing->proof_file)) {
                    $old_path = FCPATH . 'public/uploads/payment/' . $existing->proof_file;
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }

                // UPDATE
                $this->M_payment->update_by_user($user_id, $data);
                $this->session->set_flashdata('success', 'Payment successfully updated');
            } else {

                // INSERT
                $this->M_payment->insert_payment($data);
                $this->session->set_flashdata('success', 'Payment successfully submitted');
            }

            $this->session->set_flashdata('uploaded_file', $file['file_name']);
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }

        redirect('dashboard');
    }


    public function save_submission()
    {
        $user_id = $this->session->userdata('user_id');

        $country = $this->input->post('country');
        if ($country == 'Other') {
            $country = $this->input->post('other_country');
        }

        $data = [
            'user_id'     => $user_id,
            'institution' => $this->input->post('institution'),
            'country'     => $country,
            'category'    => $this->input->post('category'),
            'title'       => $this->input->post('title'),
            'link'        => $this->input->post('link')
        ];

        // CEK DATA SUDAH ADA ATAU BELUM
        $existing = $this->M_submission->get_by_user($user_id);

        if ($existing) {
            // UPDATE
            $this->M_submission->update_by_user($user_id, $data);
            $this->session->set_flashdata('success', 'Submission successfully updated');
        } else {
            // INSERT
            $this->M_submission->insert_submission($data);
            $this->session->set_flashdata('success', 'Submission successfully saved');
        }

        redirect('dashboard');
    }

    public function update_password()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('dashboard');
        }

        $user = $this->ion_auth->user()->row();
        $identity = $user->email;

        $change = $this->ion_auth->change_password(
            $identity,
            $this->input->post('current_password'),
            $this->input->post('new_password')
        );

        if ($change) {
            $this->session->set_flashdata('success_update_password', 'Password changed successfully, please log out and then log in again.');
        } else {
            $this->session->set_flashdata('error', $this->ion_auth->errors());
        }

        redirect('dashboard');
    }

    public function update_profile()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('dashboard');
        }

        $user_id = $this->session->userdata('user_id');

        $data = [
            'first_name' => $this->input->post('first_name'),
            'phone'      => $this->input->post('phone')
        ];

        // Update user data
        $this->db->where('id', $user_id);
        $update = $this->db->update('users', $data);

        if ($update) {
            // Log the activity
            $user = $this->ion_auth->user()->row();
            $this->M_log_user->save_log($user->id, "Updated profile information");

            $this->session->set_flashdata('success_update_profile', 'Profile updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate profile');
        }

        redirect('dashboard');
    }
}
