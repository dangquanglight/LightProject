<h1 class="form-title"><?php echo $this->lang->line('email-config');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
	<form id="form-data" class="f-sms-config" method="post">				
		<div class="input-box">
			<label class="text" for='email'><?php echo $this->lang->line('email');?><span class='required'>*</span></label>
			<input id="email" name="email" type="text" value="<?php echo htmlspecialchars($data['data']->email); ?>" class="normal short"/>
		</div>
		<div class="input-box">
			<label class="text" for='smtp_user'><?php echo $this->lang->line('user-name');?><span class='required'>*</span></label>
			<input id="smtp_user" name="smtp_user" type="text" value="<?php echo htmlspecialchars($data['data']->smtp_user); ?>" class="normal short"/>
		</div>
		<div class="input-box">
			<label class="text" for='smtp_pass'><?php echo $this->lang->line('password');?><span class='required'>*</span></label>
			<input id="smtp_pass" name="smtp_pass" type="password" value="<?php echo htmlspecialchars($data['data']->smtp_pass); ?>" class="normal short"/>
		</div>
		<div class="input-box">
			<label class="text" for='email_name'><?php echo $this->lang->line('email-name');?></label>
			<input id="email_name" name="email_name" type="text" value="<?php echo htmlspecialchars($data['data']->email_name); ?>" class="normal short"/>
		</div>
		<div class="input-box">
			<label class="text" for='smtp_host'><?php echo $this->lang->line('smtp-server');?><span class='required'>*</span></label>
			<input id="smtp_host" name="smtp_host" type="text" value="<?php echo htmlspecialchars($data['data']->smtp_host); ?>" class="normal short"/>
		</div>
		<div class="input-box">
			<label class="text" for='smtp_port'><?php echo $this->lang->line('port');?><span class='required'>*</span></label>
			<input id="smtp_port" name="smtp_port" type="text" value="<?php echo htmlspecialchars($data['data']->smtp_port); ?>" class="normal short"/>
		</div>
		<div class="input-box">
			<label class="text" for='smtp'><?php echo $this->lang->line('smtp');?></label>
			<input id="is_smtp" name="is_smtp" type="checkbox" value="1" <?php echo $data['data']->is_smtp ? "checked" : ""; ?>/>
		</div>
		<div class="input-box">
			<label class="text" for='is_ssl'><?php echo $this->lang->line('ssl');?></label>
			<input id="is_ssl" name="is_ssl" type="checkbox" value="1" <?php echo $data['data']->is_ssl ? "checked" : ""; ?>/>
		</div>		
		<div class="actions">
			<input type="submit" class="btn btn-yellow" value="<?php echo $this->lang->line('save'); ?>"/>
		</div>
	</form>
	<script type="text/javascript">
		$('#form-data').validate({
			rules: {				
				email: {
					required: true,
					email: true
				},
				smtp_host: "required",
				smtp_user: "required",
				smtp_pass: "required",
				smtp_port: "required"
			},
			messages: {		
				email: {
					required: "<?php echo $this->lang->line('required-email'); ?>",
					email: "<?php echo $this->lang->line('required-valid-email'); ?>"
				},
				smtp_host: "<?php echo $this->lang->line('required-smtp-host'); ?>",
				smtp_user: "<?php echo $this->lang->line('required-username'); ?>",
				smtp_pass: "<?php echo $this->lang->line('required-password'); ?>",
				smtp_port: "<?php echo $this->lang->line('required-smtp-port'); ?>"
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('email-config', $this->lang->line('email-config'));?></div>
<?php } ?>