<?php
	#LINUX
	define('COMPANIES_DIR', '/home/vsftpd/');
	define('COMPANIES_TEMP', '/home/vsftpd/temp/');
	#WINDOWS
	//define('COMPANIES_DIR', 'C:/inetpub/wwwroot/ftp/');
	//define('COMPANIES_TEMP', 'C:/inetpub/wwwroot/ftp/temp/');
	
	//IMPORT DATABASE CONFIGURATION	
	
	//CHECK CREATE TEMP DIR
	if (!is_dir(COMPANIES_TEMP)){
		mkdir(COMPANIES_TEMP);
	}
	
	$scan = new Scanning();
	$scan->start();
	
	class Scanning{
		//DEFAULT FILE INPUT NAME
		private $in_file_name = 'in.txt';
		
		function start(){
			//SCANNING IN 1 MINUTE
			$time_start = time();
			$time_end = $time_start + 60;	
			while($time_start < $time_end){		
				$this->scan(COMPANIES_DIR, COMPANIES_TEMP);		
				//SLEEP 0.5 second TO RELEASE CPU FOR ANOTHER PROGRAM
				//time_nanosleep(0, 500000000);
				sleep(1);
				$time_start = time();
			}
		}
		
		private function scan($companies_dir, $temp_dir){
			$hwd_companies_dir = opendir($companies_dir);
			//FETCH ALL DIR INSIDE
			while(false !== ($company_name = readdir($hwd_companies_dir))){
				$company_dir = $companies_dir . '/' . $company_name;
				//CHECK NAME OF DIR IS COMPANY ID (NUMBER)
				if ($company_name != '.' && $company_name != '..' && $company_name != 'temp' && is_dir($company_dir)){
					//MOVE FILE
					$file_path = $company_dir . '/in.txt';
					if (is_file($file_path)){
						//COPY FILE
						copy($file_path, $temp_dir . $company_name . '-' . time() . '-' .$this->in_file_name);
						//DELETE FILE AFTER COPY
						unlink($file_path);
					}
				}
			}
			closedir($hwd_companies_dir);
		}
	}
?>