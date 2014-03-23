<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Control extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data = new ArrayObject();
        $extend_data['content_view'] = $this->load->view('control', $data, TRUE);

        $this->load_frontend_template($extend_data, 'CONTROL');
    }
}

/* End of file control.php */
/* Location: ./application/controllers/control.php */