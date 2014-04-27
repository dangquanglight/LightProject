<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

	public function index()
	{
        $this->load->model(array(
            'floor_model',
            'device_model',
            'device_setpoint_model'
        ));

        $data['floor_list'] = $this->floor_model->get_list();
        $device = $this->device_model->get_by_device_id('018211CF');
        $data['temp_value'] = $this->device_setpoint_model->get_by_device_row_id($device['id']);

        $extend_data['content_view'] = $this->load->view('home', $data, TRUE);
        $this->load_frontend_template($extend_data, 'HOMEPAGE');
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */