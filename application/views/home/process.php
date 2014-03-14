<h1 class='form-title'><?php echo $this->lang->line('process');?></h1>
<form method="post">
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>	
	<div class='mb12'>
		<label><?php echo $this->lang->line('processing-type');?></label>
		<label class='mr12'><input type='radio' name='processing_type' value='0' <?php echo $this->input->post('processing_type') == 0 ? 'checked' : ''; ?>/> <?php echo $this->lang->line('processing-db');?></label>
		<label><input type='radio' name='processing_type' value='1' <?php echo $this->input->post('processing_type') == 1 ? 'checked' : ''; ?>/> <?php echo $this->lang->line('processing-sms');?></label>
	</div>
	<div class='mb12'>
		<label><input type='checkbox' id='overwrite' name='overwrite' value='1' <?php echo $this->input->post('overwrite') == 1 ? 'checked' : ''; ?>/> <?php echo $this->lang->line('overwrite-sms'); ?>
	</div>
	<div class='mb12'>
		<label><input type='checkbox' id='raise_alarm' name='raise_alarm' value='1' <?php echo $this->input->post('raise_alarm') == 1 ? 'checked' : ''; ?>/> <?php echo $this->lang->line('raise-alarm'); ?>
	</div>
	<input id='start-process' name='process' class='btn btn-yellow' type='submit' value='<?php echo htmlspecialchars($this->lang->line('start'));?>'/>
</form>
<div id='processing' class='hidden'><img src='<?php echo base_url('images/ajax-loader.gif'); ?>' alt='' align='absmiddle'/> <?php echo $this->lang->line('processing-please-wait');?></div>
<script type='text/javascript'>
	$(function(){
		$('#start-process').click(function(){			
			var processing = $('#processing');
			set_center_screen(processing);
			processing.show();
			setTimeout(function(){
				$('#start-process').attr('disabled', true);
			}, 100);
		});
	});
</script>
<?php if (is_post()){ ?>
<script type='text/javascript'>
	$(function(){
		$('#more-details').click(function(){
			if ($(this).attr('details') == "true"){
				$('#more-details-data').slideUp();
				$(this).attr('details', "false").text('<?php echo $this->lang->line('more-details'); ?>');
			}
			else{
				$('#more-details-data').slideDown();
				$(this).attr('details', "true").text('<?php echo $this->lang->line('hide-details'); ?>');
			}
		});
	});
</script>
<?php } ?>