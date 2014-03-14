<?php
	class Devices_formula_info extends CI_Model{
		private $table_name = "devices_formula_info";
		public $unit_name = "";
		public $description = "";				
				
		function get_by_device_id($id){			
			$this->db->where("device_id", $id);			
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
	}
?>