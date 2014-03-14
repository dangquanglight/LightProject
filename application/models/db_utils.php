<?php
	class Db_utils extends CI_Model{
		function get_datetime(){
			$query = $this->db->query("SELECT now() as `now`, curdate() as `date`, YEAR(curdate()) as `year`, MONTH(curdate()) as `month`, DAY(curdate()) as `day`, HOUR(now()) as `hour`, MINUTE(now()) as `minute`, SECOND(now()) as `second`,DATE_FORMAT(curdate(), '%w') as day_of_week", false);
			return $query->row();
		}
	}
?>