<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
<form id='login' method='post'>
	<h2><?php echo $this->lang->line('login');?></h2>	
	<div class='inner ib'>		
		<div class='ib'>
			<label class='text ib' for='email'><?php echo $this->lang->line('email');?></label><input id='email' name='email' type='text' class='normal' placeholder='<?php echo $this->lang->line('email');?>' value="<?php echo htmlspecialchars($this->input->post('email'));?>"/>
		</div>
		<div class='ib'>
			<label class='text ib' for='password'><?php echo $this->lang->line('password');?></label><input id='password' name='password' type='password' class='normal' placeholder='<?php echo $this->lang->line('password');?>'/>
		</div>
		<div class='ib'>
			<label class='text ib left' for='remember'><input id='remember' name='remember' type='checkbox'/> <?php echo $this->lang->line('remember-me');?></label>
			<input type='submit' value='<?php echo $this->lang->line('login');?>' class='btn btn-yellow right'/>
			<div class='clear'></div>
		</div>		
	</div>
	<div class='tc'><?php
		if ($setting->enable_register){ ?>
		<a href='<?php echo base_url('register');?>'><?php echo $this->lang->line('register');?></a> | <?php } ?>
		<a href='<?php echo base_url('forgot-password');?>'><?php echo $this->lang->line('forgot-password');?></a></div>
</form>
<script type='text/javascript'>
	$('#login').validate({
		rules:{
			email: {
				required: true,
				email: true
			},
			password: true
		},
		messages:{
			email: '',
			password: ''
		}
	});
</script>