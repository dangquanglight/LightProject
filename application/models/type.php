<?php
	class Type extends CI_Model{
		private $table_name = "types";
		public $type_name = "";
		public $description = "";		
		public $status = 1;		
				
		function get_id($id){			
			$this->db->where("id", $id);			
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
		function get_types($keywords, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;			
			
			if ($keywords != "")
			{				
				$this->db->like("type_name", $keywords);				
				$this->db->or_like("description", $keywords);
			}			
			$num_rows = $this->db->count_all_results($this->table_name);
			$this->db->select("a.*, TRIM(CONCAT(u.first_name, ' ', u.last_name)) as full_name, DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, (SELECT COUNT(*) FROM sub_types WHERE type_id = a.id) as total_sub_types", false);
			$this->db->join('users u', 'u.id = a.created_by', 'left');
			if ($keywords != "")
			{				
				$this->db->like("type_name", $keywords);				
				$this->db->or_like("description", $keywords);
			}
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "type-name"){
					$sort_column = "a.type_name";
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
				$this->db->order_by('a.type_name');
			}
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function insert($data, $user_id){			
			$this->db->set("type_name", $data->type_name);
			$this->db->set("description", $data->description);
			$this->db->set("created_by", $user_id);
			$this->db->set("created_date", "now()", false);			
			$this->db->set("status", $data->status);
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $id){			
			$this->db->set("type_name", $data->type_name);
			$this->db->set("description", $data->description);
			$this->db->set("status", $data->status);
			$this->db->where("id", $id);			
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function get_post_data(){
			$data = new type();
			$data->type_name = $this->input->post('type_name');
			$data->description = $this->input->post('description');
			$data->status = $this->input->post('status');
			return $data;
		}
		
		function clear_data(){
			$this->type_name = "";
			$this->description = "";
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

		function get_all_types(){
			$this->db->order_by('type_name');			
			$data = $this->db->get($this->table_name);			
			return $data;
		}
		
		function get_all_ar_types(){
			$query = $this->get_all_types();
			$data = array();
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}
?>