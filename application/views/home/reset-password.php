<h1 class="form-title"><?php echo $this->lang->line('reset-password');?></h1>
<?php if ($data['data']){ ?>
	<form id="form-data" class='f-reset' method="post">	
		<?php echo show_saved_data($data['result'], $data['err_msg']); ?>		
		<div class="ib">
			<label class="text"><?php echo $this->lang->line('name');?></label><span class="req_empty"></span>
			<b><?php echo $data['data']->full_name; ?></b>
		</div>
		<div class="ib">
			<label class="text"><?php echo $this->lang->line('email');?></label><span class="req_empty"></span>
			<b><?php echo $data['data']->email; ?></b>
		</div>
		<div class="ib">
			<label class="text"><?php echo $this->lang->line('password');?></label><span class="required">*</span>
			<input type="password" id="password" name="password" class="text normal" value="" maxlength="15"/>		
		</div>
		<div class="ib">
			<label class="text"><?php echo $this->lang->line('confirm-password');?></label><span class="required">*</span>
			<input type="password" id="confirm_password" name="confirm_password" class="text normal" value="" maxlength="15"/>		
		</div>
		<div class="actions">			
			<input type="submit" name="save" value="<?php echo $this->lang->line('save');?>" class="btn btn-yellow"/>
			<a href="<?php echo base_url($controller_name . "edit-user/" . $data['id'] . "?" . get_url_navigate()); ?>" class="btn btn-yellow"><?php echo $this->lang->line('back-to-list');?></a>
		</div>
	</form>
	<script type="text/javascript">
		$("#form-data").validate({
			rules:{			
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
				password: {
					required: "<?php echo $this->lang->line('required_password');?>",
					minlength: "<?php echo $this->lang->line('required_password_length');?>"
				},
				confirm_password: {
					required: true,
					equalTo: "<?php echo $this->lang->line('required_pass_and_confirm_pass');?>"
				}
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long($this->lang->line('user'), $this->lang->line('users'));?></div>
<?php } ?>