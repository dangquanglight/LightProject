<?php
	class Submenu extends CI_Model{
		private $table_name = "submenu";
		public $id = "";			
		public $menu_id = "";	
		public $title_en = "";
		public $title_fi = "";
		public $title_kr = "";
		public $module_id = "";
		public $status = 1;		
		
		function get_id($id){			
			$this->db->join('modules m', 'm.module_id = a.module_id', 'left');
			$this->db->where("a.id", $id);
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, m.link", false);
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
		
		function insert($data, $user_id){					
			$this->db->set("title_en", $data->title_en);
			$this->db->set("title_fi", $data->title_fi);
			$this->db->set("title_kr", $data->title_kr);
			$this->db->set("menu_id", $data->menu_id);			
			$this->db->set("status", $data->status);			
			$this->db->set("created_by", $user_id);			
			$this->db->set("created_date", "now()", false);
			$this->db->set("module_id", $data->module_id);
			$this->db->set('position', $this->get_max_position($data->menu_id) + 1);
			$result = $this->db->insert($this->table_name);			
			return $result;
		}
		
		function update($data, $id){								
			$result = false;
			//get old data
			$old_data = $this->get_id($id);
			if ($old_data){
				//check different module
				if ($old_data->menu_id != $data->menu_id){
					$this->db->set("position", $this->get_max_position($data->menu_id) + 1);
				}
			
				$this->db->set("title_en", $data->title_en);
				$this->db->set("title_fi", $data->title_fi);
				$this->db->set("title_kr", $data->title_kr);
				$this->db->set("menu_id", $data->menu_id);
				$this->db->set("module_id", $data->module_id);
				$this->db->set("status", $data->status);						
				$this->db->where("id", $id);
				$result = $this->db->update($this->table_name);
			}
			return $result;
		}
		
		function update_position($id, $is_up, $position){
			$data = $this->get_id($id);				
			if ($data){
				if ($position !== ""){
					$max_id = $this->get_max_position($data->menu_id);
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
						$sql = 'UPDATE %s SET position = position - 1 WHERE position <= %s AND position > %s AND id != %s AND menu_id = %s';
					}
					else if ($position < $data->position){
						//MOVE UP
						$sql = 'UPDATE %s SET position = position + 1 WHERE position >= %s AND position < %s AND id != %s AND menu_id = %s';
					}
					if ($sql){
						$sql = sprintf($sql, 
							$this->table_name,
							$this->db->escape($position),
							$this->db->escape($data->position),
							$this->db->escape($id),
							$this->db->escape($data->menu_id)
							);
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
						$this->db->where('menu_id', $data->menu_id);
						$this->db->order_by('position DESC');
						$query = $this->db->get($this->table_name . " a");			
						$result = $query->result();
					}
					else{								
						//find position greater than current position
						$this->db->where('position >', $position);
						$this->db->where('menu_id', $data->menu_id);
						$this->db->order_by('position ASC');
						$query = $this->db->get($this->table_name . " a");			
						$result = $query->result();
					}
					if (count($result) > 0){
						//found the first greater than current
						$other = $result[0];
						//swap position
						$this->db->set('position', $position);			
						$this->db->where('menu_id', $data->menu_id);
						$this->db->where('position', $other->position);
						$this->db->update($this->table_name);													
						
						$this->db->set('position', $other->position);
						$this->db->where('id', $id);							
						$this->db->update($this->table_name);							
					}		
				}				
			}
			
			$max_position = $this->get_max_position($data->menu_id);			
		}
		
		private function get_max_position($menu_id){
			$this->db->select_max('position');
			$this->db->where('menu_id', $menu_id);
			$row = $this->db->get($this->table_name)->row();			
			if ($row){
				return $row->position;
			}
			return 0;
		}
		
		function update_position_equal($id, $position){
			$this->db->set('position', $position);
			$this->db->where('id', $id);
			$this->db->update($this->table_name);
		}
		
		
				
		function get_submenu($menu_id, $keywords, $page, $page_size, $sort_by, $ascending, &$num_rows, $language){
			$start = ($page - 1) * $page_size;
			$end = $start + $page_size;
			
			if ($keywords != "")
			{				
				$this->db->like('title_en', $keywords);
				$this->db->or_like('title_fi', $keywords);
				$this->db->or_like('title_kr', $keywords);
			}
			if ($menu_id){
				$this->db->where('menu_id', $menu_id);
			}
			$num_rows = $this->db->count_all_results($this->table_name);			
			if ($keywords != "")
			{				
				$this->db->like('title_en', $keywords);
				$this->db->or_like('title_fi', $keywords);
				$this->db->or_like('title_kr', $keywords);
			}
			$this->db->select("a.*, a.title_" . $language->iso . " as title,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format, c.title_" . $language->iso . " as menu_title, m.module_name, m.link", false);			
			$this->db->join("menu c", "c.id = a.menu_id", "left");	
			$this->db->join('modules m', 'm.module_id = a.module_id', 'left');			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				else if ($sort_by == "title"){
					$sort_column = "a.title_" . $language->iso;
				}
				else if ($sort_by == "title"){
					$sort_column = "c.title";
				}
				else if ($sort_by == "created-date"){
					$sort_column = "a.created_date";
				}
				else if ($sort_by == 'menu-title'){
					$sort_column = "c.title_" . $language->iso;
				}
				else if ($sort_by == "module"){
					$sort_column = "m.module_name";
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
				$this->db->order_by('c.title_' . $language->iso . ', a.position');
			}
			if ($menu_id){
				$this->db->where('menu_id', $menu_id);
			}
			$data = $this->db->get($this->table_name . " a", $page_size, $start);						
			return $data; 		
		}
				
		//using for menu in home
		function get_all_submenu_in_user($iso){						
			$this->db->select('a.*,m.link');
			$this->db->where("a.status" , 1);
			$this->db->order_by("a.menu_id, position");			
			$this->db->join('modules m', 'm.module_id = a.module_id', 'left');
			$data = $this->db->get($this->table_name . ' a');

			$submenu = array();
			foreach($data->result() as $row){
				$obj = new stdClass();
				$obj->id = $row->id;
				$obj->menu_id = $row->menu_id;
				$obj->title = "";
				if ($iso == EN){
					$obj->title = $row->title_en;
				}
				else if ($iso == FI){				
					$obj->title = $row->title_fi;
				}
				else if ($iso == KR){
					$obj->title = $row->title_kr;
				}
				$obj->module_id = $row->module_id;				
				$obj->link = $row->link;				
				$submenu[] = $obj;				
			}
			return $submenu; 		
		}
		
		function get_all_submenu_by_menu_in_user($menu_id){				
			$this->db->order_by("position");
			$this->db->where("menu_id", $menu_id);
			$this->db->where("status" , 1);
			$data = $this->db->get($this->table_name);			
			$result = array();
			foreach($data->result() as $row){
				$obj = new stdClass();
				$obj->id = $row->id;
				$obj->title = $row->title;
				$obj->module_id = $row->module_id;
				$result[] = $obj;
			}
			return $result; 		
		}
		
		function get_all_submenu_by_menu_in_admin($menu_id){				
			$this->db->order_by("title");
			$this->db->where("menu_id", $menu_id);
			$data = $this->db->get($this->table_name);			
			$result = array();
			foreach($data->result() as $row){
				$obj = new stdClass();
				$obj->id = $row->id;
				$obj->module_id = $row->module_id;
				if ($iso == EN){
					$obj->title = $row->title_en;
				}
				else if ($iso == FI){				
					$obj->title = $row->title_fi;
				}
				else if ($iso == CI){
					$obj->title = $row->title_kr;
				}
				$result[] = $obj;
			}			
			return $result;
		}
		
		function get_all_submenu_in_admin(){				
			$this->db->order_by("a.menu_id, a.position");
			$this->db->join('menu c', 'c.id = a.menu_id');
			$this->db->select('a.*,c.title');
			$query = $this->db->get($this->table_name . " a");						
			return $query;
		}
		
		function get_all_submenu_by_menu_in_tree_menu_in_admin($menu_id, $language_iso){				
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_FORMAT . "') as created_date_format", false);
			$this->db->order_by("a.position");			
			$this->db->where("a.menu_id", $menu_id);			
			$query = $this->db->get($this->table_name . " a");						
			return $query;
		}
		
		function get_all_submenu_array_in_admin(){				
			$this->db->order_by("a.menu_id, a.position");						
			$query = $this->db->get($this->table_name . " a");		

			$submenu = array();
			foreach($query->result() as $row){
				$obj = new stdClass();
				$obj->id = $row->id;
				$obj->title = "";
				if ($iso == EN){
					$obj->title = $row->title_en;
				}
				else if ($iso == FI){				
					$obj->title = $row->title_fi;
				}
				else if ($iso == CI){
					$obj->title = $row->title_kr;
				}
				$obj->menu_id = $row->menu_id;				
				$obj->status = $row->status;
				$submenu[] = $obj;				
			}
			return $submenu;
		}
		
		private function get_by_position_equal($menu_id, $position){
			$this->db->where('menu_id', $menu_id);
			$this->db->where('position', $position);
			$query = $this->db->get($this->table_name . " a");			
			$data = $query->row();
			return $data;
		}
		
		function get_post_data(){
			$data = new submenu();			
			$data->title_en = $this->input->post('title_en');
			$data->title_fi = $this->input->post('title_fi');
			$data->title_kr = $this->input->post('title_kr');
			$data->menu_id = $this->input->post('menu_id');						
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
			$this->db->where("id", $id);			
			$this->db->delete($this->table_name);			
		}
		
		function delete_in($ids)
		{
			foreach($ids as $id){				
				$this->delete($id);
			}
		}
		
		function delete_by_menu_id($menu_id){
			$this->db->where("menu_id", $menu_id);
			$query = $this->db->get($this->table_name);
			foreach($query->result() as $row){				
				$this->delete($row->id);
			}			
		}
				
		function active_in($status, $ids)
		{
			$this->db->set("status", $status);
			$this->db->where_in("id", $ids);			
			$result = $this->db->update($this->table_name);
			return $result;
		}		
	}
?>