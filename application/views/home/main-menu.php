<?php if (is_login()){ ?>
	<div id='navigation-bar' class=''>					
		<ul id="navigation" class='mt12'>				
			<?php
				$m_id = $this->input->get('m_id');
				$sm_id = $this->input->get('sm_id');
				$last_short_menu = null;
				
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_sites/', $view_name, 'add_site', MODULE_SITES, 'edit-site', 'add-new-site', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_zones/', $view_name, 'add_zone', MODULE_ZONES, 'edit-zone', 'add-new-zone', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_devices/', $view_name, 'add_device', MODULE_DEVICES, 'edit-device', 'add-new-device', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_events/', $view_name, 'add_event', MODULE_EVENTS, 'edit-event', 'add-new-event', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_events_schedule/', $view_name, 'add_event', MODULE_EVENTS, 'edit-event', 'add-new-event', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_users/', $view_name, 'add_user', MODULE_USERS, 'edit-user', 'add-new-user', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_roles/', $view_name, 'add_role', MODULE_ROLES, 'edit-role', 'add-new-role', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_email_templates/', $view_name, 'add_email_template', MODULE_EMAIL_TEMPLATE, 'edit-email-template', 'add-email-template', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_cms/', $view_name, 'add_cms', MODULE_CMS, 'edit-cms', 'add-new-cms', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_menu/', $view_name, 'add_menu', MODULE_MENU, 'edit-menu', 'add-new-menu', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_menu/', $view_name, 'add_submenu', MODULE_MENU, 'edit-submenu', 'add-new-submenu', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_types/', $view_name, 'add_type', MODULE_TYPES, 'edit-type', 'add-new-type', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_sub_types/', $view_name, 'add_sub_type', MODULE_SUB_TYPES, 'edit-sub-type', 'add-new-sub-type', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_add_or_edit_menu_link($this, $controller_name, 
					'fsadfzerrwez_units/', $view_name, 'add_user', MODULE_UNITS, 'edit-user', 'add-new-user', $m_id, $sm_id);
				}					
				if (!$m_id && !$sm_id){
					$last_short_menu = search_parent_menu_link($this, $controller_name, 
					'fsadfzerrwez_analyze/', $view_name, 'analyze_status', MODULE_ANALYZE, 'analyze-status', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_parent_menu_link($this, $controller_name, 
					'fsadfzerrwez_analyze/', $view_name, 'analyze_details', MODULE_ANALYZE, 'analyze-details', $m_id, $sm_id);
				}
				if (!$m_id && !$sm_id){
					$last_short_menu = search_parent_menu_link($this, $controller_name, 
					'fsadfzerrwez_analyze/', $view_name, 'analyze_stream', MODULE_ANALYZE, 'analyze-stream', $m_id, $sm_id);
				}
								
				//create menu
				$length = count($menu_top);							
				$dropdown_img = "<img src='" . base_url('images/arrow-down-white.png') . "' atl=''/>";
				$short_menus = array();
				for($i = 0; $i < $length; $i++){ 
					$menu = $menu_top[$i];
					$is_selected = false;
					$menu_link = '';
					if ($menu->link == ''){
						$menu_link = base_url();
					}
					else if ($menu->link == '#'){
						$menu_link = 'javascript:void(0)';
					}
					else{
						$menu_link = correct_link($menu->link . '?m_id=' . $menu->id);
					}
						
					if ($sm_id){
						$submenu = $this->submenu->get_id($sm_id);
						if ($submenu){
							$m_id = $submenu->menu_id;
						}
					}
					
					if ($menu->id == $m_id){
						$is_selected = true;
						$short_menus[] = array($menu_link, $menu->title);
					}
					
					//find submenu-top
					$submenu_items = array();
					foreach($submenu_top as $submenu){
						if ($menu->id == $submenu->menu_id){
							$submenu_items[] = $submenu;
						}						
					}
					$has_submenu = count($submenu_items) > 0;
											
					$has_role = true;
					if ($menu->module_id != 7 && $menu->module_id != 8){
						$has_role = has_role($menu->module_id, MODULE_TYPE_VIEW, $user_role_modules);
					}
					//var_dump($menu);
					if ($has_role){	
						foreach($submenu_items as $sub){
							if ($sub->id == $sm_id){
								$short_menus[] = array(base_url($sub->link . '?sm_id=' . $sub->id), $sub->title);
								$is_selected = true;
								break;
							}
						}
						echo "<li class='top'><a ref_id='" . $menu->id . "' class='top' href='" . $menu_link . "'><b class='" . ($is_selected ? 'selected' : '') . "'>" . htmlspecialchars($menu->title). ($has_submenu ? $dropdown_img : '') . "</b></a>";
						//var_dump($menu);
						if ($has_submenu){
							echo "<ul class='submenu'>";
							foreach($submenu_items as $sub){																	
								$has_sub_role = true;
								if ($sub->module_id != 15 && $sub->module_id != 16){
									$has_sub_role = has_role($sub->module_id, MODULE_TYPE_VIEW, $user_role_modules);
								}
								if ($has_sub_role){
									//var_dump($sub);
									echo "<li><a ref_id='" . $sub->id . "'  href='" . base_url($sub->link . '?sm_id=' . $sub->id) . "'>" . $sub->title . "</a></li>";
								}
							}
							echo "</ul>";
						} 
						echo "</li>";
					}
				}

				if ($last_short_menu){
					$short_menus[] = $last_short_menu;
				}
			?>
	</ul>
	<script type='text/javascript'>//$(function(){create_clock();});</script>					
	<div class='clear'></div>
</div>
<div class='short-menu'>
	<?php		
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
				echo "<h1 class='mr8 ml8'> - </h1>";
			}
		}
		//echo $controller_name . ' --- ' . $view_name;
	?>
</div>
<?php } ?>