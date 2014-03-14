<?php
	class Model_utils extends CI_Model{
		private $table_name = "modules";		

		function get_current_date(){
			$this->db->select("DATE_FORMAT(now(), '" . DB_DATE_TIME_FORMAT . "') as now, DAY(curdate()) as day, MONTH(curdate()) as month, YEAR(curdate()) as year, HOUR(now()) as hour, MINUTE(now()) as minute, SECOND(now()) as second, UNIX_TIMESTAMP(now()) as timestamp", false);			
			$query = $this->db->get();
			return $query->row();
		}		
	}
?>