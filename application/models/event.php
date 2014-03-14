<?php
	class Event extends CI_Model{
		private $table_name = "events";
		public $name = "";
		public $values = "";
		public $operators = "";
		public $combines = "";
		public $device_id = "";
		public $device_ids = "";
		public $status = 1;
		public $description = '';
		public $value = '';
				
		function get_id($id){			
			$this->db->where("id", $id);			
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
		
		function get_all_enable($company_id){			
			$this->db->where("company_id", $company_id);
			$this->db->where("status", 1);
			$query = $this->db->get($this->table_name);
			return $query;
		}
		
		function get_events($company_id, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
				
			
			$sql_where = "a.company_id = " . $this->db->escape($company_id);
			if ($sql_where){
				$this->db->where($sql_where);
			}
			$num_rows = $this->db->count_all_results($this->table_name . " a");
			$this->db->select("a.*,DATE_FORMAT(a.created_date, '"  . DB_DATE_FORMAT . "') as created_date_format, d.device_name", false);			
			$this->db->join('devices d', 'd.id = a.device_id', 'left');
			$sql_where = "a.company_id = " . $this->db->escape($company_id);
			if ($sql_where){
				$this->db->where($sql_where);
			}	
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}				
				if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;				
					$this->db->order_by($sort_column);
				}
			}
			else{
				$this->db->order_by('a.id DESC');
			}
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function get_combine_events($company_id, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$sql = "SELECT * FROM (
				SELECT e.id, 1 as event_type, e.name, d.device_name, e.created_date 
				FROM `events_schedule` e LEFT JOIN devices d ON e.device_id = d.id
				WHERE 
				UNION ALL
				SELECT e.id, 2 as event_type, e.name, d.device_name, e.created_date 
				FROM `events` e LEFT JOIN devices d ON e.device_id = d.id
				) t
				ORDER BY t.created_date DESC";
			
		}
		
		function insert($data, $company_id, $user_id){
			$this->db->set("device_id", $data->device_id);
			$this->db->set("name", $data->name);
			$this->db->set("values", $data->values);
			$this->db->set("operators", $data->operators);
			$this->db->set("combines", $data->combines);
			$this->db->set("device_ids", $data->device_ids);
			$this->db->set("company_id", $company_id);
			$this->db->set("status", $data->status);
			$this->db->set("description", $data->description);
			$this->db->set("value", $data->value);
			$this->db->set("created_date", 'now()', false);
			$this->db->set("created_by", $user_id);
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $id, $company_id){
			$this->db->set("device_id", $data->device_id);
			$this->db->set("name", $data->name);
			$this->db->set("values", $data->values);
			$this->db->set("operators", $data->operators);
			$this->db->set("combines", $data->combines);
			$this->db->set("device_ids", $data->device_ids);			
			$this->db->set("status", $data->status);
			//$this->db->set("working_until", $data->description);
			$this->db->set("description", $data->description);
			$this->db->set("value", $data->value);
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function get_post_data(){
			$data = new Event();
			if ($this->input->post('values')){
				$data->values = implode(SEPARATER_FORMULAR_VALUE, $this->input->post('values'));
			}
			else{
				$data->value = "";
			}
			if ($this->input->post('operators')){
				$data->operators = implode(SEPARATER_FORMULAR_VALUE, $this->input->post('operators'));
			}
			else{
				$data->operators = "";
			}
			if ($this->input->post('combines')){
				$data->combines = implode(SEPARATER_FORMULAR_VALUE, $this->input->post('combines'));
			}
			else{
				$data->combines = "";
			}
			if ($this->input->post('device_ids')){
				$data->device_ids = implode(SEPARATER_FORMULAR_VALUE, $this->input->post('device_ids'));
			}
			else{
				$data->device_ids = "";
			}
			$data->device_id = $this->input->post('device_id');
			$data->name = $this->input->post('name');
			$data->status = $this->input->post('status');
			$data->description = $this->input->post('description');
			$data->value = $this->input->post('value');
			return $data;
		}
		
		function clear_data(){
			$this->device_id = "";
			$this->name = "";
			$this->values = "";
			$this->operators = "";
			$this->combines = "";
			$this->device_ids = "";
			$this->status = "1";
			$this->description = "";
			$this->working_util = "";
			$this->value = "";
		}
		
		function active_in($status, $ids, $company_id)
		{
			$this->db->set("status", $status);
			$this->db->where("company_id", $company_id);
			$this->db->where_in("id", $ids);			
			$result = $this->db->update($this->table_name);
			return $result;
		}
		
		function active_all($device_id, $status, $company_id){
			$this->db->set("status", $status);
			$this->db->where("device_id", $device_id);
			$this->db->where("company_id", $company_id);			
			$result = $this->db->update($this->table_name);
			return $result;
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
	}
?>