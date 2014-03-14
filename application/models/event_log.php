<?php
	class Event_log extends CI_Model{
		private $table_name = 'event_logs';
		
		function get_device_logs($device_id, $company_id, $page, $page_size, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;
			$this->db->group_by('DATE(a.log_date)');
			$this->db->where('a.device_id', $device_id);
			$num_rows = $this->db->count_all_results($this->table_name . ' a');
			
			$this->db->select("DATE_FORMAT(a.log_date, '" . DB_DATE_FORMAT . "') AS date, GROUP_CONCAT(DATE_FORMAT(a.log_date,'%H')) AS hours,GROUP_CONCAT(a.value) AS `values`,GROUP_CONCAT(DATE_FORMAT(a.log_date,'%i')) AS minutes, GROUP_CONCAT(id) AS ids", false);
			$this->db->group_by('DATE(a.log_date)');
			$this->db->where('device_id', $device_id);
			$this->db->where('company_id', $company_id);
			$this->db->order_by('a.log_date DESC');
			$data = $this->db->get($this->table_name . " a", $page_size, $start);			
			return $data; 		
		}
		
		function get_all_device_log_hoursheet($device_id, $company_id){			
			$sql = "SELECT DISTINCT DATE_FORMAT(a.log_date, '%w') as day_of_week, 
						(SELECT GROUP_CONCAT(DISTINCT DATE_FORMAT(log_date, '%H') ORDER BY HOUR(log_date)) 
							FROM event_logs 
							WHERE `device_id` = '$device_id' AND DATE_FORMAT(a.log_date, '%w') = DATE_FORMAT(log_date, '%w')
						) as hours
					FROM event_logs a
					WHERE a.`device_id` = '$device_id'
					ORDER BY DATE_FORMAT(a.log_date, '%w')";

			$data = $this->db->query($sql);
			return $data;
		}
		
		function delete_in($ids)
		{
			foreach($ids as $id){				
				$this->delete($id);
			}
		}
		
		function delete($id)
		{
			$this->db->where("device_id", $id);		
			$this->db->delete($this->table_name);			
		}
	}
?>