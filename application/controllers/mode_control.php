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
        foreach ($data as &$item) {
            if ($item['status'] == MODE_CONTROL_ENABLE)
                $item['status'] = 'Enable';
            else if ($item['status'] == MODE_CONTROL_DISABLE)
                $item['status'] = 'Disable';
        }

        return $data;
    }

    public function modify()
    {
        if ($this->input->post()) {
            $data = array(
                'mode_name' => trim($this->input->post('mode_name')),
                'status' => $this->input->post('mode_status'),
                'created_date' => time()
            );

            // Add new mode control
            if (!isset($_GET['id'])) {
                if ($mode_id = $this->mode_control_model->insert($data)) {
                    $this->session->set_flashdata($this->flash_success_session, 'Add new mode successful!');
                    redirect(edit_mode_url($mode_id));
                }
            } // Edit mode control
            else { //var_dump($this->input->post()); die();
                if ($this->mode_control_model->update($_GET['id'], $data)) {
                    $actions_list = $this->input->post('actions_list');
                    $flag = FALSE;

                    if (!$actions_list or count($actions_list) == 0)
                        $flag = TRUE;
                    else {
                        // Delete all actions of this mode
                        $mode_actions = $this->mode_control_detail_model->get_by_mode_id($_GET['id']);
                        if ($mode_actions and count($mode_actions) != count($actions_list)) {
                            foreach ($mode_actions as $item) {
                                $this->mode_control_detail_model->delete($item['mode_detail_id']);
                            }
                        }

                        for ($i = 0; $i < count($actions_list); $i++) {
                            $data = array(
                                'mode_id' => $_GET['id'],
                                'action_id' => $actions_list[$i]
                            );
                            if ($mode_actions and count($mode_actions) == count($actions_list)) {
                                if ($this->mode_control_detail_model->update($mode_actions[$i]['mode_detail_id'], $data))
                                    $flag = TRUE;
                            } else {
                                if ($this->mode_control_detail_model->insert($data))
                                    $flag = TRUE;
                            }
                        }
                    }
                    if ($flag) {
                        $this->session->set_flashdata($this->flash_success_session, 'Edit mode successful!');
                        redirect(control_controller_url());
                    }
                }
            }
        }

        $data['list_controlled_devices'] = $this->device_model->get_by_device_state(DEVICE_STATE_CONTROLLED);

        // Edit mode control
        if (isset($_GET['id']) and $_GET['id'] > 0) {
            $data['mode'] = $this->mode_control_model->get_by_id($_GET['id']);
            // Get all action of this mode
            $data['mode_actions'] = $this->prepare_action_list_info($this->mode_control_detail_model->get_by_mode_id($_GET['id']));

            $extend_data['content_view'] = $this->load->view($this->control_view . 'edit_mode', $data, TRUE);
        } // Add new mode control
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
            $this->load->model('actions_model');
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
                            if ($this->actions_model->delete($action['id']))
                                $flag = TRUE;
                        }
                    }
                }
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
                $this->load->model('actions_model');
                $action = $this->actions_model->get_by_id($mode_details['action_id']);
                if ($action) {
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

/* End of file control.php */
/* Location: ./application/controllers/control.php */