<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');
require APPPATH . 'core/REST_Controller.php';

class Ajax extends REST_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function get_zones_get() {
        $this->response($this->get_zones_list($this->input->get('floorID')));
    }

    public function get_rooms_get() {
        $this->response($this->get_rooms_list($this->input->get('zoneID')));
    }

}
