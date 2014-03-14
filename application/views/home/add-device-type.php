<h1 class="form-title"><?php echo $this->lang->line('device-type');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
	<form id="form-data" class="f-site" method="post">		
		<div class="input-box">
			<label class="text" for='type_name'><?php echo $this->lang->line('type-name');?><span class='required'>*</span></label>
			<input id="type_name" name="type_name" type="text" value="<?php echo htmlspecialchars($data['data']->type_name); ?>" class="normal text"/>
		</div>		
		<div class="input-box">
			<label class="text vtop" for='description'><?php echo $this->lang->line('description');?></label>
			<textarea id="description" name="description" class="normal text"><?php echo htmlspecialchars($data['data']->description); ?></textarea>
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('status');?></label>
			<select id="status" name="status" class="normal">
				<option value="1" <?php echo $data['data']->status == 1 ? "selected" : ""; ?>><?php echo $this->lang->line('enabled');?></option>
				<option value="0" <?php echo $data['data']->status == 0 ? "selected" : ""; ?>><?php echo $this->lang->line('disabled');?></option>
			</select>
		</div>
		<div class="actions">
			<input type="submit" class="btn btn-yellow" value="<?php echo $this->lang->line('save'); ?>"/>
			<?php if (!$data['id']){ ?>
				<input name="save_and_continue" type="submit" class="btn btn-yellow" value="<?php echo $this->lang->line('save-and-continue');?>"/>
			<?php } ?>
			<a class="btn btn-yellow" href='<?php echo $data['back-url'];?>'><?php echo $this->lang->line('back-to-list');?></a>
		</div>
	</form>
	<script type="text/javascript">
		$('#form-data').validate({
			rules: {
				type_name: "required"
			},
			messages: {
				type_name: "<?php echo $this->lang->line('required-type-name'); ?>"
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('site', $this->lang->line('sites'));?></div>
<?php } ?>