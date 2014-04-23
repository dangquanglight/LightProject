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

}
