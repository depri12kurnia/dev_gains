<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sliders extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
        $this->load->model('M_log_user');
        $this->load->model('M_sliders');

        $this->load->library('upload'); // Load library upload

        if (!$this->ion_auth->in_group('admin')) {
            redirect('page_errors');
        }
    }

    public function index()
    {
        $data['website'] = $this->M_settings->get_all_settings();
        $data['title'] = 'Sliders | Admin Panel';
        $data['content'] = 'paneladmin/sliders/list';
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

        $list = $this->M_sliders->get_datatables();
        $data = array();
        $no = $_POST['start'] + 1;
        foreach ($list as $x) {
            $row = array();
            $row[] = $no++;
            $row[] = $x->title;
            $row[] = '<img src="' . base_url('public/uploads/sliders/' . $x->image) . '" class="img-thumbnail" width="100" height="50">';
            $status = ($x->status == 'Active')
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-secondary">Inactive</span>';
            $row[] = $status;
            $row[] = '<a class="btn btn-primary btn-sm" href="javascript:void(0)" title="Edit" onclick="edit_sliders(' . "'" . $x->id . "'" . ')"><i class="fa fa-edit"></i></a>
                      <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_sliders(' . "'" . $x->id . "'" . ')"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_sliders->count_all(),
            "recordsFiltered" => $this->M_sliders->count_filtered(),
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

        // Validasi jika tidak ada gambar
        if (empty($_FILES['image']['name'])) {
            echo json_encode(["status" => false, "inputerror" => ["image"], "error_string" => ["Image tidak boleh kosong"]]);
            exit;
        }

        // Validasi ukuran gambar maksimal 2MB (2048 KB)
        if ($_FILES['image']['size'] > 2048000) {
            echo json_encode(["status" => false, "inputerror" => ["image"], "error_string" => ["Ukuran gambar tidak boleh lebih dari 2MB"]]);
            exit;
        }
        // Handle Upload image
        $image = $this->_upload_image();

        $title = $this->input->post('title');

        $data = array(
            'title'         => $title,
            'image'         => $image,
            'status'        => $this->input->post('status')
        );

        $this->M_sliders->insert_sliders($data);

        $user = $this->ion_auth->user()->row();
        $this->M_log_user->save_log($user->id, 'Add sliders');

        echo json_encode([
            "status" => TRUE,
            "csrf_token" => $this->security->get_csrf_hash()
        ]);
    }

    public function ajax_edit($id)
    {
        $data = $this->M_sliders->get_by_id($id);
        echo json_encode($data);
    }


    public function ajax_update()
    {
        $this->validate_csrf();
        $this->_validate();

        $user = $this->ion_auth->user()->row();

        $id = $this->input->post('id');
        $sliders = $this->M_sliders->get_by_id($id);

        // Cek apakah ada file image baru diupload
        $image = !empty($_FILES['image']['name']) ? $this->_upload_image($sliders->image) : $sliders->image;

        $data = array(
            'title'         => $this->input->post('title'),
            'image'         => $image, // Update image jika ada perubahan
            'status'        => $this->input->post('status')
        );

        $this->M_sliders->update_sliders($id, $data);

        $user = $this->ion_auth->user()->row();
        $this->M_log_user->save_log($user->id, 'Update sliders');

        echo json_encode([
            "status" => TRUE,
            "csrf_token" => $this->security->get_csrf_hash()
        ]);
    }

    public function ajax_delete($id)
    {
        $this->validate_csrf();

        // Ambil data berita sebelum dihapus
        $sliders = $this->M_sliders->get_by_id($id);

        if (!$sliders) {
            echo json_encode(["status" => false, "error" => "Data tidak ditemukan."]);
            exit;
        }

        // Path lokasi penyimpanan image
        $image_path = FCPATH . 'public/uploads/sliders/' . $sliders->image;

        // Hapus image jika ada
        if (!empty($sliders->image) && file_exists($image_path)) {
            unlink($image_path);
        }

        // Hapus berita dari database
        $this->M_sliders->delete_sliders($id);

        // Mendapatkan user yang login
        $user = $this->ion_auth->user()->row();

        // Simpan log aktivitas
        $this->M_log_user->save_log($user->id, 'Delete sliders');

        echo json_encode([
            "status" => TRUE,
            "csrf_token" => $this->security->get_csrf_hash() // Kirim token CSRF baru
        ]);
    }


    private function _upload_image($old_image = null)
    {
        $config['upload_path']   = './public/uploads/sliders/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 2048; // Maksimum 2MB
        $config['file_name']     = time() . '_' . $_FILES['image']['name'];

        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            $upload_data = $this->upload->data();

            $max_width  = 800;
            $max_height = 400;

            // Resize paksa ke 800x400 px
            $config_resize['image_library']  = 'gd2';
            $config_resize['source_image']   = $upload_data['full_path'];
            $config_resize['new_image']      = $upload_data['full_path']; // Menyimpan hasil resize ke file yang sama
            $config_resize['maintain_ratio'] = FALSE; // Paksa ukuran agar pas 800x400
            $config_resize['width']          = $max_width;
            $config_resize['height']         = $max_height;

            $this->load->library('image_lib', $config_resize);

            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
                return $old_image;
            }

            // Hapus file lama jika ada
            if ($old_image && file_exists('./public/uploads/sliders/' . $old_image)) {
                unlink('./public/uploads/sliders/' . $old_image);
            }

            return $upload_data['file_name']; // Return nama file baru
        } else {
            return $old_image; // Jika gagal upload, gunakan image lama
        }
    }


    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $title = $this->input->post('title');

        if (empty($title)) {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'title is required';
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
