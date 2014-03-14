<h1 class="form-title"><?php echo $this->lang->line('user');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>	
	<form id="form-data" class='f-user' method="post">	
		<div class="ib">
			<label class="text" for="first_name"><?php echo $this->lang->line('first-name');?><span class="required">*</span></label>
			<input type="textbox" id="first_name" name="first_name" class="normal" value="<?php echo htmlspecialchars($data['data']->first_name); ?>"/>		
		</div>
		<div class="ib">
			<label class="text" for="last_name"><?php echo $this->lang->line('last-name');?></label>
			<input type="textbox" id="last_name" name="last_name" class="normal" value="<?php echo htmlspecialchars($data['data']->last_name); ?>"/>		
		</div>
		<div class="ib">
			<label class="text" for="email"><?php echo $this->lang->line('email');?><span class="required">*</span></label>
			<?php if (!$data['id']){ ?>	
				<input type="textbox" id="email" name="email" class="normal" value="<?php echo htmlspecialchars($data['data']->email); ?>"/>			
			<?php } else { ?>
				<b><?php echo htmlspecialchars($data['data']->email); ?></b>
				<input type="hidden" id="email" name="email" value="<?php echo htmlspecialchars($data['data']->email); ?>"/>
			<?php } ?>
		</div>
		<?php if (!$data['id']){ ?>	
		<div class="m-bottom-6">
			<label class="text"><?php echo $this->lang->line('password');?><span class="required">*</span></label>
			<input type="password" id="password" name="password" class="text normal" value="" maxlength="15"/>		
		</div>
		<div class="m-bottom-6">
			<label class="text"><?php echo $this->lang->line('confirm-password');?><span class="required">*</span></label>
			<input type="password" id="confirm_password" name="confirm_password" class="text normal" value="" maxlength="15"/>		
		</div>
		<?php } ?>	
		<div class="ib">
			<label class="text"><?php echo $this->lang->line('phone');?></label>
			<input type="text" id="phone" name="phone" class="text normal" value="<?php echo htmlspecialchars($data['data']->phone); ?>"/>		
		</div>
		<div class="ib">
			<label class="text"><?php echo $this->lang->line('address');?></label>
			<input type="text" id="address" name="address" class="text normal" value="<?php echo htmlspecialchars($data['data']->address); ?>"/>		
		</div>
		<div class="ib">
			<label class="text" for="status"><?php echo $this->lang->line('role');?><span class="required">*</span></label>
			<select id="role_id" name="role_id" class="normal">
				<option value=""><?php echo $this->lang->line('please-select');?></option>				
				<?php foreach($data['roles']->result() as $row){ 
					echo "<option value='" . $row->id . "' " . ($row->id == $data['data']->role_id ? 'selected' : '') . ">" . htmlspecialchars($row->role_name) . "</option>";
				} ?>
			</select>
		</div>
		<div class="ib">
			<label class="text" for="activated"><?php echo $this->lang->line('activated');?></label>
			<select id="activated" name="activated" class="normal">
				<option value="1" <?php echo $data['data']->activated == 1 ? "selected" : ""; ?>><?php echo $this->lang->line('yes');?></option>
				<option value="0" <?php echo $data['data']->activated == 0 ? "selected" : ""; ?>><?php echo $this->lang->line('no');?></option>
			</select>
		</div>
		<div class="ib">
			<label class="text" for="status"><?php echo $this->lang->line('status');?></label>
			<select id="status" name="status" class="normal">
				<option value="1" <?php echo $data['data']->status == 1 ? "selected" : ""; ?>><?php echo $this->lang->line('enabled');?></option>
				<option value="0" <?php echo $data['data']->status == 0 ? "selected" : ""; ?>><?php echo $this->lang->line('disabled');?></option>
			</select>
		</div>
		<div class="actions">						
			<input type="submit" name="save" value="<?php echo $this->lang->line('save'); ?>" class="btn btn-yellow"/>						
			<?php if ($data['id']){ ?>
				<a href="<?php echo base_url("reset-password/" . $data['id'] . "?" . get_url_navigate()); ?>" class="btn btn-yellow"><?php echo $this->lang->line('reset-password');?></a>
			<?php } else { ?>
				<input name="save_and_continue" type="submit" class="btn btn-yellow" value="<?php echo $this->lang->line('save-and-continue');?>"/>
			<?php } ?>
			<a class="btn btn-yellow" href="<?php echo $data['back-url'];?>"><?php echo $this->lang->line('back-to-list');?></a>
		</div>
	</form>
	<script type="text/javascript">
		$("#form-data").validate({
			rules:{
				first_name: "required",
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 6
				},
				confirm_password: {
					required: true,
					equalTo: '#password'
				},
				role_id: 'required'
			},
			messages:{
				first_name: "<?php echo $this->lang->line('required-first-name');?>",
				email: {
					required: '<?php echo $this->lang->line('required-email');?>',
					email: '<?php echo $this->lang->line('required-valid-email');?>'
				},
				password: {
					required: "<?php echo $this->lang->line('required-password');?>",
					minlength: "<?php echo $this->lang->line('required-password-length');?>"
				},
				confirm_password: {
					required: "<?php echo $this->lang->line('required-confirm-password');?>",
					equalTo: "<?php echo $this->lang->line('required-pass-and-confirm-pass');?>"
				},
				role_id: "<?php echo $this->lang->line('required-select-role');?>"
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long($this->lang->line('user'), $this->lang->line('users'));?></div>
<?php } ?>