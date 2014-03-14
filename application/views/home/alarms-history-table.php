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
			<th>
				<a href='javascript:void(0)' sort="event-name"><?php echo $this->lang->line('event-name');?></a>				
			</th>
			<th style='width:100px;'>
				<a href='javascript:void(0)' sort="device-name"><?php echo $this->lang->line('device');?></a>				
			</th>
			<th style="width:100px">
				<a href='javascript:void(0)' sort="site"><?php echo $this->lang->line('site');?></a>
			</th>
			<th style="width:100px">
				<a href='javascript:void(0)' sort="zone"><?php echo $this->lang->line('zone');?></a>
			</th>
			<th style="width:150px">
				<a href='javascript:void(0)' sort="alarm-date"><?php echo $this->lang->line('alarm-time');?></a>
			</th>
			<th style='width:50px'>
				<a href='javascript:void(0)' sort=""><?php echo $this->lang->line('event');?></a>
			</th>
			<th style="width:60px"></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total = $data['data']->num_rows;
		$start_index = ($data['page'] - 1) * $data['page_size'] + 1;
		if ($total > 0):
			$i = 0;			
			$company_id = get_company_id();
			foreach($data['data']->result() as $row): ?>
			<tr <?php echo $i % 2 == 0 ? "class='even'" : "";?>>
				<td class="checkbox"><?php echo $start_index; ?></td>
				<td class='tc'>
					<input type="checkbox" key="<?php echo $row->id; ?>"/>
				</td>
				<td>					
					<?php if (!$row->is_schedule){ ?>
						<a href='<?php echo base_url('edit-event/' . $row->event_id);?>'><?php echo htmlspecialchars($row->event_name); ?></a>
					<?php } else { ?>
						<a href='<?php echo base_url('edit-event-schedule/' . $row->event_id);?>'><?php echo htmlspecialchars($row->event_name); ?></a>
					<?php } ?>
				</td>
				<td>
					<a href='<?php echo base_url('edit-device/' . $row->device_id);?>'><?php echo htmlspecialchars($row->device_name); ?></a>
				</td>
				<td>
					<a href='<?php echo base_url('edit-site/' . $row->site_id);?>'><?php echo htmlspecialchars($row->site_name); ?></a>
				</td>
				<td class='tc'>					
					<a href='<?php echo base_url('edit-zone/' . $row->zone_id);?>'><?php echo htmlspecialchars($row->zone_name); ?></a>
				</td>								
				<td class="tc">
					<?php echo htmlspecialchars($row->alarm_date_format); ?>
				</td>
				<td class="tc">
					<?php echo $row->is_on ? $this->lang->line('on') : $this->lang->line('off');?>
				</td>
				<td class="tc">					
					<a href="javascript:void(0)" onclick="delete_1_data('<?php echo $this->lang->line('alarm-history');?>', 'delete_alarms_history', '<?php echo $row->id; ?>')"><?php echo $this->lang->line('delete');?></a>					
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