<h1 class="form-title"><?php echo $this->lang->line('zone');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
	<form id="form-data" class="f-zone" method="post">		
		<div class="input-box">
			<label class="text" for='zone_name'><?php echo $this->lang->line('zone-name');?><span class='required'>*</span></label>
			<input id="zone_name" name="zone_name" type="text" value="<?php echo htmlspecialchars($data['data']->zone_name); ?>" class="normal text"/>
		</div>		
		<div class="input-box">
			<label class="text vtop" for='description'><?php echo $this->lang->line('description');?></label>
			<textarea id="description" name="description" class="normal text"><?php echo htmlspecialchars($data['data']->description); ?></textarea>
		</div>
		<div class="input-box">
			<label class="text" for='site_id'><?php echo $this->lang->line('site');?><span class='required'>*</span></label>
			<select id='site_id' name='site_id' class="normal text">
				<option value=''><?php echo $this->lang->line('please-select');?></option>
				<?php foreach($data['sites']->result() as $row){
					echo "<option value='" . $row->id . "' " . ($data['data']->site_id == $row->id ? 'selected': '') . ">" . htmlspecialchars($row->site_name) . "</option>";
				} ?>
			</select>
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
				zone_name: "required",
				site_id: "required",
			},
			messages: {
				zone_name: "<?php echo $this->lang->line('required-zone-name'); ?>",
				site_id: "<?php echo $this->lang->line('required-select-site'); ?>",
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('zone', $this->lang->line('zones'));?></div>
<?php } ?>