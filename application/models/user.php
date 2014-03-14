<?php
	class User extends CI_Model{
		private $table_name = "users";		
		public $first_name = "";
		public $last_name = "";
		public $ftp_user_name = '';
		public $ftp_password = '';
		public $password = "";
		public $phone = "";
		public $email = "";		
		public $role_id = "";	
		public $status = 1;		
		public $address = "";
		public $activated = 0;
		public $activated_key = "";
		public $company_name = "";
		public $company_description = "";
		public $company_id = 0;
				
		function get_id($id){			
			$this->db->where("id", $id);
			$this->db->select("*, TRIM(CONCAT(first_name, ' ', last_name)) as full_name,DATE_FORMAT(created_date,'" . DB_DATE_FORMAT . "') as created_date_format", false);
			$query = $this->db->get($this->table_name);			
			return $query->row();
		}
		
		function get_by_email($email){			
			$this->db->where("email", $email);			
			$query = $this->db->get($this->table_name);			
			return $query->row();
		}
		
		function get_by_activated_key($key){
			$this->db->select('a.*,c.company_name');
			$this->db->join('companies c', 'c.id = a.company_id', 'left');
			$this->db->where("a.activated_key", $key);
			$query = $this->db->get($this->table_name . ' a');
			return $query->row();
		}
		
		function update_activated($id){
			$this->db->set("activated", 1);						
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name);
			return $result;
		}
		
		function get_user_by_email_password($email, $password){			
			$this->db->select('a.*, r.status as role_status,c.company_name');
			$this->db->select('a.*,c.company_name');
			$this->db->join('companies c', 'c.id = a.company_id', 'left');
			$this->db->where("a.email", $email);			
			$this->db->where("a.password", $password);
			$this->db->join('roles r', 'r.id = a.role_id', 'left');
			$query = $this->db->get($this->table_name . ' a');
			return $query->row();
		}
		
		function get_user_by_email($email){			
			$this->db->where("email", $email);			
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
		
		function insert($user){		
			$this->db->set("first_name", $user->first_name);
			$this->db->set("last_name", $user->last_name);
			$this->db->set("email", $user->email);			
			$this->db->set("password", $user->password);
			$this->db->set("role_id", $user->role_id);
			$this->db->set("status", $user->status);	
			$this->db->set("phone", $user->phone);
			$this->db->set("created_date", "now()", false);
			$this->db->set("activated", $user->activated);
			$this->db->set("activated_key", $user->activated_key);
			$this->db->set("company_id", $user->company_id);
			$result = $this->db->insert($this->table_name);
			return $result;
		}
				
		function update($user, $id){			
			$this->db->set("first_name", $user->first_name);
			$this->db->set("last_name", $user->last_name);
			$this->db->set("phone", $user->phone);
			$this->db->set("address", $user->address);			
			$this->db->set("role_id", $user->role_id);
			$this->db->set("activated", $user->activated);
			$this->db->set("status", $user->status);
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name);
			return $result;
		}
		
		function update_role_and_company_id($user_id, $role_id, $company_id){
			$this->db->set("company_id", $company_id);
			$this->db->set("role_id", $role_id);
			$this->db->where("id", $user_id);
			$result = $this->db->update($this->table_name);
			return $result;
		}
		
		function update_profile($user, $id){				
			$this->db->set("first_name", $user->first_name);
			$this->db->set("last_name", $user->last_name);
			$this->db->set("phone", $user->phone);
			$this->db->set("address", $user->address);
									
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name);
			return $result;
		}
				
		function change_password($id, $old_password, $password){
			$result = false;
			$row = $this->get_user_by_id($id);
			if ($row && $row->password == $old_password){				
				$this->db->set("password", $password);
				$this->db->where("id", $id);
				$result = $this->db->update($this->table_name);
			}			
			return $result;
		}
		
		function reset_password($id, $password){			
			$this->db->where("id", $id);
			$this->db->set("password", $password);
			$result = $this->db->update($this->table_name);
			return $result;
		}
				
		function get_users($keywords, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;			
			
			if ($keywords != "")
			{				
				$this->db->like("CONCAT(first_name, ' ', last_name)", $keywords);
				$this->db->or_like('phone', $keywords);
			}
			
			$num_rows = $this->db->count_all_results($this->table_name . " u");
			
			if ($keywords != "")
			{				
				$this->db->like("CONCAT(a.first_name, ' ', a.last_name)", $keywords);
				$this->db->or_like('a.phone', $keywords);
			}
			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				else if ($sort_by == "name"){
					$sort_column = "a.first_name";
					if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
						$sort_column .= " " . $ascending;				
					}
					$sort_column .= ",a.last_name";
				}
				else if ($sort_by == "email"){
					$sort_column = "a.email";
				}
				else if ($sort_by == "role"){
					$sort_column = "r.role_name";
				}
				else if ($sort_by == "created-date"){
					$sort_column = "a.created_date";
				}				
				else if ($sort_by == "status"){
					$sort_column = "a.status";
				}				
				
				if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;				
					$this->db->order_by($sort_column);
				}
			}			
			$this->db->select("a.*, TRIM(CONCAT(a.last_name, ' ', a.first_name)) as full_name,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, r.role_name", false);			
			$this->db->join('roles r', 'r.id = a.role_id', 'left');
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function get_all_users(){
			$this->db->select("a.*, TRIM(CONCAT(a.first_name, ' ', a.last_name)) as full_name", false);
			$this->db->order_by('a.first_name');
			$query = $this->db->get($this->table_name . " a");
			return $query;
		}
		
		function get_post_data(){
			$data = new User();			
			$data->first_name = $this->input->post('first_name');
			$data->last_name = $this->input->post('last_name');
			$data->password = $this->input->post('password');
			$data->phone = $this->input->post('phone');
			$data->email = $this->input->post('email');
			$data->role_id = $this->input->post('role_id');
			$data->activated = $this->input->post('activated');
			$data->status = $this->input->post('status');
			$data->address = $this->input->post('address');
			$data->company_name = $this->input->post('company_name');
			$data->company_description = $this->input->post('company_description');
			$data->ftp_user_name = $this->input->post('ftp_user_name');
			$data->ftp_password = $this->input->post('ftp_password');
			return $data;
		}
		
		function clear_data(){
			$this->name = "";
			$this->first_name = "";
			$this->last_name = "";
			$this->password = "";
			$this->phone = "";
			$this->email = "";								
			$this->address = "";
			$this->role_id = "";
		}
				
		function delete($id)
		{
			$this->db->where("id", $id);			
			$this->db->delete($this->table_name);			
		}
		
		function delete_in($ids)
		{
			foreach($ids as $id){				
				$this->delete($id);
			}
		}
				
		function active_in($status, $ids)
		{
			$this->db->set("status", $status);
			$this->db->where_in("id", $ids);			
			$result = $this->db->update($this->table_name);
			return $result;
		}
	}
?>