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

if (!function_exists('edit_action_url')) {
    function edit_action_url($id) {
        return base_url('action_management/modify?id=' . $id);
    }
}

if (!function_exists('add_new_action_url')) {
    function add_new_action_url($action_type) {
        return base_url('action_management/modify?action_type=' . $action_type);
    }
}

if (!function_exists('delete_action_url')) {
    function delete_action_url($id) {
        return base_url('action_management/delete?id=' . $id);
    }
}

// endregion ACTION MANAGEMENT CONTROLLER

// region CONTROL CONTROLLER
if (!function_exists('control_controller_url')) {
    function control_controller_url() {
        return base_url('control');
    }
}

if (!function_exists('mode_detail_url')) {
    function mode_detail_url() {
        return base_url('control/detail');
    }
}

if (!function_exists('add_mode_url')) {
    function add_mode_url() {
        return base_url('control/modify');
    }
}
// endregion CONTROL CONTROLLER

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
// endregion STATIC PAGE

if (!function_exists('book_details_url_old')) {
    function book_details_url_old($book = FALSE, $sob_id = 0) {
        if(!$book) return base_url('/home');
        $url = base_url('/book/details/'.$book['book_id']);
        if($sob_id) $url.= "/$sob_id";
        $book_title = url_title($book['title'], '-', TRUE);
        $url.= "/$book_title";
        return $url;
    }
}

