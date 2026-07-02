<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Screenings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
        $this->load->model('M_screenings');
        $this->load->model('M_log_user');
        $this->load->model('M_users');

        if (!$this->ion_auth->in_group(array('admin', 'screenings'))) {
            redirect('admin/page_errors');
        }
    }

    public function index()
    {
        $data['website'] = $this->M_settings->get_all_settings();
        $data['groups'] = $this->M_users->get_groups();
        $data['title'] = 'Screenings Management | Admin Panel';
        $data['content'] = 'paneladmin/screenings/list';
        $this->load->view('layouts/adminlte3', $data);
    }

    public function ajax_list()
    {
        $this->validate_csrf();

        $list = $this->M_screenings->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $submission) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $submission->title;
            $row[] = $submission->country;
            $row[] = $submission->category;

            // Render Nilai Akhir (Weighted Score) & Keputusan Final
            $row[] = $submission->total_score ? '<strong class="text-success">' . number_format($submission->total_score, 2) . '</strong>' : '<span class="text-muted">Unrated</span>';

            $row[] = $submission->screening_status ? '<span class="badge badge-dark">' . $submission->screening_status . '</span>' : '<span class="text-muted">-</span>';

            // Tombol Aksi: Lihat Detail & Tombol Beri Nilai Bobot
            $row[] = '<a class="btn btn-info btn-sm" href="javascript:void(0)" title="View Info" onclick="viewSubmission(' . "'" . $submission->id . "'" . ')"><i class="fa fa-eye"></i></a>
          <a class="btn btn-primary btn-sm" href="' . base_url('admin/screenings/assess/' . $submission->id) . '" target="_blank" title="Give Weight Score"><i class="fa fa-tasks"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_screenings->count_all(),
            "recordsFiltered" => $this->M_screenings->count_filtered(),
            "data" => $data,
            "csrf_token" => $this->security->get_csrf_hash()
        );
        echo json_encode($output);
    }

    public function ajax_view($id)
    {
        $data = $this->M_screenings->get_by_id($id);
        echo json_encode($data);
    }

    /**
     * URL: admin/screenings/assess/[id_submission]
     * Membuka halaman lembar penilaian baru
     */
    public function assess($submission_id)
    {
        $submission = $this->M_screenings->get_by_id($submission_id);
        if (!$submission) {
            show_404();
        }

        $data['submission'] = $submission;

        // Ambil kategori langsung tidak ada dari peserta
        $category = strtolower('GENERAL');

        // Ambil kriteria penilaian dari DB yang hanya aktif DAN sesuai dengan kategori kompetensinya
        $data['components'] = $this->M_screenings->get_components_by_category($category);

        // Ambil skor lama jika assessor ingin melakukan edit/review kembali
        $screenings_id = $this->db->get_where('screenings', ['submission_id' => $submission_id])->row('id');
        $existing_details = $screenings_id ? $this->M_screenings->get_screenings_details($screenings_id) : [];

        $data['saved_scores'] = [];
        foreach ($existing_details as $detail) {
            $data['saved_scores'][$detail['component_id']] = $detail['score'];
        }

        $data['website'] = $this->M_settings->get_all_settings();
        $data['title']   = 'Form Assessment | Admin Panel';
        $data['content'] = 'paneladmin/screenings/assess_page';
        $this->load->view('layouts/adminlte3', $data);
    }

    /**
     * Memproses kiriman Form Nilai Berbobot (Standard POST redirect)
     */
    public function store()
    {
        // Proteksi CSRF bawaan CodeIgniter Form
        $submission_id = $this->input->post('submission_id');

        if (empty($submission_id)) {
            redirect('admin/screenings');
        }

        $user = $this->ion_auth->user()->row();

        // Jalankan kalkulasi berbobot lewat model M_screenings yang lama (Core logic tidak berubah)
        $process = $this->M_screenings->save_screenings($this->input->post(), $user->id);

        if ($process) {
            $this->M_log_user->save_log($user->id, "Calculated weighted score via page for submission ID: $submission_id");
            $this->session->set_flashdata('success', 'Penilaian Weighted Score berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan penilaian ke database.');
        }

        // Redirect kembali ke halaman list utama, lalu tab browser ini bisa ditutup oleh user
        redirect('admin/screenings');
    }

    public function export_excel()
    {
        $category = $this->input->get('category');
        $status = $this->input->get('status');

        // Tarik data dengan gabungan skor berbobot dari database
        $this->db->select('submissions.*, users.email, screenings.total_score, screenings.final_decision');
        $this->db->from('submissions');
        $this->db->join('users', 'users.id = submissions.user_id', 'left');
        $this->db->join('screenings', 'screenings.submission_id = screenings.id', 'left');

        if (!empty($category)) {
            $this->db->where('submissions.category', $category);
        }
        if (!empty($status)) {
            $this->db->where('submissions.status', $status);
        }

        $this->db->order_by('submissions.id', 'desc');
        $query = $this->db->get();
        $submissions = $query->result();

        require_once APPPATH . '../vendor/autoload.php';
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()->setCreator("Gains Admin")
            ->setLastModifiedBy("Gains Admin")
            ->setTitle("Submissions screenings Export")
            ->setSubject("screenings Data");

        // Header Table Excel (Ditambahkan Kolom Nilai Bobot & Keputusan Akhir)
        $headers = [
            'A1' => 'ID',
            'B1' => 'Email',
            'C1' => 'Team Leader',
            'D1' => 'Leader Titles',
            'E1' => 'Institution',
            'F1' => 'Country',
            'G1' => 'Participation Type',
            'H1' => 'Cross Collaboration',
            'I1' => 'Team Members',
            'J1' => 'Category',
            'K1' => 'Title',
            'L1' => 'Focus Area',
            'M1' => 'Alignment Theme',
            'N1' => 'Link',
            'O1' => 'Supporting Links',
            'P1' => 'Total Score (Weighted)',
            'Q1' => 'Final Decision',
            'R1' => 'Status',
            'S1' => 'Consent',
            'T1' => 'Comment',
            'U1' => 'Created At',
            'V1' => 'Updated At'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

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
            $sheet->setCellValue('P' . $row, $submission->total_score ? number_format($submission->total_score, 2) : '0.00');
            $sheet->setCellValue('Q' . $row, $submission->final_decision ? $submission->final_decision : '-');
            $sheet->setCellValue('R' . $row, $submission->status);
            $sheet->setCellValue('S' . $row, ($submission->consent ? 'Yes' : 'No'));
            $sheet->setCellValue('T' . $row, $submission->comment);
            $sheet->setCellValue('U' . $row, $submission->created_at);
            $sheet->setCellValue('V' . $row, $submission->updated_at);
            $row++;
        }

        $sheet->setTitle('screenings Report');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="screenings_report_' . date('Y-m-d_H-i-s') . '.xlsx"');
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
                "message" => "Invalid CSRF Token"
            ]);
            exit();
        }
    }
}
