<?php
	class Layout extends CI_Model{
		private $table_name = "layouts";		
				
		function get_id($zone_id, $device_id){			
			$this->db->where("zone_id", $zone_id);
			$this->db->where("device_id", $device_id);
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
		function get_by_zone_id($zone_id){
			$this->db->select('a.*, d.device_name, d.sub_type_id,st.type_id');
			$this->db->join('devices d', 'd.id = a.device_id', 'left');
			$this->db->join('sub_types st' , 'st.id = d.sub_type_id', 'left');
			$this->db->where("a.zone_id", $zone_id);			
			$query = $this->db->get($this->table_name . ' a');
			return $query;
		}
		
		function insert_or_update($zone_id, $device_id, $top, $left, $user_id){
			$layout = $this->get_id($zone_id, $device_id);
			
			$this->db->set("top", $top);			
			$this->db->set("left", $left);
			
			if ($layout){
				$this->db->where("zone_id", $zone_id);
				$this->db->where("device_id", $device_id);
				$result = $this->db->update($this->table_name);
			}
			else{
				$this->db->set("created_by", $user_id);
				$this->db->set("created_date", 'now()', false);
				$this->db->set("zone_id", $zone_id);
				$this->db->set("device_id", $device_id);
				$result = $this->db->insert($this->table_name);
			}
			return $result;
		}
		
		function update_color($zone_id, $color){
			$this->db->set("color", $color);
			$this->db->where("zone_id", $zone_id);
			$result = $this->db->update($this->table_name);
		}
	}
?>