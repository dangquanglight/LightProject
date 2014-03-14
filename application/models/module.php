<?php
	class Module extends CI_Model{
		private $table_name = "modules";

		function get_id($id){
			$this->db->where('module_id', $id);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}

		function get_all_modules($is_all = true){
			if (!$is_all){
				$this->db->where('module_id !=', '7');
				$this->db->where('module_id !=', '8');
			}
			$this->db->order_by('position,module_name');			
			$data = $this->db->get($this->table_name);			
			return $data;
		}				
	}
?>