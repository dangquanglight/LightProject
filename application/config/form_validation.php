<?php
	$CI = &get_instance();
	$config = array(
		 'register' => array(
				array(
					'field' => 'first_name',
					'label' => 'lang:required-first-name',
					'rules' => 'required'
				 ),
				array(
					'field' => 'email',
					'label' => 'lang:required-valid-email',
					'rules' => 'required'
				),
				array(
					'field' => 'password',
					'label' => 'lang:required-password',
					'rules' => 'required|min_length[6]'
				),
				array(
					'field' => 'confirm_password',
					'label' => 'lang:required-confirm-password',
					'rules' => 'required|matches[password]'
				),
				array(
					'field' => 'company_name',
					'label' => 'lang:required-company-name',
					'rules' => 'required'
				)			
			)		
	   );	   
?>