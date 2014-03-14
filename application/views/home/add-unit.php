<h1 class="form-title"><?php echo $this->lang->line('unit');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
	<form id="form-data" class="f-type" method="post">		
		<div class="input-box">
			<label class="text" for='unit_name'><?php echo $this->lang->line('unit-name');?><span class='required'>*</span></label>
			<input id="unit_name" name="unit_name" type="text" value="<?php echo htmlspecialchars($data['data']->unit_name); ?>" class="normal text"/>
		</div>		
		<div class="input-box">
			<label class="text vtop" for='description'><?php echo $this->lang->line('description');?></label>
			<textarea id="description" name="description" class="normal text"><?php echo htmlspecialchars($data['data']->description); ?></textarea>
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
				unit_name: "required"
			},
			messages: {
				unit_name: "<?php echo $this->lang->line('required-unit-name'); ?>"
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('unit', $this->lang->line('units'));?></div>
<?php } ?>