<h1 class="form-title"><?php echo $this->lang->line('events');?></h1>
<div class="ib">		
	<input type="hidden" id="ajax_view" value="ajax_events"/>
	<input type="hidden" id="sort_by" value=""/>
	<input type="hidden" id="ascending" value=""/>
	<span class="left">
		<a id='new-event' href="javascript:void(0)" class="btn btn-yellow"><?php echo $this->lang->line('new');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="edit_data('<?php echo $this->lang->line('event');?>', 'edit-event')"><?php echo $this->lang->line('edit');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="active_data('<?php echo $this->lang->line('events');?>', '<?php echo $this->lang->line('enable');?>', 'active_events', 1)"><?php echo $this->lang->line('enable');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="active_data('<?php echo $this->lang->line('events');?>', '<?php echo $this->lang->line('disable');?>', 'active_events', 0)"><?php echo $this->lang->line('disable');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="delete_data('<?php echo $this->lang->line('events');?>', 'delete_events')"><?php echo $this->lang->line('delete');?></a>
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
	<?php include "events-table.php"; ?>
</div>

<script type='text/javascript'>
	$(function(){
		$('#new-event').click(function(){
			var html = "<div id='mask'  style='position:fixed;top:0;height:0;width:100%;height:100%;opacity:0.8;background-color:gray;z-index:10000;'></div>";
			var html_option_mark = "<div id='mask-option' style='position:fixed;width:450px;top:150px;left:400px;border:solid 5px #CCC;background-color:white;z-index:10001;'><div style='padding:0 30px 30px 30px;'><h1 class='form-title'><?php echo $this->lang->line('add-event');?></h1><a id='new-event' href='<?php echo base_url('add-event');?>' class='btn btn-yellow'><?php echo $this->lang->line('add-condition-based');?></a><a id='new-event' href='<?php echo base_url('add-event-schedule');?>' class='btn btn-yellow'><?php echo $this->lang->line('add-time-based');?></a><img id='close-popup' style='cursor:pointer;position:absolute;right:-20px;top:-20px' title='<?php echo $this->lang->line('close');?>' src='<?php echo base_url('images/error.png');?>'/></div></div>";
			remove_mask();
			$('body').append(html);
			$('body').append(html_option_mark);
			set_center_screen($('#mark-option'));
			$('#close-popup').click(function(){
				remove_mask();
			});
			
			function remove_mask(){
				$('#mask').remove();
				$('#mask-option').remove();
			}
		});
	});
</script>