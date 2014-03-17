<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Action_management extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('action_management');
    }
}

/* End of file action_management.php */
/* Location: ./application/controllers/action_management.php */