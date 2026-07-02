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

        if (!$this->ion_auth->in_group(array('admin', 'auditor', 'reviewer'))) {
            redirect('admin/page_errors');
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
        if ($status === 'not_selected') {
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

    public function export_excel()
    {
        $category = $this->input->get('category');
        $status = $this->input->get('status');

        // Get filtered data
        $this->db->select('submissions.id, users.email, submissions.user_id, submissions.team_leader, submissions.leader_titles, submissions.institution, submissions.country, submissions.partType, submissions.crossCollab, submissions.team_members, submissions.category, submissions.title, submissions.focus_area, submissions.alignment_theme, submissions.link, submissions.supporting_links, submissions.status, submissions.consent, submissions.comment, submissions.created_at, submissions.updated_at');
        $this->db->from('submissions');
        $this->db->join('users', 'users.id = submissions.user_id');

        if (!empty($category)) {
            $this->db->where('submissions.category', $category);
        }
        if (!empty($status)) {
            $this->db->where('submissions.status', $status);
        }

        $this->db->order_by('submissions.id', 'desc');
        $query = $this->db->get();
        $submissions = $query->result();

        // Load PhpSpreadsheet library
        require_once APPPATH . '../vendor/autoload.php';
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator("Gains Admin")
            ->setLastModifiedBy("Gains Admin")
            ->setTitle("Submissions Export")
            ->setSubject("Submissions Export")
            ->setDescription("Export of submissions data");

        // Add header
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Team Leader');
        $sheet->setCellValue('D1', 'Leader Titles');
        $sheet->setCellValue('E1', 'Institution');
        $sheet->setCellValue('F1', 'Country');
        $sheet->setCellValue('G1', 'Participation Type');
        $sheet->setCellValue('H1', 'Cross Collaboration');
        $sheet->setCellValue('I1', 'Team Members');
        $sheet->setCellValue('J1', 'Category');
        $sheet->setCellValue('K1', 'Title');
        $sheet->setCellValue('L1', 'Focus Area');
        $sheet->setCellValue('M1', 'Alignment Theme');
        $sheet->setCellValue('N1', 'Link');
        $sheet->setCellValue('O1', 'Supporting Links');
        $sheet->setCellValue('P1', 'Status');
        $sheet->setCellValue('Q1', 'Consent');
        $sheet->setCellValue('R1', 'Comment');
        $sheet->setCellValue('S1', 'Created At');
        $sheet->setCellValue('T1', 'Updated At');

        // Add data
        $row = 2;
        foreach ($submissions as $submission) {
            $sheet->setCellValue('A' . $row, $submission->id);
            $sheet->setCellValue('B' . $row, $submission->email);
            $sheet->setCellValue('C' . $row, $submission->team_leader);
            $sheet->setCellValue('D' . $row, $submission->leader_titles);
            $sheet->setCellValue('E' . $row, $submission->institution);
            $sheet->setCellValue('F' . $row, $submission->country);
            $sheet->setCellValue('G' . $row, $submission->partType);
            $sheet->setCellValue('H' . $row, $submission->crossCollab);
            $sheet->setCellValue('I' . $row, $submission->team_members);
            $sheet->setCellValue('J' . $row, $submission->category);
            $sheet->setCellValue('K' . $row, $submission->title);
            $sheet->setCellValue('L' . $row, $submission->focus_area);
            $sheet->setCellValue('M' . $row, $submission->alignment_theme);
            $sheet->setCellValue('N' . $row, $submission->link);
            $sheet->setCellValue('O' . $row, $submission->supporting_links);
            $sheet->setCellValue('P' . $row, $submission->status);
            $sheet->setCellValue('Q' . $row, ($submission->consent ? 'Yes' : 'No'));
            $sheet->setCellValue('R' . $row, $submission->comment);
            $sheet->setCellValue('S' . $row, $submission->created_at);
            $sheet->setCellValue('T' . $row, $submission->updated_at);
            $row++;
        }

        // Rename worksheet
        $sheet->setTitle('Submissions');

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="submissions_' . date('Y-m-d_H-i-s') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
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
