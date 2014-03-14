<h1 class="form-title"><?php echo $this->lang->line('menus');?></h1>
<div class="input-box">		
	<input type="hidden" id="ajax_view" value="ajax_menu"/>
	<input type="hidden" id="sort_by" value=""/>
	<input type="hidden" id="ascending" value=""/>
	<span class="left">
		<a href="<?php echo base_url("add-menu");?>" class="btn btn-yellow"><?php echo $this->lang->line('new');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="edit_data('<?php echo $this->lang->line('menu');?>', 'edit-menu')"><?php echo $this->lang->line('edit');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="active_data('<?php echo $this->lang->line('menu');?>', '<?php echo $this->lang->line('enable');?>', 'active_menu', 1)"><?php echo $this->lang->line('enable');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="active_data('<?php echo $this->lang->line('menu');?>', '<?php echo $this->lang->line('disable');?>', 'active_menu', 0)"><?php echo $this->lang->line('disable');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="delete_data('<?php echo $this->lang->line('menu');?>', 'delete_menu')"><?php echo $this->lang->line('delete');?></a>
		<a href="<?php echo $data["submenu-url"];?>" class="btn btn-yellow"><?php echo $this->lang->line('submenu');?></a>
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
	<?php include "menu-table.php"; ?>
</div>
<span class='tips'><img src='<?php echo base_url('images/drag-drop.png');?>' align='absmiddle' alt=''/><?php echo $this->lang->line('drag-drop-position');?></span>
<script type="text/javascript">	
	function move_record(id, is_up, position){
		$.post(base_url + controller_name + 'update_menu_position', {id: id, is_up: is_up ? 1 : 0, position: position ? position : ''}, function(e){
			reload_data();
		});
	}	
	//function is called after load ajax done
	function extend_finish_load_data(){
		if ($(".table-list tbody tr").length > 1){
			$(".table-list tbody").sortable({
				cursor:'move',
				delay: 150,
				revert: true,				
				update: function(event, ui){	
					//move_record($("#id").val(), true, $("#position").val());									
					var input = ui.item.find('input:first');
					if (input.length > 0){
						var index = ui.item[0].rowIndex;
						var id = input.attr('key');
						move_record(id, true, index);						
					}				
				}				
			});
		}
	}
	//call at the first time
	extend_finish_load_data();
</script>