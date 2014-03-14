<h1 class="form-title"><?php echo $this->lang->line('cms'); ?></h1>
<div class="input-box">		
	<input type="hidden" id="ajax_view" value="ajax_cms"/>
	<input type="hidden" id="sort_by" value=""/>
	<input type="hidden" id="ascending" value=""/>
	<span class="left">
		<a href="<?php echo base_url("add-cms");?>" class="btn btn-yellow"><?php echo $this->lang->line('new');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="edit_data('<?php echo $this->lang->line('cms');?>', 'sua-noi-dung')"><?php echo $this->lang->line('edit');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="active_data('<?php echo $this->lang->line('cms');?>', '<?php echo $this->lang->line('enable');?>', 'active_cms', 1)"><?php echo $this->lang->line('enable');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="active_data('<?php echo $this->lang->line('cms');?>', '<?php echo $this->lang->line('disable');?>', 'active_cms', 0)"><?php echo $this->lang->line('disable');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="delete_data('<?php echo $this->lang->line('cms');?>', 'delete_cms')"><?php echo $this->lang->line('delete');?></a>
	</span>
	<span class="right">				
		<input id="h_search_type" name="h_search_type" type="hidden" value=""/>
		<input id="keywords" name="keywords" type="text" value="<?php echo $this->input->get('keywords') ?>" class="normal" placeholder="<?php echo $this->lang->line('your_keywords'); ?>"/>
		<input id="h_keywords" name="h_keywords" type="hidden" value=""/>
		<img class="search" align="top" src="<?php echo file_image('search.png'); ?>" onclick="do_search()"/>		
		<img class="search" align="top" src="<?php echo file_image('reload-icon.png'); ?>" onclick="reload_search()"/>
	</span>
	<div class="clear"></div>
</div>
<div id="d-list-data">	
	<?php include "cms-table.php"; ?>
</div>