<?php
	class Unit extends CI_Model{
		private $table_name = "units";
		public $unit_name = "";
		public $description = "";				
				
		function get_id($id){			
			$this->db->where("id", $id);			
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
		function get_by_name($name){
			$this->db->where('unit_name', $name);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
		
		function get_units($keywords, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;			
			
			if ($keywords != "")
			{				
				$this->db->like("unit_name", $keywords);				
				$this->db->or_like("description", $keywords);
			}			
			$num_rows = $this->db->count_all_results($this->table_name);
			$this->db->select("a.*, TRIM(CONCAT(u.first_name, ' ', u.last_name)) as full_name, DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format", false);
			$this->db->join('users u', 'u.id = a.created_by', 'left');
			if ($keywords != "")
			{				
				$this->db->like("unit_name", $keywords);				
				$this->db->or_like("description", $keywords);
			}
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "unit-name"){
					$sort_column = "a.unit_name";
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
				if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;				
					$this->db->order_by($sort_column);
				}
			}
			else{
				$this->db->order_by('a.unit_name');
			}
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function insert($data, $user_id){			
			$this->db->set("unit_name", $data->unit_name);
			$this->db->set("description", $data->description);
			$this->db->set("created_by", $user_id);
			$this->db->set("created_date", "now()", false);						
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $id){			
			$this->db->set("unit_name", $data->unit_name);
			$this->db->set("description", $data->description);			
			$this->db->where("id", $id);			
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function get_post_data(){
			$data = new unit();
			$data->unit_name = $this->input->post('unit_name');
			$data->description = $this->input->post('description');
			return $data;
		}
		
		function clear_data(){
			$this->unit_name = "";
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

		function get_all_units(){
			$this->db->order_by('unit_name');			
			$data = $this->db->get($this->table_name);			
			return $data;
		}
		
		function get_units_in($ids){
			$this->db->where_in('id', $ids);
			$query = $this->db->get($this->table_name);
			return $query;
		}
		
		function get_units_by_sub_type($id){
			$sub = $this->sub_type->get_id($id);
			$query = null;
			if ($sub){
				$units = explode(',', $sub->units);
				$query = $this->unit->get_units_in($units);
			}
			return $query;
		}
		
		function get_all_ar_units(){
			$query = $this->get_all_units();
			$data = array();
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}
?>