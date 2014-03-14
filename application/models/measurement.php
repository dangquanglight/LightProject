<?php
	class Measurement extends CI_Model{
		private $table_name = "measurements";
		
		function get_id($id, $company_id){		
			$this->db->select("a.*,d.zone_id,z.site_id,s.company_id,DATE_FORMAT(a.datetime, '" . DB_DATE_TIME_FORMAT . "') as datetime_format", false);
			$this->db->join('devices d', 'd.id = a.device_id');
			$this->db->join('zones z', 'z.id = d.zone_id');
			$this->db->join('sites s', 's.id = z.site_id');			
			$this->db->where('d.company_id', $company_id);	
			$this->db->where('a.id', $id);			
			$query = $this->db->get($this->table_name . ' a');
			return $query->row();
		}
		
		function get_by_device_and_time($device_id, $datetime){		
			$this->db->where('device_id', $device_id);
			if ($datetime){
				$this->db->where('datetime', $datetime);
			}
			else{
				$this->db->where('datetime', 'now()', false);
			}
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
			
		function get_lastest_data($device_id, $limit = 1){		
			$this->db->where('device_id', $device_id);		
			$this->db->order_by('datetime DESC');
			$query = $this->db->get($this->table_name, $limit);
			return $query;
		}
		
		function get_stream_measurements($device_id){
			$this->db->select('COUNT(*) as count, GROUP_CONCAT(id ORDER BY datetime ASC) as ids', false);
			$this->db->where('device_id', $device_id);
			$query = $this->db->get($this->table_name);
			return $query->row();
		}
		
		function get_times_on_off($device_id, &$times_on, &$times_off){
			$device_id = $this->db->escape($device_id);
			$sql = "SELECT (SELECT count(* )
					FROM `measurements` 
					WHERE device_id = $device_id AND value != 0) as times_on, (SELECT count(* )
					FROM `measurements` 
					WHERE device_id = $device_id AND value = 0) as times_off";			
			$row = $this->db->query($sql)->row();
			$times_on = 0;
			$times_off = 0;
			if ($row){
				$times_on = $row->times_on;
				$times_off = $row->times_off;
			}
		}
		
		function get_measurements($company_id, $keywords, $page, $page_size, $sort_by, $ascending, &$num_rows){
			$start = ($page - 1) * $page_size;
			
			$this->db->where('d.company_id', $company_id);
			$sql_where = "d.company_id = " . $this->db->escape($company_id);
			
			if ($keywords){
				$sql_where .= " AND (";
				$sql_where .= "d.device_name LIKE '%" . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= " OR st.sub_type_name LIKE '%" . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= " OR a.value LIKE '%" . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= ")";
			}
			if ($sql_where){
				$this->db->where($sql_where);
			}
			$this->db->join('devices d', 'a.device_id = d.id', 'left');
			$this->db->join('sub_types st', 'st.id = d.sub_type_id', 'left');
			
			$num_rows = $this->db->count_all_results($this->table_name . ' a');			
			if ($keywords){
				$sql_where .= " AND (";
				$sql_where .= "d.device_name LIKE '%" . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= " OR st.sub_type_name LIKE '%" . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= " OR a.value LIKE '%" . $this->db->escape_like_str($keywords) . "%'";
				$sql_where .= ")";
			}
			if ($sql_where){
				$this->db->where($sql_where);
			}
			$this->db->join('devices d', 'a.device_id = d.id', 'left');
			$this->db->join('sub_types st', 'st.id = d.sub_type_id', 'left');
			$this->db->join('zones z', 'z.id = d.zone_id', 'left');
			
			$this->db->select("a.*,DATE_FORMAT(a.created_date,'" . DB_DATE_TIME_FORMAT . "') as created_date_format,d.device_name,DATE_FORMAT(a.datetime,'" . DB_DATE_TIME_FORMAT . "') as datetime_format,d.sub_type_id, st.sub_type_name, z.zone_name, d.zone_id", false);
			
			if ($sort_by){
				$sort_column = "";
				if ($sort_by == "id"){
					$sort_column = "a.id";
				}
				else if ($sort_by == "device-name"){
					$sort_column = "d.device_name";
				}
				else if ($sort_by == "value"){
					$sort_column = "a.value";
				}
				else if ($sort_by == "type"){
					$sort_column = "st.sub_type_name";
				}
				else if ($sort_by == "created-date"){
					$sort_column = "a.created_date";
				}
				else if ($sort_by == "datetime"){
					$sort_column = "a.datetime";
				}
				else if ($sort_by == "zone"){
					$sort_column = "z.zone_name";
				}
				
				if ($sort_column && ($ascending == "asc" || $ascending == "desc")){
					$sort_column .= " " . $ascending;				
					$this->db->order_by($sort_column);
				}				
			}
			else{
				$this->db->order_by('a.datetime DESC');
			}
			
			$data = $this->db->get($this->table_name . " a", $page_size, $start);			
			return $data; 		
		}
		
		function insert_or_update($company_id, $device_id, $datetime, $value){			
			$old_measurement = $this->get_by_device_and_time($device_id, $datetime);
			$this->db->set("value", $value);
			if ($old_measurement){
				$this->db->where('device_id', $device_id);
				if ($datetime){
					$this->db->where('datetime', $datetime);
				}
				else{
					$this->db->where('datetime', 'now()', false);
				}
				$result = $this->db->update($this->table_name);
			}
			else{
				$this->db->set('device_id', $device_id);
				if ($datetime){
					$this->db->set('datetime', $datetime);
				}
				else{
					$this->db->set('datetime', 'now()', false);
				}	
				$this->db->set('created_date', 'now()', false);				
				$result = $this->db->insert($this->table_name);
			}			
			if ($result){				
				$this->check_all_events($device_id, $company_id);
			}
			return $result;
		}
		
		function insert_or_update_image($company_id, $device_id, $datetime, $image){						
			$old_measurement = $this->get_by_device_and_time($device_id, $datetime);
			$result = false;
			if (!$old_measurement){
				$this->db->set('device_id', $device_id);
				$this->db->set('datetime', $datetime);		
				$this->db->set("image", $image);				
				$this->db->set('created_date', 'now()', false);
				$result = $this->db->insert($this->table_name);
			}			
			return $result;
		}
		
		function get_mix_max_stddev($device_id, $date_type){
			$this->db->select('MIN(value) as min, MAX(value) as max, STDDEV(value) as stddev', false);
			$this->db->where('device_id', $device_id);			
			$this->set_date_by_type($date_type);			
			$this->db->order_by('datetime');
			$query = $this->db->get($this->table_name);		
			//echo $this->db->last_query();
			return $query->row();
		}
		
		function get_median($device_id, $date_type){			
			$this->db->where('device_id', $device_id);
			$this->set_date_by_type($date_type);			
			$this->db->order_by('datetime');
			$query = $this->db->get($this->table_name);
			$values = array();
			foreach($query->result() as $row){
				$values[] = $row->value;
			}
			return $this->cal_median($values);
		}
		
		function get_set_off_data($device_id, $date_type){
			$this->db->select('*,UNIX_TIMESTAMP(datetime)as timestamp', false);
			$this->db->where('device_id', $device_id);
			$this->set_date_by_type($date_type);			
			$this->db->order_by('datetime');
			$query = $this->db->get($this->table_name);
			return $query;
		}
		
		function get_data_query_4_chart($device_id, $date_format, $limit = null){
			$this->db->select("*,DATE_FORMAT(datetime, '" . DB_DATE_TIME_FORMAT . "') as datetime_format", false);
			$this->db->where('device_id', $device_id);
			//$this->set_date_by_type($date_format);
			$this->db->where('DATE(datetime)', $date_format);
			$this->db->order_by('datetime ASC');
			$query = $this->db->get($this->table_name, $limit);
			
			return $query;
		}
		
		function get_4_columns_chart($device_id, $date_type, $num_columns){
			//$num_columns += 1;
			$this->db->select("MIN(value) as min, MAX(value) as max", false);
			$this->db->where('device_id', $device_id);
			$this->set_date_by_type($date_type);
			$this->db->order_by('datetime DESC');
			$data = $this->db->get($this->table_name)->row();
			
			$min = $data->min;
			$max = $data->max;
			
			$distance = ($max - $min) / ($num_columns);
			$ar_values = array();
			for($i = $min; $i < $max; $i+= $distance){
				$ar_values[] = $i;
			}
			$ar_values[] = $max;
			$length = count($ar_values);
			$categories = array();
			$values = array();
			if ($length >= 2){
				$count_select = '';
				for($i = 0; $i < $length - 1; $i++){
					if ($i < $length - 2){
						$count_select .= sprintf("COUNT(IF(value >= %s, IF(value < %s, 1, NULL), NULL)) as total%s,", $ar_values[$i], $ar_values[$i + 1], $i);
					}
					else{
						$count_select .= sprintf("COUNT(IF(value >= %s, 1, NULL)) as total%s,", $ar_values[$i], $i);
					}
				}
				$count_select = rtrim($count_select, ',');
				
				$this->db->select($count_select, false);
				$this->db->where('device_id', $device_id);
				$this->set_date_by_type($date_type);
					
				$data = $this->db->get($this->table_name)->row();
				$i = 0;
				$total_values = 0;
				foreach($data as $key => $value){
					$total_values += $value;
				}
				$i = 0;				
				foreach($data as $key => $value){
					$categories[$i] = ($i == $num_columns - 1 ? '> ' : '') . (round($ar_values[$i] * 10) / 10) . '';
					$values[$i] = round($value * 100.0 / $total_values, 2);
					$i++;
				}				
			}
			//var_dump($categories);
			$result = new stdClass();
			$result->categories = $categories;
			$result->data = $values;
			//var_dump($result);
			//print_r($result);
			return $result;
		}
		
		function get_categories_4_chart($ids, $limit = null){
			$this->db->where_in('device_id', $ids);
			$this->db->select("GROUP_CONCAT(DISTINCT DATE_FORMAT(datetime, '" . DB_DATE_TIME_FORMAT . "') ORDER BY datetime ASC) as datetime_format", false);
			$this->db->order_by('datetime ASC');
			$query = $this->db->get($this->table_name, $limit);
			//echo $this->db->last_query();
			//die();			
			return $query->row();
		}		
		
		function get_median_by_date($device_id, $datetime_start, $datetime_end){
			//1. COUNT HOW MUCH THE NUMBER		
			$this->db->where('device_id', $device_id);
			$this->db->where("datetime BETWEEN '{$datetime_start}' AND '{$datetime_end}'");
			$num_rows = $this->db->count_all_results($this->table_name);
			$median = 'NaN';
			if ($num_rows != 0){
				if ($num_rows % 2 == 0){
					//GET AVERAGE OF POSITION i AND i + 1
					$this->db->where('device_id', $device_id);					
					$this->db->where("datetime BETWEEN '{$datetime_start}' AND '{$datetime_end}'");
					$this->db->order_by('value ASC');
					$query = $this->db->get($this->table_name, ceil($num_rows/2) + 1);
					
					$index = 0;
					foreach($query->result() as $row){
						if ($index > 0){
							$row2 = $row1;
						}
						$row1 = $row; 
						$index++;
					}
					$median = ($row1->value + $row2->value)/2;					
				}
				else{
					//GET LAST POSITION
					$this->db->where('device_id', $device_id);
					$this->db->where("datetime BETWEEN '{$datetime_start}' AND '{$datetime_end}'");
					$this->db->order_by('value ASC');
					$query = $this->db->get($this->table_name . ' a', ceil($num_rows/2));
					foreach($query->result() as $row){
						$median = $row->value;
					}
				}
			}
			return $median;
			/*
			$this->db->where('device_id', $device_id);			
			$this->db->where('datetime >=', $datetime_start);
			$this->db->where('datetime <=', $datetime_end);
			$this->db->order_by('datetime');
			$query = $this->db->get($this->table_name);
			//echo $this->db->last_query();
			$values = array();
			foreach($query->result() as $row){
				$values[] = $row->value;
			}
			$result = $this->cal_median($values);
			return $result;
			*/
		}
		
		function delete($id, $company_id)
		{
			$this->db->where("id", $id);
			//$this->db->where("company_id", $company_id);			
			$this->db->delete($this->table_name);			
		}
		
		function delete_in($ids, $company_id)
		{
			foreach($ids as $id){				
				$this->delete($id, $company_id);
			}
		}
		
		public function get_median_by_date_type($device_id, $date_type){
			//1. COUNT HOW MUCH THE NUMBER						
			$where_date = $this->get_sql_date_by_type($date_type, 'a');
			$this->db->where('device_id', $device_id);
			$this->db->where($where_date);
			$num_rows = $this->db->count_all_results($this->table_name . ' a');
			//echo 'NUM ROWS: ' . $num_rows . '<br/>';
			$median = 'NaN';
			if ($num_rows != 0){
				if ($num_rows % 2 == 0){
					//GET AVERAGE OF POSITION i AND i + 1				
					$this->db->where('device_id', $device_id);
					$this->db->where($where_date);
					$this->db->order_by('value ASC');
					$query = $this->db->get($this->table_name . ' a', ceil($num_rows/2) + 1);
					$index = 0;
					foreach($query->result() as $row){
						if ($index > 0){
							$row2 = $row1;
						}
						$row1 = $row; 
						$index++;
					}
					$median = ($row1->value + $row2->value)/2;
				}
				else{
					//GET LAST POSITION				
					$this->db->where('device_id', $device_id);
					$this->db->where($where_date);
					$this->db->order_by('value ASC');
					$query = $this->db->get($this->table_name . ' a', ceil($num_rows/2));
					//echo $this->db->last_query();
					foreach($query->result() as $row){
						$median = $row->value;
					}					
				}
			}
			return $median;
			
			/*
			$where_date_1 = $this->get_sql_date_by_type($date_type, 'x');
			$where_date_2 = $this->get_sql_date_by_type($date_type, 'y');
			$sql = "SELECT x.value 
			FROM measurements x, measurements y
			WHERE x.device_id = {$device_id} AND y.device_id = {$device_id} AND {$where_date_1} AND {$where_date_2}
			GROUP BY x.value
			HAVING SUM(SIGN(1-SIGN(y.value-x.value)))/COUNT(*) > .5
			LIMIT 1";
			$query = $this->db->query($sql);
			$row = $query->row();
			if ($row){
				return $row->value;
			}
			return null;
			*/
		}
		
		private function cal_median($values){			
			asort($values);
			$length = count($values);
			if ($length == 0){
				return 'NaN';
			}
			$half = floor($length/2);

			if($length % 2)
				return $values[$half];
			else
				return ($values[$half-1] + $values[$half]) / 2.0;
		}
		
		private function set_date_by_type($date_type){
			if ($date_type == 1){
				//day
				$date = date('Y-m-d');
				$this->db->where('DATE(datetime)', 'CURDATE()', false);
			}
			else if ($date_type == 2){
				$year = date('Y');
				$this->db->where('YEAR(datetime)', $year);				
				//week								
				$this->db->where('WEEKOFYEAR(datetime)', 'WEEKOFYEAR(NOW())', false);
			}
			else if ($date_type == 3){
				//month				
				$year = date('Y');
				$month = date('m');
				$this->db->where('YEAR(datetime)', $year);
				$this->db->where('MONTH(datetime)', $month);
			}
			else{ // if ($date_type == 4){
				$year = date('Y');
				$this->db->where('YEAR(datetime)', $year);
			}			
		}
		
		private function get_sql_date_by_type($date_type, $prefix = ''){
			$sql = '';
			$prefix = $prefix . '.';
			if ($date_type == 1){
				//day
				$date = date('Y-m-d');
				$sql = "DATE({$prefix}datetime) = '" . $date . "'";
			}
			else if ($date_type == 2){
				//WEEK
				$year = date('Y');				
				$sql = "YEAR({$prefix}datetime) = $year AND WEEKOFYEAR({$prefix}datetime) = WEEKOFYEAR(NOW())";
			}
			else if ($date_type == 3){
				//month	
				$sql = "YEAR({$prefix}datetime) = YEAR(curdate()) AND ";
				$sql .= "MONTH({$prefix}datetime) = MONTH(curdate())";
			}
			else{ // if ($date_type == 4){
				$sql = "YEAR({$prefix}datetime) = YEAR(curdate())";
			}	
			return $sql;
		}
		
		/***********************************************************************/
		/**************************** CHECKING FORMULAR *******************************/		
		/***********************************************************************/
		private function check_all_events($affect_device_id, $company_id){
			$this->load->model('event');
			$this->load->model('alarm');
			$this->load->model('device');
			$this->load->model('alarm_history');
			$query = $this->event->get_all_enable($company_id);
			foreach($query->result() as $event){
				$this->check_formula_expression($event, $affect_device_id, $company_id);
			}			
		}
		private function check_formula_expression($event, $affect_device_id, $company_id){
			/*
			$event = new stdClass();
			$event->device_ids = '3^`^4';
			$event->operators = '>=^`^<=';
			$event->values = '10^`^14';
			$event->combines = 'AND';
			*/
			$device_ids = explode(SEPARATER_FORMULAR_VALUE, $event->device_ids);
			$operators = explode(SEPARATER_FORMULAR_VALUE, $event->operators);
			$values = explode(SEPARATER_FORMULAR_VALUE, $event->values);
			$combines = explode(SEPARATER_FORMULAR_VALUE, $event->combines);
			$length = count($device_ids);
			
			if (in_array($affect_device_id, $device_ids) === false){
				return;
			}
			
			$CI = &get_instance();
			$CI->load->model('measurement');
			$device_values = array();
			
			$result = true;
			$is_break = false;
			$all_values = array();
			for($i = 0; $i < $length; $i++){
				$current_value = $this->get_latest_value($device_values, $device_ids[$i]);
				$all_values[] = $current_value;
				if ($current_value === null){
					$is_break = true;
					$result = false;
				}
				if (!$is_break){
					if ($i == 0){
						//CHECKING IN THE FIRST TIME
						$result = $this->check_formular_value($current_value, $operators[$i], $values[$i]);
					}
					else{
						if ($result && $combines[$i - 1] == 'AND'){
							//CONTINUE CHECKING
							$result = $this->check_formular_value($current_value, $operators[$i], $values[$i]);
						}
						else if ($result && $combines[$i - 1] == 'OR'){
							$is_break = true;
							//SUCCESS CASE
							break;
						}
						else if (!$result && $combines[$i - 1] == 'AND'){
							$is_break = true;
							//FALSE CASE
							break;
						}
						else if (!$result && $combines[$i - 1] == 'OR'){
							//CONTINUE CHECKING
							$result = $this->check_formular_value($current_value, $operators[$i], $values[$i]);
						}
					}
				}
			}
			
			$alarm = new alarm();
			$alarm->name = 'Condition based';
			$alarm->device_id = $event->device_id;
			$alarm->formula = build_event_fomular($event, $company_id);
			$alarm->expression = build_event_expression($alarm->formula, $all_values);
			$alarm->event_id = $event->id;
			$alarm->company_id = $company_id;
			$alarm->is_on = 1;
			//ACTIVE OR DISABLE EVENT
			$this->alarm->active($alarm, $result);
			if ($result){
				//WRITE HISTORY
				$this->alarm_history->insert($alarm, $company_id);
			}
			return $result;
		}
		
		private function check_formular_value($current_value, $operator, $value){
			$result = false;
			//echo 'COMPARE: ' . $current_value . ' ' . $operator . ' ' . $value . '<br/>';
			if ($operator == '>'){
				$result = $current_value > $value;
			}
			else if ($operator == '>='){
				$result = $current_value >= $value;
			}
			else if ($operator == '<'){
				$result = $current_value < $value;
			}
			else if ($operator == '<='){
				$result = $current_value <= $value;
			}
			else if ($operator == '='){
				$result = $current_value == $value;
			}
			else if ($operator == '!='){
				$result = $current_value != $value;
			}
			return $result;
		}
		
		private function get_latest_value(&$device_values, $device_id){
			$value = null;
			foreach($device_values as $item){
				if ($item[0] == $device_id){
					$value = $item[1];
					break;
				}
			}
			if ($value === null){
				//GET LATEST VALUE
				$meas = $this->get_lastest_data($device_id)->row();
				$value = null;
				if ($meas){
					//var_dump($meas);
					$value = $meas->value;
				}
				$device_values[] = array($device_id, $value);
			}
			
			return $value;
		}
		
		function test(){
			$result = $this->check_formula_expression();
			echo 'VALUE: ' . ($result === false ? 'FALSE': 'true');
		}
		
		/***********************************************************************/
		/**************************** CHECKING FORMULAR *******************************/		
		/***********************************************************************/		
	}
?>