<?php
	class Email_template extends CI_Model{
		public $title_en = "";
		public $title_fi = "";
		public $title_ci = "";
		public $content_en = "";
		public $content_fi = "";
		public $content_ci = "";
		public $status = 1;
		private $table_name = "email_templates";
		
		function get_id($id){			
			$this->db->where("id", $id);
			$query = $this->db->get($this->table_name);
			$data = $query->row();
			return $data;
		}
		
		function get_email_templates($keywords, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;
			
			if ($keywords != "")
			{				
				$this->db->like('title_en', $keywords);
				$this->db->or_like('title_fi', $keywords);
				$this->db->or_like('title_ci', $keywords);
			}			
			$num_rows = $this->db->count_all_results($this->table_name);
			
			if ($keywords != "")
			{				
				$this->db->like('title_en', $keywords);
				$this->db->or_like('title_fi', $keywords);
				$this->db->or_like('title_ci', $keywords);
			}
			$this->db->select("a.*,DATE_FORMAT(a.created_date, '" . DB_DATE_FORMAT . "') as created_date_format", false);			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				else if ($sort_by == "title_en"){
					$sort_column = "a.title_en";
				}
				else if ($sort_by == "title_fi"){
					$sort_column = "a.title_fi";
				}
				else if ($sort_by == "title_ci"){
					$sort_column = "a.title_ci";
				}
				else if ($sort_by == "created-date"){
					$sort_column = "a.created_date";
				}
				else if ($sort_by == "status"){
					$sort_column = "a.status";
				}				
				else if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;				
				}
				
				if ($sort_column){
					$this->db->order_by($sort_column);
				}
			}
			else{
				$this->db->order_by("a.id DESC");
			}
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function insert($data, $user_id){
			$this->db->set("title_en", $data->title_en);
			$this->db->set("title_fi", $data->title_fi);
			$this->db->set("title_ci", $data->title_ci);
			$this->db->set("content_en", $data->content_en);
			$this->db->set("content_fi", $data->content_fi);
			$this->db->set("content_ci", $data->content_ci);
			$this->db->set("status", $data->status);	
			$this->db->set("created_by", $user_id);			
			$this->db->set("created_date", "now()", false);			
			$result = $this->db->insert($this->table_name);
			return $result;
		}
		
		function update($data, $id){					
			$this->db->set("title_en", $data->title_en);
			$this->db->set("title_fi", $data->title_fi);
			$this->db->set("title_ci", $data->title_ci);
			$this->db->set("content_en", $data->content_en);
			$this->db->set("content_fi", $data->content_fi);
			$this->db->set("content_ci", $data->content_ci);
			$this->db->set("status", $data->status);			
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name);
			return $result;
		}		
		
		function get_post_data(){
			$data = new email_template();
			$data->title_en = $this->input->post('title_en');
			$data->title_fi = $this->input->post('title_fi');
			$data->title_ci = $this->input->post('title_ci');
			$data->content_en = $this->input->post('content_en');
			$data->content_fi = $this->input->post('content_fi');
			$data->content_ci = $this->input->post('content_ci');
			$data->status = $this->input->post('status');			
			return $data;
		}
		
		function clear_data(){
			$this->title_en = "";
			$this->title_fi = "";
			$this->title_ci = "";
			$this->content_en = "";
			$this->content_fi = "";
			$this->content_ci = "";
			$this->status = "1";			
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