<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

if (!function_exists('home_url')) {
	function home_url() {
		return base_url();
	}
}

// region ACTION MANAGEMENT CONTROLLER
if (!function_exists('action_management_controller_url')) {
    function action_management_controller_url() {
        return base_url('action_management');
    }
}

if (!function_exists('action_management_controller_with_callback_url')) {
    function action_management_controller_with_callback_url($callback, $data_callback) {
        return base_url('action_management?callback=' . $callback . '&data=' . $data_callback);
    }
}

if (!function_exists('edit_action_url')) {
    function edit_action_url($id) {
        return base_url('action_management/modify?id=' . $id);
    }
}

if (!function_exists('edit_action_with_callback_url')) {
    function edit_action_with_callback_url($id, $callback, $data_callback) {
        return base_url('action_management/modify?id=' . $id . '&callback=' . $callback . '&data=' . $data_callback);
    }
}

if (!function_exists('add_new_action_url')) {
    function add_new_action_url($action_type, $row_device_id) {
        return base_url('action_management/modify?action_type=' . $action_type . '&row_device_id=' . $row_device_id);
    }
}

if (!function_exists('add_new_action_with_callback_url')) {
    function add_new_action_with_callback_url($action_type, $row_device_id, $callback, $data_callback) {
        return base_url('action_management/modify?action_type=' . $action_type . '&row_device_id=' . $row_device_id .
            '&callback=' . $callback . '&data=' . $data_callback
        );
    }
}

if (!function_exists('delete_action_url')) {
    function delete_action_url($id) {
        return base_url('action_management/delete?id=' . $id);
    }
}

// endregion ACTION MANAGEMENT CONTROLLER

// region MODE CONTROL CONTROLLER

if (!function_exists('control_controller_url')) {
    function control_controller_url() {
        return base_url('mode_control');
    }
}

if (!function_exists('edit_mode_url')) {
    function edit_mode_url($id) {
        return base_url('mode_control/modify?id=' . $id);
    }
}

if (!function_exists('change_mode_status_url')) {
    function change_mode_status_url($id) {
        return base_url('mode_control/change_status?id=' . $id);
    }
}

if (!function_exists('add_new_mode_url')) {
    function add_new_mode_url() {
        return base_url('mode_control/modify');
    }
}

if (!function_exists('delete_mode_url')) {
    function delete_mode_url($id) {
        return base_url('mode_control/delete?id=' . $id);
    }
}

if (!function_exists('delete_action_mode_url')) {
    function delete_action_mode_url($id) {
        return base_url('mode_control/delete_action?id=' . $id);
    }
}

// endregion MODE CONTROL CONTROLLER

// region DEVICE MANAGEMENT
if (!function_exists('device_management_controller_url')) {
    function device_management_controller_url() {
        return base_url('device_management');
    }
}

if (!function_exists('add_new_device_url')) {
    function add_new_device_url() {
        return base_url('device_management/modify');
    }
}

if (!function_exists('edit_device_url')) {
    function edit_device_url($device_id) {
        return base_url('device_management/modify?id=' . $device_id);
    }
}
// endregion DEVICE MANAGEMENT

// region STATIC PAGE

if (!function_exists('document_viewer_url')) {
    function document_viewer_url() {
        return base_url('static_page/document_viewer');
    }
}

if (!function_exists('select_building_url')) {
    function select_building_url() {
        return base_url('static_page/select_building');
    }
}

// endregion STATIC PAGE

// region USER CONTROLLER

if (!function_exists('user_account_controller_url')) {
    function user_account_controller_url() {
        return base_url('user');
    }
}

if (!function_exists('add_new_user_url')) {
    function add_new_user_url() {
        return base_url('user/modify');
    }
}

if (!function_exists('edit_user_privileges_url')) {
    function edit_user_privileges_url($user_id) {
        return base_url('user/privileges?id=' . $user_id);
    }
}

if (!function_exists('edit_user_url')) {
    function edit_user_url($user_id) {
        return base_url('user/modify?id=' . $user_id);
    }
}

if (!function_exists('user_login_url')) {
    function user_login_url() {
        return base_url('user/login');
    }
}

if (!function_exists('user_logout_url')) {
    function user_logout_url() {
        return base_url('user/logout');
    }
}

if (!function_exists('delete_user_url')) {
    function delete_user_url($id) {
        return base_url('user/delete?id=' . $id);
    }
}

// endregion USER CONTROLLER

