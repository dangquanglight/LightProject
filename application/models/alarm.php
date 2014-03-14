<?php
	class Alarm extends CI_Model{
		public $device_id = "";
		public $event_id = "";
		public $alarm_date = "";
		public $formula = "";
		public $expression = "";
		private $table_name = "alarms";
		
		function get_id($id, $company_id){			
			$this->db->where("device_id", $id);
			$query = $this->db->get($this->table_name);
			$data = $query->row();
			return $data;
		}
				
		function get_alarms($keywords, $company_id, $page, $page_size, $sort_by, $ascending, &$num_rows){
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
			$this->db->select("a.*,DATE_FORMAT(a.alarm_date, '" . DB_DATE_TIME_FORMAT . "') as created_date_format", false);			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				else if ($sort_by == "alarm-date"){
					$sort_column = "a.alarm-date";
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
		
		function active($alarm, $is_active){
			$old_alarm = $this->get_id($alarm->device_id, $alarm->company_id);
			$result = false;
			if ($is_active){
				if (!$old_alarm){
					$this->db->set("device_id", $alarm->device_id);
					$this->db->set("event_id", $alarm->event_id);
					$this->db->set("event_name", $alarm->name);
					$this->db->set("alarm_date", $alarm->alarm_date);
					$this->db->set("formula", $alarm->formula);
					$this->db->set("expression", $alarm->expression);
					//$this->db->set("alarm_date", "now()", false);
					$this->db->set("company_id", $alarm->company_id);				
					$result = $this->db->insert($this->table_name);
				}
			}
			else{
				$result = $this->delete($alarm->device_id, $alarm->company_id);
			}
			return $result;
		}
		
		function active_by_event_schedule($event, $is_active){
			$old_alarm = $this->get_id($event->device_id, $event->company_id);
			if ($is_active && !$old_alarm){
				$this->db->set("device_id", $event->device_id);
				$this->db->set("event_id", $event->id);
				$this->db->set("event_name", $event->name);
				$this->db->set("is_schedule", 1);
				$this->db->set("formula", $this->lang->line('event-schedule'));
				$this->db->set("expression", $this->lang->line('event-schedule'));
				$this->db->set("alarm_date", "now()", false);
				$this->db->set("company_id", $event->company_id);				
				$result = $this->db->insert($this->table_name);
			}
			else{
				$result = $this->delete($event->device_id, $event->company_id);
			}
			return $result;
		}
		
		function delete($id, $company_id)
		{
			$this->db->where("device_id", $id);	
			$this->db->where('company_id', $company_id);
			$this->db->delete($this->table_name);			
		}

		function delete_in($ids, $company_id)
		{
			foreach($ids as $id){				
				$this->delete($id, $company_id);
			}
		}			
		
		function get_alarms_info($company_id){
			$this->db->select('a.device_id, d.zone_id, z.site_id', false);
			$this->db->join('devices d', 'a.device_id = d.id');
			$this->db->join('zones z', 'z.id = d.zone_id');
			$this->db->where('d.company_id', $company_id);
			$this->db->where('d.status', 1);
			$this->db->where('DATE_ADD(z.alarm_disabled_date, INTERVAL z.minutes_alarm_disabled MINUTE) <', 'now()', false);
			$query = $this->db->get('alarms a');
			$data = new stdClass();
			$site_ids = array();
			$zone_ids = array();
			$device_ids = array();
			foreach($query->result() as $row){
				$device_ids[] = $row->device_id;
				if (!in_array($row->site_id, $site_ids)){
					$site_ids[] = $row->site_id;
				}
				if (!in_array($row->zone_id, $zone_ids)){
					$zone_ids[] = $row->zone_id;
				}
			}
			$data->site_ids = $site_ids;
			$data->zone_ids = $zone_ids;
			$data->device_ids = $device_ids;
			return $data;
		}
	}
?>