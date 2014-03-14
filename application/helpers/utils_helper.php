<?php	
	session_start();
	
	function show_saved_data($status, $text){
		if ($status !== null){
			echo "<div class='" . ($status ? "validation-summary-success" :"validation-summary-errors") . "'><span>" . $text . "</span></div>";
		}
	}
	
	function is_post(){
		return count($_POST) > 0;
	}
	
	function remove_more_white_space($text){
		$pattern = "/\\s\\s+/";
		$result = preg_replace($pattern, " ", $text);		
		return $result;
	}
	
	function get_fullname($last_name, $first_name){
		return trim($last_name . " " . $first_name);
	}
	function str_vn_todate($text){
		$text = trim($text);
		if (!$text){
			return "";
		}
		$seperator = "/";
		$ar_text = explode($seperator, $text);
		if (count($ar_text) == 1){
			$seperator = "-";
			$ar_text = explode($seperator, $text);
			if (count($ar_text) == 1){
				return "";
			}
		}
		$result = "";
		if (count($ar_text) == 3){
			$result = $ar_text[2] . "-" . $ar_text[1] . "-" . $ar_text[0];
		}
		return $result;
	}
	
	function str_en_todate($text){
		$text = trim($text);
		if (!$text){
			return "";
		}
		$seperator = "/";
		$ar_text = explode($seperator, $text);
		if (count($ar_text) == 1){
			$seperator = "-";
			$ar_text = explode($seperator, $text);
			if (count($ar_text) == 1){
				return "";
			}
		}
		$result = "";
		if (count($ar_text) == 3){
			$result = $ar_text[2] . "-" . $ar_text[0] . "-" . $ar_text[1];
		}
		return $result;
	}
	
	function text_to_title($text){		
		//$result = strtolower(preg_replace("/\s\s+/", " ", trim(strip_tags($text))));
		//$result = str_replace(array(",", "@", "$"), "", $result);		
		$result = strtolower($text);
		$result = str_replace("-", "", $result);
		$result = str_replace("/", "-", $result);
		$result = preg_replace("/([^a-zA-Z0-9\s-])/", "", trim(strip_tags($result)));
		$result = preg_replace("/\s\s+/", " ", trim(strip_tags($result)));
		$result = str_replace(" ", "-", $result);
		return $result;
	}
		
	function html_to_text($html){
		return trim(htmlentities(strip_tags($html)));
	}
	
	function format_number($text){
		$result = $text;
		if (is_numeric($text)){			
			$result = number_format(intval($text), 0, ",", ".");
		}
		return $result;
	}
	
	function get_email_name($full_email){		
		$email = substr($full_email, 0, strpos($full_email, "@"));
		return $email;
	}
	
	function trim_words($content, $num_words, $more = '') { 
		$result = "";
		$ar = explode(" ", trim(trim(strip_tags(preg_replace("/<style[^>]+>[^>]+>/uis", "", $content))), "&nbsp;"));
		$index = 1;	
		foreach($ar as $word){
			if ($word)
			{
				$result .= $word . " ";
				if (++$index > $num_words){
					break;
				}
			}
		}
		if ($index >= $num_words){
			$result .= $more;
		}
		return $result; 
	}
	
	function get_url_name($url){
		$index = strpos($url, "//");
		$result = "";
		if ($index){
			$next_index = strpos($url, "/", $index + 2);
			if ($next_index){			
				$result = substr($url, $index + 2, $next_index - $index - 2);
			}
			else{
				$result = substr($url, $index + 2);
			}
			$result = strtolower(str_replace("www.", "", $result));
		}
		return $result;
	}
	
	function get_root_web_url($t_url){
		$url = $t_url;
		if (strpos($t_url, "http") !== 0){
			if (strpos($t_url, "/") > 0){
				$url = "http://" . substr($t_url, 0, strpos($t_url, "/"));
			}
		}
		else if (strpos($t_url, "https") === 0){
			if (strpos($t_url, "/") > 0){
				$t_url = str_replace("https://", "", $t_url);
				$url = "https://" . substr($t_url, 0, strpos($t_url, "/"));
			}
		}
		else if (strpos($t_url, "http") === 0){
			if (strpos($t_url, "/") > 0){
				$t_url = str_replace("http://", "", $t_url);
				$url = "http://" . substr($t_url, 0, strpos($t_url, "/"));
			}
		}
		return $url;
	}
	
	function get_url_navigate(){
		$query = "";
		
		if (get('page')){
			$query .= "&page=" . urlencode(get('page'));
		}
		if (get('sort_by')){
			$query .= "&sort_by=" . urlencode(get('sort_by'));
		}
		if (get('ascending')){
			$query .= "&ascending=" . urlencode(get('ascending'));
		}
		if (get('user_id')){
			$query .= "&user_id=" . urlencode(get('user_id'));
		}
		if (get('device_id')){
			$query .= "&device_id=" . urlencode(get('page_size'));
		}
		if (get('keywords')){
			$query .= "&keywords=" . urlencode(get('keywords'));
		}		
		return $query;
	}
	
	function get($name)
	{
		if (isset($_GET[$name]))
			return $_GET[$name];
		else
			return null;
	}
	
	function post($name)
	{		
		if (isset($_POST[$name]))
			return $_POST[$name];
		else
			return null;
	}
	
	function calculate_time_ago($now, $timestamp, $is_short = true){		
		//parameters from the database
		$CI = &get_instance();		
		$difference = strtotime($now) - strtotime($timestamp);
		if ($is_short){
			$periods = array($CI->lang->line('second_short'), 
				$CI->lang->line('minute_short'), 
				$CI->lang->line('hour_short'), 
				$CI->lang->line('day_short'), 
				$CI->lang->line('week_short'), 
				$CI->lang->line('month_short'), 
				$CI->lang->line('year_short'), 
				$CI->lang->line('decade_short'));
		}
		else{
			$periods = array($CI->lang->line('second_long'), 
				$CI->lang->line('minute_long'), 
				$CI->lang->line('hour_long'), 
				$CI->lang->line('day_long'), 
				$CI->lang->line('week_long'), 
				$CI->lang->line('month_long'), 
				$CI->lang->line('year_long'), 
				$CI->lang->line('decade_long'));
		}
		$lengths = array(60, 60, 24, 7, 4.35, 12, 10);	
		$index = 0;
		for($j = 0; $difference >= $lengths[$j]; $j++){	
			$difference /= $lengths[$j];
			if ($index++ > 10){			
				break;
			}
		}
		$difference = round($difference);
		//if($difference != 1) $periods[$j].= "s";
		$text = "$difference $periods[$j]" . ($is_short ? "" : " trước");
		return $text;
	}
	
	function is_login(){		
		$CI =& get_instance();		
		$data = isset($_SESSION['user_data']);
		return $data != null;		
	}
	
	function set_login_data($user){		
		$CI =& get_instance();
		$_SESSION['user_data'] = $user;
	}
	
	function get_company_id(){		
		$data = get_login_data();
		$company_id = null;
		if ($data){
			$company_id = $data->company_id;
		}
		return $company_id;
	}
	
	function get_company_name(){
		$data = get_login_data();
		$company_name = null;
		if ($data){			
			$company_name = $data->company_name;
		}
		return $company_name;
	}
	
	function get_login_data(){				
		$CI =& get_instance();
		$data = null;
		if (isset($_SESSION['user_data'])){
			$data = $_SESSION['user_data'];
		}
		return $data;
	}
	
	function get_user_id(){	
		$CI =& get_instance();
		$id = null;
		$data = get_login_data();
		if ($data){			
			$id = $data->id;
		}
		return $id;
	}
	
	function get_current_admin(){
		$data = null;
		if (isset($_SESSION['admin_info']) && $_SESSION['admin_info']){
			$data = $_SESSION['admin_info'];
		}
		return $data;
	}
	
	function set_current_admin($admin){
		$_SESSION['admin_info'] = $admin;
	}
	
	function get_current_admin_id(){
		$data = get_current_admin();
		if ($data){
			return $data->id;
		}
		return null;
	}
	
	function sign_out(){
		set_login_data(null);
	}
	
	function set_userdata($key, $value){
		$_SESSION[$key] = $value;
	}
	
	function userdata($key){
		$data = null;
		if (isset($_SESSION[$key])){
			$data = $_SESSION[$key];
		}
		return $data;
	}

	function get_current_url() {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	function trim_text($input, $length, $ellipses = true, $strip_html = true) {
		//strip tags, if desired
		if ($strip_html) {
			$input = strip_tags($input);
		}
	  
		//no need to trim, already shorter than trim length
		if (strlen($input) <= $length) {
			return $input;
		}
	  
		//find last space within length
		$last_space = strrpos(substr($input, 0, $length), ' ');
		$trimmed_text = substr($input, 0, $last_space);
	  
		//add ellipses (...)
		if ($ellipses) {
			$trimmed_text .= '...';
		}
	  
		return $trimmed_text;
	}
	
	function trim_length($input, $length, $ellipses = true) {		
		//no need to trim, already shorter than trim length
		if (strlen($input) <= $length) {
			return $input;
		}
	  
		//find last space within length		
		$trimmed_text = substr($input, 0, $length);
	  
		//add ellipses (...)
		if ($ellipses) {
			$trimmed_text .= '...';
		}
	  
		return $trimmed_text;
	}
	
	function get_language(){
		$data = null;
		if (isset($_SESSION['language'])){
			$data = $_SESSION['language'];
		}
		else{
			$data = get_default_language();
			$_SESSION['language'] = $data;
		}
		return $data;
	}
	
	function get_default_language(){		
		$obj = new stdClass();
		$obj->iso = 'en';
		$obj->text = 'English';
		$obj->name = 'english';
		return $obj;
	}
	
	function change_language(){
		$CI = &get_instance();
		$language = $CI->input->post('language');				
		$iso = 'en';
		$name = 'english';//using for load language file
		$text = $CI->lang->line('english');
		if ($language == 'en'){
			$text = $CI->lang->line('english');
			$iso = $language;
			$name = 'english';
		}
		else if ($language == 'fi'){
			$text = $CI->lang->line('finland');
			$iso = $language;
			$name = 'finland';
		}
		else if ($language == 'kr'){
			$text = $CI->lang->line('korea');
			$iso = $language;
			$name = 'korea';
		}
		$obj = new stdClass();
		$obj->iso = $iso;
		$obj->text = $text;
		$obj->name = $name;
		$_SESSION['language'] = $obj;
	}
	
	function set_title_by_language($source, &$obj){
		$CI = &get_instance();
		$language = get_language();
		$iso = $language->iso;
		//var_dump($obj);
		if ($iso == EN){
			$obj->title = $source->title_en;
		}
		else if ($iso == FI){				
			$obj->title = $source->title_fi;
		}
		else if ($iso == KR){
			$obj->title = $source->title_kr;
		}
	}
	
	function get_saved_fail_message($name, $text){
		$CI = &get_instance();
		return sprintf($CI->lang->line('saved_fail'), htmlspecialchars(ucfirst($CI->lang->line($name))), htmlspecialchars($text));
	}
	
	function get_saved_message($name, $text){
		$CI = &get_instance();
		return sprintf($CI->lang->line('saved'), htmlspecialchars(ucfirst($CI->lang->line($name))), htmlspecialchars($text));
	}
	
	function get_not_found_short(){
		$CI = &get_instance();		
		return $CI->lang->line('data_not_found_short');
	}
	
	function get_not_found_long($link, $name_text){
		global $controller_name;		
		$CI = &get_instance();
		return sprintf($CI->lang->line('data_not_found_long'), base_url($link), htmlspecialchars($name_text));
	}
	
	function get_not_found_long_in_home($link, $name_text){		
		$CI = &get_instance();
		return sprintf($CI->lang->line('data_not_found_long'), base_url($link), htmlspecialchars($name_text));
	}
	
	function rrmdir($path) {
		$it = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($path),
			RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ($it as $file) {
			if (in_array($file->getBasename(), array('.', '..'))) {
				continue;
			} elseif ($file->isDir()) {
				rmdir($file->getPathname());
			} elseif ($file->isFile() || $file->isLink()) {
				unlink($file->getPathname());
			}
		}
		rmdir($path);
	}
	
	function dateDiff($dateStart, $dateEnd) 
	{
		$start = strtotime($dateStart);
		$end = strtotime($dateEnd);
		$days = $end - $start;
		$days = ceil($days/86400);
		return $days;
	}
	
	function correct_url($root_url, $url){
		$url = ltrim($url, "/");
		if (strpos($url, $root_url) === false){
			$url = $root_url . "/" . $url;
		}
		return $url;
	}
	
	function file_css($file_name){
		return base_url("css/" . $file_name);
	}
	
	function file_image($file_name){
		return base_url("images/" . $file_name);
	}
	
	function file_js($file_name){
		return base_url("js/" . $file_name);
	}
	
	function replace_email_text($user, $text){
		$base_url = base_url();
		$ar_keys = array('%first name%', '%last name%', '%email%', '%password%', '%home page%', '%activate url%');
		$ar_values = array($user->first_name, $user->last_name, $user->email, $user->password, $base_url, $base_url . 'activate/' . $user->activated_key);
		$result = str_replace($ar_keys, $ar_values, $text);
		return $result;
	}
	
	function send_email($to, $subject, $content, $files = null, $email_config = null)
	{	
		$CI =&get_instance();
		//$CI->load->helper('mail');
		$result = false;
		if (!$email_config){
			$CI->load->model('email_config');
			$email_config = $CI->email_config->get_one();
		}
		
		if ($email_config){
			$config = Array(
				'protocol' => $email_config->is_smtp ? 'smtp' : '',
				'smtp_host' => $email_config->smtp_host,
				'smtp_port' => $email_config->smtp_port,
				'smtp_crypto' => $email_config->is_ssl ? 'ssl' : '',
				'smtp_user' => $email_config->smtp_user,
				'smtp_pass' => $email_config->smtp_pass,
				'mailtype'  => 'html', 
				'charset'   => 'utf-8'
			); 
			
			$CI->load->library('email', $config);
			$CI->email->set_newline("\r\n");		
			$CI->email->to($to); 
			$CI->email->from($email_config->email, $email_config->email_name);			
			$CI->email->subject($subject);  		
			$CI->email->message($content);
			if ($files && is_array($files)){
				foreach($files as $file){
					$CI->email->attach($file);
				}
			}
			$result = $CI->email->send();			
			//echo $CI->email->print_debugger();		
		}
		return $result;
	}
	
	function has_role($module_id, $module_type, $user_role_modules){
		$found = false;
		foreach($user_role_modules as $item){
			if ($module_id == $item[0]){
				$found = $item[$module_type] == 1;				
				break;
			}
		}		
		return $found;
	}
	
	function correct_link($link){
		if (!$link){
			return base_url();
		}
		else if ($link == '#'){
			return 'javascript:void(0)';
		}
		
		if (strpos($link, 'http') === false){
			return base_url($link);
		}
		else{
			return $link;
		}
	}
	
	//return .jpg pr .png in lower text...
	function get_file_upload_ext($name){
		$ext = null;
		if (isset($_FILES[$name])){
			$ext = strtolower(substr($_FILES[$name]['name'], strrpos($_FILES[$name]['name'], '.')));
		}
		return $ext;
	}
	
	function is_ext_valid_image($ext){
		$ar_img = array('.jpg', '.jpeg', '.png');
		return in_array($ext, $ar_img) !== false;
	}
	
	function delete_file($dir, $file){
		if ($file && is_file($dir . $file)){		
			unlink($dir . $file);
		}							
	}
	
	function show_errors(){
		$CI = &get_instance();
		$errors = validation_errors();
		if ($errors){
			$arr_text = explode('</p>', $errors);			
			if (form_error('result')){
				echo '<div class="validation-summary-success">';
				foreach($arr_text as $key => $text){					
					//$text = trim(strip_tags($text));
					$text = trim($text);
					if ($text && trim(strip_tags($text)) != '1'){
						echo '<span>' . $text . '</span>';
					}
				}				
				echo '</div>';
			}
			else{
				echo '<div class="validation-summary-errors">';
				echo '<span>' . $CI->lang->line('error-title') . '</span><ul>';
				foreach($arr_text as $text){
					$text = trim(strip_tags($text));
					$text = trim($text);
					if ($text){
						echo '<li>' . $text . '</li>';
					}
				}
				echo '</ul></div>';
			}
		}		
	}
	
	function input_has_error($name){
		if (form_error($name)){
			return 'error';
		}
	}
	
	function add_form_error($field, $message)
	{
		$OBJ =& _get_validation_object();
		$OBJ->_field_data[$field]['error'] = $message;
		$OBJ->_error_array[$field] = $message;
	}
	
	function get_title_cms($cms){
		$title = '';
		if ($cms){
			$lang = get_language();
			if ($lang->iso == 'en'){
				$title = $cms->title_en;
			}
			else if ($lang->iso == 'fi'){
				$title = $cms->title_fi;
			}
			else if ($lang->iso == 'kr'){
				$title = $cms->title_kr;
			}
		}
		return $title;
	}
	
	function get_content_cms($cms){
		$content = '';
		if ($cms){
			$lang = get_language();
			if ($lang->iso == 'en'){				
				$content = $cms->content_en;
			}
			else if ($lang->iso == 'fi'){				
				$content = $cms->content_fi;
			}
			else if ($lang->iso == 'kr'){				
				$content = $cms->content_kr;
			}
		}
		return $content;
	}
	
	function check_file_upload_valid($name, $ar_exts_valid = array('jpg', 'jpeg', 'gif', 'png')){
		$result = 1;
		if (isset($_FILES[$name]) && isset($_FILES[$name]['name']) && $_FILES[$name]['name']){
			$path_info = pathinfo($_FILES[$name]['name']);
			$ext = strtolower($path_info['extension']);
			$result = in_array($ext, $ar_exts_valid);
		}
		return $result;
	}
	
	function get_dir_upload_zone($id){
		$path = getcwd() . '/uploads/';;
		if (!is_dir($path)){
			mkdir($path);
		}		
		$path .= 'zones/';
		if (!is_dir($path)){
			mkdir($path);
		}		
		$path .= $id . '/';		
		if (!is_dir($path)){
			mkdir($path);
		}		
		return $path;
	}
	
	function build_event_fomular($event, $company_id){
		$device_ids = explode(SEPARATER_FORMULAR_VALUE, $event->device_ids);
		$operators = explode(SEPARATER_FORMULAR_VALUE, $event->operators);
		$values = explode(SEPARATER_FORMULAR_VALUE, $event->values);
		$combines = explode(SEPARATER_FORMULAR_VALUE, $event->combines);
		$length = count($device_ids);		
		$formula = "IF ";
		$CI = &get_instance();
		
		for($i = 0; $i < $length; $i++){
			$device = $CI->device->get_id($device_ids[$i], $company_id);
			if (!$device){
				$formula = $CI->lang->line('device') . ' has id ' . $device_ids[$i] . ' was not found';
				break;
			}
			$formula .= sprintf("%s[%s] %s %s", ($i > 0 ? (" " . $combines[$i - 1] . " ") : ""), $device->device_name, $operators[$i], $values[$i]);
		}
		return $formula;
	}
	
	function build_event_expression($event_formula, $values){
		$pattern = "/\[[^\]]+\]/";
		$key = "@`@";
		$text_replace = preg_replace($pattern, $key , $event_formula);
		$arr = explode($key, $text_replace);
		$result = '';
		$length = count($arr);
		for($i = 1; $i < $length; $i++){		
			$result .= $values[$i - 1] . $arr[$i];
		}
		return $result;
	}
	function search_add_or_edit_menu_link($CI,
		$controller_name,
		$controller_name_cmp, 
		$view_name,
		$view_name_cmp,
		$module_id,
		$lang_edit,
		$lang_add, 
		&$m_id, 
		&$sm_id){
		$last_short_menu = null;
		//CHECK ADD EDIT LINK
		if ($controller_name == $controller_name_cmp && $view_name == $view_name_cmp){			
			$last_menu = $CI->module->get_id($module_id);
			if ($last_menu){	
				$submenu = $CI->submenu->get_by_module_id($module_id);
				if ($submenu){
					$sm_id = $submenu->id;
					$m_id = $submenu->menu_id;
				}
				else{
					$menu = $CI->menu->get_by_module_id($module_id);
					if ($menu){
						$m_id = $menu->id;
					}
				}
				if ($CI->input->get('id')){
					$last_short_menu = array(null, $CI->lang->line($lang_edit));
				}
				else{					
					$last_short_menu = array(null, $CI->lang->line($lang_add));
				}
			}
		}
		
		return $last_short_menu;
	}
	
	function search_parent_menu_link($CI,
		$controller_name,
		$controller_name_cmp, 
		$view_name,
		$view_name_cmp,
		$module_id,
		$lang_name,
		&$m_id, 
		&$sm_id){
		$last_short_menu = null;
		//CHECK ADD EDIT LINK
		//echo 'AAA ' . $controller_name . ' == ' . $controller_name_cmp . ' --- ' . $view_name . ' == ' . $view_name_cmp;
		if ($controller_name == $controller_name_cmp && $view_name == $view_name_cmp){			
			$last_menu = $CI->module->get_id($module_id);
			if ($last_menu){
				$submenu = $CI->submenu->get_by_module_id($module_id);
				if ($submenu){
					$sm_id = $submenu->id;
					$m_id = $submenu->menu_id;
				}
				else{
					$menu = $CI->menu->get_by_module_id($module_id);
					if ($menu){
						$m_id = $menu->id;
					}
				}
				$last_short_menu = array(null, $CI->lang->line($lang_name));				
			}
		}
		
		return $last_short_menu;
	}
		
	function get_back_url($url, $module_id = null){
		$tail = '';
		if ($module_id){
			$CI = &get_instance();
			$last_menu = $CI->module->get_id($module_id);
			if ($last_menu){	
				$submenu = $CI->submenu->get_by_module_id($module_id);
				if ($submenu){
					$sm_id = $submenu->id;
					$tail = 'sm_id=' . $sm_id;
					//$m_id = $submenu->menu_id;
				}
				else{
					$menu = $CI->menu->get_by_module_id($module_id);
					if ($menu){
						$m_id = $menu->id;
						$tail = 'm_id=' . $m_id;
					}
				}				
			}
		}
		$url = $url . (strpos($url, '?') === false ? '?' : '') . $tail;
		return $url;
	}
?>