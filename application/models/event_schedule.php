<?php
	class Event_schedule extends CI_Model{
		private $table_name = "events_schedule";
		public $name = "";
		public $hours = "";
		public $minutes = "";
		public $hours_off = "";
		public $minutes_off = "";
		public $repeat_type = "";
		public $repeat_on = "";
		public $repeat_every = '';
		public $start_on = "";
		public $start_on_format = '';
		public $ends = 1;
		public $end_by_date = "";
		public $end_by_date_format = '';
		public $end_by_ocurrences = "";
		public $device_id = "";
		public $company_id = "";
		public $description = "";
		public $status = 1;
		public $value = '';
				
		function get_id($id){			
			$this->db->select("a.*,DATE_FORMAT(a.start_on, '"  . DB_DATE_FORMAT . "') as start_on_format,DATE_FORMAT(a.end_by_date, '"  . DB_DATE_FORMAT . "') as end_by_date_format" , false);
			$this->db->where("id", $id);			
			$query = $this->db->get($this->table_name . ' a');
			return $query->row();
		}
		
		function get_all_enable(){	
			$this->db->where("status", 1);
			$this->db->where('start_on <=', 'curdate()', false);
			$this->db->where('(ends = 1 OR (ends = 2 AND ocurrences < end_by_ocurrences) OR (ends = 3 AND end_by_date < curdate()))');
			$query = $this->db->get($this->table_name);
			return $query;
		}
		
		function get_events($company_id, $keywords, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;			
			
			$sql_where = "a.company_id = " . $this->db->escape($company_id);
			if ($keywords){
				$sql_where .= " AND (a.name LIKE '%"  . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= " OR d.device_name LIKE '%"  . $this->db->escape_like_str($keywords) . "%')";
			}
			if ($sql_where){
				$this->db->where($sql_where);
			}
			$this->db->join('devices d', 'd.id = a.device_id', 'left');
			$num_rows = $this->db->count_all_results($this->table_name . " a");
			$this->db->select("a.*,DATE_FORMAT(a.created_date, '"  . DB_DATE_FORMAT . "') as created_date_format,DATE_FORMAT(a.start_on, '"  . DB_DATE_FORMAT . "') as start_on_format, d.device_name", false);			
			$this->db->join('devices d', 'd.id = a.device_id', 'left');
			$sql_where = "a.company_id = " . $this->db->escape($company_id);
			if ($keywords){
				$sql_where .= " AND (a.name LIKE '%"  . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= " OR d.device_name LIKE '%"  . $this->db->escape_like_str($keywords) . "%')";
			}
			if ($sql_where){
				$this->db->where($sql_where);
			}	
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				else if ($sort_by == "name"){
					$sort_column = "a.name";
				}
				else if ($sort_by == "device-name"){
					$sort_column = "d.device_name";
				}
				else if ($sort_by == "repeats"){
					$sort_column = "a.repeat_type";
				}
				else if ($sort_by == "repeat-every"){
					$sort_column = "a.repeat_every";
				}
				else if ($sort_by == "starts-on"){
					$sort_column = "a.start_on";
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
		
		function insert($data, $company_id, $user_id){
			$this->db->set("name", $data->name);
			$this->db->set("device_id", $data->device_id);
			$this->db->set("hours", $data->hours);
			$this->db->set("minutes", $data->minutes);
			$this->db->set("hours_off", $data->hours_off);
			$this->db->set("minutes_off", $data->minutes_off);			
			$this->db->set("repeat_every", $data->repeat_every);
			$this->db->set("repeat_type", $data->repeat_type);
			$this->db->set("repeat_on", $data->repeat_on);
			$this->db->set("start_on", $data->start_on);
			$this->db->set("ends", $data->ends);
			$this->db->set("end_by_date", $data->end_by_date);
			$this->db->set("end_by_ocurrences", $data->end_by_ocurrences);
			$this->db->set("company_id", $company_id);
			$this->db->set("status", $data->status);
			$this->db->set("description", $data->description);
			$this->db->set("created_date", 'now()', false);
			$this->db->set("created_by", $user_id);
			$this->db->set("value", $data->value);
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $id, $company_id){
			$this->db->set("name", $data->name);
			$this->db->set("device_id", $data->device_id);
			$this->db->set("hours", $data->hours);
			$this->db->set("minutes", $data->minutes);
			$this->db->set("hours_off", $data->hours_off);
			$this->db->set("minutes_off", $data->minutes_off);
			$this->db->set("repeat_every", $data->repeat_every);
			$this->db->set("repeat_type", $data->repeat_type);
			$this->db->set("repeat_on", $data->repeat_on);			
			$this->db->set("start_on", $data->start_on);
			$this->db->set("ends", $data->ends);
			$this->db->set("end_by_date", $data->end_by_date);
			$this->db->set("end_by_ocurrences", $data->end_by_ocurrences);
			$this->db->set("status", $data->status);
			$this->db->set("description", $data->description);
			$this->db->set("value", $data->value);
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function get_post_data(){
			$data = new event_schedule();
			$data->name = $this->input->post('name');
			$data->device_id = $this->input->post('device_id');
			$data->hours = $this->input->post('hours');
			$data->minutes = $this->input->post('minutes');
			$data->hours_off = $this->input->post('hours_off');
			$data->minutes_off = $this->input->post('minutes_off');
			$data->repeat_every = $this->input->post('repeat_every');
			$data->repeat_type = $this->input->post('repeat_type');
			$data->value = $this->input->post('value');
			$repeat_on = $this->input->post('repeat_on');
			if ($repeat_on && is_array($repeat_on) && count($repeat_on)){
				$repeat_on = implode(',', $repeat_on);
			}
			else{
				$repeat_on = '';
			}
			$data->repeat_on = $repeat_on;
			$data->start_on = str_en_todate($this->input->post('start_on'));
			$data->ends = $this->input->post('ends');
			$data->end_by_date = str_en_todate($this->input->post('end_by_date'));
			$data->end_by_ocurrences = $this->input->post('end_by_ocurrences');
			$data->status = $this->input->post('status');
			$data->description = $this->input->post('description');
			return $data;
		}
		
		function clear_data(){
			$this->device_id = "";
			$this->hours = "";
			$this->minutes = "";
			$this->hours_off = "";
			$this->minutes_off = "";
			$this->repeat_every = "";
			$this->repeat_type = "";
			$this->repeat_on = "";
			$this->start_on = '';
			$this->ends = '';
			$this->end_by_date = "";
			$this->end_by_ocurrences = "";
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