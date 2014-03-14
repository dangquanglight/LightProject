<?php
	$file = getcwd() . "/" . APPPATH . "controllers/MY_controller.php";		
	include $file;
	class Fsadfzerrwez_analyze extends Fsadfzerrwez_home{
		function Fsadfzerrwez_analyze(){		
			parent::__construct();	
			$this->load->model("device");
			$this->load->model("measurement");
		}
		
		/***********************************************************************/
		/**************************** START ANALYZE *******************************/		
		/***********************************************************************/
		
		function index(){			
			$this->analyze();
		}
		
		function analyze(){
			$this->check_login();
			$this->check_role(MODULE_ANALYZE, MODULE_TYPE_VIEW);
			$data = array();
			$company_id = get_company_id();			
			$this->load_page('analyze', $this->lang->line('analyze'), $data);
		}
		
		function analyze_devices($sort_by, $is_down){
			$this->check_login();
			$this->load->model('measurement');
			$this->check_role(MODULE_ANALYZE, MODULE_TYPE_VIEW);
			$data = array();
			$data['sort_by'] = $sort_by;
			$company_id = get_company_id();			
			$data['devices'] = $this->device->get_by_company_analyze($company_id, $sort_by, $is_down);			
			$this->load->view($this->home_directory . 'analyze-devices', $data);
		}
		
		function analyze_details($id){
			$this->check_login();
			$this->check_role(MODULE_ANALYZE, MODULE_TYPE_VIEW);
			$this->load->model('site');
			$this->load->model('zone');
			$data = array();
			$company_id = get_company_id();
			$data['device'] = $this->device->get_id($id, $company_id);			
			$data['sites'] = $this->site->get_all_sites($company_id);
			$data['zones'] = $this->zone->get_all_zones_by_device_type($company_id, $data['device']->type_id);
			$data['id'] = $id;
			$this->get_next_previous_devices($id, $data);
			$this->load_page('analyze-details', $this->lang->line('analyze'), $data);
		}
		
		function analyze_stream($id){
			$data = array();
			$data['id'] = $id;
			$data['device'] = $this->device->get_id($id, get_company_id());
			$this->get_next_previous_devices($id, $data);
			$this->load_page('analyze-stream', $this->lang->line('stream'), $data);
		}
		
		function analyze_status($id){
			$this->check_login();
			$this->check_role(MODULE_ANALYZE, MODULE_TYPE_VIEW);
			$this->load->model('site');
			$this->load->model('zone');
			$data = array();
			$company_id = get_company_id();
			$data['device'] = $this->device->get_id($id, $company_id);
			$data['sites'] = $this->site->get_all_sites($company_id);
			$data['zones'] = $this->zone->get_all_zones_by_device_type($company_id, $data['device']->type_id);			
			$this->get_next_previous_devices($id, $data);
			$this->load_page('analyze-status', $this->lang->line('analyze-status'), $data);
		}
		
		function stream_info($id){
			$length = 0;
			$ids = '';
			if (is_login()){
				$data = $this->measurement->get_stream_measurements($id);
				if ($data){
					$length = $data->count;
					$ids = explode(',', $data->ids);
				}
			}
			//echo $this->db->last_query();
			$data = new stdClass();
			$data->length = $length;
			$data->ids = $ids;
			echo json_encode($data);
		}
		
		/***********************************************************************/
		/**************************** END OF ANALYZE *******************************/		
		/***********************************************************************/		
	}
?>