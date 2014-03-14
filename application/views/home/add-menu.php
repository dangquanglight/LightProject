<h1 class="form-title"><?php echo $this->lang->line('menu');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
	<form id="form-data" class="f-menu" method="post">		
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
			<label class="text" for='module_id'><?php echo $this->lang->line('module');?></label>
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
			<input type="submit" class="btn btn-yellow" value="<?php echo $this->lang->line('save'); ?>"/>
			<?php if (!$data['id']){ ?>
				<input name="save_and_continue" type="submit" class="btn btn-yellow" value="<?php echo $this->lang->line('save_and_continue');?>"/>
			<?php } ?>
			<a class="btn btn-yellow" href='<?php echo $data['back-url'];?>'><?php echo $this->lang->line('back-to-list');?></a>
		</div>
	</form>	
	<script type="text/javascript">
		$('#form-data').validate({
			rules: {
				module_id: "required"
			},
			messages: {
				module_id: "<?php echo $this->lang->line('required-select-module'); ?>"
			}
		});		
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('menu', $this->lang->line('menu'));?></div>
<?php } ?>