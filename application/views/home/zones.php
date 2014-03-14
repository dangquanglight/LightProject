<h1 class="form-title"><?php echo $this->lang->line('zones');?></h1>
<div class="ib">		
	<input type="hidden" id="ajax_view" value="ajax_zones"/>
	<input type="hidden" id="sort_by" value=""/>
	<input type="hidden" id="ascending" value=""/>
	<span class="left">
		<a href="<?php echo base_url("add-zone");?>" class="btn btn-yellow"><?php echo $this->lang->line('new');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="edit_data('<?php echo $this->lang->line('zone');?>', 'edit-zone')"><?php echo $this->lang->line('edit');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="active_data('<?php echo $this->lang->line('zones');?>', '<?php echo $this->lang->line('enable');?>', 'active_zones', 1)"><?php echo $this->lang->line('enable');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="active_data('<?php echo $this->lang->line('zones');?>', '<?php echo $this->lang->line('disable');?>', 'active_zones', 0)"><?php echo $this->lang->line('disable');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="delete_data('<?php echo $this->lang->line('zones');?>', 'delete_zones')"><?php echo $this->lang->line('delete');?></a>
		<a href="<?php echo base_url("sites");?>" class="btn btn-yellow"><?php echo $this->lang->line('sites');?></a>
	</span>
	<span class="right">				
		<input id="h_search_type" name="h_search_type" type="hidden" value=""/>
		<span class='mr8'><?php echo $this->lang->line('site');?></span><select id='site_id' name='site_id' class="normal text" style='width:150px'>
			<option value=''><?php echo $this->lang->line('all');?></option>
			<?php foreach($data['sites']->result() as $row){
				echo "<option value='" . $row->id . "' " . ($data['site_id'] == $row->id ? 'selected': '') . ">" . htmlspecialchars($row->site_name) . "</option>";
			} ?>
		</select>
		<input id="keywords" name="keywords" type="text" value="<?php echo $this->input->get('keywords') ?>" class="normal" placeholder="<?php echo $this->lang->line('your-keywords'); ?>"/>
		<input id="h_keywords" name="h_keywords" type="hidden" value=""/>
		<img class="search" align="top" src="<?php echo file_image('search.png'); ?>" onclick="do_search()"/>		
		<img class="search" align="top" src="<?php echo file_image('reload-icon.png'); ?>" onclick="reload_search()"/>
	</span>
	<div class="clear"></div>
</div>
<div id="d-list-data">	
	<?php include "zones-table.php"; ?>
</div>