<div class='short-menu'>	
	<?php
		$current_url = "";
		/*
		$short_menus = array();
		//$short_menus[] = array('home', $this->lang->line('home'));
		if ($controller_name == 'home/'){
			if ($view_name == 'index'){
				$short_menus = array();
				$short_menus[] = array('home', $this->lang->line('home'));
			}
		}
		else if ($controller_name == 'fsadfzerrwez_analyze/'){
			$short_menus[] = array('analyze', $this->lang->line('analyze'));
			if ($view_name == 'analyze_status'){
				$short_menus[] = array(null, $this->lang->line('analyze-status'));
			}
			else if ($view_name == 'analyze_details'){
				$short_menus[] = array(null, $this->lang->line('analyze-details'));
			}
			else if ($view_name == 'analyze_stream'){
				$short_menus[] = array(null, $this->lang->line('analyze-stream'));
			}
		}
		else if ($controller_name == 'fsadfzerrwez_sites/'){
			$short_menus[] = array(null, $this->lang->line('management'));
			$short_menus[] = array('sites', $this->lang->line('sites'));
			if ($view_name == 'add_site'){
				if ($data['id']){
					$short_menus[] = array(null, $this->lang->line('edit-site'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-site'));
				}
			}			
		}
		else if ($controller_name == 'fsadfzerrwez_zones/'){			
			if ($view_name == 'add_zone'){
				$short_menus[] = array(null, $this->lang->line('management'));
				$short_menus[] = array('zones', $this->lang->line('zones'));
				if ($data['id']){
					$short_menus[] = array(null, $this->lang->line('edit-zone'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-zone'));
				}
			}
			else if ($view_name == 'layout'){
				$short_menus[] = array('organisation', $this->lang->line('organisation'));
				$short_menus[] = array(null, $this->lang->line('zone-layout'));
			}
		}
		else if ($controller_name == 'fsadfzerrwez_devices/'){
			$short_menus[] = array(null, $this->lang->line('management'));
			$short_menus[] = array('devices', $this->lang->line('devices'));
			if ($view_name == 'add_device'){
				if ($data['id']){
					$short_menus[] = array(null, $this->lang->line('edit-device'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-device'));
				}
			}			
		}
		else if ($controller_name == 'fsadfzerrwez_events/' || $controller_name == 'fsadfzerrwez_events_schedule/'){
			$short_menus[] = array(null, $this->lang->line('management'));
			$short_menus[] = array('events', $this->lang->line('events'));
			if ($view_name == 'add_event'){
				if ($data['id']){
					$short_menus[] = array(null, $this->lang->line('edit-event'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-event'));
				}
			}			
		}
		else if ($controller_name == 'fsadfzerrwez_alarms_history/'){
			$short_menus[] = array(null, $this->lang->line('management'));
			$short_menus[] = array('alarms_history', $this->lang->line('alarms-history'));				
		}
		else if ($controller_name == 'fsadfzerrwez_measurements/'){		
			if ($view_name == 'import'){
				$short_menus[] = array('alarms_history', $this->lang->line('import-measurements'));
			}
			else if ($view_name == 'measurements'){
				$short_menus[] = array('measurements', $this->lang->line('measurements'));
			}
			else if ($view_name == 'send_measurement'){
				$short_menus[] = array('send-measurement', $this->lang->line('send-measurement'));
			}
		}
		else if ($controller_name == 'fsadfzerrwez_users/'){
			if ($view_name == 'add_user'){
				$short_menus[] = array('users', $this->lang->line('users'));
				if ($data['id']){					
					$short_menus[] = array(null, $this->lang->line('edit-user'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-user'));
				}
			}
			else if ($view_name == 'users'){
				$short_menus[] = array(null, $this->lang->line('administrator'));
				$short_menus[] = array('users', $this->lang->line('users'));
			}
		}
		else if ($controller_name == 'fsadfzerrwez_roles/'){
			$short_menus[] = array(null, $this->lang->line('administrator'));
			if ($view_name == 'add_role'){
				$short_menus[] = array('roles', $this->lang->line('roles'));
				if ($data['id']){
					$short_menus[] = array(null, $this->lang->line('edit-role'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-role'));
				}
			}
			else if ($view_name == 'roles'){				
				$short_menus[] = array('roles', $this->lang->line('roles'));
			}
		}
		else if ($controller_name == 'fsadfzerrwez_organisation/'){
			if ($view_name == 'organisation'){
				$short_menus[] = array('organisation', $this->lang->line('organisation'));
			}
		}
		else if ($controller_name == 'fsadfzerrwez_email_templates/'){
			$short_menus[] = array(null, $this->lang->line('administrator'));
			$short_menus[] = array('email_templates', $this->lang->line('email-templates'));
			if ($view_name == 'add_email_template'){
				if ($data['id']){
					$short_menus[] = array(null, $this->lang->line('edit-email-template'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-email-template'));
				}
			}			
		}
		else if ($controller_name == 'fsadfzerrwez_email_config/'){
			$short_menus[] = array(null, $this->lang->line('administrator'));
			if ($view_name == 'config'){
				$short_menus[] = array('email-config', $this->lang->line('email-config'));				
			}
		}
		else if ($controller_name == 'fsadfzerrwez_cms/'){		
			$short_menus[] = array(null, $this->lang->line('administrator'));
			$short_menus[] = array('cms', $this->lang->line('cms'));			
			if ($view_name == 'add_cms'){
				if ($data['id']){
					$short_menus[] = array(null, $this->lang->line('edit-cms'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-cms'));
				}
			}			
		}
		else if ($controller_name == 'fsadfzerrwez_menu/'){
			$short_menus[] = array(null, $this->lang->line('administrator'));
			if ($view_name == 'menu'){
				$short_menus[] = array('menu', $this->lang->line('menus'));
			}
			else if ($view_name == 'add_menu'){
				$short_menus[] = array('menu', $this->lang->line('menus'));
				if ($data['id']){					
					$short_menus[] = array(null, $this->lang->line('edit-menu'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-menu'));
				}
			}
			else if ($view_name == 'submenu'){			
				$short_menus[] = array('submenu', $this->lang->line('submenu'));
			}
			else if ($view_name == 'add_submenu'){
				$short_menus[] = array('menu', $this->lang->line('submenu'));
				if ($data['id']){					
					$short_menus[] = array(null, $this->lang->line('edit-submenu'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-submenu'));
				}
			}
		}
		else if ($controller_name == 'fsadfzerrwez_site_setting/'){
			$short_menus[] = array(null, $this->lang->line('administrator'));
			if ($view_name == 'setting'){
				$short_menus[] = array('site-setting', $this->lang->line('site-setting'));				
			}
		}
		else if ($controller_name == 'fsadfzerrwez_types/'){	
			$short_menus[] = array(null, $this->lang->line('administrator'));
			$short_menus[] = array('types', $this->lang->line('types'));			
			if ($view_name == 'add_type'){
				if ($data['id']){
					$short_menus[] = array(null, $this->lang->line('edit-type'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-type'));
				}
			}			
		}
		else if ($controller_name == 'fsadfzerrwez_sub_types/'){	
			$short_menus[] = array(null, $this->lang->line('administrator'));
			$short_menus[] = array('sub-types', $this->lang->line('sub-types'));			
			if ($view_name == 'add_sub_type'){
				if ($data['id']){
					$short_menus[] = array(null, $this->lang->line('edit-sub-type'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-sub-type'));
				}
			}			
		}
		else if ($controller_name == 'fsadfzerrwez_units/'){	
			$short_menus[] = array(null, $this->lang->line('administrator'));
			$short_menus[] = array('units', $this->lang->line('units'));			
			if ($view_name == 'add_unit'){
				if ($data['id']){
					$short_menus[] = array(null, $this->lang->line('edit-unit'));
				}
				else{					
					$short_menus[] = array(null, $this->lang->line('add-new-unit'));
				}
			}			
		}
		else if ($controller_name == 'home_user/'){
			if ($view_name == 'profile'){
				$short_menus[] = array('profile', $this->lang->line('profile'));
			}
			
		}
		*/						
		$length = count($short_menus);
		for($i = 0; $i < $length; $i++){	
			$menu = $short_menus[$i];
			echo "<h1>";
			if ($menu[0]){
				echo "<a href='" . $menu[0] . "'>" . $menu[1] . "</a>";				
			}
			else {
				echo "<span>" . $menu[1] . "</span>";
			}
			echo '</h1>';
			if ($i < $length - 1){
				//echo "<img class='mr8 ml8' align='absmiddle' src='" . base_url('images/arrow-right.png') . "'/>";
				echo "<h1 class='mr8 ml8'> - </h1>";
			}
		}
		echo $controller_name . ' --- ' . $view_name;
	?>
	
</div>