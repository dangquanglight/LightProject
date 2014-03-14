<?php
	class Site_setting extends CI_Model{
		private $table_name = "site_setting";
		public $page_width = "";
		public $border_color = "";
		public $border_width = "";
		public $border_type = "";
		public $enable_border = "";
		public $bg_color = "";
		public $enable_bg_image = 1;
		public $bg_repeat = 0;
		public $enabled_register = 1;		
		public $h_shadow = "";
		public $v_shadow = "";
		public $blur_shadow = "";
		public $size_shadow = "";
		public $color_shadow = "";
		public $out_inset_shadow = "";
		public $enable_shadow = "";
		public $menu_color = "";
		public $separate_bar_bg_color = "";
		public $button_linear_color_1 = "";
		public $button_linear_color_2 = "";
		
		
		function get_one(){		
			$query = $this->db->get($this->table_name);				
			return $query->row();
		}
				
		function insert_or_update($data, $user_id){
			$this->db->set("enable_register", $data->enable_register);
			$this->db->set("page_width", $data->page_width);
			$this->db->set("border_color", $data->border_color);
			$this->db->set("border_width", $data->border_width);
			$this->db->set("border_type", $data->border_type);
			$this->db->set("enable_border", $data->enable_border);
			$this->db->set("bg_color", $data->bg_color);
			$this->db->set("enable_bg_image", $data->enable_bg_image);
			$this->db->set("bg_repeat", $data->bg_repeat);
			$this->db->set("h_shadow", $data->h_shadow);
			$this->db->set("v_shadow", $data->v_shadow);
			$this->db->set("blur_shadow", $data->blur_shadow);
			$this->db->set("size_shadow", $data->size_shadow);
			$this->db->set("color_shadow", $data->color_shadow);
			$this->db->set("out_inset_shadow", $data->out_inset_shadow);
			$this->db->set("enable_shadow", $data->enable_shadow);
			$this->db->set("menu_color", $data->menu_color);
			$this->db->set("separate_bar_bg_color", $data->separate_bar_bg_color);
			$this->db->set("button_linear_color_1", $data->button_linear_color_1);
			$this->db->set("button_linear_color_2", $data->button_linear_color_2);
			
			$old_setting = $this->get_one();
			if ($old_setting){
				//update
				$result = $this->db->update($this->table_name);
			}
			else{
				$this->db->set("created_date", "now()", false);
				$this->db->set("created_by", $user_id);
				$result = $this->db->insert($this->table_name);
			}			
						
			return $result;
		}
		
		function get_post_data(){
			$data = new site_setting();
			$data->enable_register = $this->input->post('enable_register');
			$data->page_width = $this->input->post('page_width');
			$data->border_color = $this->input->post('border_color');
			$data->border_width = $this->input->post('border_width');
			$data->border_type = $this->input->post('border_type');
			$data->enable_border = $this->input->post('enable_border');
			$data->bg_color = $this->input->post('bg_color');
			$data->bg_repeat = $this->input->post('bg_repeat');
			$data->enable_bg_image = $this->input->post('enable_bg_image');
			$data->h_shadow = $this->input->post('h_shadow');
			$data->v_shadow = $this->input->post('v_shadow');
			$data->blur_shadow = $this->input->post('blur_shadow');
			$data->size_shadow = $this->input->post('size_shadow');
			$data->color_shadow = $this->input->post('color_shadow');
			$data->out_inset_shadow = $this->input->post('out_inset_shadow');
			$data->enable_shadow = $this->input->post('enable_shadow');
			$data->menu_color = $this->input->post('menu_color');
			$data->separate_bar_bg_color = $this->input->post('separate_bar_bg_color');
			$data->button_linear_color_1 = $this->input->post('button_linear_color_1');
			$data->button_linear_color_2 = $this->input->post('button_linear_color_2');
			return $data;
		}
		
		function delete($id)
		{
			$this->db->where("id", $id);			
			$this->db->delete($this->table_name);			
		}		
	}
?>