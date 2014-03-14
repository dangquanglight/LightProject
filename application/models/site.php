<?php
	class Site extends CI_Model{
		private $table_name = "sites";
		public $site_name = "";
		public $square = "";
		public $description = "";
		public $company_id = 0;
		public $status = 1;		
				
		function get_id($id){			
			$this->db->where("id", $id);			
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
		function get_sites($keywords, $company_id, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;			
			
			if ($keywords != "")
			{				
				$this->db->like("site_name", $keywords);				
				$this->db->or_like("description", $keywords);
			}
			$this->db->where('company_id', $company_id);
			$num_rows = $this->db->count_all_results($this->table_name);
			$this->db->select("a.*, TRIM(CONCAT(u.first_name, ' ', u.last_name)) as full_name, DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, (SELECT COUNT(*) FROM zones WHERE site_id = a.id) as total_zones", false);
			$this->db->join('users u', 'u.id = a.created_by', 'left');
			if ($keywords != "")
			{				
				$this->db->like("site_name", $keywords);				
				$this->db->or_like("description", $keywords);
			}			
			$this->db->where('a.company_id', $company_id);
			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "site-name"){
					$sort_column = "a.site_name";
				}
				else if ($sort_by == "created-by"){
					$sort_column = "u.first_name";
					if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
						$sort_column .= " " . $ascending;				
					}
					$sort_column .= ",u.last_name";
				}
				else if ($sort_by == "created-date"){
					$sort_column = "a.created_date";
				}
				else if ($sort_by == "created-by"){
					$sort_column = "a.created-by";
				}
				else if ($sort_by == "status"){
					$sort_column = "a.status";
				}
				if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;				
					$this->db->order_by($sort_column);
				}
			}
			else{
				$this->db->order_by('a.site_name');
			}
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function get_consumtion($company_id, $date_type){
			//BUILD SAFE QUERY
			$company_id = $this->db->escape($company_id);
			
			
			$sql = "SELECT z.site_id, s.site_name, s.square, SUM(value - %s) as consumption
					FROM sites s LEFT JOIN zones z ON s.id = z.site_id 
						LEFT JOIN devices d ON d.zone_id = z.id
						LEFT JOIN last_measurements m ON m.device_id = d.id					
					WHERE s.status = 1 AND s.company_id = $company_id 
					GROUP BY z.site_id, s.site_name, s.square";
					
			//YEAR
			if ($date_type == 3){
				$sql = sprintf($sql, 'first_value_year');
			}
			else if ($date_type == 2){
				$sql = sprintf($sql, 'first_value_month');
			}
			else{
				$sql = sprintf($sql, 'first_value_week');
			}
			
			/*
			$sql = "SELECT *, 0 as consumption
					FROM sites s
					WHERE s.company_id = $company_id";
			*/	
			//echo date('H:i:s');
			//echo $sql;
			$query = $this->db->query($sql);
			//echo date('H:i:s');
			$result = array();
			$this->load->model('alarm_history');
			foreach($query->result() as $row){
				$item = new stdClass();
				$item->site_name = $row->site_name;
				$item->consumption = $row->consumption ? number_format($row->consumption) : 0;
				$item->alarms = $this->alarm_history->count_alarms_by_site_id($row->site_id);
				$item->specific_energy = '0';
				$item->saved_energy = '0';
				
				if ($row->consumption && $row->square){
					$item->specific_energy = number_format($row->consumption / $row->square, 2);
				}
				$result[] = $item;	
			}
			//echo date('H:i:s');
			//die();
			return $result;
		}
		
		function calculate_site_info(){
			
		}
		
		function insert($data, $user_id){			
			$this->db->set("site_name", $data->site_name);
			$this->db->set("description", $data->description);
			$this->db->set("square", $data->square);
			$this->db->set("created_by", $user_id);
			$this->db->set("created_date", "now()", false);
			$this->db->set("company_id", $data->company_id);
			$this->db->set("status", $data->status);
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $company_id, $id){			
			$this->db->set("site_name", $data->site_name);
			$this->db->set("description", $data->description);
			$this->db->set("square", $data->square);
			$this->db->set("status", $data->status);
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function get_post_data(){
			$data = new site();
			$data->site_name = $this->input->post('site_name');
			$data->description = $this->input->post('description');
			$data->square = $this->input->post('square');
			$data->status = $this->input->post('status');
			return $data;
		}
		
		function clear_data(){
			$this->site_name = "";
			$this->description = "";
			$this->square = "";
		}
				
		function delete($company_id, $id)
		{
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$this->db->delete($this->table_name);			
		}
		
		function delete_in($company_id, $ids)
		{
			foreach($ids as $id){				
				$this->delete($company_id, $id);
			}
		}
				
		function active_in($company_id, $status, $ids)
		{
			$this->db->set("status", $status);
			$this->db->where_in("id", $ids);			
			$this->db->where("company_id", $company_id);
			$result = $this->db->update($this->table_name);
			return $result;
		}

		function get_all_sites($company_id){
			$this->db->order_by('site_name');
			$this->db->where('company_id', $company_id);
			$data = $this->db->get($this->table_name);			
			return $data;
		}		
	}
?>