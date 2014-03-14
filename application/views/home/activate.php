<h1 class='form-title'><?php echo $this->lang->line('activate');?></h1>
<div class='<?php echo $data['status'] == 0 ? 'validation-summary-success' : 'validation-summary-errors';?>'>
	<span>
	<?php if ($data['status'] == 1){ 
		echo $this->lang->line('activate-already');
	} else if ($data['status'] == 2){ 
		echo $this->lang->line('activate-not-found');
	} else if ($data['status'] == 0) { 
		echo sprintf($this->lang->line('activate-completed'), '<b id="seconds">10</b>');		
	} ?>
	</span>
</div>
<?php if ($data['status'] == 0){ ?>
	<script type='text/javascript'>
		$(function(){
			var seconds = 10;
			var key = setInterval(function(){
				seconds--;
				$('#seconds').text(seconds);				
				if (seconds <= 0){					
					window.location = base_url;
					clearInterval(key);
				}
			}, 1000);
		});
	</script>
<?php } ?>