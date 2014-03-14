<h1 class='form-title'><?php echo $this->lang->line("register");?></h1>
<?php //echo show_saved_data($data['result'], $data['err_msg']); ?>
<?php show_errors(); ?>
<form id='f-register' class='f-input' method='post'>
	<div>
		<div class='acc-info left'>
			<div class='lb'>
				<h3><?php echo $this->lang->line("your-account-information");?></h3>
			</div>
			<div class='ib'>
				<label class='text' for='first_name'><?php echo $this->lang->line("first-name");?><span class='required'>*</span></label>
				<input type='text' id='first_name' name='first_name' class='normal <?php echo input_has_error('first_name');?>' value="<?php echo htmlspecialchars($data['data']->first_name);?>"/>
			</div>
			<div class='ib'>
				<label class='text' for='last_name'><?php echo $this->lang->line("last-name");?></label>
				<input type='text' id='last_name' name='last_name' class='normal' value="<?php echo htmlspecialchars($data['data']->last_name);?>"/>
			</div>
			<div class='ib'>
				<label class='text' for='email'><?php echo $this->lang->line("email");?><span class='required'>*</span></label>
				<input type='text' id='email' name='email' class='normal <?php echo input_has_error('email');?>' value="<?php echo htmlspecialchars($data['data']->email);?>"/>
			</div>
			<div class='ib'>
				<label class='text' for='password'><?php echo $this->lang->line("password");?><span class='required'>*</span></label>
				<input type='password' id='password' name='password' class='normal <?php echo input_has_error('password');?>' value=""/>
			</div>
			<div class='ib'>
				<label class='text' for='confirm_password'><?php echo $this->lang->line("confirm-password");?><span class='required'>*</span></label>
				<input type='password' id='confirm_password' name='confirm_password' class='normal <?php echo input_has_error('confirm_password');?>' value=""/>
			</div>
			<div class='ib'>
				<label class='text' for='phone'><?php echo $this->lang->line("phone");?></label>
				<input type='text' id='phone' name='phone' class='normal' value="<?php echo htmlspecialchars($data['data']->phone);?>"/>
			</div>
		</div>
		<div class='company-info right'>
			<div class='lb'>
				<h3><?php echo $this->lang->line("your-company-information");?></h3>
			</div>
			<div class='ib'>
				<label class='text' for='company_name'><?php echo $this->lang->line("company-name");?><span class='required'>*</span></label>
				<input type='text' id='company_name' name='company_name' class='normal <?php echo input_has_error('company_name');?>' value="<?php echo htmlspecialchars($data['data']->company_name);?>"/>
			</div>
			<div class='ib'>
				<label class='text vtop' for='company_description'><?php echo $this->lang->line("description");?></label>
				<textarea id='company_description' name='company_description' class='normal'><?php echo htmlspecialchars($data['data']->company_description);?></textarea>
			</div>
		</div>		
		<div class='clear'></div>
	</div>
	<div>
		<div class='ftp-info left'>
			<div class='lb'>
				<h3><?php echo $this->lang->line("ftp-information");?></h3>
			</div>
			<div class='ib'>
				<label class='text' for='ftp_user_name'><?php echo $this->lang->line("user-name");?><span class='required'>*</span></label>
				<input type='text' id='ftp_user_name' name='ftp_user_name' class='normal <?php echo input_has_error('ftp_user_name');?>' value="<?php echo htmlspecialchars($data['data']->ftp_user_name);?>"/>
			</div>
			<div class='ib'>
				<label class='text' for='ftp_password'><?php echo $this->lang->line("password");?><span class='required'>*</span></label>
				<input type='password' id='ftp_password' name='ftp_password' class='normal <?php echo input_has_error('password');?>' value=""/>
			</div>
			<div class='ib'>
				<label class='text' for='ftp_confirm_password'><?php echo $this->lang->line("confirm-password");?><span class='required'>*</span></label>
				<input type='password' id='ftp_confirm_password' name='ftp_confirm_password' class='normal <?php echo input_has_error('ftp_confirm_password');?>' value=""/>
			</div>
		</div>
		<div class='clear'></div>
	</div>
	<div class='actions'>
		<input type="submit" value="<?php echo $this->lang->line("submit");?>" class='btn btn-yellow' />
		<a href='login' class='btn btn-yellow'><?php echo $this->lang->line('login');?></a>
	</div>
</form>
<script type="text/javascript">
    $(function () {
        $('#f-register').validate({
            rules: {
                first_name: 'required'
                ,email: {
                    required: true
                    ,email: true
                }
                ,password: {
					required: true
					,minlength: 6
				}				
                ,confirm_password: {
                    required: true,
                    equalTo: '#password'
                }
                ,company_name: 'required'				
				,ftp_user_name: {
					required: true,
					minlength: 6,
					required_user_name: true
				}
				,ftp_password: {
					required: true,
					minlength: 6
				}
                ,ftp_confirm_password: {
                    required: true,
                    equalTo: '#ftp_password'
                }
            },
            messages: {
                first_name: "<?php echo $this->lang->line("required-first-name");?>"
                ,email: {
                    required: "<?php echo $this->lang->line("required-email");?>",
                    email: "<?php echo $this->lang->line("required-valid-email");?>"
                }
				,password: {
					required: "<?php echo $this->lang->line("required-password");?>",
					minlength: "<?php echo $this->lang->line("required-password-length");?>"
				}
                ,user_email: {
					required: "<?php echo $this->lang->line("required-password");?>",
					minlength: "<?php echo $this->lang->line("required-password-length");?>"
				}
                ,confirm_password: {
                    required: "<?php echo $this->lang->line("required-confirm-password");?>",
                    equalTo: "<?php echo $this->lang->line("required-pass-and-confirm-pass");?>"
                }
				
                ,company_name: "<?php echo $this->lang->line("required-company-name");?>"
				,ftp_user_name: {
					required: "<?php echo $this->lang->line("required-ftp-user-name");?>",
					minlength: "<?php echo $this->lang->line("min-length-ftp-user-name");?>",
					required_user_name: "<?php echo $this->lang->line("require-valid-user-name");?>"
				}
				,ftp_password: {
					required: "<?php echo $this->lang->line("required-password");?>",
					minlength: "<?php echo $this->lang->line("required-password-length");?>"
				}
                ,ftp_confirm_password: {
                    required: "<?php echo $this->lang->line("required-confirm-password");?>",
                    equalTo: "<?php echo $this->lang->line("required-pass-and-confirm-pass");?>"
                }
            }
        });
    });
</script>
