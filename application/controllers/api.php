<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

///HieuT 14-05-2014
class DataProvider
{
    var $setting;
    function getSetting()
    {
        $setting['sitedir'] = '';
        $setting['dbhost'] = 'localhost';
        $setting['dbusername'] = 'root';
        $setting['dbpassword'] = '123';
        $setting['dbname'] = 'gehouse';
        return $setting;
    }
}

///HieuT 14-05-2014
class DataConnector extends DataProvider
{
    var $theQuery;
    var $link;

    function DataConnector()
    {
        try {
            $setting = DataProvider::getSetting();
            $host = $setting['dbhost'];
            $db = $setting['dbname'];
            $user = $setting['dbusername'];
            $pass = $setting['dbpassword'];
            $this->link = mysqli_connect($host, $user, $pass, $db);
        }
        catch (Excepton $e) {
            echo $e->getMessage();
        }
    }
    function query($query)
    {
        $this->theQuery = $query;
        return mysqli_query($this->link, $query);
    }

    function getQuery()
    {
        return $this->theQuery;
    }

    function getNumRows($result)
    {
        return mysqli_num_rows($result);
    }

    function fetchArray($result)
    {
        return mysqli_fetch_array($result);
    }

    function close()
    {
        mysqli_close($this->link);
    }
}

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
                'device_setpoint_model'));

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
                            if ($item3['value'] == null)
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
                        else
                            if (count($device_setpoins) == 0)
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

    ///HieuT 16-05-2014
    public function post_ip()
    {
        try {
            if (isset($_POST['ID']) and strlen($_POST['ID']) == 8 and isset($_POST['IP'])) {
                $device_id = $_POST['ID'];
                $device_ip = $_POST['IP'];
                $connector = new DataConnector();
                $result = $connector->query('SELECT Device_Name FROM Devices WHERE Device_Name LIKE "EOHUB%" AND Device_Id = "' .
                    $device_id . '"');
                $row = $connector->fetchArray($result);
                if ($row['Device_Name'] != null) {
                    $update = $connector->query('UPDATE Devices SET Description = "' . $device_ip .
                        '" WHERE Device_Id = "' . $device_id . '"');
                    echo 'OK';
                } else
                    echo 'NOT_OK';
            }
        }
        catch (exception $e) {
            echo 'NOT_OK';
        }
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
                'device_state_model'));
            $device = $this->device_model->get_by_device_id($device_id);
            if ($device) {
                $state = $this->device_state_model->get_by_name(DEVICE_STATE_CONTROLLED);
                $relation_device_type_list = $this->device_type_model->
                    get_controller_type_and_state($device['device_type_id'], $state['id']);
                $count = 0;
                $flag_none = true;
                foreach ($relation_device_type_list as $item) {
                    $devices_list = $this->device_model->get_list_by_device_type_id($item['type_id']);
                    foreach ($devices_list as $item2) {
                        $setpoints_output = '';
                        $device_setpoins = $this->device_setpoint_model->get_by_device_row_id($item2['row_device_id']);
                        $setpoint_log = $this->device_setpoint_log_model->get_latest_setpoint($device['id']);
                        // Assign setpoint string
                        foreach ($device_setpoins as $item3) {
                            if ($item3['value'] == null)
                                $setpoints_output .= 'FF';
                            else {
                                if ($item2['property_name'] == 'Temperature sensor') {                                    
                                    $temp = 51 * ($item3['value'] - 15) / 2;
                                    $setpoints_output .= strtoupper(dechex($temp));
                                } else {
                                    $temp = 255 * ($item3['value']) / 100; 
                                    $setpoints_output .= strtoupper(dechex($temp)); 
                                }

                                if (strlen($setpoints_output) == 1)
                                    $setpoints_output = '0' . $setpoints_output;
                            }
                        }
                        // if device not have any setpoint, assign FFFF to it
                        if (count($device_setpoins) == 1)
                            $setpoints_output .= 'FF';
                        else
                            if (count($device_setpoins) == 0)
                                $setpoints_output .= 'FFFF';
                        if (count($setpoint_log) == 0)
                            $flag_none = false;
                        else {
                            foreach ($device_setpoins as $setpoint) {
                                if ($setpoint['value'] != $setpoint_log['current_setpoint']) {
                                    $flag_none = false;
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
            } else
                redirect(home_url());
        } else
            redirect(home_url());
    }
    
    //HieuB added 2014-17-05
    public function get_mode()
    {
        if (isset($_GET['ID']) and strlen($_GET['ID']) == 8) {
            $device_id = $_GET['ID'];
            $output = '';
            $this->load->model(array(
                'device_model',
                //'device_type_model',
                //'device_setpoint_model',
                //'device_setpoint_log_model',
                //'device_state_model',
                'mode_control_model',
                'mode_control_detail_model',
                'actions_model'));
            //$device = $this->device_model->get_by_device_id($device_id);
            //Find the active mode
            $mode   = $this->mode_control_model->get_by_status(1); 
            if ($mode){          
                //Find the action list of the active mode
                $action_list = $this->mode_control_detail_model->get_by_mode_id($mode['id']);     
                $count = 0;
                
                foreach ($action_list as $item) {
                    $action_id_list = $this->mode_control_detail_model->get_by_mode_id($item['action_id']);                              
                    $device_list = $this->actions_model->get_by_id($item['action_id']);
                    $device_id = $this->device_model->get_by_row_id($device_list['device_id']);;  
                    $setpoint = $device_list['action_setpoint'];   
                    
                    if (($device_list['device_id'] == 10) or ($device_list['device_id'] == 13)) {                                    
                        $temp = 255 * $setpoint / 100;  
                        $setpoints_output .= strtoupper(dechex($temp));
                    } else {
                        $temp = 51 * ($setpoint - 15) / 2;
                        $setpoints_output = strtoupper(dechex($temp));
                    }               
                    $setpoints_output .= 'FF';
                    echo '?';
                    echo $device_id['device_id'];  
                    echo $setpoints_output; 
                    $count++;                    
                }
                if ($count == 0)
                    echo 'UPD_NONE';
            }
            else 
                echo 'UPD_NONE';
        } else
            redirect(home_url());
    }

    //HieuB added 201405171700
    public function get_action()
    {
        if (isset($_GET['ID']) and strlen($_GET['ID']) == 8) {
            $device_id = $_GET['ID'];
            $output = '';
            $this->load->model(array(
                'device_model',
                'device_type_model',
                'device_setpoint_model',
                'actions_model',
                'action_condition_model',
                ));          
            
            $action_condition_list   = $this->action_condition_model->get_list();
            $count = 0;
            if ($action_condition_list){
            foreach ($action_condition_list as $condition) {
                    $action = $this->actions_model->get_by_id($condition['action_id']);
                    if ($action['status'] == 1){                        
                        $input_device = $this->device_model->get_by_row_id($condition['row_device_id']);
                        $value = $condition['condition_setpoint'];
                        
                        $cond = $condition['operator'];
                        if ($cond == '>=') $cond = '>';
                        else if ($cond == '<=') $cond = 'S';
                        else if ($cond == '<') $cond = 'S';
                        
                        switch ($input_device['device_type_id']){
                            case 2:
                                if ($value == 1) $value = 0x10;
                                else if ($value == 0) $value = 0x30;                                
                                break;
                            case 8:
                                $value = (51 * ($value - 15) / 2); 
                                break;
                            case 9:                                
                                if ($value == 1) $value = 0xFF;
                                else if ($value == 0) $value = 0x02;
                                break;
                            default:
                                break;
                        }
                        $value = str_pad(strtoupper(dechex($value)), 2, '0', STR_PAD_LEFT);
                        //Print the input condition
                        $output .= '?';
                        $output .= $input_device['device_id'];
                        $output .= $input_device['eep'];                        
                        $output .= $cond;
                        $output .= $value;
                        
                        //Target ID
                        $target_device = $this->device_model->get_by_row_id($action['device_id']);
                        
                        //Script to find the setpoint, noted the exeption
                        $setpoint = $action['action_setpoint'];
                        if ((($action['exception_type'] == 'day') and (date('Y-m-d') == $action['exception_from'])) or 
                        (($action['exception_type'] == 'duration') and (date('Y-m-d') >= $action['exception_from'] and date('Y-m-d') <= $action['exception_to']))) {
                            $setpoint = $action['exception_setpoint'];
                        }                       
                        
                        if (($input_device['device_type_id'] == 10) or ($input_device['device_type_id'] == 13)) {                                    
                            $temp = 255 * $setpoint / 100;                              
                        } else {
                            $temp = 51 * ($setpoint - 15) / 2;                            
                        }        
                        $setpoints_output = str_pad(strtoupper(dechex($temp)), 2, '0', STR_PAD_LEFT);
                        $setpoints_output .= 'FF';
                        
                        
                        $output .= $target_device['device_id'];
                        $output .= $target_device['eep']; 
                        $output .= $setpoints_output;   
                        $output .= 'FFFFFFFF';
                    } 
                }
            }
            //Insert action for DALI with PIR
            echo '?0005F0EBA50701=FFC4141198F6DA000100FFFFFFFF?0005F0EBA50701=02C4141198F6DA000200FFFFFFFF';
            //Insert action for DALI with SWITCH
            echo '?008BD382F60302=10C4141198F6DA000002FFFFFFFF?008BD382F60302=30C4141198F6DA000003FFFFFFFF';
            echo $output;
        }
        else
            redirect(home_url());
    }

    public function post_value()
    {
        if (isset($_POST['len']) and isset($_POST['val'])) {
            $strlen = $_POST['len'];
            $strval = $_POST['val'];
            $this->load->model(array('device_model', 'device_setpoint_model'));
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
                                        $update_data = array('value' => $setpoint1);
                                        if ($this->device_setpoint_model->update($item2['id'], $update_data)) {
                                            $this->device_setponit_log($device['id'], $setpoint1);
                                            $flag_ok = true;
                                        }
                                    }
                                } else
                                    if (count($device_setpoint) == 2) {
                                        if ($setpoint1 != 'FF') {
                                            $update_data = array('value' => $setpoint1);
                                            if ($this->device_setpoint_model->update($item2['id'], $update_data)) {
                                                $this->device_setponit_log($device['id'], $setpoint1);
                                                $flag_ok = true;
                                            }

                                        }
                                        if ($setponit2 != 'FF') {
                                            $update_data = array('value' => $setponit2);
                                            if ($this->device_setpoint_model->update($item2['id'], $update_data)) {
                                                $this->device_setponit_log($device['id'], $setponit2);
                                                $flag_ok = true;
                                            }

                                        }
                                    }
                            }
                        }
                        // Else create new setpoint for it
                        else {
                            if ($setpoint1 != 'FF') {
                                $insert_data = array('row_device_id' => $device['id'], 'value' => $setpoint1);
                                if ($this->device_setpoint_model->insert($insert_data)) {
                                    $this->device_setponit_log($device['id'], $setpoint1);
                                    $flag_ok = true;
                                }

                            }
                            if ($setponit2 != 'FF') {
                                $insert_data = array('row_device_id' => $device['id'], 'value' => $setponit2);
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
            }
            else
                redirect(home_url());
        }
        else
            redirect(home_url());
    }

}

/* End of file api.php */
/* Location: ./application/controllers/api.php */
