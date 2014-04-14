<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Device_management extends GEH_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("device_model");
    }

    public $device_management_view = 'device_management/';

    public function index()
    {
        $this->load->model(array(
            'floor_model',
            'zone_model',
            'room_model'
        ));

        // Get floor list
        $data['floor_list'] = $this->floor_model->get_list();

        // Filter device by location
        if ($this->input->get()) {
            if (is_numeric($_GET['floor']) and is_numeric($_GET['zone']) and is_numeric($_GET['room'])) {
                if ($_GET['floor'] == 0 or $_GET['zone'] == 0 or $_GET['room'] == 0) {
                    // List device of all floors
                    if ($_GET['floor'] == 0) {
                        // Get devices list
                        $data['list_devices'] = $this->prepare_device_info($this->device_model->get_list());
                        $extend_data['content_view'] = $this->load->view(
                            $this->device_management_view . 'index', $data, TRUE);
                    }
                    // List device of all zones
                    else if ($_GET['zone'] == 0) {
                        $list_devices = array();
                        $zones_list = $this->zone_model->get_by_floor_id($_GET['floor']);
                        foreach ($zones_list as $zone) {
                            $rooms_list = $this->room_model->get_by_zone_id($zone['zone_id']);
                            foreach ($rooms_list as $room) {
                                array_push(
                                    $list_devices,
                                    $this->prepare_device_info($this->device_model->get_list_by_room_id($room['room_id']))
                                );
                            }
                        }
                        $data['list_devices'] = $list_devices[0];
                        $extend_data['content_view'] = $this->load->view(
                            $this->device_management_view . 'index_filter', $data, TRUE);
                    }
                    // List device of all rooms
                    else if ($_GET['room'] == 0) {
                        $list_devices = array();
                        $zone = $this->zone_model->get_by_id($_GET['zone']);
                        $rooms_list = $this->room_model->get_by_zone_id($zone['id']);
                        foreach ($rooms_list as $room) {
                            array_push(
                                $list_devices,
                                $this->prepare_device_info($this->device_model->get_list_by_room_id($room['room_id']))
                            );
                        }
                        $data['list_devices'] = $list_devices[0];
                        $extend_data['content_view'] = $this->load->view(
                            $this->device_management_view . 'index_filter', $data, TRUE);
                    }
                }
                else {
                    // Get devices list
                    $data['list_devices'] = $this->prepare_device_info($this->device_model->get_list_by_room_id($_GET['room']));
                    $extend_data['content_view'] = $this->load->view($this->device_management_view . 'index_filter', $data, TRUE);
                }
            }
        }
        else {
            // Get devices list
            $data['list_devices'] = $this->prepare_device_info($this->device_model->get_list());
            $extend_data['content_view'] = $this->load->view($this->device_management_view . 'index', $data, TRUE);
        }

        $this->load_frontend_template($extend_data, 'DEVICE MANAGEMENT');
    }

    private function prepare_device_info($data)
    {
        foreach ($data as &$item) {
            $item['device_location'] = $item['floor_name'] . ', ' . $item['zone_name'] . ', ' . $item['room_name'];
            $item['state_name'] = ucfirst($item['state_name']);
            if ($item['device_status'] == STATUS_PENDING_TEACH_IN)
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
            'device_type_model',
            'device_state_model',
            'device_type_model'
        ));

        $data['floor_list'] = $this->floor_model->get_list();
        $data['device_type_list'] = $this->device_type_model->get_list();

        // List temperature devices
        $type = $this->device_type_model->get_by_short_name('TEMP');
        $data['temp_devices_list'] = $this->device_model->get_list_by_device_type_id($type['id']);

        // List internal temperature sensor devices
        $type = $this->device_type_model->get_by_short_name('INTERNAL');
        $data['internal_devices_list'] = $this->device_model->get_list_by_device_type_id($type['id']);

        // Get list input devices
        $state = $this->device_state_model->get_by_name(DEVICE_STATE_INPUT);
        $data['input_devices'] = $this->device_model->get_list_by_state_id($state['id']);

        // Case: edit device
        if (isset($_GET['id'])) {
            $data['device'] = $this->device_model->get_by_row_id($_GET['id']);

            $extend_data['content_view'] = $this->load->view($this->device_management_view . 'edit_device', $data, TRUE);
            $this->load_frontend_template($extend_data, 'EDIT DEVICE INFORMATION');
        } // Case: add new device
        else {
            $extend_data['content_view'] = $this->load->view($this->device_management_view . 'add_device', $data, TRUE);
            $this->load_frontend_template($extend_data, 'ADD NEW DEVICE');
        }
    }
}

/* End of file device_management.php */
/* Location: ./application/controllers/device_management.php */