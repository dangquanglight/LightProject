<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Control extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('control');
    }
}

/* End of file control.php */
/* Location: ./application/controllers/control.php */