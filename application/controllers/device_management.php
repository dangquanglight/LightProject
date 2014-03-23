<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Device_management extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('device_management');
    }
}

/* End of file device_management.php */
/* Location: ./application/controllers/device_management.php */