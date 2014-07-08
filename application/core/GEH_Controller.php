<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GEH_Controller extends CI_Controller
{
    public $client_address;
    //Hieu added 2014-05-17
    public $client_mode_request;
    public $client_action_request;
    public $client_ip_address;

    function __construct()
    {
        parent::__construct();

        // Check user logged or not
        $this->check_user_logged_in();

        $this->load->model('device_model');
        $device = $this->device_model->get_by_device_id('0086A88D');

        $this->client_address = 'http://' . $device['description'] . '/status.html?request';
        //Hieu added 2014-05-17
        $this->client_mode_request = 'http://' . $device['description'] . '/mode.html?request';
        $this->client_action_request = 'http://' . $device['description'] . '/action.html?request';
        $this->client_ip_address = $device['description'];
    }

    // Flash data successful
    public $flash_success_session = 'flash_success';
    // Flash data warning
    public $flash_warning_session = 'flash_warning';

    function get_common_view()
    {
        $data = new ArrayObject();
        $username = array('username' => $this->get_username_from_session());
        $user_group = array('user_group' => $this->get_user_group_from_session());

        $header = $this->load->view('templates/header', $username, TRUE);
        $footer = $this->load->view('templates/footer', $data, TRUE);
        $sidebar = $this->load->view('templates/sidebar', $user_group, TRUE);

        $data = array(
            'header' => $header,
            'footer' => $footer,
            'sidebar' => $sidebar
        );

        return $data;
    }

    function load_frontend_template($extend_data, $page_title = '')
    {
        $common_views = $this->get_common_view();
        $common_views['content_view'] = '';
        if (isset($extend_data['content_view'])) {
            $common_views['content_view'] = $extend_data['content_view'];
        }

        $data['views'] = $common_views;
        $data['page_title'] = $page_title;
        //$data['content'] = $extend_data;

        $this->load->view('templates/default', $data);
    }

    function load_view_error($data)
    {
        $this->load->view("error_page", $data);
    }

    public function send_email($to, $subject, $content, $debug = false)
    {
        require_once APPPATH . 'libraries/phpmailer521/class.phpmailer.php';
        $mail = new PHPMailer(true);
        $mail->IsSMTP();

        if ($debug) {
            // enables SMTP debug information (for testing)
            // 1 = errors and messages
            // 2 = messages only
            $mail->SMTPDebug = 2;
        }

        $mail->CharSet = 'UTF-8';
        $mail->SMTPAuth = true; // turn on SMTP authentication
        //$mail->SMTPSecure = "ssl";
        $mail->Host = $this->config->item('email_smtp_host');
        $mail->Port = $this->config->item('email_smtp_port');
        $mail->Username = $this->config->item('email_smtp_user');
        $mail->Password = $this->config->item('email_smtp_pass');
        $mail->AddAddress($to);
        $mail->SetFrom($this->config->item('email_from_email'), $this->config->item('email_from_name'));
        $mail->AddReplyTo($this->config->item('email_from_email'), $this->config->item('email_from_name'));
        $mail->Subject = $subject;
        $mail->MsgHTML($content);

        if (!$mail->Send()) {
            return $mail->ErrorInfo;
        } else {
            return TRUE;
        }
    }

    public function get_email_template($type)
    {
        /*$base_path = FCPATH . "application/views/emails_template/";
        $file = $base_path . $name . ".txt";
        if (file_exists($file)) {
            return file_get_contents($file);
        }
        return false;*/
        $this->load->model('email_template_model');
        $content = $this->email_template_model->get_by_type($type);

        if ($content) {
            if ($content['main_template'] == -1) {
                return $content['content'];
            } else {
                $main_template = $this->get_main_email_template($content['main_template']);
                if ($main_template) {
                    return str_replace("{content}", $content['content'], $main_template);
                } else
                    return FALSE;
            }
        } else
            return FALSE;
    }

    public function get_main_email_template($main_template)
    {
        $this->load->model('email_template_model');
        $main = $this->email_template_model->get_main_template($main_template);
        if ($main)
            return $main['content'];
        else
            return FALSE;
    }

    public function fill_email_content($type, $data)
    {
        $template_content = $this->get_email_template($type);
        foreach ($data as $key => $aData) {
            $template_content = str_replace("{" . $key . "}", $aData, $template_content);
        }
        return $template_content;
    }

    public function get_floors_list_by_privileges()
    {
        $this->load->model('floor_model');
        $user_info = $this->get_user_logged_in_info();

        if ($user_info['user_group'] == USER_GROUP_ROOT_ADMIN) {
            return $this->floor_model->get_list();
        }
        else if ($user_info['user_group'] == USER_GROUP_BUILDINGS_OWNER) {
            $this->load->model('user_privileges_model');
            $floors_list = array();

            $privileges = $this->user_privileges_model->get_by_account($user_info['user_group'], $user_info['user_id']);
            foreach ($privileges as $privilege) {
                $result = $this->floor_model->get_by_building_id($privilege['building_id']);
                foreach($result as $item) {
                    array_push($floors_list, $item);
                }
            }

            return $floors_list;
        }
        else if ($user_info['user_group'] == USER_GROUP_ROOMS_ADMIN) {
            $this->load->model(array(
                'user_privileges_model',
                'room_model'
            ));
            $floors_list = array();

            $privileges = $this->user_privileges_model->get_by_account($user_info['user_group'], $user_info['user_id']);
            foreach($privileges as $privilege) {
                $floor = $this->room_model->get_floor_id($privilege['room_id']);
                if(!in_array($floor, $floors_list)) {
                    array_push($floors_list, $floor);
                }
            }

            return $floors_list;
        }
    }

    public function get_floors_list($building_id)
    {
        $this->load->model('floor_model');
        $zones = $this->floor_model->get_by_building_id($building_id);
        $data = array();
        foreach ($zones as $key => $zone) {
            $data[$key]['name'] = $zone['floor_name'];
            $data[$key]['id'] = $zone['floor_id'];
        }

        return $data;
    }

    public function get_zones_list($floor_id)
    {
        $this->load->model('zone_model');
        $zones = $this->zone_model->get_by_floor_id($floor_id);
        $data = array();
        foreach ($zones as $key => $zone) {
            $data[$key]['name'] = $zone['zone_name'];
            $data[$key]['id'] = $zone['zone_id'];
        }

        return $data;
    }

    public function get_rooms_list($zone_id)
    {
        $this->load->model('room_model');
        $rooms = $this->room_model->get_by_zone_id($zone_id);
        $data = array();
        foreach ($rooms as $room) {
            array_push($data, array(
                'id' => $room['room_id'],
                'name' => $room['room_name']
            ));
        }

        return $data;
    }

    public function get_devices_list_by_privileges()
    {
        $this->load->model('device_model');
        $user_info = $this->get_user_logged_in_info();

        if ($user_info['user_group'] == USER_GROUP_ROOT_ADMIN) {
            return $this->device_model->get_list();
        }
        else if ($user_info['user_group'] == USER_GROUP_BUILDINGS_OWNER) {
            $this->load->model(array(
                'user_privileges_model',
                'building_model'
            ));
            $devices_list = array();

            $privileges = $this->user_privileges_model->get_by_account($user_info['user_group'], $user_info['user_id']);
            foreach ($privileges as $privilege) {
                $result = $this->building_model->get_devices_list($privilege['building_id']);
                foreach($result as $item) {
                    array_push($devices_list, $item);
                }
            }

            return $devices_list;
        }
        else if ($user_info['user_group'] == USER_GROUP_ROOMS_ADMIN) {
            $this->load->model(array(
                'user_privileges_model'
            ));
            $devices_list = array();

            $privileges = $this->user_privileges_model->get_by_account($user_info['user_group'], $user_info['user_id']);
            foreach ($privileges as $privilege) {
                $result = $this->device_model->get_list_by_room_id($privilege['room_id']);
                foreach($result as $item) {
                    array_push($devices_list, $item);
                }
            }

            return $devices_list;
        }
    }

    public function get_controlled_devices_list($room_id)
    {
        $this->load->model(array('device_model', 'device_state_model'));
        $state = $this->device_state_model->get_by_name(DEVICE_STATE_CONTROLLED);
        $devices = $this->device_model->get_list_by_state_id_and_room_id($state['id'], $room_id);
        $data = array();
        foreach ($devices as $device) {
            array_push($data, array(
                'id' => $device['row_device_id'],
                'name' => $device['device_name']
            ));
        }

        return $data;
    }

    public function get_setpoint_info($device_row_id)
    {
        $this->load->model(array('device_model', 'device_setpoint_model'));

        // Get device info
        $device = $this->device_model->get_by_row_id($device_row_id);
        $data = array(
            'min_value' => $device['min_value'],
            'max_value' => $device['max_value'],
            'unit_name' => $device['unit_name']
        );

        // Get device setpoint value
        $setpoint_info = $this->device_setpoint_model->get_by_device_row_id($device['id']);
        $flag = 1;
        foreach ($setpoint_info as $item) {
            if (count($setpoint_info) == 1) {
                $data['setpoint1'] = $item['value'];
            } else if (count($setpoint_info) == 2) {
                if ($flag == 1) {
                    $data['setpoint1'] = $item['value'];
                    $flag++;
                } else {
                    $data['setpoint2'] = $item['value'];
                }
            }
        }

        return $data;
    }

    public function device_setponit_log($row_device_id, $current_setpoint)
    {
        $insert_data = array(
            'row_device_id' => $row_device_id,
            'current_setpoint' => $current_setpoint,
            'log_time' => date('Y-m-d H:i:s')
        );
        $this->load->model('device_setpoint_log_model');

        if ($this->device_setpoint_log_model->insert($insert_data))
            return TRUE;
        else
            return FALSE;
    }

    public function check_user_logged_in()
    {
        $flag = FALSE;
        if ($this->router->class != 'user') {
            $flag = TRUE;
        }
        else {
            if ($this->router->method != 'login') {
                $flag = TRUE;
            }
        }

        if ($flag) {
            if (!$this->session->userdata(USER_SESSION_NAME))
                redirect(user_login_url());
        }
    }

    public function set_user_session($user_info)
    {
        $user_data = array(
            'user_id' => $user_info['id'],
            'user_email' => $user_info['email'],
            'user_group' => $user_info['user_group'],
            'username' => $user_info['username']
        );

        $this->session->set_userdata(USER_SESSION_NAME, $user_data);
    }

    public function get_username_from_session()
    {
        $account = $this->session->userdata(USER_SESSION_NAME);
        return $account['username'];
    }

    public function get_user_group_from_session()
    {
        $account = $this->session->userdata(USER_SESSION_NAME);
        return $account['user_group'];
    }

    public function get_user_logged_in_info()
    {
        return $this->session->userdata(USER_SESSION_NAME);
    }

}