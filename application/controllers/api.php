<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

    public function get_config()
    {
        if(isset($_GET['ID']) and strlen($_GET['ID']) == 8) {
            $device_id = $_GET['ID'];
            $output = '';
            $this->load->model(array(
                'device_model',
                'device_type_model',
                'device_setpoint_model'
            ));

            $eohub = $this->device_model->get_by_device_id($device_id);
            if($eohub) {
                $relation_device_type_list = $this->device_type_model->get_controller_type($eohub['device_type_id']);
                foreach($relation_device_type_list as $item) {
                    $devices_list = $this->device_model->get_list_by_device_type_id($item['type_id']);
                    foreach($devices_list as $item2) {
                        $device_setpoins = $this->device_setpoint_model->get_by_device_row_id($item2['row_device_id']);
                        $setpoints_output = '';
                        foreach($device_setpoins as $item3) {
                            if($item3['value'] == NULL)
                                $setpoints_output .= 'FF';
                            else
                                $setpoints_output .= $item3['value'];
                        }
                        if(count($device_setpoins) == 1)
                            $setpoints_output .= 'FF';
                        else if(count($device_setpoins) == 0)
                            $setpoints_output .= 'FFFF';

                        $output .= '?' . $item2['device_id'] . $item2['eep'] . $setpoints_output;
                    }
                }
                echo $output;
            }
            else
                redirect(home_url());
        }
        else
            redirect(home_url());
    }

    public function get_status()
    {

    }
}

/* End of file api.php */
/* Location: ./application/controllers/api.php */