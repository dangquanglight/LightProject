<?php
	#LINUX
	define('COMPANIES_TEMP', '/home/vsftpd/temp/');
	#WINDOWS
	//define('COMPANIES_TEMP', 'C:/inetpub/wwwroot/ftp/temp/');
	
	//IMPORT DATABASE CONFIGURATION	
	
	//CHECK CREATE TEMP DIR
	if (!is_dir(COMPANIES_TEMP)){
		mkdir();
	}
	
	$scan = new Scanning();
	$scan->start();
	
	class Scanning{
		//DEFAULT FILE INPUT NAME
		private $in_file_name = 'in.txt';
		private $conn = null;
		function Scanning(){
			$this->conn = mysql_connect('localhost', 'root', 'testabc123') or die();
			mysql_select_db('mos');
		}
		
		function start(){
			//SCANNING IN 1 MINUTE
			$time_start = time();
			$time_end = $time_start + 60;
			//$index = 1;
			while($time_start < $time_end){		
				$this->scan(COMPANIES_TEMP);		
				//SLEEP 0.5 second TO RELEASE CPU FOR ANOTHER PROGRAM				
				//time_nanosleep(0, 500000000);
				sleep(1);
				$time_start = time();
			}
		}
		
		function scan($temp_dir){
			$hwd_temp_dir = opendir($temp_dir);
			//FETCH ALL DIR INSIDE
			while(false !== ($file_name = readdir($hwd_temp_dir))){
				if ($file_name != '.' && $file_name != '..'){
					$file_path = $temp_dir . '/' . $file_name;
					$ar_file_name = explode('-', $file_name);
					//[ftp user name - timestamp - in.txt]				
					if (count($ar_file_name) == 3){
						$ftp_user_name = $ar_file_name[0];
						$company = $this->get_company_by_ftp($ftp_user_name);
						//CHECK COMPANY EXISTED
						if ($company){
							//READ CONTENT IN FILE
							$lines = file($file_path);
							if ($lines && count($lines) > 0){
								foreach($lines as $line){
									$ar_data = explode(',', $line);
									if (count($ar_data) == 3){
										//GET INFO FROM LINE IN FILE [device tag (name), date time, value]
										$device_tag = trim($ar_data[0]);							
										$datetime = trim($ar_data[1]);
										$value = trim($ar_data[2]);
										$this->insert($company['company_id'], $device_tag, $datetime, $value);
									}
								}
							}
						}
					}
					unlink($file_path);
				}
			}
			closedir($hwd_temp_dir);
		}
		
		function insert($company_id, $device_tag, $datetime, $value){
			//FIND DEVICE INFO
			$device = $this->get_device_id($company_id, $device_tag);
			if ($device){
				//CHECK THIS MEASUREMENT WHETHER EXISTED
				$old_meas = $this->get_measurement_by_date($device['id'], $datetime);
				$sql = "";
				if ($old_meas){
					//UPDATE CASE
					$sql = sprintf("UPDATE measurements SET value = '%s' WHERE device_id = '%s' AND datetime = '%s'", $this->escape($value), $device['id'], $this->escape($datetime));
				}
				else{
					//INSERT CASE
					$sql = sprintf("INSERT INTO measurements SET value = '%s', device_id = '%s', datetime = '%s', created_date = now()", $this->escape($value), $device['id'], $this->escape($datetime));
				}
				mysql_query($sql);
			}
		}
		
		function get_company_by_ftp($ftp_name){
			$sql = sprintf("SELECT * FROM ftp_users WHERE user_name = '%s'", $this->escape($ftp_name));
			$company = mysql_fetch_array(mysql_query($sql));			
			return $company;
		}
		
		function get_measurement_by_date($device_id, $datetime){
			$sql = sprintf("SELECT * FROM measurements WHERE device_id = '%s' AND datetime = '%s'", $this->escape($device_id), $this->escape($datetime));
			$data = mysql_fetch_array(mysql_query($sql));
			return $data;
		}
		
		function get_device_id($company_id, $device_tag){
			$sql = sprintf("SELECT * FROM devices WHERE device_name = '%s' AND company_id = '%s'", $this->escape($device_tag), $this->escape($company_id));			
			$data = mysql_fetch_array(mysql_query($sql));
			return $data;
		}
		
		function escape($text){
			return str_replace("'", "''", $text);
		}
		
		function __destruct(){
			if ($this->conn){
				mysql_close($this->conn);
			}
		}
	}
?>