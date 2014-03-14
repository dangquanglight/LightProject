<h1 class='form-title'><?php echo $this->lang->line('import-measurements');?></h1>
<form id='form-data' method='post' enctype='multipart/form-data'>
	<?php echo show_errors(); ?>
	<label><?php echo $this->lang->line('file-measurement-import'); ?> <input type='file' id='file' name='file'/></label>
	<input type='submit' name='submit' value='Upload'/>
</form>
<a class='u' href='<?php echo base_url('uploads/templates/Measurements.xlsx');?>'><?php echo $this->lang->line('download-template');?></a>
<div id='message-import'>
	<div class='overlay'></div>
	<div class='wrap'>
		<h1 class='msg form-title'><?php echo $this->lang->line('message-measurement-import');?></h1>
	</div>
</div>
<script type='text/javascript'>
	$(function(){
		$('#details').click(function(){
			var item = $('#' + $(this).attr('ref'));
			if (item.attr('status') == 1){
				item.attr('status', 0).slideUp();
				$(this).text("<?php echo $this->lang->line('more-details'); ?>");
			}
			else{
				item.attr('status', 1).slideDown();
				$(this).text("<?php echo $this->lang->line('hide-details'); ?>");
			}
		});
		$('#form-data').submit(function(){
			$('#message-import').appendTo('body').show();
		});
	});
</script>