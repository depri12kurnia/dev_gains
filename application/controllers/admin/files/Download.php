<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Download extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
        $this->load->model('M_log_user');
        $this->load->model('M_ddownload');

        $this->load->library('upload'); // Load library upload

        if (!$this->ion_auth->in_group('admin')) {
            redirect('page_errors');
        }
    }

    public function index()
    {
        $data['website'] = $this->M_settings->get_all_settings();
        $data['category'] = $this->M_ddownload->get_category();
        $data['type'] = $this->M_ddownload->get_type();
        $data['title'] = 'Downloads | Admin Panel';
        $data['content'] = 'paneladmin/download/list';
        $this->load->view('layouts/adminlte3', $data);
    }

    public function ajax_list()
    {
        $csrf_token = $this->input->server('HTTP_X_CSRF_TOKEN');
        $valid_token = $this->security->get_csrf_hash();

        if (empty($csrf_token)) {
            log_message('error', 'CSRF Token kosong, periksa apakah dikirim dari frontend.');
        }

        if ($csrf_token !== $valid_token) {
            echo json_encode(['status' => 'Error', 'message' => 'Invalid CSRF Token']);
            exit();
        }

        $list = $this->M_ddownload->get_datatables();
        $data = array();
        $no = $_POST['start'] + 1;
        foreach ($list as $x) {
            $row = array();
            $row[] = $no++;
            $row[] = $x->category_name;
            $row[] = $x->type_name;
            $row[] = $x->name_files;
            $row[] = '<a class="btn btn-primary btn-sm" href="javascript:void(0)" title="Edit" onclick="edit_download(' . "'" . $x->id . "'" . ')"><i class="fa fa-edit"></i></a>
                      <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_download(' . "'" . $x->id . "'" . ')"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_ddownload->count_all(),
            "recordsFiltered" => $this->M_ddownload->count_filtered(),
            "data" => $data,
            "csrf_token" => $this->security->get_csrf_hash() // Kirim token CSRF baru
        );
        echo json_encode($output);
    }

    public function ajax_add()
    {
        $this->validate_csrf();
        $this->_validate();

        $user = $this->ion_auth->user()->row();

        if (empty($_FILES['thumbnail']['name'])) {
            echo json_encode(["status" => false, "inputerror" => ["thumbnail"], "error_string" => ["Thumbnail tidak boleh kosong"]]);
            exit;
        }
        // Handle Upload Thumbnail
        $filenames = $this->_upload_filesname();

        $name = $this->input->post('name');

        $data = array(
            'd_category_id'   => $this->input->post('d_category_id'),
            'd_type_id'       => $this->input->post('d_type_id'),
            'name'            => $name,
            'name_files'      => $filenames
        );

        $this->M_ddownload->insert_news($data);

        $user = $this->ion_auth->user()->row();
        $this->M_log_user->save_log($user->id, 'Add News');

        echo json_encode([
            "status" => TRUE,
            "csrf_token" => $this->security->get_csrf_hash()
        ]);
    }

    public function ajax_edit($id)
    {
        $data = $this->M_ddownload->get_by_id($id);
        echo json_encode($data);
    }


    public function ajax_update()
    {
        $this->validate_csrf();
        $this->_validate();

        $user = $this->ion_auth->user()->row();

        $id = $this->input->post('id');
        $news = $this->M_ddownload->get_by_id($id);

        $published_at = $this->input->post('published_at');
        if (!empty($published_at)) {
            $news->published_at = date('Y-m-d\TH:i', strtotime($news->published_at)); // Format untuk <input type="datetime-local">
        } else {
            $published_at = date('Y-m-d H:i:s'); // Default ke waktu sekarang jika kosong
        }

        // Cek apakah ada file thumbnail baru diupload
        $thumbnail = !empty($_FILES['thumbnail']['name']) ? $this->_upload_thumbnail($news->thumbnail) : $news->thumbnail;

        $data = array(
            'category_id'   => $this->input->post('category_id'),
            'title'         => $this->input->post('title'),
            'content'       => $this->input->post('content'),
            'thumbnail'     => $thumbnail, // Update thumbnail jika ada perubahan
            'status'        => $this->input->post('status'),
            'author'        => $user->id,
            'published_at'  => $published_at,
        );

        $this->M_ddownload->update_news($id, $data);

        $user = $this->ion_auth->user()->row();
        $this->M_log_user->save_log($user->id, 'Update News');

        echo json_encode([
            "status" => TRUE,
            "csrf_token" => $this->security->get_csrf_hash()
        ]);
    }

    public function ajax_delete($id)
    {
        $this->validate_csrf();

        // Ambil data berita sebelum dihapus
        $news = $this->M_ddownload->get_by_id($id);

        if (!$news) {
            echo json_encode(["status" => false, "error" => "Data tidak ditemukan."]);
            exit;
        }

        // Path lokasi penyimpanan thumbnail
        $thumbnail_path = FCPATH . 'public/uploads/news/' . $news->thumbnail;

        // Hapus thumbnail jika ada
        if (!empty($news->thumbnail) && file_exists($thumbnail_path)) {
            unlink($thumbnail_path);
        }

        // Hapus berita dari database
        $this->M_ddownload->delete_news($id);

        // Mendapatkan user yang login
        $user = $this->ion_auth->user()->row();

        // Simpan log aktivitas
        $this->M_log_user->save_log($user->id, 'Delete News');

        echo json_encode([
            "status" => TRUE,
            "csrf_token" => $this->security->get_csrf_hash() // Kirim token CSRF baru
        ]);
    }


    private function _upload_filesname($old_filesname = null)
    {
        $config['upload_path']   = './public/uploads/files/';
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 10048; // Maksimum 2MB
        $config['file_name']     = time() . '_' . $_FILES['filesname']['name'];

        $this->upload->initialize($config);

        if ($this->upload->do_upload('filesname')) {
            $upload_data = $this->upload->data();

            // Hapus file lama jika ada
            if ($old_filesname && file_exists('./public/uploads/news/' . $old_filesname)) {
                unlink('./public/uploads/news/' . $old_filesname);
            }

            return $upload_data['file_name']; // Return nama file baru
        } else {
            return $old_filesname; // Jika gagal upload, gunakan thumbnail lama
        }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $title = $this->input->post('title');
        $content = $this->input->post('content');

        if (empty($title)) {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'title is required';
            $data['status'] = FALSE;
        }

        if (empty($content)) {
            $data['inputerror'][] = 'content';
            $data['error_string'][] = 'content is required';
            $data['status'] = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }


    private function validate_csrf()
    {
        $csrf_token = $this->input->server('HTTP_X_CSRF_TOKEN');
        $valid_token = $this->security->get_csrf_hash();

        if ($csrf_token !== $valid_token) {
            echo json_encode(['status' => 'Error', 'message' => 'Invalid CSRF Token']);
            exit();
        }
    }
}
