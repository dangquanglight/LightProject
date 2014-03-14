<h1 class="form-title"><?php echo $this->lang->line('change-password');?></h1>
<?php echo show_saved_data($data['result'], $data['err_msg'], true); ?>	
<form id="form-data" class='f-change-password' method="post">		
	<div class="ib">
		<label class="text"><?php echo $this->lang->line('name');?></label><span class="req_empty"></span>
		<b><?php echo $data['data']->full_name; ?></b>		
	</div>
	<div class="ib">
		<label class="text"><?php echo $this->lang->line('email');?></label><span class="req_empty"></span>
		<b><?php echo $data['data']->email; ?></b>		
	</div>
	<div class="ib">
		<label class="text"><?php echo $this->lang->line('old-password');?><span class="required">*</span></label>
		<input type="password" id="old_password" name="old_password" class="text normal" value="" maxlength="15"/>		
	</div>
	<div class="ib">
		<label class="text"><?php echo $this->lang->line('password');?><span class="required">*</span></label>
		<input type="password" id="password" name="password" class="text normal" value="" maxlength="15"/>		
	</div>
	<div class="ib">
		<label class="text"><?php echo $this->lang->line('confirm-password');?><span class="required">*</span></label>
		<input type="password" id="confirm_password" name="confirm_password" class="text normal" value="" maxlength="15"/>		
	</div>
	<div class="actions">		
		<input type="submit" name="save" value="<?php echo $this->lang->line('save'); ?>" class="btn btn-yellow"/>
		<a href='<?php echo base_url('profile');?>' class='btn btn-yellow'><?php echo $this->lang->line('back-to-profile');?></a>
	</div>
</form>
<script type="text/javascript">
	$("#form-data").validate({
		rules:{	
			old_password: {
				required: true,
				minlength: 6
			},
			password: {
				required: true,
				minlength: 6
			},
			confirm_password: {
				required: true,
				equalTo: '#password'
			}
		},
		messages:{	
			old_password: {
				required: "<?php echo $this->lang->line('required-old-password');?>",
				minlength: "<?php echo $this->lang->line('required-password-length');?>"
			},
			password: {
				required: "<?php echo $this->lang->line('required-password');?>",
				minlength: "<?php echo $this->lang->line('required-password-length');?>"
			},
			confirm_password: {
				required: "<?php echo $this->lang->line('required-confirm-password');?>",
				equalTo: "<?php echo $this->lang->line('required-pass-and-confirm-pass');?>"
			}
		}
	});
</script>