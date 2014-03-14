<?php 		
	$paging_bar = paging_bar($data['num_rows'], $data['page_size'], $data['page'], $controller_name, "ajax_submenu", get_url_navigate()); ?>
	<?php echo $paging_bar; ?>
<table cellpadding="0" cellspacing="0" width="100%" class="table-list" page_size="<?php echo $data['page_size'];?>">
	<thead>
		<tr>
			<th class="checkbox"></th>
			<th class="checkbox">
				<input type="checkbox" onclick="check_all(this.checked)"/>
			</th>
			<th style='width:60px'>
				<a href='javascript:void(0)' sort="id"><?php echo $this->lang->line('id');?></a>
			</th>			
			<th>
				<a href='javascript:void(0)' sort="title"><?php echo $this->lang->line('title'); ?></a>
			</th>			
			<th style="width:180px">
				<a href='javascript:void(0)' sort="menu-title"><?php echo $this->lang->line('menu'); ?></a>
			</th>
			<th style="width:140px">
				<a href='javascript:void(0)' sort='module'><?php echo $this->lang->line('module');?></a>
			</th>			
			<th style="width:100px">
				<a href='javascript:void(0)' sort="created-date"><?php echo $this->lang->line('created-date'); ?></a>
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
			<tr <?php echo $i % 2 == 0 ? "class='even'" : "";?> <?php echo "menu_id='" . $row->menu_id . "'";?> <?php echo "position='" . $row->position . "'";?>>
				<td class="checkbox"><?php echo $start_index; ?></td>
				<td class="checkbox">
					<input type="checkbox" key="<?php echo $row->id; ?>"/>
				</td>
				<td style="width:60px" class="checkbox">
					<?php echo $row->id; ?>
				</td>				
				<td style="width:236px" >
					<a target="_blank" href="<?php echo correct_link($row->link); ?>"><?php echo htmlspecialchars($row->title); ?></a>
				</td>				
				<td style="width:188px" >
					<a href="<?php echo base_url('edit-menu/' . $row->menu_id);?>"><?php echo htmlspecialchars($row->menu_title); ?></a>
				</td>
				<td style="width:140px">
					<a href='<?php echo correct_link($row->link);?>'><?php echo htmlspecialchars($row->module_name); ?></a>
				</td>
				<td style="width:100px" class="tc">
					<?php echo htmlspecialchars($row->created_date_format); ?>
				</td>
				<td style="width:60px" class="tc">
					<?php if ($row->status == 1) { ?>
						<img src="<?php echo base_url('images/enabled.gif');?>" title="<?php echo htmlspecialchars($this->lang->line('enabled'));?>"/>
					<?php } ?>
				</td>				
				<td style="width:100px" class="tc">					
					<a href="<?php echo base_url("edit-submenu/" . $row->id . "?" . get_url_navigate());?>"><?php echo $this->lang->line('edit');?></a> 
					| <a href="javascript:void(0)" onclick="delete_1_data('<?php echo $this->lang->line('submenu');?>', 'delete_submenu', '<?php echo $row->id; ?>')"><?php echo $this->lang->line('delete');?></a>					
				</td>
			</tr>
			<?php
			$start_index++;
			$i++;
			endforeach;
		else:
		 ?>
			<tr>
				<td colspan="9">
					<?php echo $this->lang->line('data-not-found');?>
				</td>
			</tr>
		<?php endif ?>
	</tbody>
</table>	
<?php echo $paging_bar; ?>	