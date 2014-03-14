<?php
	class Admin extends CI_Model{
		private $table_name = "admins";
		public $name = "";
		public $email = "";
		public $password = "";
		public $is_power = 0;		
		public $status = 1;
		
		function get_id($id){			
			$this->db->where("id", $id);
			$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y') as created_date_format", false);
			$query = $this->db->get($this->table_name);			
			return $query->row();
		}
		
		function get_admin($email, $password){			
			$this->db->where(array("email" => $email, "password" => $this->encrypt_password($password), "status" => 1));			
			$query = $this->db->get($this->table_name);
			$result = $query->result();			
			$data = null;
			if (count($result) > 0){
				$data = $result[0];
			}
			return $data;
		}
		
		function get_admin_by_email($email){
			$this->db->where("email", $email);
			$query = $this->db->get($this->table_name);			
			return $query->row();
		}
				
		function get_admin_by_id($id){			
			$this->db->where("id", $id);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
		
		function insert($admin, $owner){		
			$this->db->set("name", $admin->name);
			$this->db->set("email", $admin->email);			
			$this->db->set("password", $this->encrypt_password($admin->password));
			$this->db->set("status", $admin->status);
			$this->db->set("is_power", $admin->is_power);
			$this->db->set("created_by", $owner);			
			$this->db->set("created_date", "now()", false);
			$result = $this->db->insert($this->table_name);
			return $result;
		}
		
		function update($admin, $id){				
			$this->db->set("name", $admin->name);			
			$this->db->set("status", $admin->status);
			$this->db->set("is_power", $admin->is_power);			
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name);
			return $result;
		}
		
		function update_profile($admin, $id){				
			$this->db->set("name", $admin->name);						
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name);
			return $result;
		}
		
		function change_password($id, $old_password, $password){
			$result = false;
			$row = $this->get_admin_by_id($id);
			if ($row && $row->password == $this->encrypt_password($old_password)){				
				$this->db->set("password", $this->encrypt_password($password));
				$this->db->where("id", $id);
				$result = $this->db->update($this->table_name);
			}			
			return $result;
		}
		
		function reset_password($id, $password){			
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name, array("password" => $this->encrypt_password($password)));
			return $result;
		}
		
		function get_admins($keywords, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;			
			
			if ($keywords != "")
			{				
				$this->db->like('name', $keywords);
				$this->db->or_like('email', $keywords);
			}
							
			$num_rows = $this->db->count_all_results($this->table_name . " a");
			
			if ($keywords != "")
			{				
				$this->db->like('a.name', $keywords);
				$this->db->like('a.email', $keywords);
			}
			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				if ($sort_by == "name"){
					$sort_column = "a.name";
				}
				if ($sort_by == "email"){
					$sort_column = "a.email";
				}
				if ($sort_by == "created-date"){
					$sort_column = "a.created_date";
				}
				if ($sort_by == "status"){
					$sort_column = "a.status";
				}				
				if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;				
				}
				
				if ($sort_column){
					$this->db->order_by($sort_column);
				}
			}
			
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'%d/%m/%Y') as created_date_format", false);
			$data = $this->db->get($this->table_name . " a", $page_size, $start);			
			return $data; 		
		}
		
		function get_post_data(){
			$data = new admin();
			$data->name = $this->input->post('name');
			$data->email = $this->input->post('email');
			$data->password = $this->input->post('password');
			$data->status = $this->input->post('status');
			$data->is_power = $this->input->post('is_power');			
			return $data;
		}
		
		function clear_data(){
			$this->name = "";
			$this->email = "";
			$this->password = "";
			$this->status = "1";
			$this->is_power = "";
		}
		
		function delete($id)
		{
			//$this->db->where("is_power !=", 1);
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
		
		function encrypt_password($password){
			$result = sha1($password);
			return $result;
		}
		
		function get_power_status(){
			$this->db->where("type", 4);
			$query = $this->db->get("working_status");
			return $query;
		}
		
		function get_enabled_status(){
			$this->db->where("type", 3);
			$query = $this->db->get("working_status");
			return $query;
		}
	}
?>