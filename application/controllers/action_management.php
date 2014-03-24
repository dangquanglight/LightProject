<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Action_management extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

    public $action_management_view = 'action_management/';

    public function index()
    {
        $data = new ArrayObject();
        $extend_data['content_view'] = $this->load->view($this->action_management_view . 'index', $data, TRUE);

        $this->load_frontend_template($extend_data, 'ACTION MANAGEMENT');
    }

    public function schedule()
    {
        $data = new ArrayObject();
        $extend_data['content_view'] = $this->load->view($this->action_management_view . 'manage_by_schedule', $data, TRUE);

        $this->load_frontend_template($extend_data, 'ACTION MANAGEMENT BY SCHEDULE');
    }

    public function event()
    {
        $data = new ArrayObject();
        $extend_data['content_view'] = $this->load->view($this->action_management_view . 'manage_by_event', $data, TRUE);

        $this->load_frontend_template($extend_data, 'ACTION MANAGEMENT BY EVENT');
    }
}

/* End of file action_management.php */
/* Location: ./application/controllers/action_management.php */