<?php 				
	$paging_bar = paging_bar($data['num_rows'], $data['page_size'], $data['page'], $controller_name, "ajax_users", get_url_navigate()); ?>
	<?php echo $paging_bar; ?>
<table cellpadding="0" cellspacing="0" width="100%" class="table-list" page_size="<?php echo $data['page_size'];?>">
	<thead>
		<tr>
			<th class="checkbox"></th>
			<th class="checkbox">
				<input type="checkbox" onclick="check_all(this.checked)"/>
			</th>
			<th style="width:40px;">
				<a href='javascript:void(0)' sort='id'><?php echo $this->lang->line('id');?></a>
			</th>			
			<th>
				<a href='javascript:void(0)' sort='name'><?php echo $this->lang->line('name');?></a>
			</th>			
			<th style="width:220px">
				<a href='javascript:void(0)' sort='email'><?php echo $this->lang->line('email');?></a>
			</th>			
			<th style="width:120px;">
				<a href='javascript:void(0)' sort='role'><?php echo $this->lang->line('role');?></a>
			</th>
			<th style="width:130px">
				<a href='javascript:void(0)' sort='created-date'><?php echo $this->lang->line('created-date');?></a>
			</th>
			<th style="width:60px">
				<a href='javascript:void(0)' sort='status'><?php echo $this->lang->line('status');?></a>
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
				<td class="tc">
					<?php echo htmlspecialchars($row->id); ?>
				</td>
				<td>
					<?php echo htmlspecialchars($row->full_name); ?>
				</td>
				<td>
					<a href="mailto:<?php echo htmlspecialchars($row->email); ?>"><?php echo htmlspecialchars($row->email); ?></a>
				</td>
				<td>
					<a href="<?php echo base_url('edit-role/' . $row->role_id);?>"><?php echo htmlspecialchars($row->role_name); ?></a>
				</td>
				<td class="tc">
					<?php echo htmlspecialchars($row->created_date_format); ?>
				</td>				
				<td class="tc">
					<?php if ($row->status == 1) { ?>
						<img src="<?php echo base_url('images/enabled.gif');?>" title="<?php echo htmlspecialchars($this->lang->line('enabled'));?>"/>
					<?php } ?>
				</td>				
				<td class="tc">					
					<a href="<?php echo base_url("edit-user/" . $row->id . "?" . get_url_navigate());?>"><?php echo $this->lang->line('edit');?></a> 
					| <a href="javascript:void(0)" onclick="delete_1_data('<?php echo $this->lang->line('user');?>', 'delete_users', '<?php echo $row->id; ?>')"><?php echo $this->lang->line('delete');?></a>					
				</td>
			</tr>
			<?php
			$start_index++;
			$i++;
			endforeach;
		else:
		 ?>
			<tr>
				<td colspan="8">
					<?php echo $this->lang->line('data_not_found');?>
				</td>
			</tr>
		<?php endif ?>
	</tbody>
</table>	
<?php echo $paging_bar; ?>
<script type="text/javascript">
	$("a.slide").lightBox();
</script>