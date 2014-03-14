<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Zaduzdfasdf_admin extends MY_controller{				
		protected $view_name = "";
		protected $admin_id;
		protected $cookie_auth_name = "auth_admin";
		protected $website_setting = null;
		
		function Zaduzdfasdf_admin(){		
			parent::__construct();			
			$this->home_directory = "admin/";
			$this->controller_name = ADMIN_CONTROLLER_NAME;
			$this->load->helper('email');
			$this->load->model("admin");
			$this->load->model("cms");			
			$this->load->model("site_setting");
			$this->website_setting = $this->site_setting->get_one();
			//login if found login cookie
			$this->check_auto_login();
			$this->lang->load('admin', get_language()->name);
			//get_ip_details();
		}
		
		/***********************************************************************/
		/**************************** USERS ONLINE INFORMATION *******************************/		
		/***********************************************************************/
		
		function user_online_information(){
			$this->check_login();
			$data = new stdClass();
			$data->guests_online = $guests;
			$data->members_online = $members;			
			echo json_encode($data);
		}
		
		/***********************************************************************/
		/**************************** END OF USERS ONLINE INFORMATION *******************************/		
		/***********************************************************************/
		
		function logout(){			
			$this->session->set_userdata("admin_info", null);			
			//$this->session->sess_destroy();
			if (isset($_COOKIE[$this->cookie_auth_name])){
				setcookie($this->cookie_auth_name, "", -1);
			}
			redirect(base_url($this->controller_name . "dang-nhap"));
		}

		function forgot_password(){
			$title_page = $this->lang->line('forgot_password');
			$err_msg = '';
			$result = null;
			$data = array();
			if(is_post()){
				$result = false;
				$email = $this->input->get('user');
				$user = $this->user->get_user_by_email($email);
				if ($user){					
					$this->load->helper('email');
					$this->load->model('emailtemplate');
					$email_template = $this->emailtemplate->get_id(4);
					if ($email_template){												
						$content = $email_template->content;
						$content = str_replace("%trang chu%", base_url(''), $content);
						$content = str_replace("%ten%", htmlspecialchars($user->first_name), $content);
						$content = str_replace("%mat khau%", htmlspecialchars($user->password), $content);
						$content = str_replace("%logo%", base_url(WEBSITE_DIRECTORY_IMAGES . $this->website_setting->logo), $content);							
						$content = str_replace("%email%", htmlspecialchars($user->email), $content);						
												
						$result = send_email(NOREPLY_EMAIL, EMAIL_NAME, $this->website_setting->email_password, $user->email, $email_template->title . SUFFIX_EMAIL_TITLE, $content);
						
						if ($result){
							$result = true;
							$err_msg = $this->lang->line('sent_email_password_to_your_email');
						}
						else{
							$err_msg = $this->lang->line('sent_email_password_to_your_email_fail');
						}
					}
					else{
						$err_msg = get_not_found_long('admin');
					}
				}
				else{
					$err_msg = $this->lang->line('email_didt_exist');
				}
			}
			$data['err_msg'] = $err_msg;
			$data['result'] = $result;
			$this->load_page('forgot-password', $title_page, $data, "empty-template"); 
		}
		
		function login(){
			$err_msg = "";
			$result = null;
			//already login
			if (get_current_admin_id())
			{
				//go to home page if already login
				redirect(base_url($this->controller_name));
			}			
						
			if ($this->input->post("login"))
			{	
				$result = false;
				$this->form_validation->set_rules('email', 'email', 'required|email');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[15]');					
			
				if ($this->form_validation->run() == TRUE)
				{
					$email = $this->input->post("email");
					$password = $this->input->post("password");
					$admin = $this->admin->get_admin($email, $password);
					if ($admin){
						if ($admin){
							$admin->password = "";
							$admin->created_date = "";
						}
						$this->session->set_userdata('admin_info', $admin);
						$setting = $this->setting->get();						
						//store admin id into session						
						//$this->tracking->tracking_admin($admin->id);
						
						//set remember cookie
						if ($this->input->post('remember')){
							$time = time();
							//add subfix 5 and postfix 5 characters
							$rem_data = "email=" . urlencode($email) . "&hash=" . substr($time, 0, 5) . $this->admin->encrypt_password(urlencode($password)) . substr($time, -5);
							//2 weeks
							setcookie($this->cookie_auth_name, $rem_data, $time + 14 * 24 * 60 * 60);
						}
						else{
							setcookie($this->cookie_auth_name, "", -1);
						}
						
						$url_redirect = $this->input->get('url');						
						if ($url_redirect){							
							redirect(urldecode(str_replace("/index.php", "", $url_redirect)));
						}
						else{
							redirect(base_url($this->controller_name));
						}
					}
					else{
						$err_msg = $this->lang->line('email_or_password_incorrect');
					}
				}
				else{
					$err_msg = $this->lang->line('email_or_password_incorrect');
				}
			}
			$data['err_msg'] = $err_msg;
			$data['result'] = $result;
			$this->load_page('login', $this->lang->line('signin'), $data, 'empty-template');
		}		
		
		protected function load_page($file_name, $title, $data, $template = "admin-template"){
			$model['data'] = $data;
			$model['page_title'] = $title;			
			$model['file_name'] = $this->home_directory . $file_name . ".php";			
			$model['controller_name'] = $this->controller_name;
			$model['view_name'] = $this->view_name;
			$model['admin_info'] = get_current_admin();
			$model['setting'] = $this->website_setting;
			$model['header_data'] = $this->cms->get_id(13);						
			$model['language'] = get_language();			
			$this->load->view($template . ".php", $model);
		}
		
		protected function check_login(){			
			if (!get_current_admin_id()){
				redirect(base_url($this->controller_name . 'login?url=' . urlencode(current_url())));
			}			
		}
		
		protected function is_login(){
			$data = get_current_admin();
			if ($data){
				return true;
			}			
			return false;
		}
		
		protected function check_auto_login(){
			if (isset($_COOKIE[$this->cookie_auth_name]) && !$this->admin_id){				
				parse_str($_COOKIE[$this->cookie_auth_name],$data);				
				if (isset($data['email']) && isset($data['hash'])){
					$email = $data['email'];
					$pass_length = strlen($data['hash']);
					$password = substr($data['hash'], 5, $pass_length - 10);
					$admin = $this->admin->get_admin_by_email($email);
					if ($admin){
						//admin password was already md5
						if($admin->status == 1 && $admin->password == $password){
							$this->session->set_userdata('admin_info', $admin);
							//reset cookie
							$time = time();
							$rem_data = "email=" . urlencode($email) . "&hash=" . substr($time, 0, 5) . $this->admin->encrypt_password(urlencode($password)) . substr($time, -5);
							setcookie($this->cookie_auth_name, $rem_data, $time + 14 * 24 * 60 * 60);
						}
						else{
							//delete cookie
							//setcookie($this->cookie_auth_name, "", -1);
						}
					}
					else{
						//delete cookie
						//setcookie($this->cookie_auth_name, "", -1);
					}
				}				
			}
		}
		
		function set_flashdata($value){
			$this->session->set_flashdata('flashdata', $value);
		}
	}
?>