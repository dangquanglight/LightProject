<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mode_control extends GEH_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'floor_model',
            'device_model',
            'mode_control_model',
            'mode_control_detail_model',
            'actions_model'
        ));
    }

    public $control_view = 'control/';

    public function index()
    {
		
        if($this->input->post()) {
            $this->load->model('device_setpoint_model');
            $row_device_id = $this->input->post('device_id');
            $setpoint = $this->input->post('setpoint1');

            $device_setpoint = $this->device_setpoint_model->get_by_device_row_id($row_device_id);

            $data = array(
                'value' => $setpoint
            );
            if($this->device_setpoint_model->update($device_setpoint[0]['id'], $data)) {
                $this->session->set_flashdata($this->flash_success_session, 'Sending setpoint successful!');
                $this->session->set_flashdata('call_client', $this->client_address);
                redirect(control_controller_url());
            }
        }
		//$this->session->set_flashdata('call_client', $this->client_address);
        // Get floor list
        $data['floor_list'] = $this->floor_model->get_list();

        // Get list mode control
        $data['list_mode'] = $this->prepare_mode_info($this->mode_control_model->get_list());

        $extend_data['content_view'] = $this->load->view($this->control_view . 'index', $data, TRUE);
        $this->load_frontend_template($extend_data, 'CONTROL');
    }

    private function prepare_mode_info($data)
    {
        foreach ($data as &$item) {
            if ($item['status'] == MODE_CONTROL_ENABLE)
                $item['status'] = 'Enable';
            else if ($item['status'] == MODE_CONTROL_DISABLE)
                $item['status'] = 'Disable';
        }

        return $data;
    }

    public function change_status()
    {
        if(isset($_GET['id'])) {
            $mode = $this->mode_control_model->get_by_id($_GET['id']);
            if($mode) {
                if($mode['status'] == MODE_CONTROL_ENABLE) {
                    $data = array(
                        'status' => MODE_CONTROL_DISABLE
                    );
                }
                else if($mode['status'] == MODE_CONTROL_DISABLE) {
                    $data = array(
                        'status' => MODE_CONTROL_ENABLE
                    );

                    $all_modes_except_this_mode = $this->mode_control_model->get_not_in_by_id(array($_GET['id']));
                    foreach($all_modes_except_this_mode as $item) {
                        $update_data = array(
                            'status' => MODE_CONTROL_DISABLE
                        );
                        $this->mode_control_model->update($item['id'], $update_data);
                    }
                }

                if($this->mode_control_model->update($_GET['id'], $data)) {
                    $this->session->set_flashdata($this->flash_success_session, 'Mode status has been change successful!');
                    $this->session->set_flashdata('call_client', $this->client_mode_request);
                    redirect(control_controller_url());
                }
            }
        }
    }

    public function modify()
    {
        if ($this->input->post()) {
            // Add action to mode from existing action
            if($this->input->post('existing_actions_list')) {
                $list = $this->input->post('existing_actions_list');
                $flag = FALSE;

                foreach($list as $item) {
                    $data = array(
                        'action_id' => $item,
                        'mode_id' => $_GET['id']
                    );

                    if ($this->mode_control_detail_model->insert($data)) {
                        $flag = TRUE;
                    }
                }
                if($flag) {
                    $this->session->set_flashdata($this->flash_success_session, 'Add new action(s) successful!');
					//$this->session->set_flashdata('call_client', $this->client_action_request);
                    redirect(edit_mode_url($_GET['id']));
                }
            }

            // Add new mode control
            if (!isset($_GET['id'])) {
                $data = array(
                    'mode_name' => trim($this->input->post('mode_name')),
                    'status' => MODE_CONTROL_DISABLE,
                    'created_date' => time()
                );

                if ($mode_id = $this->mode_control_model->insert($data)) {
                    $this->session->set_flashdata($this->flash_success_session, 'Add new mode successful!');
                    redirect(edit_mode_url($mode_id));
                }
            }
            // Edit mode control
            else {
                $data = array(
                    'mode_name' => trim($this->input->post('mode_name')),
                    'created_date' => time()
                );

                if ($this->mode_control_model->update($_GET['id'], $data)) {
                    $this->session->set_flashdata($this->flash_success_session, 'Edit mode successful!');
                    redirect(control_controller_url());
                }
            }
        }

        $data['list_controlled_devices'] = $this->device_model->get_by_device_state(DEVICE_STATE_CONTROLLED);

        // Edit mode control
        if (isset($_GET['id']) and $_GET['id'] > 0) {
            $data['mode'] = $this->mode_control_model->get_by_id($_GET['id']);

            // Get all action of this mode
            $mode_actions = $this->mode_control_detail_model->get_by_mode_id($_GET['id']);
            $data['mode_actions'] = $this->prepare_action_list_info($mode_actions);

            // List all action from action management
            $actions_list = $this->actions_model->get_list();
            // Remove actions which already in actions list of mode
            foreach($actions_list as $key => &$value) {
                foreach($mode_actions as $item) {
                    if($value['action_id'] == $item['action_id'] and $value['action_type'] == $item['action_type'])
                        unset($actions_list[$key]);
                }
            }
            $data['actions_list'] = $this->prepare_action_list_info($actions_list);

            $extend_data['content_view'] = $this->load->view($this->control_view . 'edit_mode', $data, TRUE);
        }
        // Add new mode control
        else {
            $extend_data['content_view'] = $this->load->view($this->control_view . 'add_mode', $data, TRUE);
        }

        $this->load_frontend_template($extend_data, 'CONTROL MODE DETAIL');
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

    public function delete()
    {
        if ($this->input->get('id')) {
            $this->load->model(array(
                'actions_model',
                'action_condition_model'
            ));
            $mode_id = $this->input->get('id');
            $mode = $this->mode_control_model->get_by_id($mode_id);
            $flag = FALSE;

            if ($mode) {
                $mode_details = $this->mode_control_detail_model->get_by_mode_id($mode_id);

                if ($mode_details) {
                    foreach ($mode_details as $detail) {
                        if ($this->mode_control_detail_model->delete($detail['mode_detail_id']))
                            $flag = TRUE;

                        // Delete action has been created by this mode
                        $action = $this->actions_model->get_by_id($detail['action_id']);
                        if ($action) {
                            // Find all condions of this action and delete it first
                            $conditions = $this->action_condition_model->get_by_action_id($action['id']);
                            if ($conditions) {
                                foreach ($conditions as $condition) {
                                    $this->action_condition_model->delete($condition['id']);
                                }
                            }

                            if ($this->actions_model->delete($action['id']))
                                $flag = TRUE;
                        }
                    }
                }
                // Delete mode control
                if($this->mode_control_model->delete($mode_id))
                    $flag = TRUE;

                if ($flag) {
                    $this->session->set_flashdata($this->flash_success_session, 'Mode has been removed successful!');
                    redirect(control_controller_url());
                }
            }
        }
    }

    public function delete_action()
    {
        if ($this->input->get('id')) {
            $mode_detail_id = $this->input->get('id');
            $flag = FALSE;

            $mode_details = $this->mode_control_detail_model->get_by_id($mode_detail_id);
            if ($mode_details) {
                // Delete mode control detail
                if ($this->mode_control_detail_model->delete($mode_details['id']))
                    $flag = TRUE;

                // Delete action has been created by this mode
                $this->load->model(array(
                    'actions_model',
                    'action_condition_model'
                ));
                $action = $this->actions_model->get_by_id($mode_details['action_id']);

                if ($action) {
                    // Find all condions of this action and delete it first
                    $conditions = $this->action_condition_model->get_by_action_id($action['id']);
                    if ($conditions) {
                        foreach ($conditions as $condition) {
                            $this->action_condition_model->delete($condition['id']);
                        }
                    }

                    if ($this->actions_model->delete($action['id']))
                        $flag = TRUE;
                }
            }
            if ($flag) {
                $this->session->set_flashdata($this->flash_success_session, 'Action has been removed successful!');
                redirect(edit_mode_url($mode_details['mode_id']));
            }
        }
    }

}

/* End of file mode_control.php */
/* Location: ./application/controllers/mode_control.php */