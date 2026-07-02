<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
        $this->load->model('M_payment');
        $this->load->model('M_submission');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        // ==================
        // PAYMENT DASHBOARD
        // ==================
        $data['payment_total'] = $this->M_payment->count_all();
        $data['payment_pending'] = $this->db->where('status', 'pending')->count_all_results('payments');
        $data['payment_approved'] = $this->db->where('status', 'approved')->count_all_results('payments');
        $data['payment_rejected'] = $this->db->where('status', 'rejected')->count_all_results('payments');

        // Payment success rate
        if ($data['payment_total'] > 0) {
            $data['payment_success_rate'] = round(($data['payment_approved'] / $data['payment_total']) * 100, 2);
        } else {
            $data['payment_success_rate'] = 0;
        }

        // Recent payments
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(5);
        $data['recent_payments'] = $this->M_payment->get_all();

        // ==================
        // SUBMISSION DASHBOARD
        // ==================
        $data['submission_total'] = $this->M_submission->count_all();
        $data['submission_submitted'] = $this->db->where('status', 'submitted')->count_all_results('submissions');
        $data['submission_finalist'] = $this->db->where('status', 'finalist')->count_all_results('submissions');
        $data['submission_not_selected'] = $this->db->where('status', 'not_selected')->count_all_results('submissions');

        // Submission success rate (finalist vs total)
        if ($data['submission_total'] > 0) {
            $data['submission_success_rate'] = round(($data['submission_finalist'] / $data['submission_total']) * 100, 2);
        } else {
            $data['submission_success_rate'] = 0;
        }

        // Submissions by category
        $this->db->select('category, COUNT(*) as count');
        $this->db->group_by('category');
        $data['submissions_by_category'] = $this->db->get('submissions')->result();

        // Submissions by country (top 10)
        $this->db->select('country, COUNT(*) as count');
        $this->db->group_by('country');
        $this->db->order_by('count', 'DESC');
        $this->db->limit(10);
        $data['submissions_by_country'] = $this->db->get('submissions')->result();

        // Recent submissions
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(5);
        $data['recent_submissions'] = $this->M_submission->get_all();

        // ==================
        // MONTHLY TRENDS
        // ==================
        // Payment monthly trend (last 6 months)
        $data['payment_trend'] = $this->get_payment_monthly_trend();

        // Submission monthly trend (last 6 months)
        $data['submission_trend'] = $this->get_submission_monthly_trend();

        // ==================
        // GENERAL
        // ==================
        $data['website'] = $this->M_settings->get_all_settings();
        $data['title'] = 'Dashboard | Admin Panel';
        $data['content'] = 'paneladmin/dashboard';
        $this->load->view('layouts/adminlte3', $data);
    }

    private function get_payment_monthly_trend()
    {
        $query = "
            SELECT DATE_FORMAT(created_at, '%Y-%m') as month, 
                   COUNT(*) as total,
                   SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                   SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                   SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
            FROM payments
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY month ASC
        ";
        return $this->db->query($query)->result();
    }

    private function get_submission_monthly_trend()
    {
        $query = "
            SELECT DATE_FORMAT(created_at, '%Y-%m') as month, 
                   COUNT(*) as total,
                   SUM(CASE WHEN status = 'finalist' THEN 1 ELSE 0 END) as finalist,
                   SUM(CASE WHEN status = 'submitted' THEN 1 ELSE 0 END) as submitted,
                   SUM(CASE WHEN status = 'not_selected' THEN 1 ELSE 0 END) as not_selected
            FROM submissions
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY month ASC
        ";
        return $this->db->query($query)->result();
    }
}
