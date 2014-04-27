<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Action_management extends GEH_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'actions_model',
            'device_model',
            'device_state_model',
            'device_setpoint_model'
        ));
    }

    public $action_management_view = 'action_management/';

    public function index()
    {
        if($this->input->post()) {
            // Go to page add new action with controlled device id GET value
            redirect(add_new_action_url($this->input->post('action_type')) . '&row_device_id=' . $this->input->post('controlled_device'));
        }

        $data['actions_list'] = $this->prepare_action_list_info($this->actions_model->get_list());
        $data['controlled_devices_list'] = $this->device_model->get_by_device_state(DEVICE_STATE_CONTROLLED);
        $extend_data['content_view'] = $this->load->view($this->action_management_view . 'index', $data, TRUE);

        $this->load_frontend_template($extend_data, 'ACTION MANAGEMENT');
    }

    private function prepare_action_list_info($data)
    {
        foreach ($data as &$item) {
            // Action type
            if ($item['action_type'] == ACTION_TYPE_SCHEDULE)
                $item['action_type'] = 'Schedule';
            else
                $item['action_type'] = 'Event';
            // Action status
            if ($item['status'] == ACTION_ENABLE)
                $item['status'] = 'Enable';
            else
                $item['status'] = 'Disalbe';
        }

        return $data;
    }

    public function modify()
    {//var_dump($this->input->post()); die();
        // Get state id by state name: Input
        $state = $this->device_state_model->get_by_name(DEVICE_STATE_INPUT);
        // Get list input devices
        $data['input_devices_list'] = $this->device_model->get_list_by_state_id($state['id']);

        // Case: edit action
        if ( isset($_GET['id']) and (is_numeric($_GET['id']) and intval($_GET['id'] > 0)) ) {
            $action = $this->actions_model->get_by_id($_GET['id']);
            $data['action'] = $this->prepare_action_info($action);

            $device = $this->device_model->get_by_row_id($action['device_id']);
            $data['device'] = $device;
            $data['device_setpoints'] = $this->device_setpoint_model->get_by_device_row_id($device['id']);

            // Action type: schedule
            if ($action['action_type'] == ACTION_TYPE_SCHEDULE) {
                $extend_data['content_view'] = $this->load->view($this->action_management_view . 'edit_action_schedule', $data, TRUE);

            }
            // Action type: event
            else if ($action['action_type'] == ACTION_TYPE_EVENT) {
                $extend_data['content_view'] = $this->load->view($this->action_management_view . 'edit_action_event', $data, TRUE);
            }

            $this->load_frontend_template($extend_data, 'EDIT ACTION');
        }

        // Case: add new action
        else if( isset($_GET['action_type']) and ($_GET['action_type'] == 'schedule' or $_GET['action_type'] == 'event') ) {
            $action_type = $_GET['action_type'];
            $device = $this->device_model->get_by_row_id($_GET['row_device_id']);
            $data['device'] = $device;
            $data['device_setpoints'] = $this->device_setpoint_model->get_by_device_row_id($device['id']);

            // Action type: schedule
            if ($action_type == 'schedule') {
                $extend_data['content_view'] = $this->load->view($this->action_management_view . 'add_action_schedule', $data, TRUE);
            }
            // Action type: event
            else if ($action_type == 'event') {
                $extend_data['content_view'] = $this->load->view($this->action_management_view . 'add_action_event', $data, TRUE);
            }

            $this->load_frontend_template($extend_data, 'ADD NEW ACTION');
        }
        else if($this->input->post()) {
            var_dump($this->input->post()); die();
        }
        else
            redirect(action_management_controller_url());
    }

    private function prepare_action_info($data)
    {
        // Action schedule day
        if($data['action_type'] == ACTION_TYPE_SCHEDULE) {
            $data['schedule_days'] = explode(", ", $data['schedule_days']);
        }

        return $data;
    }

}

/* End of file action_management.php */
/* Location: ./application/controllers/action_management.php */