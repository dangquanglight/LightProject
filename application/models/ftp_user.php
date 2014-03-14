<?php
	class Ftp_user extends CI_Model{
		private $table_name = "ftp_users";		
		public $user_name = "";
						
		function get_id($user_name){			
			$this->db->where("user_name", $user_name);			
			$query = $this->db->get($this->table_name);			
			return $query->row();
		}
		
		function get_by_company_id($company_id){
			$this->db->where('company_id', $company_id);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}

		function insert($user_name, $password, $company_id){
			$this->db->set('user_name', $user_name);
			$this->db->set('password', md5($password));
			$this->db->set('company_id', $company_id);
			$this->db->set('created_date', 'now()', false);
			$result = $this->db->insert($this->table_name);
			return $result;
		}
	}
?>