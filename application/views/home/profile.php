<h1 class="form-title"><?php echo $this->lang->line('profile');?></h1>
<form id="form-data" class='f-profile' method="post">	
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>	
	<div class="input-box">
		<label class="text"><?php echo $this->lang->line('first-name');?><span class="required">*</span></label>
		<input type="text" id="first_name" name="first_name" class="text normal" value="<?php echo htmlspecialchars($data['data']->first_name); ?>"/>		
	</div>
	<div class="input-box">
		<label class="text"><?php echo $this->lang->line('last-name');?></label>
		<input type="text" id="last_name" name="last_name" class="text normal" value="<?php echo htmlspecialchars($data['data']->last_name); ?>"/>		
	</div>
	<div class="input-box">
		<label class="text"><?php echo $this->lang->line('email');?></label>
		<b><?php echo htmlspecialchars($data['data']->email); ?></b>
	</div>
	<div class="input-box">
		<label class="text"><?php echo $this->lang->line('phone'); ?></label>
		<input type="text" id="phone" name="phone" class="text normal" value="<?php echo htmlspecialchars($data['data']->phone); ?>"/>		
	</div>
	<div class="input-box">
		<label class="text"><?php echo $this->lang->line('address'); ?></label>
		<input type="text" id="address" name="address" class="text normal" value="<?php echo htmlspecialchars($data['data']->address); ?>"/>		
	</div>	
	<div class="input-box actions">
		<input type="submit" name="submit" value="<?php echo $this->lang->line('save');?>" class="btn btn-yellow"/>
		<a class='btn btn-yellow' href='<?php echo base_url('change-password');?>'><?php echo $this->lang->line('change-password');?></a>
	</div>
</form>
<script type="text/javascript">
	$("#form-data").validate({
		rules:{
			first_name: "required"
		},
		messages:{
			name: "<?php echo $this->lang->line('required-first-name');?>"
		}
	});
</script>