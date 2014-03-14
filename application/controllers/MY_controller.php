<?php		
	class MY_controller extends CI_Controller{	
		protected $view_name = "";
		protected $controller_name = "";
		protected $home_directory = "home/";
		protected $meta_keywords = "";
		protected $meta_description = "";
		protected $date_info = null;
		protected $user_role_modules = array();
		protected $language = null;
		
		function MY_controller(){			
			parent::__construct();	
			$CI = &get_instance();			
			$this->load->model('role_4_modules');
			$this->load->model('model_utils');
			$this->load->helper('url');
			$this->load->helper('utils');
			$this->load->helper('paging');			
			$this->load->library('session');
			$this->load->library('form_validation');
			$this->load->model('module');
			$this->load->model('menu');
			$this->load->model('submenu');						
			$this->language = get_language();
			$this->lang->load('home', $this->language->name);			
			$this->view_name = $CI->router->method;
			$this->controller_name = $CI->router->class . "/";
			$this->date_info = $this->model_utils->get_current_date();
			
			//LOAD ALL ROLES
			$user_data = get_login_data();
			if ($user_data){								
				$this->user_role_modules = $this->role_4_modules->get_arr_by_role($user_data->role_id);
			}	
		}
		
		function check_role($module_id, $module_type){
			if (!has_role($module_id, $module_type, $this->user_role_modules)){
				redirect(base_url('not-enough-privilege'));
			}
		}
		
		function check_role_ajax($module_id, $module_type){
			if (!has_role($module_id, $module_type, $this->user_role_modules)){
				echo AJAX_NOT_ENOUGH_PRIVILEGE;
				die();
			}
		}
		
		protected function check_login(){
			$user_id = get_user_id();
			if (!$user_id){				
				$redirect_url = current_url();
				redirect(base_url("login") . "?redirect_url=" . $redirect_url);
			}
		}
		
		protected function check_login_ajax(){
			$user_id = get_user_id();
			if (!$user_id){				
				echo AJAX_NOT_LOGIN;
				die();
			}
		}
				
		function change_language(){
			change_language();
		}
		
		protected function get_page_config(){			
			$page = 1;
			$page_size = PAGE_SIZE_DEFAULT;
			if ($this->input->get('page') && intval($this->input->get('page')) > 0)
			{
				$page = intval($this->input->get('page'));
			}
			
			if ($this->input->get('page_size') && intval($this->input->get('page_size')) > 0)
			{
				$page_size = intval($this->input->get('page_size'));
			}			
			
			$data['sort_by'] = $this->input->get("sort_by");
			$data['ascending'] = $this->input->get("ascending");			
			$data['search_type'] = $this->input->get('search_type');
			$data['keywords'] = $this->input->get('keywords');
			$data['page'] = $page;
			$data['page_size'] = $page_size;						
			return $data;
		}
		
		protected function set_paging_data(&$data, $query, $num_rows){
			$data['data'] = $query;
			$data['num_rows'] = $num_rows;
			$data['total_pages'] = ceil($num_rows / $data['page_size']);
			$data['controller_name'] = $this->controller_name;
			return $data;
		}
		
		protected function get_array_ids(){
			$ids = $this->input->post('ids');
			$ar_id = explode(",", $ids);
			return $ar_id;
		}		
		
		protected function set_flashdata($value){
			$this->session->set_flashdata('flashdata', $value);
		}	
		
		protected function get_next_previous_devices($id, &$data){
			$data['next-device-url'] = null;
			$data['previous-device-url'] = null;
			$company_id = get_company_id();
			if ($company_id){
				$this->device->get_next_device($id, $company_id, $previous_device, $next_device);
				$this->bind_device_url($data, $previous_device, 'previous-device-url');
				$this->bind_device_url($data, $next_device, 'next-device-url');
			}
		}
		
		private function bind_device_url(&$data, $device, $key){
			if ($device){				
				if ($device->type_id == 1){
					$data[$key] = base_url('stream/' . $device->id . '/' . text_to_title($device->device_name));
				}
				else if ($device->type_id == 2){
					$data[$key] = base_url('analyze-status/' . $device->id . '/' . text_to_title($device->device_name));
				}
				else{
					$data[$key] = base_url('analyze-details/' . $device->id . '/' . text_to_title($device->device_name));
				}
			}
		}
	}	
	require APPPATH . "controllers/fsadfzerrwez_home.php";		
	require APPPATH . "controllers/zaduzdfasdf_admin.php";
?>