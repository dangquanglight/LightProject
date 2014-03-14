<h1 class="form-title"><?php echo $this->lang->line('device');?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_errors(); ?>
	<form id="form-data" class="f-device relative" method="post">
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('device-name');?><span class='required'>*</span></label>
			<input id="device_name" name="device_name" type="text" value="<?php echo htmlspecialchars($data['data']->device_name); ?>" class="normal text" <?php echo $data['id'] ? 'readonly' : ''; ?>/>
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('type');?><span class='required'>*</span></label>
			<select id='sub_type_id' name='sub_type_id' class='normal'>
				<option value=''><?php echo htmlspecialchars($this->lang->line('please-select'));?></option>
				<?php foreach($data['types'] as $row){ ?>
					<optgroup label="<?php echo htmlspecialchars($row->type_name);?>">
						<?php foreach($data['sub_types'] as $srow){ 
							if ($srow->type_id == $row->id){ ?>
							<option value='<?php echo $srow->id;?>' <?php echo $data['data']->sub_type_id == $srow->id ? 'selected' : '';?>><?php echo htmlspecialchars($srow->sub_type_name);?></option>
						<?php } 
						} ?>
					</optgroup>
				<?php } ?>
			</select>
		</div>
		<div id='unit' class="input-box <?php echo !$data['units'] || $data['units']->num_rows == 0 ? 'hidden' : '';?>">
			<label class="text"><?php echo $this->lang->line('unit');?></label>
			<select id='unit_id' name='unit_id' class='normal'>
				<?php 
					if ($data['units']){
						foreach($data['units']->result() as $unit){
							echo "<option value='" . $unit->id . "' " . ($data['data']->unit_id == $unit->id ? 'selected' : '') . ">" . htmlspecialchars($unit->unit_name) . "</option>";						
						}
					}
				?>
			</select>
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('location');?><span class='required'>*</span></label>
			<select id='zone_id' name='zone_id' class='normal'>
				<option value=''><?php echo $this->lang->line('please-select');?></option>
				<?php foreach($data['sites']->result() as $site) {
					echo '<optgroup label="' . htmlspecialchars($site->site_name) . '">';
					foreach($data['zones'] as $zone){
						if ($site->id == $zone->site_id){
							echo "<option value='" . $zone->id . "' " . ($data['data']->zone_id == $zone->id ? 'selected' : '') . ">" . htmlspecialchars($zone->zone_name) . "</option>";
						}
					}
					echo '</optgroup>';
				} ?>
			</select>
		</div>		
		<div class="input-box">
			<label class="text vtop"><?php echo $this->lang->line('description');?></label>
			<textarea class="text normal" id="description" name="description" maxlength='255'><?php echo htmlspecialchars($data['data']->description); ?></textarea>
		</div>
		<div class="input-box">
			<label class="text"><?php echo $this->lang->line('status');?>: </label>
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
		<div class='box hidden' style='width:280px;top:0;left:600px;position:absolute;min-height:85px;'>
			<h3 class="title"><?php echo $this->lang->line('device-name');?></h3>
			<div class="info tc relative">
				<img id='image-template' src="<?php echo base_url('images/co2.png');?>" align="absmiddle" class="icon">
				<span id='measurement-template'>
					<span id='text-template'></span><span class="value">0</span> <span id='unit-in-box'><?php echo $this->lang->line('unit');?></span>
				</span>
				<span id='cam-template' class='hidden'>					
					<img src='<?php echo base_url('images/cam-template-1.jpg');?>' class='image image1'/>
					<img src='<?php echo base_url('images/cam-template-2.jpg');?>' class='image image2'/>
				</span>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		$(function(){
			change_image_template();
		});
		function change_image_template(){
			var value = $('#sub_type_id').val();
			var is_display_unit = true;
			if (value == 1){
				file_img = 'cam';
				text = "<?php echo $this->lang->line('cam');?>";
			}
			else if (value == 2){
				file_img = 'on-off';
				text = "<?php echo $this->lang->line('on-off');?>";
			}		
			else if (value == 4){
				file_img = 'humidity';
				text = "<?php echo $this->lang->line('humidity');?>";
			}
			else if (value == 5){
				file_img = 'luminance';
				text = "<?php echo $this->lang->line('luminance');?>";
			}
			else if (value == 6){
				file_img = 'temperature';
				text = "<?php echo $this->lang->line('temperature');?>";
			}
			else if (value == 7){
				file_img = 'unspecified';
				text = "<?php echo $this->lang->line('unspecified');?>";
			}
			else if (value == 8){
				file_img = 'gas';
				text = "<?php echo $this->lang->line('gas');?>";
			}		
			else if (value == 9){
				file_img = 'co2';	
				text = "<?php echo $this->lang->line('co2');?>";				
			}
			else if (value == 10){
				file_img = 'pressure';
				text = "<?php echo $this->lang->line('pressure');?>";
			}
			else if (value == 11){
				file_img = 'power';
				text = "<?php echo $this->lang->line('power');?>";
			}
			else if (value == 12){
				file_img = 'energy';
				text = "<?php echo $this->lang->line('energy');?>";
			}
			else if (value == 13){
				file_img = 'smoke';
				text = "<?php echo $this->lang->line('smoke');?>";
			}
			else if (value == 15){
				file_img = 'window-break';
				text = "<?php echo $this->lang->line('window-break');?>";
				is_display_unit = false;
			}
			else if (value == 16){
				file_img = 'door-switch';
				text = "<?php echo $this->lang->line('door-switch');?>";
				is_display_unit = false;
			}
			else if (value == 17){
				file_img = 'door-bell';
				text = "<?php echo $this->lang->line('door-bell');?>";
				is_display_unit = false;
			}
			else if (value == 18){
				file_img = 'control-device';
				text = "<?php echo $this->lang->line('control-device');?>";
				is_display_unit = false;
			}
			else if (value == 19){
				file_img = 'adjustment-device';
				text = "<?php echo $this->lang->line('adjustment-device');?>";
				is_display_unit = false;
			}
			else if (value == 20){
				file_img = 'motion-detection';
				text = "<?php echo $this->lang->line('motion-device');?>";
				is_display_unit = false;
			}
			else if (value == 21){
				file_img = 'garage-door';
				text = "<?php echo $this->lang->line('garage-door');?>";
				is_display_unit = false;
			}
			
			if (is_display_unit){
				$('#unit-in-box').show();
			}
			else{
				$('#unit-in-box').hide();
			}
			if (value){
				$('.f-device .box').show();
				$('#image-template').attr('src', '<?php echo base_url('images');?>/' + file_img + '.png');
				if (value != 1){
					$('#measurement-template').show();
					$('#cam-template').hide();					
					$('#text-template').text(text);
				}
				else{
					$('#cam-template').show();
					$('#measurement-template').hide();
				}
			}
			else{
				$('.f-device .box').hide();
			}
		}
		$('#form-data').validate({
			rules: {
				name: "required",
				sub_type_id: 'required',
				zone_id : 'required'
			},
			messages: {
				name: "<?php echo $this->lang->line('required-device-name'); ?>",
				sub_type_id: "<?php echo $this->lang->line('required-select-type'); ?>",
				zone_id: "<?php echo $this->lang->line('required-select-location'); ?>"
			}
		});
		$('#sub_type_id').change(function(){
			change_image_template();
			var value = $('#sub_type_id').val();
			if (value != ''){
				
				//$('#unit').show();
				$.get(base_url + 'units-by-sub-types/' + $(this).val(), function(e){
					var html = '';
					if (e){
						e = $.parseJSON(e);
						for(var i = 0; i < e.length; i++){
							html +="<option value='" + e[i][0] + "'>" + e[i][1] + "</option>";
						}
						$('#unit_id').html(html);
						if (e.length == 0){
							$('#unit_id').html('');
							$('#unit').hide();
						}
						else{
							$('#unit').show();
						}
					}
				});
			}
			else{
				$('#unit_id').html('');
				$('#unit').hide();
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('devices', $this->lang->line('device'));?></div>
<?php } ?>