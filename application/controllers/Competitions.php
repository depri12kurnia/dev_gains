<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Competitions extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_settings');
    }

    public function irpc()
    {
        $data['website'] = $this->M_settings->get_all_settings();
        $data['title'] = 'International Research Pitch Competition (IRPC)';
        $data['content'] = 'competition';
        $data['comp_type'] = 'irpc';
        $this->load->view('layouts/userlte3', $data);
    }

    public function bppa()
    {
        $data['website'] = $this->M_settings->get_all_settings();
        $data['title'] = 'Best Published Paper Award (BPPA)';
        $data['content'] = 'competition';
        $data['comp_type'] = 'bppa';
        $this->load->view('layouts/userlte3', $data);
    }

    public function ahic()
    {
        $data['website'] = $this->M_settings->get_all_settings();
        $data['title'] = 'Academic & Health Innovation Challenge (AHIC)';
        $data['content'] = 'competition';
        $data['comp_type'] = 'ahic';
        $this->load->view('layouts/userlte3', $data);
    }

    public function e2ipbc()
    {
        $data['website'] = $this->M_settings->get_all_settings();
        $data['title'] = 'Evidence-to-Impact Policy Brief Competition (E2I-PBC)';
        $data['content'] = 'competition';
        $data['comp_type'] = 'e2ipbc';
        $this->load->view('layouts/userlte3', $data);
    }
}
