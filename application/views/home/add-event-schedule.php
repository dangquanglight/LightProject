<h1 class="form-title"><?php echo $this->lang->line('event-schedule');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_errors(); 
		$ar_repeat_on = explode(',', $data['data']->repeat_on);
	?>
	<form id="form-data" class="f-event-schedule" method="post">
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('name');?><span class='required'>*</span></label>
			<input id="name" name="name" type="text" value="<?php echo htmlspecialchars($data['data']->name); ?>" class="normal text" />
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('device');?><span class='required'>*</span></label>
			<select id='device_id' name='device_id' class='normal'>
				<option value=''><?php echo htmlspecialchars($this->lang->line('please-select'));?></option>
			<?php foreach($data['devices']->result() as $row) { ?>								
				<option value='<?php echo $row->id;?>' <?php echo $data['data']->device_id == $row->id ? 'selected' : '';?>><?php echo htmlspecialchars($row->device_name);?></option>
			<?php } ?>
			</select>
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('value');?><span class='required'>*</span></label>
			<input id="value" name="value" type="text" value="<?php echo htmlspecialchars($data['data']->value); ?>" class="normal text" />
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('repeats');?></label>
			<select id='repeat_type' name='repeat_type' class='normal'>				
				<option value='1' <?php echo $data['data']->repeat_type == 1 ? 'selected' : '';?>><?php echo $this->lang->line('daily');?></option>
				<option value='2' <?php echo $data['data']->repeat_type == 2 ? 'selected' : '';?>><?php echo $this->lang->line('weekly');?></option>
				<option value='3' <?php echo $data['data']->repeat_type == 3 ? 'selected' : '';?>><?php echo $this->lang->line('monthly');?></option>
			</select>
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('repeat-every');?></label>
			<select id='repeat_every' name='repeat_every' class='normal'>
				<option value=''><?php echo $this->lang->line('please-select');?></option>
				<?php for($i = 1; $i <= 30; $i++){ 
					echo '<option value="' . $i . '" ' . ($data['data']->repeat_every == $i ? 'selected' : '') . '>' . $i . '</option>';
				} ?>
			</select>
			<span id='repeat-text'><?php 
				if ($data['data']->repeat_type == 2){
					echo $this->lang->line('weeks');
				}
				else if ($data['data']->repeat_type == 3){
					echo $this->lang->line('months');
				}
				else {
					echo $this->lang->line('days');
				}
			?></span>
		</div>
		<div id='drepeat_on' class="input-box" style='<?php echo $data['data']->repeat_type != 2 ? 'display:none': '';?>'>
			<label class="text"><?php echo $this->lang->line('repeat-on');?></label>
			<label class='mr8'><input type='checkbox' name='repeat_on[]' value='1' <?php echo in_array(1, $ar_repeat_on) !== false ? 'checked' : '';?>/> <?php echo $this->lang->line('mon');?></label>
			<label class='mr8'><input type='checkbox' name='repeat_on[]' value='2' <?php echo in_array(2, $ar_repeat_on) !== false ? 'checked' : '';?>/> <?php echo $this->lang->line('tue');?></label>
			<label class='mr8'><input type='checkbox' name='repeat_on[]' value='3' <?php echo in_array(3, $ar_repeat_on) !== false ? 'checked' : '';?>/> <?php echo $this->lang->line('wed');?></label>
			<label class='mr8'><input type='checkbox' name='repeat_on[]' value='4' <?php echo in_array(4, $ar_repeat_on) !== false ? 'checked' : '';?>/> <?php echo $this->lang->line('thu');?></label>
			<label class='mr8'><input type='checkbox' name='repeat_on[]' value='5' <?php echo in_array(5, $ar_repeat_on) !== false ? 'checked' : '';?>/> <?php echo $this->lang->line('fri');?></label>
			<label class='mr8'><input type='checkbox' name='repeat_on[]' value='6' <?php echo in_array(6, $ar_repeat_on) !== false ? 'checked' : '';?>/> <?php echo $this->lang->line('sat');?></label>
			<label class='mr8'><input type='checkbox' name='repeat_on[]' value='7' <?php echo in_array(7, $ar_repeat_on) !== false ? 'checked' : '';?>/> <?php echo $this->lang->line('sun');?></label>
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('starts-on');?></label>
			<input id="start_on" name="start_on" type="text" value="<?php echo htmlspecialchars($data['data']->start_on_format); ?>" class="normal text" />
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('time-turn-on');?></label>
			<span class='mr8'><?php echo $this->lang->line('hours');?></span><select id='hours' name='hours' class='normal' style='width:60px;'>
				<?php for($i = 0; $i < 24; $i++){
					echo "<option value='" . $i . "' " . ($i == $data['data']->hours ? 'selected' : '') . ">" . ($i < 10 ? ("0" . $i) : $i) . "</option>";
				} ?>
			</select>
			<span class='mr8 ml8'><?php echo $this->lang->line('minutes');?></span><select id='minutes' name='minutes' class='normal' style='width:60px;'>
				<?php for($i = 0; $i < 60; $i++){
					echo "<option value='" . $i . "' " . ($i == $data['data']->minutes ? 'selected' : '') . ">" . ($i < 10 ? ("0" . $i) : $i) . "</option>";
				} ?>
			</select>
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('time-turn-off');?></label>
			<span class='mr8'><?php echo $this->lang->line('hours');?></span><select id='hours_off' name='hours_off' class='normal' style='width:60px;'>
				<?php for($i = 0; $i < 24; $i++){
					echo "<option value='" . $i . "' " . ($i == $data['data']->hours_off ? 'selected' : '') . ">" . ($i < 10 ? ("0" . $i) : $i) . "</option>";
				} ?>
			</select>
			<span class='mr8 ml8'><?php echo $this->lang->line('minutes');?></span><select id='minutes_off' name='minutes_off' class='normal' style='width:60px;'>
				<?php for($i = 0; $i < 60; $i++){
					echo "<option value='" . $i . "' " . ($i == $data['data']->minutes_off ? 'selected' : '') . ">" . ($i < 10 ? ("0" . $i) : $i) . "</option>";
				} ?>
			</select>
		</div>
		<div class="input-box date-end">
			<label class="text left"><?php echo $this->lang->line('ends');?></label>
			<div class='left'>
				<p><label><input type='radio' name='ends' value='1' <?php echo $data['data']->ends == 1 ? 'checked' : '';?>/> <span><?php echo $this->lang->line('never');?></span></label></p>
				<p><label><input type='radio' name='ends' value='2' <?php echo $data['data']->ends == 2 ? 'checked' : '';?>/> <span><?php echo $this->lang->line('after');?></span><input type='text' id='end_by_ocurrences' name='end_by_ocurrences' value="<?php echo $data['data']->end_by_ocurrences;?>" class='text'/> <?php echo $this->lang->line('occurrences');?></label></p>
				<p><label><input type='radio' name='ends' value='3' <?php echo $data['data']->ends == 3 ? 'checked' : '';?>/> <span><?php echo $this->lang->line('on');?></span><input type='text' id='end_by_date' name='end_by_date' value="<?php echo ($data['data']->end_by_date_format != '00/00/0000') ? ($data['data']->end_by_date_format) : '';?>" class='text'/></label></p>
			</div>
			<div class='clear'></div>
		</div>
		<div class="input-box">
			<label class="text vtop"><?php echo $this->lang->line('description');?></label>
			<textarea id="description" name="description" class='normal' type="text"><?php echo htmlspecialchars($data['data']->description); ?></textarea>
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
			<a class="btn btn-yellow" href='<?php echo base_url('events');?>'><?php echo $this->lang->line('back-to-events');?></a>
		</div>
	</form>
	<script type="text/javascript">		
		$('#start_on,#end_by_date').datepicker();
		$('#repeat_type').change(function(){
			var val = $('#repeat_type').val();
			if (val == 1){
				$('#repeat-text').text('<?php echo strtolower($this->lang->line('days'));?>');	
				$('#drepeat_on').hide();
			}
			else if(val == 2){
				$('#repeat-text').text('<?php echo strtolower($this->lang->line('weeks'));?>');
				$('#drepeat_on').show();
			}
			else{
				$('#repeat-text').text('<?php echo strtolower($this->lang->line('months'));?>');
				$('#drepeat_on').hide();
			}			
		});
		$('#form-data').validate({
			rules:{
				name: 'required',
				device_id: 'required',
				start_on: 'required',
				repeat_every: 'required',
				value: 'required'
			},
			messages:{
				name: '',
				device_id: '',
				start_on: '',
				repeat_every: '',
				value: ''
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('devices', $this->lang->line('device'));?></div>
<?php } ?>