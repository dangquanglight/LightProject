<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Device_management extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

    public $device_management_view = 'device_management/';

    public function index()
    {
        $data = new ArrayObject();
        $extend_data['content_view'] = $this->load->view($this->device_management_view . 'index', $data, TRUE);

        $this->load_frontend_template($extend_data, 'DEVICE MANAGEMENT');
    }

    public function modify()
    {
        $data = new ArrayObject();
        if(isset($_GET['id'])) {
            $extend_data['content_view'] = $this->load->view($this->device_management_view . 'edit_device', $data, TRUE);

            $this->load_frontend_template($extend_data, 'EDIT DEVICE INFORMATION');
        }
        else {
            $extend_data['content_view'] = $this->load->view($this->device_management_view . 'add_device', $data, TRUE);

            $this->load_frontend_template($extend_data, 'ADD NEW DEVICE');
        }
    }
}

/* End of file device_management.php */
/* Location: ./application/controllers/device_management.php */