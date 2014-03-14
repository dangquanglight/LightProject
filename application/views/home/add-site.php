<h1 class="form-title"><?php echo $this->lang->line('site');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
	<form id="form-data" class="f-site" method="post">		
		<div class="input-box">
			<label class="text" for='site_name'><?php echo $this->lang->line('site-name');?><span class='required'>*</span></label>
			<input id="site_name" name="site_name" type="text" value="<?php echo htmlspecialchars($data['data']->site_name); ?>" class="normal text"/>
		</div>
		<div class="input-box">
			<label class="text" for='square'><?php echo $this->lang->line('square');?></label>
			<input id="square" name="square" type="text" value="<?php echo htmlspecialchars($data['data']->square); ?>" class="normal text"/>
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
				site_name: "required"
			},
			messages: {
				site_name: "<?php echo $this->lang->line('required-site-name'); ?>"
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('site', $this->lang->line('sites'));?></div>
<?php } ?>