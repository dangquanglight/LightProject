<?php
	class Zone extends CI_Model{
		private $table_name = "zones";
		public $zone_name = "";
		public $description = "";
		public $company_id = 0;
		public $status = 1;		
				
		function get_id($id){			
			$this->db->where("id", $id);			
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
		function get_id_by_company($id, $company_id){
			$this->db->select('a.*, (SELECT COUNT(*) FROM devices where zone_id = a.id) as devices, TIMESTAMPDIFF(MINUTE, now(), DATE_ADD(alarm_disabled_date, INTERVAL minutes_alarm_disabled MINUTE)) as minutes_disabled_remaining', false);
			$this->db->where("a.id", $id);
			$this->db->where("a.company_id", $company_id);
			$query = $this->db->get($this->table_name . ' a');
			return $query->row();
		}
		
		function get_next_zone($id, $site_id, $company_id, &$previous_zone, &$next_zone){
			$this->db->where("id >", $id);
			$this->db->where("site_id", $site_id);
			$this->db->where("company_id", $company_id);			
			$this->db->order_by("id", 'ASC');
			$this->db->limit(1);			
			$query = $this->db->get($this->table_name);
			$next_zone = $query->row();			
			
			$this->db->where("id <", $id);
			$this->db->where("site_id", $site_id);
			$this->db->where("company_id", $company_id);			
			$this->db->order_by("id", 'DESC');
			$this->db->limit(1);			
			$query = $this->db->get($this->table_name);
			$previous_zone = $query->row();			
		}
		
		function get_zones($keywords, $company_id, $site_id, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;			
			$sql_where = 'a.company_id = ' . $this->db->escape($company_id);
			if ($site_id){
				$sql_where .= ' AND a.site_id = ' . $this->db->escape($site_id);
			}
			if ($keywords != "")
			{				
				$sql_where .= " AND (a.site_name LIKE '%" . $this->db->escape_like_str(keywords) . "%'";
				$sql_where .= " OR a.site_description LIKE '%" . $this->db->escape_like_str(keywords) . "%')";
			}
			//SET WHERE CLAUSE
			$this->db->where($sql_where);
			$num_rows = $this->db->count_all_results($this->table_name . ' a');
			$this->db->select("a.*, TRIM(CONCAT(u.first_name, ' ', u.last_name)) as full_name, DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, s.site_name", false);
			$this->db->join('sites s', 's.id = a.site_id', 'left');
			$this->db->join('users u', 'u.id = a.created_by', 'left');
			//SET WHERE CLAUSE
			$this->db->where($sql_where);
			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "zone-name"){
					$sort_column = "a.zone_name";
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
				$this->db->order_by('a.zone_name');
			}
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function insert($data, $user_id){			
			$this->db->set("zone_name", $data->zone_name);
			$this->db->set("description", $data->description);
			$this->db->set("created_by", $user_id);
			$this->db->set("created_date", "now()", false);
			$this->db->set("company_id", $data->company_id);
			$this->db->set("site_id", $data->site_id);
			$this->db->set("status", $data->status);
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $company_id, $id){
			$this->db->set("site_id", $data->site_id);
			$this->db->set("zone_name", $data->zone_name);
			$this->db->set("description", $data->description);
			$this->db->set("status", $data->status);
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function update_has_layout($id, $company_id){
			$this->db->set("has_layout", 1);
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function update_disable_alarm($id, $company_id, $minutes){
			$this->db->set("minutes_alarm_disabled", $minutes);
			$this->db->set("alarm_disabled_date", 'now()', false);
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function update_alarm($id, $company_id, $enabled){
			$this->db->set("alarm_enabled", $enabled);			
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
				
		function get_post_data(){
			$data = new zone();
			$data->zone_name = $this->input->post('zone_name');
			$data->description = $this->input->post('description');
			$data->status = $this->input->post('status');
			$data->site_id = $this->input->post('site_id');
			return $data;
		}
		
		function clear_data(){
			$this->zone_name = "";
			$this->description = "";
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

		function get_all_zones($company_id, $site_id = null){
			$this->db->select('*,(SELECT COUNT(*) FROM devices where zone_id = a.id) as devices', false);
			$this->db->order_by('a.site_id, zone_name');
			$this->db->where('a.company_id', $company_id);
			if ($site_id){
				$this->db->where('a.site_id', $site_id);
			}
			$data = $this->db->get($this->table_name . ' a');			
			return $data;
		}	

		function get_all_zones_by_device_type($company_id, $type_id){
			$type_id = $this->db->escape($type_id);
			$this->db->select("*,(SELECT COUNT(*) FROM devices d INNER JOIN sub_types st ON st.id = d.sub_type_id WHERE d.zone_id = a.id AND st.type_id = $type_id) as devices", false);
			$this->db->order_by('a.site_id, zone_name');
			$this->db->where('a.company_id', $company_id);			
			$data = $this->db->get($this->table_name . ' a');				
			return $data;
		}

		function get_all_zones_status($company_id, $site_id = null){
			$this->db->select('*,(SELECT COUNT(*) FROM devices WHERE zone_id = a.id AND sub_type_id = 2) as devices', false);
			$this->db->order_by('a.site_id, zone_name');
			$this->db->where('a.company_id', $company_id);
			if ($site_id){
				$this->db->where('a.site_id', $site_id);
			}
			$data = $this->db->get($this->table_name . ' a');			
			return $data;
		}		
		
		function get_all_ar_zones($company_id, $site_id = null){				
			$query = $this->get_all_zones($company_id, $site_id);
			$data = array();
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}		
	}
