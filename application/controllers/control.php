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
        $data = new ArrayObject();
        $extend_data['content_view'] = $this->load->view($this->control_view . 'index', $data, TRUE);

        $this->load_frontend_template($extend_data, 'CONTROL');
    }

    public function detail()
    {
        $data = new ArrayObject();
        $extend_data['content_view'] = $this->load->view($this->control_view . 'detail', $data, TRUE);

        $this->load_frontend_template($extend_data, 'CONTROL MODE DETAIL');
    }
}

/* End of file control.php */
/* Location: ./application/controllers/control.php */