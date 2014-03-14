<?php
	class Email_config extends CI_Model{
		private $table_name = "email_config";
		public $email = "";
		public $email_name = "";
		public $is_smtp = "1";
		public $smtp_host = "";
		public $smtp_port = "465";
		public $is_ssl = "1";
		public $smtp_user = "";
		public $smtp_pass = "";
		
		function get_one(){		
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
				
		function insert_or_update($data, $user_id){
			$this->db->set("email", $data->email);
			$this->db->set("email_name", $data->email_name);
			$this->db->set("is_smtp", $data->is_smtp);
			$this->db->set("smtp_host", $data->smtp_host);			
			$this->db->set("smtp_port", $data->smtp_port);
			$this->db->set("is_ssl", $data->is_ssl);
			$this->db->set("smtp_user", $data->smtp_user);
			$this->db->set("smtp_pass", $data->smtp_pass);
			
			$old_config = $this->get_one();
			if ($old_config){
				//update
				$result = $this->db->update($this->table_name);
			}
			else{
				$this->db->set("created_date", "now()", false);
				$this->db->set("created_by", $user_id);
				$result = $this->db->insert($this->table_name);
			}			
						
			return $result;
		}
		
		function get_post_data(){
			$data = new Email_config();
			$data->email = $this->input->post('email');
			$data->email_name = $this->input->post('email_name');
			$data->is_smtp = $this->input->post('is_smtp');
			$data->smtp_host = $this->input->post('smtp_host');
			$data->smtp_port = $this->input->post('smtp_port');
			$data->is_ssl = $this->input->post('is_ssl');
			$data->smtp_user = $this->input->post('smtp_user');
			$data->smtp_pass = $this->input->post('smtp_pass');						
			return $data;
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
	}
?>