<h1 class="form-title"><?php echo $this->lang->line('submenu');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
	<form id="form-data" class="f-submenu" method="post">		
		<div class="ib">
			<label class="text" for="menu_id"><?php echo $this->lang->line('menu');?></label>
			<select id="menu_id" name="menu_id" class="normal">			
				<?php foreach($data['menu']->result() as $row): ?>
					<option value="<?php echo $row->id; ?>" <?php echo $row->id == $data['data']->menu_id ? "selected" : ""; ?>><?php echo htmlspecialchars($row->title); ?></option>
				<?php endforeach ?>			
			</select>
		</div>
		<div class="ib">
			<label class="text" for='title_en'><?php echo $this->lang->line('title-en');?></label>
			<input id="title_en" name="title_en" type="text" value="<?php echo htmlspecialchars($data['data']->title_en); ?>" class="normal text"/>
		</div>
		<div class="ib">
			<label class="text" for='title_fi'><?php echo $this->lang->line('title-fi');?></label>
			<input id="title_fi" name="title_fi" type="text" value="<?php echo htmlspecialchars($data['data']->title_fi); ?>" class="normal text"/>
		</div>
		<div class="ib">
			<label class="text" for='title_kr'><?php echo $this->lang->line('title-ci');?></label>
			<input id="title_kr" name="title_kr" type="text" value="<?php echo htmlspecialchars($data['data']->title_kr); ?>" class="normal text"/>
		</div>
		<div class="input-box">
			<label class="text" for='module_id'><?php echo $this->lang->line('module');?><span class='required'>*</span></label>
			<select id='module_id' name='module_id' class="normal text">
				<?php foreach($data['modules']->result() as $row){
					echo "<option value='" . $row->module_id . "' " . ($data['data']->module_id == $row->module_id ? 'selected': '') . ">" . htmlspecialchars($row->module_name) . "</option>";
				} ?>
			</select>
		</div>		
		<div class="ib">
			<label class="text" for='status'><?php echo $this->lang->line('status');?></label>
			<select id="status" name="status" class="normal">
				<option value="1" <?php echo $data['data']->status == 1 ? "selected" : ""; ?>><?php echo $this->lang->line('enabled');?></option>
				<option value="0" <?php echo $data['data']->status == 0 ? "selected" : ""; ?>><?php echo $this->lang->line('disabled');?></option>
			</select>			
		</div>		
		<div class="actions">			
			<input type="submit" class="btn btn-yellow" value="<?php echo $this->lang->line('save');?>"/>
			<?php if (!$data['id']){ ?>
				<input name="save_and_continue" type="submit" class="btn btn-yellow" value="<?php echo $this->lang->line('save-and-continue');?>"/>
			<?php } ?>
			<a class="btn btn-yellow" href='<?php echo base_url('submenu');?>'><?php echo $this->lang->line('back-to-list');?></a>
		</div>
	</form>
	<script type="text/javascript">
		$('#form-data').validate({
			rules: {
				title: "required",
				menu_id: "required",
				module_id: 'required'
			},
			messages: {
				title: "<?php echo $this->lang->line('required-title');?>",
				menu_id: "<?php echo $this->lang->line('required-select-menu');?>",
				module_id: "<?php echo $this->lang->line('required-select-module');?>"
			}
		});
		$('#suggest-links').click(function(){			
			var offset = $(this).offset();
			var top = 50;
			var left = offset.left + $(this).outerWidth();			
			$('#links-context').css({top: top + 'px', left: left + 'px'}).show('clip');
		});
		var mouse_is_inside_popup_context = false;
		$('#links-context').hover(function(){ 
			mouse_is_inside_popup_context=true; 
		}, function(){ 
			mouse_is_inside_popup_context=false; 
		});
		$("body").mouseup(function(){ 
			if(!mouse_is_inside_popup_context){$('#links-context').hide('clip');}
		});
		$('#links-context li a').click(function(){			
			var options = { to: "#link", className: "ui-effects-transfer" };
			var link = $(this).attr('href');
			$(this).effect('transfer', options, 500, function(){
				$('#link').val(link);
				$('#links-context').hide('clip');
			});
			return false;
		});
		$('#links-context li a').click(function(){
			return false;
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('submenu', $this->lang->line('submenu'));?></div>
<?php } ?>