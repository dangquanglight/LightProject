<h1 class="form-title"><?php echo $this->lang->line('sub-type');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
	<form id="form-data" class="f-sub-type" method="post">		
		<div class="input-box">
			<label class="text" for='sub_type_name'><?php echo $this->lang->line('sub-type-name');?><span class='required'>*</span></label>
			<input id="sub_type_name" name="sub_type_name" type="text" value="<?php echo htmlspecialchars($data['data']->sub_type_name); ?>" class="normal text"/>
		</div>
		<div class="input-box units">
			<label class="text left vtop" for='units'><?php echo $this->lang->line('units');?></label>
			<ul class='left'>
			<?php
				$units = explode(',', $data['data']->units);
				foreach($data['units']->result() as $unit){
					$is_checked = in_array($unit->id, $units) !== false;
					echo "<li>";
					echo "<label class='" . ($is_checked ? 'bred' : '') . "'>";
					echo "<input type='checkbox' name='units[]' value='" . $unit->id . "' " . ($is_checked ? 'checked' : '') . "/> ";
					echo $unit->unit_name;
					echo "</label>";
					echo "</li>";
				}
			?>
			</ul>
			<div class='clear'></div>
		</div>		
		<div class="input-box">
			<label class="text vtop" for='description'><?php echo $this->lang->line('description');?></label>
			<textarea id="description" name="description" class="normal text"><?php echo htmlspecialchars($data['data']->description); ?></textarea>
		</div>
		<div class="input-box">
			<label class="text" for='type_id'><?php echo $this->lang->line('type');?><span class='required'>*</span></label>
			<select id='type_id' name='type_id' class="normal text">
				<option value=''><?php echo $this->lang->line('please-select');?></option>
				<?php foreach($data['types']->result() as $row){
					echo "<option value='" . $row->id . "' " . ($data['data']->type_id == $row->id ? 'selected': '') . ">" . htmlspecialchars($row->type_name) . "</option>";
				} ?>
			</select>
		</div>
		<div id='min-max' class="<?php echo $data['data']->type_id == 3 ? '' : 'hidden';?>">
			<div class="ib">
				<label class="text" for='min'><?php echo $this->lang->line('min-value');?></label>
				<input id="min" name="min" type="text" value="<?php echo htmlspecialchars($data['data']->min); ?>" class="normal text"/>
			</div>
			<div class="ib">
				<label class="text" for='max'><?php echo $this->lang->line('max-value');?></label>
				<input id="max" name="max" type="text" value="<?php echo htmlspecialchars($data['data']->max); ?>" class="normal text"/>
			</div>
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
				sub_type_name: "required",
				type_id: "required",
				min:{
					number: true
				},
				max: {
					number: true
				}
			},
			messages: {
				sub_type_name: "<?php echo $this->lang->line('required-sub-type-name'); ?>",
				type_id: "<?php echo $this->lang->line('required-select-type'); ?>",
				min: {
					number: "<?php echo $this->lang->line('required-number');?>",
				},
				max: {
					number: "<?php echo $this->lang->line('required-number');?>"
				}
			}
		});
		$('#type_id').change(function(){
			if ($(this).val() == 3){
				$('#min-max').show();
			}
			else{
				$('#min-max').hide();
			}
		});
		$('.units input').change(function(){
			if ($(this).attr('checked')){
				$(this).parent().addClass('bred');
			}
			else{
				$(this).parent().removeClass('bred');
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('sub_type', $this->lang->line('sub_types'));?></div>
<?php } ?>