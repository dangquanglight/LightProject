<?php
	class Email_schedule extends CI_Model{
		private $table_name = "email_schedules";
		public $title = '';
		public $time = "";
		public $display_type = "";
		public $months_range = "";
		public $emails = "";
		public $device_id = "";
		public $auto_scale = 1;
		public $ymax = 0;
		public $ymin = 0;
		public $status = 1;		
				
		function get_id($id){			
			$this->db->where("id", $id);			
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
		
		function get_email_schedules($keywords, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;			
			
			if ($keywords != "")
			{				
				$this->db->like("time", $keywords);				
				$this->db->or_like("emails", $keywords);
				$this->db->or_like("d.name", $keywords);
			}
			$this->db->join('devices d', 'd.id = a.device_id', 'left');
			$num_rows = $this->db->count_all_results($this->table_name . ' a');
			$this->db->select("a.*, TRIM(CONCAT(u.first_name, ' ', u.last_name)) as full_name, DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, d.name as device_name", false);
			$this->db->join('users u', 'u.id = a.created_by', 'left');
			$this->db->join('devices d', 'd.id = a.device_id', 'left');
			if ($keywords != "")
			{				
				$this->db->like("time", $keywords);				
				$this->db->or_like("emails", $keywords);
				$this->db->or_like("d.name", $keywords);
			}			
			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "time"){
					$sort_column = "a.time";
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
				else if ($sort_by == "device-name"){
					$sort_column = "d.device_name";
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
				$this->db->order_by('a.id DESC');
			}
			$data = $this->db->get($this->table_name . " a", $page_size, $start);
			return $data; 		
		}
		
		function insert($data, $user_id){			
			$this->db->set("title", $data->title);
			$this->db->set("time", $data->time);
			$this->db->set("months_range", $data->months_range);
			$this->db->set("display_type", $data->display_type);
			$this->db->set("device_id", $data->device_id);
			$this->db->set("auto_scale", $data->auto_scale);
			$this->db->set("ymin", $data->ymin);
			$this->db->set("ymax", $data->ymax);
			$this->db->set("emails", $data->emails);
			$this->db->set("created_by", $user_id);
			$this->db->set("created_date", "now()", false);
			$this->db->set("status", $data->status);
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $id){			
			$this->db->set("title", $data->title);
			$this->db->set("time", $data->time);
			$this->db->set("months_range", $data->months_range);
			$this->db->set("display_type", $data->display_type);
			$this->db->set("device_id", $data->device_id);
			$this->db->set("auto_scale", $data->auto_scale);
			$this->db->set("ymin", $data->ymin);
			$this->db->set("ymax", $data->ymax);
			$this->db->set("emails", $data->emails);
			$this->db->set("status", $data->status);
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function get_post_data(){
			$data = new Email_schedule();
			$data->title = $this->input->post('title');
			$data->display_type = $this->input->post('display_type');
			$data->months_range = $this->input->post('months_range');
			$data->time = $this->input->post('time');
			$data->device_id = $this->input->post('device_id');
			$data->auto_scale = $this->input->post('auto_scale');
			$data->ymin = $this->input->post('ymin');
			$data->ymax = $this->input->post('ymax');
			$data->emails = $this->input->post('emails');			
			$data->status = $this->input->post('status');
			return $data;
		}
		
		function clear_data(){
			$this->title = "";
			$this->time = "";
			$this->display_type = "";
			$this->months_range = "";
			$this->device_id = "";
			$this->auto_scale = "1";
			$this->ymin = "0";
			$this->ymax = "0";
			$this->emails = "";
		}
				
		function delete($id)
		{
			$this->db->where("id", $id);			
			$this->db->delete($this->table_name);			
		}
		
		function delete_in($ids)
		{
			foreach($ids as $id){				
				$this->delete($id);
			}
		}
				
		function active_in($status, $ids)
		{
			$this->db->set("status", $status);
			$this->db->where_in("id", $ids);			
			$result = $this->db->update($this->table_name);
			return $result;
		}
		
		//using for thread running background schedule
		function get_all_emails_schedule(){			
			$this->db->where('status', 1);
			$data = $this->db->get($this->table_name);			
			return $data;
		}		
	}
?>