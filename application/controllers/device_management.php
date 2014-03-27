<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Device_management extends GEH_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("device_model");
    }

    public $device_management_view = 'device_management/';

    public function index()
    {
        $data['list_devices'] = $this->prepare_device_info($this->device_model->get_list());
        $extend_data['content_view'] = $this->load->view($this->device_management_view . 'index', $data, TRUE);

        $this->load_frontend_template($extend_data, 'DEVICE MANAGEMENT');
    }

    private function prepare_device_info($data)
    {
        foreach($data as &$item) {
            $item['device_location'] = $item['floor_name'] . ', ' . $item['zone_name'] . ', ' . $item['room_name'];
            if($item['device_status'] == STATUS_PENDING_TEACH_IN)
                $item['teach_in_status'] = 'Pending';
            else
                $item['teach_in_status'] = 'Taught-in';
        }

       return $data;
    }

    public function modify()
    {
        $this->load->model(array(
            'floor_model',
            'zone_model',
            'room_model',
            'device_type_model'
        ));
        $data['floor_list'] = $this->floor_model->get_list();
        $data['device_type_list'] = $this->device_type_model->get_list();

        // Case: edit device
        if(isset($_GET['id'])) {
            $data['device'] = $this->device_model->get_by_id($_GET['id']);

            $extend_data['content_view'] = $this->load->view($this->device_management_view . 'edit_device', $data, TRUE);
            $this->load_frontend_template($extend_data, 'EDIT DEVICE INFORMATION');
        }
        // Case: add new device
        else {
            $extend_data['content_view'] = $this->load->view($this->device_management_view . 'add_device', $data, TRUE);
            $this->load_frontend_template($extend_data, 'ADD NEW DEVICE');
        }
    }
}

/* End of file device_management.php */
/* Location: ./application/controllers/device_management.php */