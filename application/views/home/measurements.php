<h1 class="form-title"><?php echo $this->lang->line('measurements');?></h1>
<div class="ib">		
	<input type="hidden" id="ajax_view" value="ajax_measurements"/>
	<input type="hidden" id="sort_by" value=""/>
	<input type="hidden" id="ascending" value=""/>
	<span class="left">		
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="delete_data('<?php echo $this->lang->line('measurements');?>', 'delete_measurements')"><?php echo $this->lang->line('delete');?></a>
	</span>
	<span class="right">				
		<input id="h_search_type" name="h_search_type" type="hidden" value=""/>
		<input id="keywords" name="keywords" type="text" value="<?php echo $this->input->get('keywords') ?>" class="normal" placeholder="<?php echo $this->lang->line('your-keywords'); ?>"/>
		<input id="h_keywords" name="h_keywords" type="hidden" value=""/>
		<img class="search" align="top" src="<?php echo file_image('search.png'); ?>" onclick="do_search()"/>		
		<img class="search" align="top" src="<?php echo file_image('reload-icon.png'); ?>" onclick="reload_search()"/>
	</span>
	<div class="clear"></div>
</div>
<div id="d-list-data">	
	<?php include "measurements-table.php"; ?>
</div>