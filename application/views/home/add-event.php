<h1 class="form-title"><?php echo $this->lang->line('event');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_errors(); ?>
	<form id="form-data" class="f-event" method="post">
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
			<label class="text left" style='margin-top:10px;'><?php echo $this->lang->line('condition(s)');?></label>
			<div class='conditions left'>
				<ul class='condition'>
					<?php 
					$device_ids = explode(SEPARATER_FORMULAR_VALUE, $data['data']->device_ids);
					$operators = explode(SEPARATER_FORMULAR_VALUE, $data['data']->operators);
					$values = explode(SEPARATER_FORMULAR_VALUE, $data['data']->values);
					$combines = explode(SEPARATER_FORMULAR_VALUE, $data['data']->combines);
					$length = count($device_ids);
					for($i = 0; $i < $length; $i++){ ?>
					<li>
						<div class='ib'>
							<?php if ($i > 0){ ?>
							<select id='else' name='combines[]' class='normal' style='background-color:#76ad5c'>
								<option value='AND' <?php echo $combines[$i - 1] == 'AND' ? 'selected' : '';?>>AND</option>
								<option value='OR' <?php echo $combines[$i - 1] == 'OR' ? 'selected' : '';?>>OR</option>
							</select>
							<?php } 
							else { ?>
								<label id='if' class='text tc' style='width:100px;background-color:orange;padding:6px 0;'><b>IF</b></label>
							<?php } ?>
							<select name='device_ids[]' class='mr8 normal'>
								<?php foreach($data['devices']->result() as $row) { ?>								
									<option value='<?php echo $row->id;?>' <?php echo $device_ids[$i] == $row->id ? 'selected' : '';?>><?php echo htmlspecialchars($row->device_name);?></option>
								<?php } ?>
							</select><select name='operators[]' class='normal condition mr8'>
								<option value='>' <?php echo $operators[$i] == '>' ? 'selected': '';?>>&gt;</option>
								<option value='>=' <?php echo $operators[$i] == '>=' ? 'selected': '';?>>&gt;=</option>
								<option value='<' <?php echo $operators[$i] == '<' ? 'selected': '';?>>&lt;</option>
								<option value='<=' <?php echo $operators[$i] == '<=' ? 'selected': '';?>>&lt;=</option>
								<option value='=' <?php echo $operators[$i] == '=' ? 'selected': '';?>>=</option>
								<option value='!=' <?php echo $operators[$i] == '!=' ? 'selected': '';?>>!=</option>
							</select>
							<input type='text' name='values[]' class='normal' value="<?php echo htmlspecialchars($values[$i]);?>"/>
							<img class='add pointer' src='<?php echo base_url('images/add.png');?>' align='absmiddle' title='<?php echo $this->lang->line('add-more');?>' alt='<?php echo $this->lang->line('add-more');?>'/>
							<?php if ($i > 0){ ?>
								<img class='remove pointer' src='<?php echo base_url('images/remove.png');?>' align='absmiddle' title='<?php echo $this->lang->line('remove');?>' alt='<?php echo $this->lang->line('remove');?>'/>
							<?php 								
							} ?>
						</div>
					</li>
					<?php } ?>
				</ul>
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
		$('#form-data').bind('submit', function(){
			var is_valid = true;
			$(this).find('input').each(function(){
				if ($(this).val() == ''){
					is_valid = false;
					$(this).addClass('error').focus();
				}
				else{
					$(this).removeClass('error');
				}
			});
			$('#device_id,#name,#value').each(function(){
				if ($(this).val() == ""){
					$(this).focus();
					$(this).addClass('error');
					is_valid = false;
				}
				else{
					$(this).removeClass('error');
				}
			});
			
			return is_valid;
		});
		
		$('ul.condition img.add').live('click', function(){
			var li = $(this).parent().clone();
			li.find('label.error').remove();
			var input = li.find('input').val('').removeClass('error');
			if (li.find('#if').length > 0){
				li.find('#if').remove();
				li.prepend("<select id='else' name='combines[]' class='normal' style='background-color:#76ad5c'><option value='AND'>AND</option><option value='OR'>OR</option></select>");
			}
			if (li.find('img.remove').length == 0){
				li.append("<img class='pointer remove' src='<?php echo base_url('images/remove.png');?>' align='absmiddle' title='<?php echo $this->lang->line('remove');?>' alt='<?php echo $this->lang->line('remove');?>'/>");
			}			
			li.appendTo('ul.condition');
			add_rule(input);
		});
		add_rule($('#form-data .condition input,#device_id,#name'));
		function add_rule(input){			
			input.blur(function(){
				if($(this).val() == ""){
					$(this).addClass('error');
				}
				else{
					$(this).removeClass('error');
				}
			});
		}
		
		$('ul.condition img.remove').live('click', function(){
			$(this).parent().remove();
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('devices', $this->lang->line('device'));?></div>
<?php } ?>