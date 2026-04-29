<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Timeline extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
    }

    public function index()
    {
        $data['website'] = $this->M_settings->get_all_settings();
        $data['title'] = 'Timeline';
        $data['content'] = 'timeline';
        $this->load->view('layouts/userlte3', $data);
    }
}
