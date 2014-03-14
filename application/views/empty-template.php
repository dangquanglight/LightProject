<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title><?php echo $page_title;?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url("css/admin.css"); ?>"/>				
		<script type="text/javascript" src="<?php echo base_url("js/jquery-1.8.3.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.9.2.custom.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("js/jquery.validate.js"); ?>"></script>
		<script type="text/javascript">var base_url = '<?php echo base_url(); ?>';var controller_name = '<?php echo $controller_name; ?>';</script>	
	</head>
	<body>
		<div class='wrapper'>
			<div id="header">							
				<?php include APPPATH . "views/" . $file_name; ?>								
			</div>
		</div>
		<img id='loading' class='hidden' src='<?php echo base_url('images/ajax-loader.gif');?>'/>
	</body>
</html>