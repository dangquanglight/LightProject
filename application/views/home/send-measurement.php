<h1 class="form-title"><?php echo $this->lang->line('send-measurement');?></h1>
<?php echo show_errors(); ?>
<form id="form-data" class="f-send-measurement" method="post">		
	<div class="input-box">
		<label class="text"><?php echo $this->lang->line('device');?><span class='required'>*</span></label>
		<select id='device_id' name='device_id' class='normal'>
			<option value=''><?php echo htmlspecialchars($this->lang->line('please-select'));?></option>
		<?php foreach($data['devices']->result() as $row) { ?>								
			<option value='<?php echo $row->id;?>' <?php echo $data['device_id'] == $row->id ? 'selected' : '';?>><?php echo htmlspecialchars($row->device_name);?></option>
		<?php } ?>
		</select>
	</div>
	<div class='ib'>
		<label class="text"><?php echo $this->lang->line('value');?><span class='required'>*</span></label>
		<input type='text' id='value' name='value' class='normal'/>
	</div>
	<div class='tr'>
		<input type='submit' class='btn-yellow' value='<?php echo $this->lang->line('send');?>'/>
		<a href="<?php echo base_url('measurements');?>" class='btn btn-yellow'><?php echo $this->lang->line('back-to-measurements');?></a>
	</div>
</div>
<script type='text/javascript'>
	$('#form-data').validate({
		rules: {
			device_id: 'required',
			value: 'required'
		},
		messages: {
			device_id: '',
			value: ''
		}
	});
</script>