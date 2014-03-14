<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
	<form id="form-data" class="f-role" method="post">
		<div>
			<div class='left' style='width:400px'>
				<h1 class="form-title"><?php echo $this->lang->line('role');?></h1>
				<div class="input-box">
					<label class="text" for='role_name'><?php echo $this->lang->line('role-name');?><span class='required'>*</span></label>
					<input id="role_name" name="role_name" type="text" value="<?php echo htmlspecialchars($data['data']->role_name); ?>" class="normal text"/>
				</div>		
				<div class="input-box">
					<label class="text"><?php echo $this->lang->line('description');?></label>
					<textarea class="text normal vtop" id="description" name="description" maxlength='255'><?php echo htmlspecialchars($data['data']->description); ?></textarea>
				</div>
				<div class="ib">
					<label class="text" for="status"><?php echo $this->lang->line('status');?></label>
					<select id="status" name="status" class="normal">
						<option value="1" <?php echo $data['data']->status == 1 ? "selected" : ""; ?>><?php echo $this->lang->line('enabled');?></option>
						<option value="0" <?php echo $data['data']->status == 0 ? "selected" : ""; ?>><?php echo $this->lang->line('disabled');?></option>
					</select>
				</div>
			</div>
			<div class='right' style='width:450px'>
				<h1 class="form-title"><?php echo $this->lang->line('modules');?></h1>
				<table id='modules' width='100%' cellpadding='0' cellspacing='0' class='table-list' no-default-event='true'>
					<thead>
						<tr>
							<th><?php echo $this->lang->line('module');?></th>
							<th style="width:70px;"><label><input type='checkbox' id='check-1' value='1'/> <?php echo $this->lang->line('view');?></label></th>
							<th style="width:70px;"><label><input type='checkbox' id='check-2' value='1'/> <?php echo $this->lang->line('add');?></label></th>
							<th style="width:70px;"><label><input type='checkbox' id='check-3' value='1'/> <?php echo $this->lang->line('update');?></label></th>
							<th style="width:70px;"><label><input type='checkbox' id='check-4' value='1'/> <?php echo $this->lang->line('delete');?></label></th>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach($data['modules']->result() as $row){ 
								$permission = $this->role_4_modules->check_permission_in_array($data['role_modules'], $row->module_id);
							?>
							<tr>							
								<td style='padding-left:6px'><?php echo $this->lang->line('module-' . $row->module_id);?></td>
								<td class='tc'><input class='check-1' type='checkbox' name='module-<?php echo $row->module_id;?>-1' <?php echo $permission[0] ? 'checked' : '';?>/></td>
								<td class='tc'><input class='check-2' type='checkbox' name='module-<?php echo $row->module_id;?>-2' <?php echo $permission[1] ? 'checked' : '';?>/></td>
								<td class='tc'><input class='check-3' type='checkbox' name='module-<?php echo $row->module_id;?>-3' <?php echo $permission[2] ? 'checked' : '';?>/></td>
								<td class='tc'><input class='check-4' type='checkbox' name='module-<?php echo $row->module_id;?>-4' <?php echo $permission[3] ? 'checked' : '';?>/></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class='clear'></div>
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
		$(function(){
			$('#form-data').validate({
				rules: {
					role_name: "required"				
				},
				messages: {
					role_name: "<?php echo $this->lang->line('required-role-name'); ?>"
				}
			});
			$('#modules thead input').click(function(){
				if ($(this).attr('checked')){
					$('#modules tbody .' + $(this).attr('id')).attr('checked', true);
				}
				else{
					$('#modules tbody .' + $(this).attr('id')).attr('checked', false);
				}
			});
			$('#modules tbody input').click(function(){
				var length = $('#modules tbody .' + $(this).attr('class') + ':checked').length;
				var checkbox_length = $('#modules tbody .' + $(this).attr('class')).length;
				$('#' + $(this).attr('class')).attr('checked', length == checkbox_length);
			});
			$('#modules thead input').each(function(){
				var length = $('#modules tbody .' + $(this).attr('id') + ':checked').length;
				var checkbox_length = $('#modules tbody .' + $(this).attr('id')).length;						
				$(this).attr('checked', length == checkbox_length);
			});
		});
	</script>
<?php } else { ?>
	<h1 class="form-title"><?php echo $this->lang->line('role');?></h1>
	<div class="fail"><?php echo get_not_found_long('roles', $this->lang->line('role'));?></div>
<?php } ?>