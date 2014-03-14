<?php 		
	$paging_bar = paging_bar($data['num_rows'], $data['page_size'], $data['page'], $controller_name, "ajax_email_template", get_url_navigate()); ?>
	<?php echo $paging_bar; ?>
<table cellpadding="0" cellspacing="0" width="100%" class="table-list" page_size="<?php echo $data['page_size'];?>">
	<thead>
		<tr>
			<th class="checkbox"></th>			
			<th class="checkbox">
				<input type="checkbox" onclick="check_all(this.checked)"/>
			</th>	
			<th class="checkbox">
				<a href='javascript:void(0)' sort='title'><?php echo $this->lang->line('id'); ?></a>
			</th>			
			<th style="width:120px">
				<a href='javascript:void(0)' sort='title-en'><?php echo $this->lang->line('title-en'); ?></a>
			</th>
			<th style="width:120px">
				<a href='javascript:void(0)' sort='title-fi'><?php echo $this->lang->line('title-fi'); ?></a>
			</th>
			<th style="width:120px">
				<a href='javascript:void(0)' sort='title-ci'><?php echo $this->lang->line('title-ci'); ?></a>
			</th>
			<th style="width:80px">
				<a href='javascript:void(0)' sort='created-date'><?php echo $this->lang->line('created-date');?></a>
			</th>			
			<th style="width:60px">
				<a href='javascript:void(0)' sort='status'><?php echo $this->lang->line('status');?></a>
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
				<td class="tc">
					<?php echo $row->id; ?>
				</td>
				<td>
					<?php echo htmlspecialchars($row->title_en); ?>
				</td>
				<td>
					<?php echo htmlspecialchars($row->title_fi); ?>
				</td>
				<td>
					<?php echo htmlspecialchars($row->title_ci); ?>
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
					<a href="<?php echo base_url("edit-email-template/" . $row->id . "?" . get_url_navigate());?>"><?php echo $this->lang->line('edit');?></a> 
					| <a href="javascript:void(0)" onclick="delete_1_data('email-template', 'delete_email_templates', '<?php echo $row->id; ?>')"><?php echo $this->lang->line('delete');?></a>					
				</td>
			</tr>
			<?php
			$start_index++;
			$i++;
			endforeach;
		else:
		 ?>
			<tr>
				<td colspan="7">
					<?php echo $this->lang->line('data-not-found');?>
				</td>
			</tr>
		<?php endif ?>
	</tbody>
</table>	
<?php echo $paging_bar; ?>	