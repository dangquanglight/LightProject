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
            'action_condition_model',
            'device_model',
            'device_state_model',
            'device_setpoint_model',
            'mode_control_detail_model'
        ));
    }

    public $action_management_view = 'action_management/';

    public function index()
    {
        if ($this->input->post()) { //var_dump($this->input->post()); die();
            if (isset($_GET['callback'])) {
                if ($_GET['callback'] == CALLBACK_ADD_EDIT_MODE_CONTROL) {
                    redirect(add_new_action_with_callback_url("event",
                        $this->input->post('controlled_device'), CALLBACK_ADD_EDIT_MODE_CONTROL, $_GET['data']
                    ));
                }
            } else {
                // Go to page add new action with controlled device id GET value
                redirect(add_new_action_url($this->input->post('action_type'), $this->input->post('controlled_device')));
            }
        }

        // List actions of all modes
        $mode_actions = $this->mode_control_detail_model->get_list();
        $mode_actions_id_list = array();
        $i = 0;
        foreach($mode_actions as $item) {
            $mode_actions_id_list[$i] = $item['action_id'];
            $i++;
        }

        if(count($mode_actions_id_list) > 0) {
            $actions_list = $this->actions_model->get_list_index($mode_actions_id_list);
        }
        else {
            $actions_list = $this->actions_model->get_list();
        }

        $data['actions_list'] = $this->prepare_action_list_info($actions_list);
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
                $item['status'] = 'Disable';
        }

        return $data;
    }

    public function modify()
    {
        // Insert / Update data into database
        if ($this->input->post()) { //var_dump($this->input->post()); die();
            // Flash data successful
            $add_new_success_message = 'Add new action successful!';
            $edit_success_message = 'Edit action successful!';

            // Get exception day from - to
            if ($this->input->post('exception_type')) {
                $exception_from = $this->input->post('exception_type') == EXCEPTION_TYPE_DAY ?
                    date('Y-m-d', strtotime($this->input->post('exception_day'))) :
                    date('Y-m-d', strtotime($this->input->post('exception_from')));

                $exception_to = $this->input->post('exception_type') == EXCEPTION_TYPE_DURATION ?
                    date('Y-m-d', strtotime($this->input->post('exception_to'))) : NULL;
            }
            else {
                $exception_from = $exception_to = NULL;
            }

            // Action type Schedule
            if ((isset($_GET['action_type']) and $_GET['action_type'] == 'schedule') or (isset($_POST['action_type']) and $_POST['action_type'] == 'schedule')) {
                if ($this->input->post('schedule_day')) {
                    // Create string schedule days
                    $schedule_days = implode(',', $this->input->post('schedule_day'));
                }
                else {
                    $schedule_days = NULL;
                }

                $data = array(
                    'device_id' => $this->input->post('action_device_id'),
                    'status' => intval($this->input->post('action_status')),
                    'action_type' => ACTION_TYPE_SCHEDULE,
                    'action_setpoint' => floatval($this->input->post('action_setpoint')),
                    'schedule_days' => $schedule_days,
                    'schedule_start' => $this->input->post('time_start'),
                    'schedule_end' => $this->input->post('time_end'),
                    'exception_type' => $this->input->post('exception_type'),
                    'exception_from' => $exception_from,
                    'exception_to' => $exception_to,
                    'exception_setpoint' => floatval($this->input->post('exception_setpoint')),
                    'created_date' => time()
                );

                // Edit action
                if (isset($_GET['id']) and (is_numeric($_GET['id']) and intval($_GET['id'] > 0))) {
                    if ($this->actions_model->update($_GET['id'], $data)) {
                        $this->session->set_flashdata($this->flash_success_session, $edit_success_message);

                        if (isset($_GET['callback'])) {
                            if ($_GET['callback'] == CALLBACK_ADD_EDIT_MODE_CONTROL) {
                                redirect(edit_mode_url($_GET['data']));
                            }
                        }
                        else {
                            $this->session->set_flashdata('call_client', $this->client_address);
                            redirect(action_management_controller_url());
                        }
                    }
                }
                // Add new action
                else if (isset($_GET['action_type']) and ($_GET['action_type'] == 'schedule' or $_GET['action_type'] == 'event')) {
                    if ($action_id = $this->actions_model->insert($data)) {
                        $this->session->set_flashdata($this->flash_success_session, $add_new_success_message);

                        if (isset($_GET['callback'])) {
                            if ($_GET['callback'] == CALLBACK_ADD_EDIT_MODE_CONTROL) {
                                $this->load->model('mode_control_detail_model');
                                $data = array(
                                    'action_id' => $action_id,
                                    'mode_id' => $_GET['data']
                                );

                                if ($this->mode_control_detail_model->insert($data)) {
                                    redirect(edit_mode_url($_GET['data']));
                                }
                            }
                        }
                        else {
                            $this->session->set_flashdata('call_client', $this->client_address);
                            redirect(action_management_controller_url());
                        }
                    }
                }
            }
            // Action type event
            else if ((isset($_GET['action_type']) and $_GET['action_type'] == 'event') or (isset($_POST['action_type']) and $_POST['action_type'] == 'event')) {
                $data = array(
                    'device_id' => $this->input->post('action_device_id'),
                    'status' => intval($this->input->post('action_status')),
                    'action_type' => ACTION_TYPE_EVENT,
                    'action_setpoint' => floatval($this->input->post('action_setpoint')),
                    'exception_type' => $this->input->post('exception_type'),
                    'exception_from' => $exception_from,
                    'exception_to' => $exception_to,
                    'exception_setpoint' => floatval($this->input->post('exception_setpoint')),
                    'created_date' => time()
                );
                //TODO: Find new way to edit action event
                // Edit action
                if (isset($_GET['id']) and (is_numeric($_GET['id']) and intval($_GET['id'] > 0))) {
                    if ($this->actions_model->update($_GET['id'], $data)) {
                        // Find all condions of this action and delete it first
                        $conditions = $this->action_condition_model->get_by_action_id($_GET['id']);
                        if ($conditions) {
                            foreach ($conditions as $condition) {
                                $this->action_condition_model->delete($condition['id']);
                            }
                        }

                        if ($this->input->post('input_device') and count($this->input->post('input_device')) > 0) {
                            $flag = FALSE;

                            // Remove all action condition and insert the new one to database
                            for ($i = 0; $i < count($this->input->post('input_device')); $i++) {
                                $row_device_id = $this->input->post('input_device');
                                $operator = $this->input->post('operator');
                                $condition_setpoint = $this->input->post('condition_setpoint');

                                $data = array(
                                    'action_id' => $_GET['id'],
                                    'row_device_id' => $row_device_id[$i],
                                    'operator' => $operator[$i],
                                    'condition_setpoint' => $condition_setpoint[$i]
                                );
                                if ($this->action_condition_model->insert($data))
                                    $flag = TRUE;
                            }
                        }
                        else {
                            $flag = TRUE;
                        }

                        $this->session->set_flashdata($this->flash_success_session, $edit_success_message);
                        if (isset($_GET['callback'])) {
                            if ($_GET['callback'] == CALLBACK_ADD_EDIT_MODE_CONTROL) {
                                redirect(edit_mode_url($_GET['data']));
                            }
                        }
                        else if ($flag) {
                            $this->session->set_flashdata('call_client', $this->client_address);
                            redirect(action_management_controller_url());
                        }
                    }
                }
                // Add new action
                else if (isset($_GET['action_type']) and ($_GET['action_type'] == 'schedule' or $_GET['action_type'] == 'event')) {
                    if ($action_id = $this->actions_model->insert($data)) {
                        if ($this->input->post('input_device') and count($this->input->post('input_device')) > 0) {
                            $flag = FALSE;

                            for ($i = 0; $i < count($this->input->post('input_device')); $i++) {
                                $row_device_id = $this->input->post('input_device');
                                $operator = $this->input->post('operator');
                                $condition_setpoint = $this->input->post('condition_setpoint');

                                $data = array(
                                    'action_id' => $action_id,
                                    'row_device_id' => $row_device_id[$i],
                                    'operator' => $operator[$i],
                                    'condition_setpoint' => $condition_setpoint[$i]
                                );
                                if ($this->action_condition_model->insert($data))
                                    $flag = TRUE;
                            }
                        }
                        else {
                            $flag = TRUE;
                        }

                        $this->session->set_flashdata($this->flash_success_session, $add_new_success_message);
                        if (isset($_GET['callback'])) {
                            if ($_GET['callback'] == CALLBACK_ADD_EDIT_MODE_CONTROL) {
                                $this->load->model('mode_control_detail_model');
                                $data = array(
                                    'action_id' => $action_id,
                                    'mode_id' => $_GET['data']
                                );

                                if ($this->mode_control_detail_model->insert($data)) {
                                    redirect(edit_mode_url($_GET['data']));
                                }
                            }
                        }
                        else if ($flag) {
                            $this->session->set_flashdata('call_client', $this->client_address);
                            redirect(action_management_controller_url());
                        }
                    }
                }
            }
        }

        // Get state id by state name: Input
        $state = $this->device_state_model->get_by_name(DEVICE_STATE_INPUT);
        // Get list input devices
        $input_devices = $this->device_model->get_list_by_state_id($state['id']);
        $data['input_devices_list'] = $input_devices;

        // Case: edit action
        if (isset($_GET['id']) and (is_numeric($_GET['id']) and intval($_GET['id'] > 0))) {
            // Get action detail information
            $action = $this->actions_model->get_by_id($_GET['id']);
            $data['action'] = $this->prepare_action_info($action);

            // Get device detail information
            $device = $this->device_model->get_by_row_id($action['device_id']);
            $data['device'] = $device;

            // Action type: schedule
            if ($action['action_type'] == ACTION_TYPE_SCHEDULE) {
                $data['action_type'] = 'schedule';
                $extend_data['content_view'] = $this->load->view($this->action_management_view . 'edit_action_schedule',
                    $data, TRUE);

            } // Action type: event
            else if ($action['action_type'] == ACTION_TYPE_EVENT) {
                $action_conditions = $this->action_condition_model->get_by_action_id($action['id']);
                $data['action_conditions'] = $action_conditions;

                //Remove input device of conditions from list input device
                $temp_input_device = $input_devices;
                foreach ($temp_input_device as $key => &$value) {
                    foreach ($action_conditions as $item) {
                        if ($item['row_device_id'] == $value['row_device_id']) {
                            unset($temp_input_device[$key]);
                        }
                    }
                }
                $data['new_input_devices'] = $temp_input_device;
                $data['action_type'] = 'event';

                if (isset($_GET['callback'])) {
                    if ($_GET['callback'] == CALLBACK_ADD_EDIT_MODE_CONTROL) {
                        $extend_data['content_view'] = $this->load->view($this->action_management_view . 'edit_action_event_page_control',
                            $data, TRUE);
                    }
                }
                else {
                    $extend_data['content_view'] = $this->load->view($this->action_management_view . 'edit_action_event',
                        $data, TRUE);
                }
            }

            $this->load_frontend_template($extend_data, 'EDIT ACTION');
        }
        // Case: add new action
        else if (isset($_GET['action_type']) and ($_GET['action_type'] == 'schedule' or $_GET['action_type'] == 'event')) {
            $action_type = $_GET['action_type'];
            $device = $this->device_model->get_by_row_id($_GET['row_device_id']);
            $data['device'] = $device;
            $data['device_setpoints'] = $this->device_setpoint_model->get_by_device_row_id($device['id']);

            // Action type: schedule
            if ($action_type == 'schedule') {
                $extend_data['content_view'] = $this->load->view($this->action_management_view . 'add_action_schedule',
                    $data, TRUE);
            } // Action type: event
            else if ($action_type == 'event') {
                if (isset($_GET['callback'])) {
                    if ($_GET['callback'] == CALLBACK_ADD_EDIT_MODE_CONTROL) {
                        $extend_data['content_view'] = $this->load->view($this->action_management_view . 'add_action_event_page_control',
                            $data, TRUE);
                    }
                }
                else {
                    $extend_data['content_view'] = $this->load->view($this->action_management_view . 'add_action_event',
                        $data, TRUE);
                }
            }

            $this->load_frontend_template($extend_data, 'ADD NEW ACTION');
        }
        else
            redirect(action_management_controller_url());
    }

    public function delete()
    {
        if ($this->input->get('id')) {
            $action_id = $this->input->get('id');
            // Find all condions of this action and delete it first
            $conditions = $this->action_condition_model->get_by_action_id($action_id);
            if ($conditions) {
                foreach ($conditions as $condition) {
                    $this->action_condition_model->delete($condition['id']);
                }
            }

            // Delete action after delete all its condition
            if ($this->actions_model->delete($action_id)) {
                $this->session->set_flashdata($this->flash_success_session, 'Action has been removed successful!');
                redirect(action_management_controller_url());
            }
        }
    }

    private function prepare_action_info($data)
    {
        // Action schedule day
        if ($data['action_type'] == ACTION_TYPE_SCHEDULE) {
            $data['schedule_days'] = explode(",", $data['schedule_days']);
        }

        return $data;
    }

}

/* End of file action_management.php */
/* Location: ./application/controllers/action_management.php */