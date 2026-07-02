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

        if (!$this->ion_auth->in_group(array('admin', 'auditor', 'reviewer'))) {
            redirect('admin/page_errors');
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

        $list = $this->M_payment->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $payment) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $payment->email;
            $row[] = $payment->first_name . ' ' . $payment->last_name;
            $row[] = $payment->bank_name;
            $row[] = $payment->sender_name;
            if ($payment->status == 'pending') {
                $status_icon = '<i class="fas fa-paper-plane text-primary" title="Pending"></i>';
            } elseif ($payment->status == 'rejected') {
                $status_icon = '<i class="fas fa-times-circle text-danger" title="Rejected"></i>';
            } elseif ($payment->status == 'approved') {
                $status_icon = '<i class="fas fa-check-circle text-success" title="Approved"></i>';
            } else {
                $status_icon = $payment->status;
            }
            $row[] = $status_icon;
            $row[] = '<a class="btn btn-primary btn-sm" href="javascript:void(0)" title="Verify" onclick="viewPayment(' . "'" . $payment->id . "'" . ')"><i class="fa fa-eye"></i></a>
                      ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_payment->count_all(),
            "recordsFiltered" => $this->M_payment->count_filtered(),
            "data" => $data,
            "csrf_token" => $this->security->get_csrf_hash()
        );
        echo json_encode($output);
    }

    public function ajax_view($id)
    {
        $data = $this->M_payment->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_verify()
    {
        $this->validate_csrf();

        $id      = $this->input->post('id');
        $status  = $this->input->post('status');
        $comment = $this->input->post('comment');

        $data = ['status' => $status];
        if ($status === 'rejected') {
            $data['comment'] = $comment;
        }

        $this->M_payment->update_payment($id, $data);

        // log
        $user = $this->ion_auth->user()->row();
        $this->M_log_user->save_log($user->id, "Verify payment ID: $id -> $status");

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

    public function export_excel()
    {

        // Get filtered data
        $this->db->select('payments.id, payments.user_id, users.email, users.first_name, users.last_name, payments.bank_name, payments.sender_name, payments.status, payments.proof_file,');
        $this->db->from('payments');
        $this->db->join('users', 'users.id = payments.user_id');

        $this->db->order_by('payments.id', 'desc');
        $query = $this->db->get();
        $payments = $query->result();

        // Load PhpSpreadsheet library
        require_once APPPATH . '../vendor/autoload.php';
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator("Gains Admin")
            ->setLastModifiedBy("Gains Admin")
            ->setTitle("payments Export")
            ->setSubject("payments Export")
            ->setDescription("Export of payments data");

        // Add header
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Fist Name');
        $sheet->setCellValue('D1', 'Last Name');
        $sheet->setCellValue('E1', 'Bank Name');
        $sheet->setCellValue('F1', 'Sender Name');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Proof File');

        // Add data
        $row = 2;
        foreach ($payments as $p) {
            $sheet->setCellValue('A' . $row, $p->id);
            $sheet->setCellValue('B' . $row, $p->email);
            $sheet->setCellValue('C' . $row, $p->first_name);
            $sheet->setCellValue('D' . $row, $p->last_name);
            $sheet->setCellValue('E' . $row, $p->bank_name);
            $sheet->setCellValue('F' . $row, $p->sender_name);
            $sheet->setCellValue('G' . $row, $p->status);

            $fileUrl = base_url('public/uploads/payment/' . $p->proof_file);

            $sheet->setCellValue('H' . $row, $p->proof_file);

            $sheet->getCell('H' . $row)->getHyperlink()->setUrl($fileUrl);

            $sheet->getStyle('H' . $row)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
            $sheet->getStyle('H' . $row)->getFont()->setUnderline(true);
            $row++;
        }

        // Rename worksheet
        $sheet->setTitle('Payments');

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="payments_' . date('Y-m-d_H-i-s') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
