<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Mode_control extends GEH_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array(
            'floor_model',
            'device_model',
            'mode_control_model',
            'mode_control_detail_model'
        ));
    }

    public $control_view = 'control/';

    public function index()
    {
        // Get floor list
        $data['floor_list'] = $this->floor_model->get_list();

        // Get list mode control
        $data['list_mode'] = $this->prepare_mode_info($this->mode_control_model->get_list());

        $extend_data['content_view'] = $this->load->view($this->control_view . 'index', $data, TRUE);
        $this->load_frontend_template($extend_data, 'CONTROL');
    }

    private function prepare_mode_info($data)
    {
        foreach($data as &$item) {
            if($item['status'] == MODE_CONTROL_ENABLE)
                $item['status'] = 'Enable';
            else if($item['status'] == MODE_CONTROL_DISABLE)
                $item['status'] = 'Disable';
        }

        return $data;
    }

    public function modify()
    {
        if($this->input->post()) {
            // Add new mode control
            if(!isset($_GET['id'])) {
                $data = array(
                    'mode_name' => trim($this->input->post('mode_name')),
                    'status' => $this->input->post('mode_status'),
                    'created_date' => time()
                );

                if($mode_id = $this->mode_control_model->insert($data)) {
                    redirect(edit_mode_url($mode_id));
                }
            }
            // Edit mode control
            else {

            }
        }

        $data['list_controlled_devices'] = $this->device_model->get_by_device_state(DEVICE_STATE_CONTROLLED);

        // Edit mode control
        if(isset($_GET['id']) and $_GET['id'] > 0) {
            $data['mode'] = $this->mode_control_model->get_by_id($_GET['id']);
            // Get all action of this mode
            $data['mode_actions'] = $this->mode_control_detail_model->get_by_mode_id($_GET['id']);

            $extend_data['content_view'] = $this->load->view($this->control_view . 'edit_mode', $data, TRUE);
        }

        // Add new mode control
        else {
            $extend_data['content_view'] = $this->load->view($this->control_view . 'add_mode', $data, TRUE);
        }

        $this->load_frontend_template($extend_data, 'CONTROL MODE DETAIL');
    }
}

/* End of file control.php */
/* Location: ./application/controllers/control.php */