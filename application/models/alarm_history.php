<?php
	class Alarm_history extends CI_Model{
		public $device_id = "";
		public $event_id = "";
		public $alarm_date = "";
		public $formula = "";
		public $expression = "";
		public $is_on = 1;
		private $table_name = "alarms_history";
		
		function get_id($id, $company_id){			
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$query = $this->db->get($this->table_name);
			$data = $query->row();
			return $data;
		}
		
		function count_alarms_by_site_id($site_id){
			$this->db->join('devices d', 'd.id = a.device_id');
			$this->db->join('zones z', 'z.id = d.zone_id');
			$this->db->where('z.site_id', $site_id);
			$num_rows = $this->db->count_all_results($this->table_name . ' a');
			return $num_rows;
		}
		
		function get_alarms_history($keywords, $company_id, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;
			
			if ($keywords != "")
			{				
				$this->db->like('alarm_date', $keywords);
			}			
			$this->db->where('company_id', $company_id);
			$num_rows = $this->db->count_all_results($this->table_name);
			$this->db->where('a.company_id', $company_id);
			if ($keywords != "")
			{				
				$this->db->like('alarm_date', $keywords);
			}
			$this->db->select("a.*,DATE_FORMAT(a.alarm_date, '" . DB_DATE_TIME_FORMAT . "') as alarm_date_format,d.device_name,d.zone_id,z.zone_name,z.site_id,s.site_name, e.device_ids,e.operators,e.values,e.combines", false);			
			$this->db->join('events e', 'e.id = a.event_id', 'left');
			$this->db->join('devices d', 'd.id = a.device_id', 'left');
			$this->db->join('zones z', 'z.id = d.zone_id', 'left');
			$this->db->join('sites s', 's.id = z.site_id', 'left');
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				else if ($sort_by == "alarm-date"){
					$sort_column = "a.alarm-date";
				}
				else if ($sort_by == "site"){
					$sort_column = "s.site_name";
				}
				else if ($sort_by == "zone"){
					$sort_column = "z.zone_name";
				}
				else if ($sort_by == "device-name"){
					$sort_column = "d.device_name";
				}
				
				if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;
					$this->db->order_by($sort_column);
				}
			}
			else{
				$this->db->order_by("a.id DESC");
			}
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function get_all_device_history_hoursheet($device_id, $company_id){			
			$sql = "SELECT DISTINCT DATE_FORMAT(a.alarm_date, '%w') as day_of_week, 
						(SELECT GROUP_CONCAT(DISTINCT DATE_FORMAT(alarm_date, '%H') ORDER BY HOUR(alarm_date)) 
							FROM alarms_history 
							WHERE `device_id` = '$device_id' AND DATE_FORMAT(a.alarm_date, '%w') = DATE_FORMAT(alarm_date, '%w')
						) as hours
					FROM alarms_history a
					WHERE a.`device_id` = '$device_id'
					ORDER BY DATE_FORMAT(a.alarm_date, '%w')";
			
			$data = $this->db->query($sql);
			//echo $this->db->last_query();
			return $data;
		}
		
		function insert($alarm, $company_id){
			$this->db->set("device_id", $alarm->device_id);
			$this->db->set("event_id", $alarm->event_id);
			$this->db->set("event_name", $alarm->name);
			//$this->db->set("alarm_date", $alarm->alarm_date);
			$this->db->set("formula", $alarm->formula);
			$this->db->set("expression", $alarm->expression);
			$this->db->set("alarm_date", "now()", false);		
			$this->db->set("company_id", $company_id);
			$this->db->set('is_on', $alarm->is_on);
			$result = $this->db->insert($this->table_name);
			return $result;
		}
		
		function insert_by_event_schedule($event){	
			$this->db->set("device_id", $event->device_id);
			$this->db->set("event_id", $event->id);
			$this->db->set("event_name", $event->name);
			$this->db->set("is_schedule", 1);
			$this->db->set("formula", $this->lang->line('event-schedule'));
			$this->db->set("expression", $this->lang->line('event-schedule'));
			$this->db->set("alarm_date", "now()", false);
			$this->db->set("company_id", $event->company_id);			
			$this->db->set('is_on', $event->is_on);
			$result = $this->db->insert($this->table_name);
			return $result;
		}
		
		function update($alarm, $id, $company_id){
			$this->db->set("device_id", $alarm->device_id);
			$this->db->set("event_id", $alarm->event_id);
			$this->db->set("alarm_date", $alarm->alarm_date);
			$this->db->set("formula", $alarm->formula);
			$this->db->set("expression", $alarm->expression);
			$this->db->set("alarm_date", "now()", false);
			$this->db->set("company_id", $company_id);
			$this->db->where("id", $id);
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