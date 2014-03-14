<h1 class="form-title"><?php echo $this->lang->line('submenu'); ?></h1>
<div class="input-box">		
	<input type="hidden" id="ajax_view" value="ajax_submenu"/>
	<input type="hidden" id="sort_by" value=""/>
	<input type="hidden" id="ascending" value=""/>
	<span class="left">
		<a href="<?php echo base_url("add-submenu");?>" class="btn btn-yellow"><?php echo $this->lang->line('new');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="edit_data('<?php echo $this->lang->line('submenu'); ?>', 'sua-submenu-top')"><?php echo $this->lang->line('edit');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="active_data('<?php echo $this->lang->line('submenu'); ?>', '<?php echo $this->lang->line('enable');?>', 'active_submenu', 1)"><?php echo $this->lang->line('enable');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="active_data('<?php echo $this->lang->line('submenu'); ?>', '<?php echo $this->lang->line('disable');?>', 'active_submenu', 0)"><?php echo $this->lang->line('disable');?></a>
		<a href="javascript:void(0)" class="btn btn-yellow" onclick="delete_data('<?php echo $this->lang->line('submenu'); ?>', 'delete_submenu')"><?php echo $this->lang->line('delete');?></a>
		<a href="<?php echo $data['menu-url'];?>" class="btn btn-yellow"><?php echo $this->lang->line('menu');?></a>
	</span>
	<span class="right">
		<span><?php echo $this->lang->line('menu'); ?></span>		
		<select id="menu_id" name="menu_id" class="normal">
			<option value=""><?php echo $this->lang->line('all');?></option>
			<?php				
			foreach($data['menu']->result() as $row): ?>
				<option value="<?php echo $row->id; ?>" <?php echo $row->id == $data['menu_id'] ? "selected" : ""; ?>><?php echo htmlspecialchars($row->title); ?></option>
			<?php endforeach ?>			
		</select>		
		<input id="h_search_type" name="h_search_type" type="hidden" value=""/>
		<input id="keywords" name="keywords" type="text" value="<?php echo $this->input->get('keywords') ?>" class="normal" placeholder="<?php echo $this->lang->line('your_keywords');?>"/>
		<input id="h_keywords" name="h_keywords" type="hidden" value=""/>
		<img class="search" align="top" src="<?php echo file_image('search.png'); ?>" onclick="do_search()"/>		
		<img class="search" align="top" src="<?php echo file_image('reload-icon.png'); ?>" onclick="reload_search()"/>
	</span>
	<div class="clear"></div>
</div>
<div id="d-list-data">	
	<?php include "submenu-table.php"; ?>
</div>
<span class='tips'><img src='<?php echo base_url('images/drag-drop.png');?>' align='absmiddle' alt=''/>
<?php echo $this->lang->line('drag-drop-position') .  ' ' . $this->lang->line('need-to-filer-by-menu');?></span>
<script type="text/javascript">	
	function move_record(id, is_up, position){
		$.post(base_url + controller_name + 'update_submenu_position', {id: id, is_up: is_up ? 1 : 0, position: position ? position : ''}, function(e){		
			reload_data();
		});
	}	
	//function is called after load ajax done
	function extend_finish_load_data(){
		var arRawPosition = new Array();
		$(".table-list tbody tr").each(function(){
			arRawPosition[arRawPosition.length] = $(this).attr('position');
		});
		
		if ($(".table-list tbody tr").length > 1){
			$(".table-list tbody").sortable({
				cursor:'move',
				delay: 0,				
				revert: true,				
				update: function(event, ui){						
					var input = ui.item.find('input:first');
					if (input.length > 0){
						//get new position
						var index = arRawPosition[ui.item[0].rowIndex - 1];
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