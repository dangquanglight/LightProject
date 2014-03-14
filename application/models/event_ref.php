<?php
	class Event_ref extends CI_Model{
		private $table_name = "events_ref";
						
		function get_id($id, $company_id){
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
		
		function get_ids($ids, $company_id){
			$this->db->where_in("id", $ids);
			$this->db->where("company_id", $company_id);
			$query = $this->db->get($this->table_name);
			return $query;
		}		
		
		function get_all_enable($company_id){			
			$this->db->where("company_id", $company_id);
			$this->db->where("status", 1);
			$query = $this->db->get($this->table_name);
			return $query;
		}
		
		function get_events($company_id, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
				
			
			$sql_where = "a.company_id = " . $this->db->escape($company_id);
			if ($sql_where){
				$this->db->where($sql_where);
			}
			$num_rows = $this->db->count_all_results($this->table_name . " a");
			$this->db->select("a.*,DATE_FORMAT(a.created_date, '"  . DB_DATE_FORMAT . "') as created_date_format, d.device_name", false);			
			$this->db->join('devices d', 'd.id = a.device_id', 'left');
			$sql_where = "a.company_id = " . $this->db->escape($company_id);
			if ($sql_where){
				$this->db->where($sql_where);
			}	
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				else if ($sort_by == "name"){
					$sort_column = "a.name";
				}
				else if ($sort_by == "device-name"){
					$sort_column = "d.device_name";
				}
				else if ($sort_by == "event-type"){
					$sort_column = "a.event_type";
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
		
		function insert($data, $company_id, $user_id){
			$this->db->set("device_id", $data->device_id);
			$this->db->set("name", $data->name);
			$this->db->set("ref_id", $data->ref_id);
			$this->db->set("event_type", $data->event_type);
			$this->db->set("company_id", $company_id);
			$this->db->set("status", $data->status);
			$this->db->set("description", $data->description);
			$this->db->set("created_date", 'now()', false);
			$this->db->set("created_by", $user_id);
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $id, $company_id){			
			$this->db->set("device_id", $data->device_id);
			$this->db->set("name", $data->name);			
			$this->db->set("status", $data->status);			
			$this->db->set("description", $data->description);
			$this->db->where("id", $id);
			$this->db->where("company_id", $company_id);			
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		
		function active_in($status, $ids, $company_id)
		{
			$result = false;			
			$query = $this->get_ids($ids, $company_id);			
			$this->load->model('event');
			$this->load->model('event_schedule');
			
			foreach($query->result() as $row){
				//UPDATE REF EVENT
				if ($row->event_type == 1){
					//condition based						
					$this->event->active_in($status, array($row->ref_id), $company_id);
				}
				else{
					//condition based
					$this->event->active_in($status, array($row->ref_id), $company_id);
				}
			}
			
			$this->db->set("status", $status);
			$this->db->where("company_id", $company_id);
			$this->db->where_in("id", $ids);			
			$result = $this->db->update($this->table_name);
			
			
			return $result;
		}
		
		function active_all($device_id, $status, $company_id){
			$this->db->set("status", $status);
			$this->db->where("device_id", $device_id);
			$this->db->where("company_id", $company_id);			
			$result = $this->db->update($this->table_name);
			return $result;
		}
				
		function delete($id, $company_id)
		{
			$old_data = $this->get_id($id, $company_id);
			if ($old_data){
				//DELETE REF TABLE
				if ($old_data->event_type == 1){
					//condition based
					$this->event->delete($old_data->ref_id, $company_id);
				}
				else{
					//condition based					
					$this->event_schedule->delete($old_data->ref_id, $company_id);
				}
				//delete event ref
				$this->db->where("id", $id);
				$this->db->where("company_id", $company_id);
				$this->db->delete($this->table_name);
			}
		}
		
		function delete_in($ids, $company_id)
		{
			$this->load->model('event');
			$this->load->model('event_schedule');
			foreach($ids as $id){				
				$this->delete($id, $company_id);
			}
		}
		
		function get_post_data(){
			$data = new event_ref();
			$data->name = $this->input->post('name');
			$data->device_id = $this->input->post('device_id');
			$data->status = $this->input->post('status');
			$data->description = $this->input->post('description');
			return $data;
		}
	}
?>