<?php
	class Role_4_modules extends CI_Model{
		private $table_name = "role_4_modules";
		public $role_id = "";
		public $module_id = "";
		public $view = "";
		public $insert = "";
		public $update = "";
		public $delete = "";
		
		function get_by_role_and_module($role_id, $module_id){
			$this->db->where("role_id", $role_id);
			$this->db->where("module_id", $module_id);
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
		function get_arr_by_role($role_id){
			$this->db->where("role_id", $role_id);			
			$query = $this->db->get($this->table_name);
			$data = array();
			foreach($query->result() as $row){
				$data[] = array($row->module_id, $row->view, $row->insert, $row->update, $row->delete);
			}
			return $data;
		}		
		
		function insert_or_update($data, $user_id){
			//find old data
			$old_data = null;
			if ($data->role_id && $data->role_id){
				$old_data = $this->get_by_role_and_module($data->role_id, $data->module_id);						
			}			
			$this->db->set("view", $data->view);
			$this->db->set("insert", $data->insert);
			$this->db->set("update", $data->update);
			$this->db->set("delete", $data->delete);
			if (!$old_data){
				$this->db->set("role_id", $data->role_id);	
				$this->db->set("module_id", $data->module_id);
				$this->db->set("created_by", $user_id);
				$this->db->set("created_date", "now()", false);
				$result = $this->db->insert($this->table_name);
			}
			else{
				$this->db->where("role_id", $data->role_id);	
				$this->db->where("module_id", $data->module_id);
				$result = $this->db->update($this->table_name);
			}			
			return $result;
		}
		
		function insert_or_update_arr($ar_items, $role_id, $user_id){
			$result_count = 0;
			foreach($ar_items as $item){
				$data = new role_4_modules();
				$data->module_id = $item[0];
				$data->role_id = $role_id;
				$data->view = $item[1];
				$data->insert = $item[2];
				$data->update = $item[3];
				$data->delete = $item[4];
				$result = $this->insert_or_update($data, $user_id);
				if ($result){
					$result_count++;
				}
			}			
			return $result_count;
		}
		
		function check_permission_in_array($role_modules, $module_id){
			$data = array(0,0,0,0);
			foreach($role_modules as $item){
				if ($item[0] == $module_id){
					$data[0] = $item[1];
					$data[1] = $item[2];
					$data[2] = $item[3];
					$data[3] = $item[4];
					break;
				}
			}
			return $data;
		}
		
		function get_post_data(){
			$query = $this->module->get_all_modules();
			$data = array();
			foreach($query->result() as $row){
				//FIND POST DATA
				$view = $this->input->post('module-' . $row->module_id . '-1') ? 1 : 0;
				$insert = $this->input->post('module-' . $row->module_id . '-2') ? 1 : 0;
				$update = $this->input->post('module-' . $row->module_id . '-3') ? 1 : 0;
				$delete = $this->input->post('module-' . $row->module_id . '-4') ? 1 : 0;
				$data[] = array($row->module_id, $view, $insert, $update, $delete);
			}
			return $data;
		}
	}
?>