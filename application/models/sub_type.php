<?php
	class Sub_type extends CI_Model{
		private $table_name = "sub_types";
		public $sub_type_name = "";
		public $min = "";
		public $max = "";
		public $description = "";
		public $units = "";
		public $status = 1;	
		public $type_id = '';		
				
		function get_id($id){			
			$this->db->where("id", $id);			
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
		function get_sub_types($keywords, $type_id, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;
			$sql_where = '';
			if ($type_id){
				$sql_where .= 'a.type_id = ' . $this->db->escape($type_id);
			}
			if ($keywords != "")
			{				
				$sql_where .= ($sql_where ? ' AND ' : '');
				$sql_where .= " (a.type_name LIKE '%" . $this->db->escape_like_str(keywords) . "%'";
				$sql_where .= " OR a.type_description LIKE '%" . $this->db->escape_like_str(keywords) . "%')";
			}
			//SET WHERE CLAUSE
			if ($sql_where){
				$this->db->where($sql_where);
			}
			$num_rows = $this->db->count_all_results($this->table_name . ' a');
			$this->db->select("a.*, TRIM(CONCAT(u.first_name, ' ', u.last_name)) as full_name, DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, s.type_name", false);
			$this->db->join('types s', 's.id = a.type_id', 'left');
			$this->db->join('users u', 'u.id = a.created_by', 'left');
			//SET WHERE CLAUSE
			if ($sql_where){
				$this->db->where($sql_where);
			}
			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "sub-type-name"){
					$sort_column = "a.sub_type_name";
				}
				else if ($sort_by == "type-name"){
					$sort_column = "s.type_name";
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
				$this->db->order_by('s.type_name,a.sub_type_name');
			}
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function insert($data, $user_id){			
			$this->db->set("sub_type_name", $data->sub_type_name);
			$this->db->set("description", $data->description);
			$this->db->set("min", $data->min);
			$this->db->set("max", $data->max);
			$this->db->set("created_by", $user_id);
			$this->db->set("created_date", "now()", false);			
			$this->db->set("type_id", $data->type_id);
			$this->db->set("status", $data->status);
			$this->db->set("units", $data->units);
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $id){
			$old_sub_type = $this->get_id($id);
			if ($old_sub_type){		
				$this->db->set("type_id", $data->type_id);
				$this->db->set("sub_type_name", $data->sub_type_name);
				$this->db->set("description", $data->description);
				$this->db->set("min", $data->min);
				$this->db->set("max", $data->max);
				$this->db->set("status", $data->status);
				$this->db->set("units", $data->units);
				$this->db->where("id", $id);			
				$result = $this->db->update($this->table_name);
				
				$length_old_units = 0;
				$length_units = 0;
				if ($old_sub_type->units){
					$old_units = explode(',', $old_sub_type->units);
					$length_old_units = count($old_units);
				}
				if ($data->units){
					$units = explode(',', $data->units);				
					$length_units = count($units);
				}
				
				//echo $length_old_units . ' ---- ' . $length_units;
				if ($length_old_units == 0 && $length_units > 0){
					//UPDATE ALL OF DEVICE WHICH HAVE SUB TYPE IS THIS
					$this->device->update_unit_id_by_sub_type_id($id, $units[0]);
					//echo $this->db->last_query();
				}
				else if ($length_old_units > 0 && $length_units == 0){
					//UPDATE ALL OF DEVICE WHICH HAVE SUB TYPE IS THIS
					$this->device->update_unit_id_by_sub_type_id($id, null);
					//echo $this->db->last_query();
				}
				
			}
			
			
			return $result;
		}
		
		function get_post_data(){
			$data = new sub_type();
			$data->sub_type_name = $this->input->post('sub_type_name');
			$data->description = $this->input->post('description');
			$data->min = $this->input->post('min');
			$data->max = $this->input->post('max');
			$data->status = $this->input->post('status');
			$data->type_id = $this->input->post('type_id');
			$units = $this->input->post('units');
			if ($units && is_array($units) && count($units) > 0){
				$units = implode(',', $units);
			}
			else{
				$units = '';
			}
			$data->units = $units;
			return $data;
		}
		
		function clear_data(){
			$this->sub_type_name = "";
			$this->description = "";
			$this->min = "";
			$this->max = "";
			$this->unit = "";
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

		function get_all_sub_types($type_id = null){
			$this->db->order_by('sub_type_name');
			if ($type_id){
				$this->db->where('type_id', $type_id);
			}
			$data = $this->db->get($this->table_name);
			return $data;
		}
		
		function get_all_ar_sub_types($type_id = null){
			$query = $this->get_all_sub_types($type_id);
			$data = array();
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}
?>