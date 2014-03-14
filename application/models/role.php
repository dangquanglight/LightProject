<?php
	class Role extends CI_Model{
		private $table_name = "roles";
		public $role_name = "";
		public $description = "";
		public $status = 1;
				
		function get_id($id){			
			$this->db->where("id", $id);			
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
		function get_by_name($role_name, $company_id){
			$this->db->where("role_name", $role_name);
			$this->db->where('company_id', $company_id);			
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
		function get_roles($keywords, $company_id, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;			
			$this->db->where('company_id', $company_id);
			if ($keywords != "")
			{				
				$this->db->like("role_name", $keywords);
			}			
			$num_rows = $this->db->count_all_results($this->table_name);
			
			$this->db->select("a.*, TRIM(CONCAT(u.first_name, ' ', u.last_name)) as full_name, DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format", false);
			$this->db->join('users u', 'u.id = a.created_by', 'left');
			$this->db->where('a.company_id', $company_id);
			if ($keywords != "")
			{				
				$this->db->like("role_name", $keywords);
			}			
			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "role"){
					$sort_column = "a.role_name";
				}
				else if ($sort_by == "created-by"){
					$sort_column = "u.first_name";
					if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
						$sort_column .= " " . $ascending;				
					}
					$sort_column .= ",u.last_name";
				}
				else if ($sort_by == "created-date"){
					$sort_column = "a.created_date";
				}
				else if ($sort_by == "created-by"){
					$sort_column = "a.created-by";
				}
				else if ($sort_by == "status"){
					$sort_column = "a.status";
				}
				if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;				
					$this->db->order_by($sort_column);
				}
			}
			else{
				$this->db->order_by('role_name');
			}			
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function set_default_modules($company_id){
			//CREATE ADMINISTRATOR AND VIEWER AS DEFAULT
			
			/*** ADMINISTRATOR ***/
			$data = new Role();
			$data->company_id = $company_id;
			$data->role_name = 'Administrator';
			$data->description = 'This only for administrator';
			$data->status = 1;
			$this->insert($data, null);
			$role_id = $this->db->insert_id();
			$role_admin_id = $role_id;
			
			//SET FULL PERMISSION FOR ALL OF MODULES						
			$query_modules = $this->module->get_all_modules(false);
			$module_data = new Role_4_modules();
			$module_data->view = 1;
			$module_data->insert = 1;
			$module_data->update = 1;
			$module_data->delete = 1;
			$module_data->role_id = $role_id;			
			foreach($query_modules->result() as $row){
				$module_data->module_id = $row->module_id;
				$this->role_4_modules->insert_or_update($module_data, null);
			}
			
			/*** VIEWER ***/
			$data->role_name = 'Viewer';
			$this->insert($data, null);
			$role_id = $this->db->insert_id();
			
			//SET READ ONLY PERMISSION FOR ALL OF MODULES			
			$module_data->view = 1;
			$module_data->insert = 0;
			$module_data->update = 0;
			$module_data->delete = 0;
			$module_data->role_id = $role_id;			
			foreach($query_modules->result() as $row){
				$module_data->module_id = $row->module_id;
				$this->role_4_modules->insert_or_update($module_data, null);
			}
			return $role_admin_id;
		}
		
		function insert($data, $user_id){			
			$this->db->set("role_name", $data->role_name);			
			$this->db->set("description", $data->description);
			$this->db->set("status", $data->status);
			$this->db->set("company_id", $data->company_id);
			$this->db->set("created_by", $user_id);
			$this->db->set("created_date", "now()", false);
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $company_id, $id){			
			$this->db->set("role_name", $data->role_name);
			$this->db->set("description", $data->description);
			$this->db->set("status", $data->status);
			$this->db->where("company_id", $company_id);
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function get_post_data(){
			$data = new role();
			$data->role_name = $this->input->post('role_name');
			$data->description = $this->input->post('description');
			$data->status = $this->input->post('status');
			return $data;
		}
		
		function clear_data(){
			$this->role_name = "";
			$this->description = "";
			$this->status = "";
		}
				
		function delete($id, $company_id)
		{
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$this->db->delete($this->table_name);			
		}
		
		function delete_in($ids, $company_id)
		{
			foreach($ids as $id){				
				$this->delete($id, $company_id);
			}
		}
		
		function active_in($status, $ids, $company_id)
		{
			$this->db->set("status", $status);
			$this->db->where("company_id", $company_id);
			$this->db->where_in("id", $ids);			
			$result = $this->db->update($this->table_name);
			return $result;
		}
				
		function get_all_roles($company_id){
			$this->db->order_by('role_name');
			if ($company_id){
				$this->db->where("company_id", $company_id);
			}
			$data = $this->db->get($this->table_name);			
			return $data;
		}		
	}
?>