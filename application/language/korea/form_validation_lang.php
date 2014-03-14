<?php
	$CI = &get_instance();	
	$CI->form_validation->set_message('required', '%s');
	$CI->form_validation->set_message('matches', $CI->lang->line('required-pass-and-confirm-pass'));
	$CI->form_validation->set_message('min_length', $CI->lang->line('required-password-length'));
	$CI->form_validation->set_error_delimiters('<li>', '</li>');
?>