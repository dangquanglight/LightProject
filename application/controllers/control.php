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
        $this->load->model('device_model');

        $data['list_controlled_devices'] = $this->device_model->get_by_device_state(DEVICE_STATE_CONTROLLED);
        $extend_data['content_view'] = $this->load->view($this->control_view . 'detail', $data, TRUE);

        $this->load_frontend_template($extend_data, 'CONTROL MODE DETAIL');
    }

    public function modify()
    {
        $this->load->model('device_model');

        $data['list_controlled_devices'] = $this->device_model->get_by_device_state(DEVICE_STATE_CONTROLLED);
        $extend_data['content_view'] = $this->load->view($this->control_view . 'detail', $data, TRUE);

        $this->load_frontend_template($extend_data, 'CONTROL MODE DETAIL');
    }
}

/* End of file control.php */
/* Location: ./application/controllers/control.php */