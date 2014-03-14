<?php
	class Favorite_menu extends CI_Model{
		private $table_name = "favorites_menu";

		function get_id($id){
			$this->db->where('id', $id);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
		
		function get_by_favorite_id($id){
			$this->db->where('favorite_id', $id);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}

		function insert_or_update($id, $is_menu){
			$result = false;
			$old_data = $this->get_by_favorite_id($id);
			if ($old_data){
				$this->db->set('used', 'used + 1', false);
				$this->db->where('id', $old_data->id);
				$result = $this->db->update($this->table_name);
			}
			else{
				$this->db->set('favorite_id', $id);
				$this->db->set('is_menu', $is_menu);
				$this->db->set('used', 1);
				$result = $this->db->insert($this->table_name);
			}
			
			return $result;
		}
		
		function get_favories_menu($limit){
			$this->db->order_by('used DESC');
			$query = $this->db->get($this->table_name, $limit);
			return $query;
		}
	}
?>