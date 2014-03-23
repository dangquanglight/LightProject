<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Device_management extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data = new ArrayObject();
        $extend_data['content_view'] = $this->load->view('device_management', $data, TRUE);

        $this->load_frontend_template($extend_data, 'DEVICE MANAGEMENT');
    }
}

/* End of file device_management.php */
/* Location: ./application/controllers/device_management.php */