<?php 		
	$paging_bar = paging_bar($data['num_rows'], $data['page_size'], $data['page'], $controller_name, "ajax_types", get_url_navigate()); ?>
	<?php echo $paging_bar; ?>
<table cellpadding="0" cellspacing="0" width="100%" class="table-list" page_size="<?php echo $data['page_size'];?>">
	<thead>
		<tr>
			<th class="checkbox"></th>
			<th class="checkbox">
				<input type="checkbox" onclick="check_all(this.checked)"/>
			</th>			
			<th style='width:40px;'>
				<a href='javascript:void(0)' sort="id"><?php echo $this->lang->line('id');?></a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="type-name"><?php echo $this->lang->line('type-name');?></a>				
			</th>
			<th style="width:200px">
				<a href='javascript:void(0)'><?php echo $this->lang->line('description');?></a>
			</th>
			<th style="width:65px">
				<a href='javascript:void(0)'><?php echo $this->lang->line('sub-types');?></a>
			</th>
			<th style="width:120px">
				<a href='javascript:void(0)' sort="created-by"><?php echo $this->lang->line('created-by');?></a>
			</th>			
			<th style="width:100px">
				<a href='javascript:void(0)' sort="created-date"><?php echo $this->lang->line('created-date');?></a>
			</th>
			<th style="width:60px">
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
				<td class='tc'>
					<input type="checkbox" key="<?php echo $row->id; ?>"/>
				</td>				
				<td class='tc'>
					<?php echo htmlspecialchars($row->id); ?>
				</td>
				<td>					
					<a href='<?php echo base_url('edit-type/' . $row->id);?>'><?php echo htmlspecialchars($row->type_name); ?></a>
				</td>
				<td>
					<?php echo htmlspecialchars($row->description); ?>
				</td>
				<td class='tc'>					
					<a href='<?php echo base_url('sub-types?type_id=' . $row->id);?>'>[ <?php echo htmlspecialchars($row->total_sub_types); ?> ]</a>
				</td>
				<td>
					<a href='<?php echo base_url('edit-user/' . $row->created_by);?>'><?php echo htmlspecialchars($row->full_name); ?></a>
				</td>
				<td class="tc">
					<?php echo htmlspecialchars($row->created_date_format); ?>
				</td>
				<td class="tc">
					<?php if ($row->status == 1) { ?>
						<img src="<?php echo base_url('images/enabled.gif');?>" title="<?php echo $this->lang->line('enabled');?>"/>
					<?php } ?>
				</td>				
				<td class="tc">					
					<a href="<?php echo base_url("edit-type/" . $row->id . "?" . get_url_navigate()); ?>"><?php echo $this->lang->line('edit');?></a> 
					| <a href="javascript:void(0)" onclick="delete_1_data('<?php echo $this->lang->line('type');?>', 'delete_types', '<?php echo $row->id; ?>')"><?php echo $this->lang->line('delete');?></a>					
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