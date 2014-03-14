<?php
	class Menu extends CI_Model{
		private $table_name = "menu";
		public $id = "";	
		public $title_en = "";
		public $title_fi = "";
		public $title_kr = "";
		public $module_id = "";
		public $status = 1;
		
		function get_id($id){		
			$this->db->join('modules m', 'm.module_id = a.module_id', 'left');
			$this->db->where("a.id", $id);
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format,m.link", false);
			$query = $this->db->get($this->table_name . ' a');
			return $query->row();
		}
		
		function get_by_module_id($module_id){
			$this->db->where("module_id", $module_id);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
		
		function get_id_in_user($id){			
			$this->db->where("id", $id);
			$this->db->select("*,DATE_FORMAT(created_date,'" . DB_DATE_FORMAT . "') as created_date_format", false);
			$this->db->where('status', 1);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
		
		function insert($data, $admin_id){						
			$this->db->set("title_en", $data->title_en);
			$this->db->set("title_fi", $data->title_fi);
			$this->db->set("title_kr", $data->title_kr);
			$this->db->set("status", $data->status);			
			$this->db->set("created_by", $admin_id);			
			$this->db->set("created_date", "now()", false);
			$this->db->set("module_id", $data->module_id);
			$this->db->set('position', $this->get_max_position() + 1);			
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $id){			
			$this->db->set("title_en", $data->title_en);
			$this->db->set("title_fi", $data->title_fi);
			$this->db->set("title_kr", $data->title_kr);
			$this->db->set("status", $data->status);						
			$this->db->set("module_id", $data->module_id);			
			$this->db->where("id", $id);
			$result = $this->db->update($this->table_name);			
			return $result;
		}
		
		function update_positions($ids){
			$index = 1;
			foreach($ids as $id){
				$this->update_position_equal($id, $index++);				
			}			
		}
				
		function get_menu($keywords, $page, $page_size, $sort_by, $ascending, &$num_rows, $language){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;
			
			if ($keywords != "")
			{				
				$this->db->like('title_en', $keywords);
				$this->db->or_like('title_fi', $keywords);
				$this->db->or_like('title_kr', $keywords);
			}
			
			$num_rows = $this->db->count_all_results($this->table_name);			
			if ($keywords != "")
			{				
				$this->db->like('title_en', $keywords);
				$this->db->or_like('title_fi', $keywords);
				$this->db->or_like('title_kr', $keywords);
			}
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, (SELECT COUNT(*) FROM submenu WHERE menu_id = a.id) as total_submenu, m.module_name, a.title_" . $language->iso . " as title, m.link", false);
			$this->db->join('modules m', 'm.module_id = a.module_id', 'left');
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				else if ($sort_by == "title"){
					$sort_column = "a.title_" . $language->iso;
				}				
				else if ($sort_by == "created-date"){
					$sort_column = "a.created_date";
				}
				else if ($sort_by == "status"){
					$sort_column = "a.status";
				}
				else if ($sort_by == "module"){
					$sort_column = "m.module_name";
				}
				else if ($sort_by == 'submenu'){
					$sort_column = '(SELECT COUNT(*) FROM submenu WHERE menu_id = a.id)';
				}
				if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;				
					$this->db->order_by($sort_column);
				}				
			}
			else{
				$this->db->order_by('position ASC');
			}
			
			$data = $this->db->get($this->table_name . " a", $page_size, $start);			
			return $data; 		
		}
		//using for menu in home
		function get_all_menu_in_user($iso){
			$this->db->select('a.*,m.link');
			$this->db->join('modules m', 'm.module_id = a.module_id', 'left');
			$this->db->where("a.status" , 1);
			$this->db->order_by("a.position");
			$data = $this->db->get($this->table_name . ' a');

			$menu = array();
			foreach($data->result() as $row){
				$obj = new stdClass();
				$obj->id = $row->id;
				$obj->title = "";
				set_title_by_language($row, $obj);
				$obj->module_id = $row->module_id;				
				$obj->link = $row->link;
				$menu[] = $obj;				
			}
			//echo $this->db->last_query();
			return $menu; 		
		}
		
		function get_all_menu_in_admin($language){						
			//$this->db->select("*, 'ddd' as title", false);
			$this->db->order_by("position");
			$this->db->select('*,title_' . $language->iso . ' as title');			
			$data = $this->db->get($this->table_name);
			return $data; 		
		}
		
		function get_all_menu_array_in_admin(){		
			$this->db->select("*, (SELECT COUNT(*) FROM submenu WHERE menu_id = a.id) as total_submenu", false);			
			$this->db->order_by("a.position");
			$data = $this->db->get($this->table_name . " a");
			
			$cateogries = array();
			foreach($data->result() as $row){
				$obj = new stdClass();
				$obj->id = $row->id;
				$obj->module_id = $row->module_id;
				set_title_by_language($obj);
				$obj->status = $row->status;				
				$obj->total_submenu = $row->total_submenu;
				$cateogries[] = $obj;				
			}
			return $cateogries;			
		}
		
		function get_post_data(){
			$data = new menu();			
			$data->title_en = $this->input->post('title_en');
			$data->title_fi = $this->input->post('title_fi');
			$data->title_kr = $this->input->post('title_kr');
			$data->module_id = $this->input->post('module_id');
			$data->status = $this->input->post('status');			
			return $data;
		}
		
		function clear_data(){			
			$this->title_en = "";
			$this->title_fi = "";
			$this->title_kr = "";
			$this->module_id = "";
		}
		
		function delete($id)
		{
			$this->submenu->delete_by_menu_id($id);
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
		
		private function get_by_position_equal($position){
			$this->db->where('position', $position);
			$query = $this->db->get($this->table_name . " a");			
			$data = $query->row();
			return $data;
		}
		
		private function update_position_equal($id, $position){
			$this->db->set('position', $position);
			$this->db->where('id', $id);
			$this->db->update($this->table_name);
		}
		
		function update_position($id, $is_up, $position){
			$data = $this->get_id($id);				
			if ($data){
				if ($position !== ""){					
					$max_id = $this->get_max_position();
					if ($position >= $max_id){
						$position = $max_id;						
					}
					else if ($position < 1){
						$position = 1;
					}
					
					$sql = '';
					//check move up or down
					if ($position > $data->position){
						//MOVE DOWN
						$sql = 'UPDATE %s SET position = position - 1 WHERE position <= %s AND position > %s AND id != %s';
					}
					else if ($position < $data->position){
						//MOVE UP
						$sql = 'UPDATE %s SET position = position + 1 WHERE position >= %s AND position < %s AND id != %s';
					}
					
					if ($sql){
						$sql = sprintf($sql, 
							$this->table_name,
							$this->db->escape($position),
							$this->db->escape($data->position),
							$this->db->escape($id));
						
						$result = mysql_query($sql);
						if ($result){
							$this->update_position_equal($id, $position);
						}
					}
				}
				else{				
					$position = $data->position;
					if ($is_up){					
						//find position lower than current position
						$this->db->where('position <', $position);
						$this->db->order_by('position DESC');
						$query = $this->db->get($this->table_name . " a");			
						$result = $query->result();
					}
					else{								
						//find position greater than current position
						$this->db->where('position >', $position);
						$this->db->order_by('position ASC');
						$query = $this->db->get($this->table_name . " a");			
						$result = $query->result();
					}
					if (count($result) > 0){
						//found the first greater than current
						$other = $result[0];
						//swap position
						$this->db->set('position', $position);							
						$this->db->where('position', $other->position);							
						$this->db->update($this->table_name);													
						
						$this->db->set('position', $other->position);
						$this->db->where('id', $id);							
						$this->db->update($this->table_name);							
					}		
				}				
			}
			
			$max_position = $this->get_max_position();
			if ($max_position > 1000){				
				//reformat position for more nice purpose
				$this->db->order_by('position ASC');
				$query = $this->db->get($this->table_name . " a");			
				$index = 1;
				foreach($query->result() as $row){				
					$this->update_position_equal($row->id, $index++);
				}				
			}
		}

		private function get_max_position(){
			$this->db->select_max('position');
			$row = $this->db->get($this->table_name);
			$result = $row->result();			
			if (count($result)){				
				return $result[0]->position;
			}
			return 0;
		}		
	}
?>