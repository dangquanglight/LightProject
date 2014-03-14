<?php 		
	$paging_bar = paging_bar($data['num_rows'], $data['page_size'], $data['page'], $controller_name, "ajax_measurements", get_url_navigate()); ?>
	<?php echo $paging_bar; ?>
<table cellpadding="0" cellspacing="0" width="100%" class="table-list" page_size="<?php echo $data['page_size'];?>">
	<thead>
		<tr>
			<th class="checkbox"></th>
			<th class="checkbox">
				<input type="checkbox" onclick="check_all(this.checked)"/>
			</th>
			<th>
				<a href='javascript:void(0)' sort="device-name"><?php echo $this->lang->line('device-name');?></a>
			</th>
			<th style='width:120px'>
				<a href='javascript:void(0)' sort="zone"><?php echo $this->lang->line('zone');?></a>
			</th>
			<th style='width:120px'>
				<a href='javascript:void(0)' sort="type"><?php echo $this->lang->line('type');?></a>
			</th>
			<th style='width:120px'>
				<a href='javascript:void(0)' sort="value"><?php echo $this->lang->line('value');?></a>
			</th>
			<th style="width:130px">
				<a href='javascript:void(0)' sort="timestamp"><?php echo $this->lang->line('timestamp');?></a>
			</th>
			<th style="width:130px">
				<a href='javascript:void(0)' sort="created-date"><?php echo $this->lang->line('created-date');?></a>
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
			foreach($data['data']->result() as $row): ?>
			<tr <?php echo $i % 2 == 0 ? "class='even'" : "";?>>
				<td class="checkbox"><?php echo $start_index; ?></td>
				<td class="checkbox">
					<input type="checkbox" key="<?php echo $row->id; ?>"/>
				</td>
				<td>
					<a href="<?php echo base_url("edit-device/" . $row->id . "?" . get_url_navigate()); ?>"><?php echo htmlspecialchars($row->device_name); ?></a>
				</td>
				<td>
					<a href="<?php echo base_url('edit-zone/' . htmlspecialchars($row->zone_id)); ?>"><?php echo htmlspecialchars($row->zone_name); ?></a>
				</td>
				<td>
					<a href="<?php echo base_url('edit-sub-type/' . htmlspecialchars($row->sub_type_id)); ?>"><?php echo htmlspecialchars($row->sub_type_name); ?></a>
				</td>
				<td>
					<?php echo htmlspecialchars($row->value); ?>
				</td>
				<td class="tc">
					<?php echo htmlspecialchars($row->datetime_format); ?>
				</td>
				<td class="tc">
					<?php echo htmlspecialchars($row->created_date_format); ?>
				</td>
				<td class="tc">					
					<a href="javascript:void(0)" onclick="delete_1_data('<?php echo $this->lang->line('measurement');?>', 'delete_measurements', '<?php echo $row->id; ?>')"><?php echo $this->lang->line('delete');?></a>					
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