<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends GEH_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_config()
    {
        if (isset($_GET['ID']) and strlen($_GET['ID']) == 8) {
            $device_id = $_GET['ID'];
            $output = '';
            $this->load->model(array(
                'device_model',
                'device_type_model',
                'device_setpoint_model'
            ));

            $eohub = $this->device_model->get_by_device_id($device_id);
            if ($eohub) {
                $relation_device_type_list = $this->device_type_model->get_controller_type($eohub['device_type_id']);
                foreach ($relation_device_type_list as $item) {
                    $devices_list = $this->device_model->get_list_by_device_type_id($item['type_id']);
                    foreach ($devices_list as $item2) {
                        $device_setpoins = $this->device_setpoint_model->get_by_device_row_id($item2['row_device_id']);
                        $setpoints_output = '';

                        // Assign setpoint string
                        foreach ($device_setpoins as $item3) {
                            if ($item3['value'] == NULL)
                                $setpoints_output .= 'FF';
                            else {
                                $setpoints_output .= strtoupper(dechex($item3['value']));
                                if (strlen($setpoints_output) == 1)
                                    $setpoints_output = '0' . $setpoints_output;
                            }
                        }
                        // if device not have any setpoint, assign FFFF to it
                        if (count($device_setpoins) == 1)
                            $setpoints_output .= 'FF';
                        else if (count($device_setpoins) == 0)
                            $setpoints_output .= 'FFFF';

                        $output .= '?' . $item2['device_id'] . $item2['eep'] . $setpoints_output;
                    }
                }

                $fixxed_length_number = 4;
                // Get length of output string
                $strlen = strlen($output);
                // Get length of output string and string $strlen
                $strlen = $strlen + $fixxed_length_number;
                $strlen = strval($strlen);

                if (strlen($strlen) < $fixxed_length_number) {
                    for ($i = 0; $i < $fixxed_length_number - strlen($strlen); $i++) {
                        $strlen = '0' . $strlen;
                    }
                }

                echo $strlen, $output;
            } else
                redirect(home_url());
        } else
            redirect(home_url());
    }

    public function get_status()
    {
        if (isset($_GET['ID']) and strlen($_GET['ID']) == 8) {
            $device_id = $_GET['ID'];
            $output = '';
            $this->load->model(array(
                'device_model',
                'device_type_model',
                'device_setpoint_model',
                'device_setpoint_log_model',
                'device_state_model'
            ));

            $device = $this->device_model->get_by_device_id($device_id);
            if ($device) {
                $state = $this->device_state_model->get_by_name(DEVICE_STATE_CONTROLLED);
                $relation_device_type_list = $this->device_type_model->get_controller_type_and_state($device['device_type_id'], $state['id']);
                $count = 0;
                $flag_none = TRUE;

                foreach ($relation_device_type_list as $item) {
                    $devices_list = $this->device_model->get_list_by_device_type_id($item['type_id']);

                    foreach ($devices_list as $item2) {
                        $setpoints_output = '';
                        $device_setpoins = $this->device_setpoint_model->get_by_device_row_id($item2['row_device_id']);
                        $setpoint_log = $this->device_setpoint_log_model->get_latest_setpoint($device['id']);

                        // Assign setpoint string
                        foreach ($device_setpoins as $item3) {
                            if ($item3['value'] == NULL)
                                $setpoints_output .= 'FF';
                            else {
                                if ($item2['property_name'] == 'Temperature sensor') {
                                    $temp = (1 - ($item3['value'] / 40)) * 255;
                                    $setpoints_output .= strtoupper(dechex($temp));
                                }
                                else {
                                    $setpoints_output .= strtoupper(dechex($item3['value']));
                                }

                                if (strlen($setpoints_output) == 1)
                                    $setpoints_output = '0' . $setpoints_output;
                            }
                        }
                        // if device not have any setpoint, assign FFFF to it
                        if (count($device_setpoins) == 1)
                            $setpoints_output .= 'FF';
                        else if (count($device_setpoins) == 0)
                            $setpoints_output .= 'FFFF';

                        if (count($setpoint_log) == 0)
                            $flag_none = FALSE;
                        else {
                            foreach ($device_setpoins as $setpoint) {
                                if ($setpoint['value'] != $setpoint_log['current_setpoint']) {
                                    $flag_none = FALSE;
                                }
                            }
                        }

                        if (!$flag_none) {
                            if ($count == 0)
                                $output .= 'UPD_CMMD?' . $item2['device_id'] . $setpoints_output;
                            else
                                $output .= '?' . $item2['device_id'] . $setpoints_output;
                        }
                        $count++;
                    }
                }
                if ($flag_none)
                    $output .= 'UPD_NONE';

                echo $output;
            }
            else
                redirect(home_url());
        }
        else
            redirect(home_url());
    }

    public function post_value()
    {
        if (isset($_POST['len']) and isset($_POST['val'])) {
            $strlen = $_POST['len'];
            $strval = $_POST['val'];
            $this->load->model(array(
                'device_model',
                'device_setpoint_model'
            ));
            $flag_ok = false;

            if ($strlen == strlen($strval)) {
                $strdata = explode('?', $strval);
                foreach ($strdata as $item) {
                    if ($item) {
                        $device_id = intval(substr($item, 0, 8));
                        $setponit = substr($item, 8);
                        $setpoint1 = hexdec(substr($setponit, 0, 2));
                        $setponit2 = hexdec(substr($setponit, 2));

                        $device = $this->device_model->get_by_device_id($device_id);
                        $device_setpoint = $this->device_setpoint_model->get_by_device_row_id($device['id']);

                        // If device has value in DB, just update it
                        if ($device_setpoint) {
                            foreach ($device_setpoint as $item2) {
                                if (count($device_setpoint) == 1) {
                                    if ($setpoint1 != 'FF') {
                                        $update_data = array(
                                            'value' => $setpoint1
                                        );
                                        if ($this->device_setpoint_model->update($item2['id'], $update_data)) {
                                            $this->device_setponit_log($device['id'], $setpoint1);
                                            $flag_ok = true;
                                        }
                                    }
                                } else if (count($device_setpoint) == 2) {
                                    if ($setpoint1 != 'FF') {
                                        $update_data = array(
                                            'value' => $setpoint1
                                        );
                                        if ($this->device_setpoint_model->update($item2['id'], $update_data)) {
                                            $this->device_setponit_log($device['id'], $setpoint1);
                                            $flag_ok = true;
                                        }

                                    }
                                    if ($setponit2 != 'FF') {
                                        $update_data = array(
                                            'value' => $setponit2
                                        );
                                        if ($this->device_setpoint_model->update($item2['id'], $update_data)) {
                                            $this->device_setponit_log($device['id'], $setponit2);
                                            $flag_ok = true;
                                        }

                                    }
                                }
                            }
                        } // Else create new setpoint for it
                        else {
                            if ($setpoint1 != 'FF') {
                                $insert_data = array(
                                    'row_device_id' => $device['id'],
                                    'value' => $setpoint1
                                );
                                if ($this->device_setpoint_model->insert($insert_data)) {
                                    $this->device_setponit_log($device['id'], $setpoint1);
                                    $flag_ok = true;
                                }

                            }
                            if ($setponit2 != 'FF') {
                                $insert_data = array(
                                    'row_device_id' => $device['id'],
                                    'value' => $setponit2
                                );
                                if ($this->device_setpoint_model->insert($insert_data)) {
                                    $this->device_setponit_log($device['id'], $setponit2);
                                    $flag_ok = true;
                                }
                            }
                        }
                    }
                }
                if ($flag_ok)
                    echo "OK";
                else
                    echo "NOT_OK";
            } else
                redirect(home_url());
        } else
            redirect(home_url());
    }

}

/* End of file api.php */
/* Location: ./application/controllers/api.php */