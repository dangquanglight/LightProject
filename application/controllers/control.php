<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Control extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

    public $control_view = 'control/';

    public function index()
    {
        $this->load->model('floor_model');
        // Get floor list
        $data['floor_list'] = $this->floor_model->get_list();

        $extend_data['content_view'] = $this->load->view($this->control_view . 'index', $data, TRUE);
        $this->load_frontend_template($extend_data, 'CONTROL');
    }

    public function detail()
    {
        $data = new ArrayObject();

        $extend_data['content_view'] = $this->load->view($this->control_view . 'detail', $data, TRUE);
        $this->load_frontend_template($extend_data, 'CONTROL MODE DETAIL');
    }

    public function modify()
    {
        $data = new ArrayObject();

        $extend_data['content_view'] = $this->load->view($this->control_view . 'detail', $data, TRUE);
        $this->load_frontend_template($extend_data, 'CONTROL MODE DETAIL');
    }
}

/* End of file control.php */
/* Location: ./application/controllers/control.php */