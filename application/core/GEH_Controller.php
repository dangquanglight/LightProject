<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GEH_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function get_common_view() {
        $data = new ArrayObject();

        $header = $this->load->view('templates/header', $data, TRUE);
        $footer = $this->load->view('templates/footer', $data, TRUE);
        $sidebar = $this->load->view('templates/sidebar', $data, TRUE);

        $data = array(
            'header' => $header,
            'footer' => $footer,
            'sidebar' => $sidebar
        );

        return $data;
    }

    function load_frontend_template($extend_data, $page_title = '') {
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

    function load_view_error($data) {
        $this->load->view("error_page", $data);
    }

    public function send_email($to, $subject, $content, $debug = false) {
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
        }
        else {
            return TRUE;
        }
    }

    public function get_email_template($type) {
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

    public function get_main_email_template($main_template) {
        $this->load->model('email_template_model');
        $main = $this->email_template_model->get_main_template($main_template);
        if ($main)
            return $main['content'];
        else
            return FALSE;
    }

    public function fill_email_content($type, $data) {
        $template_content = $this->get_email_template($type);
        foreach ($data as $key => $aData) {
            $template_content = str_replace("{" . $key . "}", $aData, $template_content);
        }
        return $template_content;
    }

    public function get_zones_list($floor_id) {
        $this->load->model('zone_model');
        $zones = $this->zone_model->get_by_floor_id($floor_id);
        $data = array();
        foreach ($zones as $key => $zone) {
            $data[$key]['name'] = $zone['zone_name'];
            $data[$key]['id'] = $zone['zone_id'];
        }

        return $data;
    }

    public function get_rooms_list($zone_id) {
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

    public function get_controlled_devices_list($room_id) {
        $this->load->model(array('device_model', 'device_state_model'));
        $state = $this->device_state_model->get_by_name(DEVICE_STATE_CONTROLLED);
        $devices = $this->device_model->get_list_by_device_type_id_and_room_id($state['id'], $room_id);
        $data = array();
        foreach($devices as $device) {
            array_push($data, array(
                'id' => $device['row_device_id'],
                'name' => $device['device_name']
            ));
        }

        return $data;
    }

}