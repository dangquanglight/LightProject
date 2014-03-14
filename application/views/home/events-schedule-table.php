<?php 		
	$paging_bar = paging_bar($data['num_rows'], $data['page_size'], $data['page'], $controller_name, "ajax_alarms", get_url_navigate()); ?>
	<?php echo $paging_bar; ?>
<table cellpadding="0" cellspacing="0" width="100%" class="table-list" page_size="<?php echo $data['page_size'];?>">
	<thead>
		<tr>
			<th class="checkbox"></th>
			<th class="checkbox">
				<input type="checkbox" onclick="check_all(this.checked)"/>
			</th>			
			<th style='width:50px'>
				<a href='javascript:void(0)' sort="id"><?php echo $this->lang->line('id');?></a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="name"><?php echo $this->lang->line('event-name');?></a>
			</th>
			<th style='width:150px'>
				<a href='javascript:void(0)' sort="device-name"><?php echo $this->lang->line('device-name');?></a>
			</th>			
			<th style='width:80px'>
				<a href='javascript:void(0)' sort="repeats"><?php echo $this->lang->line('repeats');?></a>
			</th>
			<th style='width:80px'>
				<a href='javascript:void(0)' sort="repeat-every"><?php echo $this->lang->line('repeat-every');?></a>
			</th>
			<th style="width:100px">
				<a href='javascript:void(0)' sort="starts-on"><?php echo $this->lang->line('starts-on');?></a>
			</th>			
			<th style="width:50px">
				<a href='javascript:void(0)' sort="status"><?php echo $this->lang->line('status');?></a>
			</th>			
			<th style="width:100px"></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total = $data['data']->num_rows;
		$start_index = ($data['page'] - 1) * $data['page_size'] + 1;
		if ($total > 0):
			$i = 0;			
			foreach($data['data']->result() as $row): ?>
			<tr <?php echo $i % 2 == 0 ? "class='even'" : "";?>>
				<td class="checkbox"><?php echo $start_index; ?></td>
				<td class="checkbox">
					<input type="checkbox" key="<?php echo $row->id; ?>"/>
				</td>				
				<td class="checkbox">
					<?php echo $row->id; ?>
				</td>
				<td>
					<a href="<?php echo base_url("edit-event-schedule/" . $row->id . "?" . get_url_navigate()); ?>"><?php echo htmlspecialchars($row->name); ?></a>
				</td>	
				<td>
					<a href="<?php echo base_url("edit-device/" . $row->device_id . "?" . get_url_navigate()); ?>"><?php echo htmlspecialchars($row->device_name); ?></a>
				</td>				
				<td>
					<?php
						$repeat_text = '';
						if ($row->repeat_type == 1){
							echo $this->lang->line('daily');
							$repeat_text = $this->lang->line('days');
						}
						else if ($row->repeat_type == 2){
							echo $this->lang->line('weekly');
							$repeat_text = $this->lang->line('weeks');
						}
						else{
							echo $this->lang->line('monthly');
							$repeat_text = $this->lang->line('months');
						}
					?>
				</td>
				<td class="tc">
					<?php echo $row->repeat_every . ' ' . $repeat_text; ?>
				</td>
				<td class="tc">
					<?php echo htmlspecialchars($row->start_on_format); ?>
				</td>
				<td class="tc">
					<?php if ($row->status == 1) { ?>
						<img src="<?php echo base_url('images/enabled.gif');?>" title="<?php echo $this->lang->line('enabled');?>"/>
					<?php } ?>
				</td>							
				<td class="tc">					
					<a href="<?php echo base_url("edit-event-schedule/" . $row->id . "?" . get_url_navigate()); ?>"><?php echo $this->lang->line('edit');?></a> 
					| <a href="javascript:void(0)" onclick="delete_1_data('<?php echo $this->lang->line('event');?>', 'delete_events_schedule', '<?php echo $row->id; ?>')"><?php echo $this->lang->line('delete');?></a>					
				</td>
			</tr>
			<?php
			$start_index++;
			$i++;
			endforeach;
		else:
		 ?>
			<tr>
				<td colspan="10">
					<?php echo $this->lang->line("data-not-found");?>
				</td>
			</tr>
		<?php endif ?>
	</tbody>
</table>	
<?php echo $paging_bar; ?>	