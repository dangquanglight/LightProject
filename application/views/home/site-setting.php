<link type="text/css" rel="stylesheet" href="<?php echo base_url("css/jquery.colorpicker.css"); ?>"/>
<script type="text/javascript" src="<?php echo base_url("js/jquery.colorpicker.js"); ?>"></script>
<h1 class="form-title"><?php echo $this->lang->line('site-setting');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_errors(); ?>
	<form id="form-data" class="f-site-setting" method="post" enctype='multipart/form-data'>				
		<div class="separate-bar <?php echo $data['website-config-status'] ? 'maximize' : 'minimize';?>" ref='website-config'><?php echo $this->lang->line('website-config');?></div>
		<div id='website-config' style='<?php echo !$data['website-config-status'] ? 'display:none' : '';?>'>
			<div class="ib">
				<label class="text" for='enable_register'><?php echo $this->lang->line('enable-register');?></label>
				<label><input id="enable_register" name="enable_register" type="radio" value="1" <?php echo $data['data']->enable_register ? "checked" : ""; ?>/> <?php echo $this->lang->line('yes');?></label>
				<label><input name="enable_register" type="radio" value="0" <?php echo !$data['data']->enable_register ? "checked" : ""; ?>/> <?php echo $this->lang->line('no');?></label>
			</div>
			<input type='hidden' name='website-config-status' class='open-status' value='<?php echo $data['website-config-status'];?>'/>
		</div>
		<div class="separate-bar <?php echo $data['appearence-status'] ? 'maximize' : 'minimize';?>" ref='appearence'><?php echo $this->lang->line('appearance');?></div>
		<div id='appearence' style='<?php echo !$data['appearence-status'] ? 'display:none' : '';?>'>
			<div class="ib">
				<label class="text" for='page_width'><?php echo $this->lang->line('page-width');?></label>
				<input id="page_width" name="page_width" type="text" value="<?php echo htmlspecialchars($data['data']->page_width); ?>" class="normal mr8"/>
				<span class='tips'><?php echo $this->lang->line('page-width-tips');?></span>
			</div>
			<div class="ib relative">
				<label class="text" for='border_color'><?php echo $this->lang->line('border-color');?></label>
				<input id="border_color" name="border_color" type="text" value="<?php echo htmlspecialchars($data['data']->border_color); ?>" class="normal mr8"/>
			</div>
			<div class="ib">
				<label class="text" for='border_type'><?php echo $this->lang->line('border-type');?></label>
				<select id='border_type' name='border_type' class='normal'>
					<option value='solid' <?php echo $data['data']->border_type == 'solid' ? 'selected' : '';?>>Solid</option>
					<option value='dotted' <?php echo $data['data']->border_type == 'dotted' ? 'selected' : '';?>>Dotted</option>
					<option value='dashed' <?php echo $data['data']->border_type == 'dashed' ? 'selected' : '';?>>Dashed</option>
					<option value='groove' <?php echo $data['data']->border_type == 'groove' ? 'selected' : '';?>>Groove</option>
					<option value='ridge' <?php echo $data['data']->border_type == 'ridge' ? 'selected' : '';?>>Ridge</option>
					<option value='inset' <?php echo $data['data']->border_type == 'inset' ? 'selected' : '';?>>Inset</option>
					<option value='outset' <?php echo $data['data']->border_type == 'outset' ? 'selected' : '';?>>Outset</option>
				</select>			
			</div>
			<div class="ib">
				<label class="text" for='border_width'><?php echo $this->lang->line('border-width');?></label>
				<input id="border_width" name="border_width" type="text" value="<?php echo htmlspecialchars($data['data']->border_width); ?>" class="normal mr8"/>
				<span class='tips'><?php echo $this->lang->line('px-unit-tips');?></span>
			</div>
			<div class="ib">
				<label class="text" for='enable_border'><?php echo $this->lang->line('enable-border');?></label>
				<label><input id="enable_border" name="enable_border" type="radio" value="1" <?php echo $data['data']->enable_border ? "checked" : ""; ?>/> <?php echo $this->lang->line('yes');?></label>
				<label><input name="enable_border" type="radio" value="0" <?php echo !$data['data']->enable_border ? "checked" : ""; ?>/> <?php echo $this->lang->line('no');?></label>			
			</div>
			<div class="ib relative">
				<label class="text" for='bg_color'><?php echo $this->lang->line('bg-color');?></label>
				<input id="bg_color" name="bg_color" type="text" value="<?php echo htmlspecialchars($data['data']->bg_color); ?>" class="normal mr8"/>
			</div>
			<div class="ib">
				<label class="text" for='bg_image'><?php echo $this->lang->line('bg-image');?></label>
				<input id="bg_image" name="bg_image" type="file"/>
			</div>
			<div class="ib">
				<label class="text" for='bg_repeat_x_y'><?php echo $this->lang->line('bg-repeat');?></label>
				<label class='mr12'><input id='bg_repeat_x_y' name="bg_repeat" type="radio" value="0" <?php echo $data['data']->bg_repeat == 0 ? "checked" : ""; ?>/> <?php echo $this->lang->line('bg-repeat-x-y');?></label>
				<label class='mr12'><input name="bg_repeat" type="radio" value="1" <?php echo $data['data']->bg_repeat == 1 ? "checked" : ""; ?>/> <?php echo $this->lang->line('bg-repeat-x');?></label>
				<label class='mr12'><input name="bg_repeat" type="radio" value="2" <?php echo $data['data']->bg_repeat == 2 ? "checked" : ""; ?>/> <?php echo $this->lang->line('bg-repeat-y');?></label>
				<label class='mr12'><input name="bg_repeat" type="radio" value="3" <?php echo $data['data']->bg_repeat == 3 ? "checked" : ""; ?>/> <?php echo $this->lang->line('bg-repeat-no-repeat');?></label>
			</div>
			<div class="ib">
				<label class="text" for='enable_bg_image'><?php echo $this->lang->line('enable-bg-image');?></label>
				<label><input id="enable_bg_image" name="enable_bg_image" type="radio" value="1" <?php echo $data['data']->enable_bg_image ? "checked" : ""; ?>/> <?php echo $this->lang->line('yes');?></label>
				<label><input name="enable_bg_image" type="radio" value="0" <?php echo !$data['data']->enable_bg_image ? "checked" : ""; ?>/> <?php echo $this->lang->line('no');?></label>			
			</div>
			<input type='hidden' name='appearence-status' class='open-status' value='<?php echo $data['appearence-status'];?>'/>
		</div>
		<div class="separate-bar <?php echo $data['appearence-logo-status'] ? 'maximize' : 'minimize';?>" ref='appearence-logo'><?php echo $this->lang->line('appearance-logo');?></div>
		<div id='appearence-logo' style='<?php echo !$data['appearence-logo-status'] ? 'display:none' : '';?>'>
			<div class="ib">
				<label class="text" for='logo'><?php echo $this->lang->line('logo');?></label>
				<input id="logo" name="logo" type="file"/>
			</div>
			<div class="ib">
				<label class="text" for='email_logo'><?php echo $this->lang->line('email-logo');?></label>
				<input id="email_logo" name="email_logo" type="file"/>
			</div>			
			<div class='relative setting-images ib'>
				<div class='logo logo-setting'>
					<p class='mb8'><b><?php echo $this->lang->line('logo');?></b></p>
					<img src='<?php echo base_url("images/logo.png");?>' alt='' title='<?php echo $this->lang->line('logo');?>'/>
				</div>
				<div class='email-logo logo-setting'>
					<p class='mb8'><b><?php echo $this->lang->line('email-logo');?></b></p>
					<img src='<?php echo base_url("images/small-logo.png");?>' alt='' title='<?php echo $this->lang->line('email-logo');?>'/>
				</div>
				<div style='margin-right:0' class='background-image logo-setting'>
					<p class='mb8'><b><?php echo $this->lang->line('bg-image');?></b></p>
					<img src='<?php echo base_url("images/background.png");?>' alt='' title='<?php echo $this->lang->line('bg-image');?>'/>
				</div>
				<div class='clear'></div>
			</div>
			<input type='hidden' name='appearence-logo-status' class='open-status' value='<?php echo $data['appearence-logo-status'];?>'/>
		</div>
		<div class="separate-bar <?php echo $data['menu-button-status'] ? 'maximize' : 'minimize';?>" ref='menu-button'><?php echo $this->lang->line('menu-button');?></div>
		<div id='menu-button' style='<?php echo !$data['menu-button-status'] ? 'display:none' : '';?>'>			
			<div class="ib relative">
				<label class="text" for='menu_color'><?php echo $this->lang->line('menu-color');?></label>
				<input id="menu_color" name="menu_color" type="text" value="<?php echo htmlspecialchars($data['data']->menu_color); ?>" class="normal mr8"/>
			</div>
			<div class="ib relative">
				<label class="text" for='separate_bar_bg_color'><?php echo $this->lang->line('separate-bar-color');?></label>
				<input id="separate_bar_bg_color" name="separate_bar_bg_color" type="text" value="<?php echo htmlspecialchars($data['data']->separate_bar_bg_color); ?>" class="normal mr8"/>
			</div>
			<div class="ib relative">
				<label class="text" for='button_linear_color_1'><?php echo $this->lang->line('button-linear-color-1');?></label>
				<input id="button_linear_color_1" name="button_linear_color_1" type="text" value="<?php echo htmlspecialchars($data['data']->button_linear_color_1); ?>" class="normal mr8"/>
			</div>
			<div class="ib relative">
				<label class="text" for='button_linear_color_2'><?php echo $this->lang->line('button-linear-color-2');?></label>
				<input id="button_linear_color_2" name="button_linear_color_2" type="text" value="<?php echo htmlspecialchars($data['data']->button_linear_color_2); ?>" class="normal mr8"/>
			</div>
			<input type='hidden' name='menu-button-status' class='open-status' value='<?php echo $data['menu-button-status'];?>'/>
		</div>
		<div class="separate-bar <?php echo $data['shadow-status'] ? 'maximize' : 'minimize';?>" ref='shadow'><?php echo $this->lang->line('shadow');?></div>
		<div id='shadow' style='<?php echo !$data['shadow-status'] ? 'display:none' : '';?>'>
			<div class="ib">
				<label class="text" for='h_shadow'><?php echo $this->lang->line('horizontal');?></label>
				<input id="h_shadow" name="h_shadow" type="text" value="<?php echo htmlspecialchars($data['data']->h_shadow); ?>" class="normal mr8"/>
				<span class='tips'><?php echo $this->lang->line('px-unit-tips');?></span>
			</div>
			<div class="ib">
				<label class="text" for='v_shadow'><?php echo $this->lang->line('vertical');?></label>
				<input id="v_shadow" name="v_shadow" type="text" value="<?php echo htmlspecialchars($data['data']->v_shadow); ?>" class="normal mr8"/>
				<span class='tips'><?php echo $this->lang->line('px-unit-tips');?></span>
			</div>
			<div class="ib">
				<label class="text" for='blur_shadow'><?php echo $this->lang->line('distance');?></label>
				<input id="blur_shadow" name="blur_shadow" type="text" value="<?php echo htmlspecialchars($data['data']->blur_shadow); ?>" class="normal mr8"/>
				<span class='tips'><?php echo $this->lang->line('px-unit-tips');?></span>
			</div>
			<div class="ib">
				<label class="text" for='size_shadow'><?php echo $this->lang->line('size');?></label>
				<input id="size_shadow" name="size_shadow" type="text" value="<?php echo htmlspecialchars($data['data']->size_shadow); ?>" class="normal mr8"/>
				<span class='tips'><?php echo $this->lang->line('px-unit-tips');?></span>
			</div>
			<div class="ib relative">
				<label class="text" for='color_shadow'><?php echo $this->lang->line('color');?></label>
				<input id="color_shadow" name="color_shadow" type="text" value="<?php echo htmlspecialchars($data['data']->color_shadow); ?>" class="normal mr8"/>
			</div>
			<div class="ib">
				<label class="text" for='out_inset_shadow'><?php echo $this->lang->line('position');?></label>
				<label><input id="out_inset_shadow" name="out_inset_shadow" type="radio" value="1" <?php echo $data['data']->out_inset_shadow ? "checked" : ""; ?>/> <?php echo $this->lang->line('outset');?></label>
				<label><input name="out_inset_shadow" type="radio" value="0" <?php echo !$data['data']->out_inset_shadow ? "checked" : ""; ?>/> <?php echo $this->lang->line('inset');?></label>			
			</div>
			<div class="ib">
				<label class="text" for='enable_shadow'><?php echo $this->lang->line('enable-shadow');?></label>
				<label><input id="enable_shadow" name="enable_shadow" type="radio" value="1" <?php echo $data['data']->enable_shadow ? "checked" : ""; ?>/> <?php echo $this->lang->line('yes');?></label>
				<label><input name="enable_shadow" type="radio" value="0" <?php echo !$data['data']->enable_shadow ? "checked" : ""; ?>/> <?php echo $this->lang->line('no');?></label>			
			</div>
			<input type='hidden' name='shadow-status' class='open-status' value='<?php echo $data['shadow-status'];?>'/>
		</div>
		<div class="actions">
			<input type="submit" class="btn btn-yellow" value="<?php echo $this->lang->line('save'); ?>"/>
		</div>
		<input type='hidden' id='scroll-top' name='scroll-top' value='<?php echo $scroll_top;?>'/>
	</form>
	<script type='text/javascript'>
		$( function() {
			$('#bg_color,#border_color,#color_shadow,#menu_color,#separate_bar_bg_color,#button_linear_color_1,#button_linear_color_2').colorpicker({
				parts: 'full',
				showOn: 'both',
				buttonColorize: true,
				showNoneButton: true,
				alpha: true
			});			
		});
		$('.separate-bar').click(function(){
			var div = $('#' + $(this).attr('ref'));
			var open_status = div.find('.open-status');
			//minimize
			if (open_status.val() != 1){
				open_status.val(1);
				div.slideDown(500);				
				$(this).addClass('maximize').removeClass('minimize');
			}
			else{
				open_status.val(0);
				div.slideUp(500);
				$(this).addClass('minimize').removeClass('maximize');
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('site-setting', $this->lang->line('site-setting'));?></div>
<?php } ?>