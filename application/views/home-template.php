<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title><?php echo $page_title . ' - ' . $this->lang->line('k2') ; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />						
		<link type="text/css" rel="stylesheet" href="<?php echo base_url("css/home.css"); ?>"/>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url("css/ui-lightness/jquery-ui-1.9.2.custom.min.css"); ?>"/>				
		<script type="text/javascript" src="<?php echo base_url("js/jquery-1.8.3.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.9.2.custom.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("js/jquery.validate.js"); ?>"></script>		
		<script type="text/javascript" src="<?php echo base_url("js/home.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("js/common.js"); ?>"></script>		
		<script type="text/javascript">var base_url = '<?php echo base_url(); ?>';		
			var controller_name = '<?php echo $controller_name; ?>';var current_timestamp = <?php echo $date_info->timestamp * 1000;?>;
			var alarms_text = '<?php echo $this->lang->line('alarms');?>';
			var alarm_text = '<?php echo $this->lang->line('alarm');?>';
			var is_login = <?php echo is_login() ? 'true' : 'false';?>;
		</script>
		<style type='text/css'>			
			<?php				
				if ($setting){
					if ($setting->page_width){
						echo sprintf("#wrapper{width:%s;}", $setting->page_width);
					}
					if ($setting->enable_border){						
						echo sprintf("#wrapper-content{border-width:%s;border-style: %s;border-color: %s;}", $setting->border_width, $setting->border_type, '#' . $setting->border_color);
					}
					if ($setting->enable_shadow){						
						echo sprintf("#wrapper{box-shadow:%s %s %s %s %s;-moz-box-shadow:%s %s %s %s %s;-webkit-box-shadow:%s %s %s %s %s;}", 
							$setting->h_shadow, $setting->v_shadow, $setting->blur_shadow, $setting->size_shadow, '#' . $setting->color_shadow,
							$setting->h_shadow, $setting->v_shadow, $setting->blur_shadow, $setting->size_shadow, '#' . $setting->color_shadow,
							$setting->h_shadow, $setting->v_shadow, $setting->blur_shadow, $setting->size_shadow, '#' . $setting->color_shadow
							);
					}					
					if ($setting->enable_bg_image){
						$repeat = 'repeat';
						if ($setting->bg_repeat == 1){
							$repeat = 'repeat-x';
						}
						else if ($setting->bg_repeat == 2){
							$repeat = 'repeat-y';
						}
						else if ($setting->bg_repeat == 3){
							$repeat = 'no-repeat';
						}
						$bg_color = '';
						if ($setting->bg_color){
							$bg_color = '#' . $setting->bg_color;
						}
						echo sprintf("body{background:url(%s) %s %s;}", base_url('images/background.png'), $repeat, $bg_color);
					}
					else{
						$bg_color = '';
						if ($setting->bg_color){
							$bg_color = '#' . $setting->bg_color;
							echo sprintf("body{background-color:%s;}", $bg_color);
						}
					}					
					if ($setting->menu_color){
						//echo sprintf("#navigation-bar{border-bottom: 2px solid %s;}", '#' . $setting->menu_color);
						echo sprintf("#navigation .submenu li:hover, .suggestion li:hover, .suggestion li.selected {background-color: %s;}", '#' . $setting->menu_color);						
					}
					if ($setting->separate_bar_bg_color){
						echo sprintf(".separate-bar{background-color:%s;}", '#' . $setting->separate_bar_bg_color);
						echo sprintf(".separate-bar.maximize{background:url(" . base_url() . "images/maximize_icon.png) right 3px no-repeat %s;}", '#' . $setting->separate_bar_bg_color);
						echo sprintf(".separate-bar.minimize{background:url(" . base_url() . "images/minimize_icon.png) right 3px no-repeat %s;}", '#' . $setting->separate_bar_bg_color);						
					}
					if ($setting->button_linear_color_1 && $setting->button_linear_color_2){
						echo sprintf(".btn-yellow {						
						background: %s;
						background: -moz-linear-gradient(top,%s 0,%s 100%%);
						background: -webkit-gradient(linear,left top,left bottom,color-stop(0%%,%s),color-stop(100%%,%s));
						background: -webkit-linear-gradient(top,%s 0,%s 100%%);
						background: -o-linear-gradient(top,%s 0,%s 100%%);
						background: -ms-linear-gradient(top,%s 0,%s 100%%);
						background: linear-gradient(top,%s 0,%s 100%%);
						filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='%s',endColorstr='%s',GradientType=0);
						}", '#' . $setting->button_linear_color_1,
							'#' . $setting->button_linear_color_1, '#' . $setting->button_linear_color_2,
							'#' . $setting->button_linear_color_1, '#' . $setting->button_linear_color_2,
							'#' . $setting->button_linear_color_1, '#' . $setting->button_linear_color_2,
							'#' . $setting->button_linear_color_1, '#' . $setting->button_linear_color_2,
							'#' . $setting->button_linear_color_1, '#' . $setting->button_linear_color_2,
							'#' . $setting->button_linear_color_1, '#' . $setting->button_linear_color_2,
							'#' . $setting->button_linear_color_1, '#' . $setting->button_linear_color_2);
					}
				}				
			?>
		</style>
	</head>
	<body id=''>
		<div id='wrapper' class='relative'>
			<div id='wrapper-content'>
				<div id='header-page' class='relative'>
					<img src='<?php echo base_url('images/logo.png');?>' style='position:absolute' width='274px' height='102px' alt=''/>
					<span id="info">
						<?php if ($user_info){ ?>
							<span id="greeting"><?php echo $this->lang->line('greeting');?> <a class="profile" href="<?php echo base_url('profile'); ?>"><?php echo htmlspecialchars(trim($user_info->first_name . ' ' . $user_info->last_name));?></a></span>
							<input id='logout' type='button' value="<?php echo $this->lang->line('logout');?>"/>
						<?php } else{ ?>
							<form id='login-short-form' action='' method='post'>
								<label><?php echo $this->lang->line('email');?> <input type='text' id='email_login' name='email_login'/></label>
								<label><?php echo $this->lang->line('password');?> <input type='password' id='password_login' name='password_login'/></label>
								<label><input type='checkbox' id='remember_login' name='remember_login'/> <?php echo $this->lang->line('remember');?></label>
								<input type='submit' value="<?php echo $this->lang->line('login');?>"/>
								<input type='button' value="<?php echo $this->lang->line('register');?>" onclick="window.location = '<?php echo base_url('register');?>'"/>
								<?php if (isset($data['err_msg_login']) && $data['err_msg_login']){ 
									echo "<div id='login-fail'>" . $data['err_msg_login'] . '</div>';
								}
								?>
							</form>
						<?php } ?>
					</span>	
					<span id="d-languages"><?php echo $this->lang->line('language');?><a id="a-language" href="javascript:void(0)">
						<img class="language-icon" align="absmiddle" src="<?php echo base_url('images/' . $language->name) ;?>.jpg"> <?php echo $language->text ;?>
					</a>
					</span>
					<div id="languages-popup">
						<ul class='language-flags'>						
							<li class="english <?php echo $language->iso == "en" ? "checked" : "";?>" lang="en">
								<p><a href="javascript:void(0)"><?php echo $this->lang->line('english');?></a></p>
							</li>
							<li class="finland <?php echo $language->iso == "fi" ? "checked" : "";?>" lang="fi">
								<p><a href="javascript:void(0)"><?php echo $this->lang->line('finland');?></a></p>
							</li>
							<li class="korea <?php echo $language->iso == "kr" ? "checked" : "";?>" lang="kr">
								<p><a href="javascript:void(0)"><?php echo $this->lang->line('korea');?></a></p>
							</li>
						</ul>
					</div>
					<h1 id='header-company-name'><?php echo htmlspecialchars($company_name);?></h1>
					<a class='alarm-icon' href='<?php echo base_url('organisation');?>'></a>
				</div>
				<?php include APPPATH . "views/home/main-menu.php"; ?>
				<?php include APPPATH . "views/" . $file_name; ?>
				<?php include APPPATH . "views/home/footer.php"; ?>
			</div>
		</div>
		<div style="" class="scroll-icon nav_up hidden" id="nav_up"></div>
		<div style="" class="scroll-icon nav_down hidden" id="nav_down"></div>
		<img id='loading' src='<?php echo base_url('images/ajax-loader.gif');?>'/>
		<div id='flash-message'><span><?php echo $this->session->flashdata('flashdata');?></span></div>
	</body>
</html>