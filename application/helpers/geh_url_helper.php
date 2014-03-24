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

if (!function_exists('manage_by_schedule_url')) {
    function manage_by_schedule_url() {
        return base_url('action_management/schedule');
    }
}

if (!function_exists('manage_by_event_url')) {
    function manage_by_event_url() {
        return base_url('action_management/event');
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
// endregion CONTROL CONTROLLER

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

