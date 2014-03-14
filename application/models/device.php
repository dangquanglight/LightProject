<?php
	class Device extends CI_Model{
		private $table_name = "devices";
		public $id = "";	
		public $device_name = "";
		public $description = "";
		public $sub_type_id = "";		
		public $created_by = "";
		public $created_date = "";
		public $status = 1;
		public $zone_id = "";
		public $site_id = "";
		public $unit_id = '';
		
		function get_id($id, $company_id){
			$this->db->where("a.id", $id);
			$this->db->where("a.company_id", $company_id);
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, z.zone_name, s.site_name, u.unit_name,st.type_id", false);
			$this->db->join('zones z' , 'z.id = a.zone_id', 'left');
			$this->db->join('sites s' , 's.id = z.site_id', 'left');
			$this->db->join('units u' , 'u.id = a.unit_id', 'left');
			$this->db->join('sub_types st' , 'st.id = a.sub_type_id', 'left');
			$query = $this->db->get($this->table_name . ' a');
			return $query->row();
		}
		
		function get_by_sub_types($sub_type_id){
			$this->db->where('sub_type_id', $sub_type_id);
			$query = $this->db->get($this->table_name);
			return $query;
		}
		
		function get_by_device_name($device_name, $company_id){
			$this->db->where("device_name", $device_name);
			$this->db->where("company_id", $company_id);
			$this->db->select("*,DATE_FORMAT(created_date,'" . DB_DATE_FORMAT . "') as created_date_format", false);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
		//USING FOR ZONE LAYOUT
		function get_by_zone($zone_id, $company_id){
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, z.zone_name, s.site_name, st.type_id", false);
			$this->db->where("a.status", 1);
			$this->db->where("a.zone_id", $zone_id);
			$this->db->where("a.company_id", $company_id);			
			$this->db->join('zones z' , 'z.id = a.zone_id', false);
			$this->db->join('sites s' , 's.id = z.site_id', false);
			$this->db->join('sub_types st' , 'st.id = a.sub_type_id', 'left');
			$query = $this->db->get($this->table_name . ' a');
			return $query;
		}
		//USING FOR ZONE LAYOUT
		function get_by_zone_id($company_id, $zone_id){
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, z.zone_name, s.site_name, st.type_id", false);
			$this->db->where("a.status", 1);
			$this->db->where("a.zone_id", $zone_id);
			$this->db->where("a.company_id", $company_id);			
			$this->db->join('zones z' , 'z.id = a.zone_id', false);
			$this->db->join('sites s' , 's.id = z.site_id', false);
			$this->db->join('sub_types st' , 'st.id = a.sub_type_id', 'left');
			$query = $this->db->get($this->table_name . ' a');
			return $query;
		}
		
		function update_position($device_id, $company_id, $top, $left, $user_id){
			$device = $this->get_id($device_id, $company_id);
			$result = false;			
			if ($device){
				$this->db->set("top", $top);			
				$this->db->set("left", $left);
				$this->db->where("id", $device_id);
				$this->db->where("company_id", $company_id);
				$result = $this->db->update($this->table_name);
			}
			return $result;
		}
		
		function get_by_site($site_id, $company_id){
			$this->db->where("s.site_id", $site_id);
			$this->db->where("a.company_id", $company_id);
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, z.zone_name, s.site_name", false);
			$this->db->join('zones z' , 'z.id = a.zone_id', false);
			$this->db->join('sites s' , 's.id = z.site_id', false);
			$query = $this->db->get($this->table_name . ' a');
			return $query;
		}
		
		function get_by_company_analyze($company_id, $sort_by, $is_down){
			$this->db->where("a.company_id", $company_id);						
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format,z.zone_name,s.sub_type_name,s.type_id,lm.value as last_value, u.unit_name", false);
			$this->db->join('last_measurements lm', 'lm.device_id = a.id', 'left');
			$this->db->join('zones z', 'z.id = a.zone_id', 'left');
			$this->db->join('sub_types s', 's.id = a.sub_type_id', 'left');
			$this->db->join('units u', 'u.id = a.unit_id', 'left');
			if ($sort_by){
				$sort_column = '';
				if ($sort_by == 'id'){
					$sort_column = 'a.id';
				}
				else if ($sort_by == 'name'){
					$sort_column = 'a.device_name';
				}
				else if ($sort_by == 'type'){
					$sort_column = 's.sub_type_name';
				}
				else if ($sort_by == 'zone'){
					$sort_column = 'z.zone_name';
				}
				
				if ($sort_column){
					$sort_column .= ($is_down) ? ' ASC' : ' DESC';
					$this->db->order_by($sort_column);
				}
			}
			
			$query = $this->db->get($this->table_name . ' a');
			//echo $this->db->last_query();
			return $query;
		}
		
		function get_next_device($id, $company_id, &$previous_device, &$next_device){
			$this->db->select('a.*,st.type_id');
			$this->db->join('sub_types st', 'st.id = a.sub_type_id');
			$this->db->where("a.id >", $id);
			$this->db->where("a.company_id", $company_id);			
			$this->db->order_by("a.id", 'ASC');
			$this->db->limit(1);			
			$query = $this->db->get($this->table_name . ' a');
			$next_device = $query->row();			
			
			$this->db->select('a.*,st.type_id');
			$this->db->join('sub_types st', 'st.id = a.sub_type_id');
			$this->db->where("a.id <", $id);
			$this->db->where("a.company_id", $company_id);			
			$this->db->order_by("a.id", 'DESC');
			$this->db->limit(1);			
			$query = $this->db->get($this->table_name . ' a');
			$previous_device = $query->row();			
		}
				
		function insert($data, $company_id, $user_id){			
			$this->db->set("device_name", $data->device_name);
			$this->db->set("description", $data->description);
			$this->db->set("zone_id", $data->zone_id);			
			$this->db->set("sub_type_id", $data->sub_type_id);
			$this->db->set("unit_id", $data->unit_id);
			$this->db->set("company_id", $company_id);
			$this->db->set("created_by", $user_id);
			$this->db->set("created_date", "now()", false);
			$this->db->set("status", $data->status);
			$result = $this->db->insert($this->table_name);		
			return $result;
		}
		
		function update($data, $id, $company_id){
			$this->db->set("device_name", $data->device_name);
			$this->db->set("description", $data->description);
			$this->db->set("zone_id", $data->zone_id);			
			$this->db->set("sub_type_id", $data->sub_type_id);
			$this->db->set("unit_id", $data->unit_id);
			$this->db->set("status", $data->status);
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function update_unit_id_by_sub_type_id($sub_type_id, $unit_id){
			$this->db->set('unit_id', $unit_id);
			$this->db->where('sub_type_id', $sub_type_id);
			$this->db->update($this->table_name);
		}
		
		function get_devices($company_id, $site_id, $zone_id, $keywords, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;
			$sql_where = "a.company_id = " . $this->db->escape($company_id);
			if ($site_id){
				$sql_where .= ' AND site_id = ' . $this->db->escape($site_id);
			}
			
			if ($zone_id){
				$sql_where .= ' AND zone_id = ' . $this->db->escape($zone_id);
			}
			
			if ($keywords){
				$sql_where .= " AND (";
				$sql_where .= "device_name LIKE '%" . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= " OR z.zone_name LIKE '%" . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= " OR s.site_name LIKE '%" . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= ")";
			}
			if ($sql_where){
				$this->db->where($sql_where);
			}
			$this->db->join('sub_types st', 'st.id = a.sub_type_id', 'left');			
			$this->db->join('zones z', 'z.id = a.zone_id', 'left');
			$this->db->join('sites s', 's.id = z.site_id', 'left');
			$num_rows = $this->db->count_all_results($this->table_name . ' a');			
			if ($sql_where){
				$this->db->where($sql_where);
			}
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, st.sub_type_name, s.site_name, z.site_id, z.zone_name, e.device_id as has_event", false);
			$this->db->join('sub_types st', 'st.id = a.sub_type_id', 'left');			
			$this->db->join('zones z', 'z.id = a.zone_id', 'left');
			$this->db->join('sites s', 's.id = z.site_id', 'left');
			$this->db->join('events e', 'e.device_id = a.id', 'left');
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				else if ($sort_by == "device-name"){
					$sort_column = "a.device_name";
				}
				else if ($sort_by == "zone_name"){
					$sort_column = "z.zone_name";
				}
				else if ($sort_by == "site_name"){
					$sort_column = "m.site_name";
				}
				else if ($sort_by == "type"){
					$sort_column = "st.sub_type_name";
				}				
				
				if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;				
					$this->db->order_by($sort_column);
				}				
			}
			else{
				$this->db->order_by('a.id DESC');
			}
			
			$data = $this->db->get($this->table_name . " a", $page_size, $start);			
			return $data; 		
		}
		
		function get_all_devices_4_rand_import(){		
			$query = $this->db->get($this->table_name);
			return $query;
		}
		
		function get_measurements($company_id){		
			$this->db->select('a.*,z.zone_name,s.site_name');
			$this->db->join('sub_types st', 'st.id = a.sub_type_id', 'left');
			$this->db->join('zones z' , 'z.id = a.zone_id', 'left');
			$this->db->join('sites s' , 's.id = z.site_id', 'left');
			$this->db->where('a.company_id', $company_id);			
			$this->db->where('st.type_id', 3);			
			$query = $this->db->get($this->table_name . ' a');			
			return $query;
		}
		
		function get_measurements_and_status($company_id){		
			$this->db->select('a.*,z.zone_name,s.site_name');
			$this->db->join('sub_types st', 'st.id = a.sub_type_id', 'left');
			$this->db->join('zones z' , 'z.id = a.zone_id', 'left');
			$this->db->join('sites s' , 's.id = z.site_id', 'left');
			$this->db->where('a.company_id', $company_id);			
			$this->db->where('(st.type_id = 2 OR st.type_id = 3)');
			$query = $this->db->get($this->table_name . ' a');				
			return $query;
		}
				
		function get_all_devices_by_type_id_and_zone($type_id, $zone_id, $company_id){		
			$this->db->select('a.*,z.zone_name,s.site_name');
			$this->db->join('sub_types st', 'st.id = a.sub_type_id', 'left');
			$this->db->join('zones z' , 'z.id = a.zone_id', 'left');
			$this->db->join('sites s' , 's.id = z.site_id', 'left');
			$this->db->where('a.company_id', $company_id);
			$this->db->where('a.zone_id', $zone_id);
			$this->db->where('st.type_id', $type_id);			
			$query = $this->db->get($this->table_name . ' a');			
			return $query;
		}
				
		function get_post_data(){
			$data = new device();
			$data->device_name = $this->input->post('device_name');
			$data->description = $this->input->post('description');			
			$data->zone_id = $this->input->post('zone_id');
			$data->sub_type_id = $this->input->post('sub_type_id');
			$data->unit_id = $this->input->post('unit_id');
			$data->status = $this->input->post('status');
			return $data;
		}
		
		function clear_data(){
			$this->unit = "";
			$this->device_name = "";
			$this->description = "";			
		}
		
		function delete($id, $company_id)
		{
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);			
			$this->db->delete($this->table_name);			
		}
		
		function delete_in($ids, $company_id)
		{
			foreach($ids as $id){				
				$this->delete($id, $company_id);
			}
		}
		
		function active_in($status, $ids, $company_id)
		{
			$this->db->set("status", $status);
			$this->db->where("company_id", $company_id);
			$this->db->where_in("id", $ids);			
			$result = $this->db->update($this->table_name);
			return $result;
		}		
	}
?>