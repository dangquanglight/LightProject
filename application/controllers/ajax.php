<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');
require APPPATH . 'core/REST_Controller.php';

class Ajax extends REST_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function get_zones_get() {
        $zones_list = $this->get_zones_list($this->input->get('floorID'));

        if($this->input->get('option') and $this->input->get('option') == 'all') {
            array_push($zones_list, array(
                'id' => '0',
                'name' => 'All'
            ));
        }

        $this->response($zones_list);
    }

    public function get_rooms_get() {
        $rooms_list = $this->get_rooms_list($this->input->get('zoneID'));

        if($this->input->get('option') and $this->input->get('option') == 'all') {
            array_push($rooms_list, array(
                'id' => '0',
                'name' => 'All'
            ));
        }

        $this->response($rooms_list);
    }

    public function get_controlled_device_by_room_get() {
        $this->response($this->get_controlled_devices_list($this->input->get('roomID')));
    }

    public function get_setpoint_info_get() {
        $this->response($this->get_setpoint_info($this->input->get('deviceRowId')));
    }

    public function get_temperature_homepage_post() {
        $this->load->model(array(
            'device_model',
            'device_setpoint_model'
        ));

        $device = $this->device_model->get_by_device_id('018211CF');
        $setpoint = $this->device_setpoint_model->get_by_device_row_id($device['id']);
        $setpoint = 40 * (1 - $setpoint[1]['value'] / 255);

        $this->response(round($setpoint));
    }

}
