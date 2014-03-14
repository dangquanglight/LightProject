<?php
	function resize_image_upload($fileupload_name, $directory_path, $file_name, $fixed_width = 400, $fixed_height = 388, $is_mantain_ratio = true)
	{
		if (!is_dir($directory_path)){
			mkdir($directory_path);
		}
		$file_name_result = $file_name;
		if($_FILES[$fileupload_name]['type'] == "image/gif" || 
		$_FILES[$fileupload_name]['type'] == "image/pjpeg" || 
		$_FILES[$fileupload_name]['type'] == "image/jpg" || 
		$_FILES[$fileupload_name]['type'] == "image/jpeg" || 
		$_FILES[$fileupload_name]['type'] == "image/png")
		{			
			//move_uploaded_file($_FILES['tempimage1']['tmp_name'],$path.$tempimage1);
			$uid = uniqid();
			$fname = $uid . '_' . time();
			
			if($_FILES[$fileupload_name]['type'] == "image/gif") 
				$filetype = ".gif";
			else if ($_FILES[$fileupload_name]['type'] == "image/jpg" || $_FILES[$fileupload_name]['type'] == "image/jpeg")
				$filetype = ".jpg";
			else if ($_FILES[$fileupload_name]['type'] == "image/png")
				$filetype = ".png";
				
			$newupload = $_FILES[$fileupload_name]['tmp_name']; 
			if($filetype==".gif") 
				$src = imagecreatefromgif($newupload);
			else if($filetype==".jpg") 
				$src = imagecreatefromjpeg($newupload);
			else if($filetype==".png")
				$src = imagecreatefrompng($newupload);
			
			list($width,$height) = getimagesize($newupload);
			if ($width < $fixed_width && $height < $fixed_height){
				$path = $directory_path . $file_name_result;
				move_uploaded_file($_FILES[$fileupload_name]['tmp_name'],$path);
			}
			else{					
				if ($is_mantain_ratio){
					if($width > $fixed_width)
					{
						$newwidth = $fixed_width;
						$w= $width / $newwidth;
						$newheight = $height / $w;
					}
					else{
						$newwidth = $width;
						$newheight = $height;
					}
				}
				else{
					$newwidth = $fixed_width;
					$newheight = $fixed_height;
				}
					
				$tmp=imagecreatetruecolor($newwidth,$newheight);
				imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
				
				if (!$file_name_result)
				{
					$file_name_result = $fname . $filetype;
				}					
				$path = $directory_path . $file_name_result;
				
				if($filetype==".gif") 
					imagegif($tmp,$path,80);
				else if($filetype==".jpg") 
					imagejpeg($tmp,$path,80);
				else if($filetype==".png") 
					imagepng($tmp,$path,80);
					
				imagedestroy($src);
				imagedestroy($tmp);
			}
		}
		else{
			$file_name_result = null;
		}
		return $file_name_result;
	}
?>