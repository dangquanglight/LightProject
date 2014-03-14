<h1 class='form-title'><?php echo $this->lang->line('zone-layout');?></h1>
<div class='zone-layout'>
	<div class='left'>
		<h3 class='header-box tc relative'>
			<?php echo $this->lang->line('zone');?>
			<?php if ($data['next_zone']){ ?>
			<a class='abs' style='top:8px;right:5px;' href='<?php echo base_url('zone-layout/' . $data['next_zone']->id . '/' . text_to_title($data['next_zone']->zone_name));?>' title='<?php echo $this->lang->line('next-zone');?>'>
				<img src='<?php echo base_url('images/next.png');?>'></a>
			</a>
			<?php } ?>
			<?php if ($data['previous_zone']){ ?>
			<a class='abs' style='top:8px;left:5px;' href='<?php echo base_url('zone-layout/' . $data['previous_zone']->id . '/' . text_to_title($data['previous_zone']->zone_name));?>' title='<?php echo $this->lang->line('next-zone');?>'>
				<img src='<?php echo base_url('images/previous.png');?>'></a>
			</a>
			<?php } ?>
		</h3>
		<div class='zone-info'>
			<div class='ib'>
				<ul>
					<li><span class='b'><?php echo $this->lang->line('name') . '</span>: <a href="' . base_url('edit-zone/' . $data['zone']->id) . '">' . htmlspecialchars($data['zone']->zone_name) . '</a>';?></li>
					<li><span class='b'><?php echo $this->lang->line('devices') . '</span>: ' . htmlspecialchars($data['zone']->devices);?></li>
				</ul>
			</div>			
		</div>
		<h3 class='header-box tc'><?php echo $this->lang->line('devices');?></h3>
		<div class='devices'>
			<ul>
				<?php foreach($data['zones']->result() as $row){
						echo "<li><span ref='" . $row->id . "' type_id='" . $row->type_id . "' sub_type_id='" . $row->sub_type_id . "' class='chip chip" . $row->sub_type_id . " chip-device chip-black'><span class='icon'></span><span class='text'>" . $row->device_name . "</span></span></li>";
					} ?>
			</ul>			
		</div>
	</div>
	<div id='box-right' class='right relative'>
		<h3 class='header-box'>			
			<span id='device-alarm-icon' ref='list-alarm-icons' class='item relative icon-left'><img src='<?php echo base_url('images/upload.png');?>' class='abs' style='left:0px;top:0;'/> <?php echo $this->lang->line('upload-zone-layout');?>
			</span>
			<?php if (0){ ?>
			<span class='item relative icon-left'><img src='<?php echo base_url('images/alarm.png');?>' alt='alarm' class='abs' style='left:0px;top:0;'/> <label><?php echo $this->lang->line('enable-alarm');?> <input id='enable-alarm' type='checkbox' value='0' <?php echo $data['zone']->alarm_enabled ? 'checked': '';?>/></label>
			</span>
			<?php } ?>
			<span id='disable-alarm' ref='disable-alarm-minutes' class='item icon-right'><?php echo sprintf($this->lang->line('disable-alarm-minutes'), "<span id='minutes-disabled-remaining'>" . ($data['zone']->minutes_disabled_remaining > 0 ? ($data['zone']->minutes_disabled_remaining . ' ') : '') . "</span>");?></span>
		</h3>		
		<div id='disable-alarm-minutes' class='abs z1 suggestion hidden'>
			<ul>
				<li val='0' class='<?php echo $data['zone']->minutes_disabled_remaining == 0 ? 'checked' : '';?>'><?php echo $this->lang->line('enable-now');?></li>
				<?php					
					$arr_minutes = array(5, 10, 15, 20, 25, 30);
					foreach($arr_minutes as $minute){ ?>
						<li val='<?php echo $minute;?>' class='<?php echo $data['zone']->minutes_disabled_remaining > 0 && $data['zone']->minutes_alarm_disabled == $minute ? 'checked' : '';?>'><?php echo $this->lang->line($minute . '-minutes');?></li>
				<?php } ?>
			</ul>
		</div>
		<div id='image-box' class='relative'>
			<?php 
				$t = time();
				if ($data['zone']->has_layout){
				echo "<img id='zone-layout' src='" . base_url('uploads/zones/' . $data['zone']->id . '/layout.jpg?t=' . $t) . "' alt='zone-layout'/>";
			} ?>
			<?php 
				$has_old_device = false;
				foreach($data['devices']->result() as $dev){	
					$has_old_device = true;
					echo  sprintf("<span ref='%s' type_id='%s' sub_type_id='%s' class='chip chip%s ui-draggable added' style='left: %spx; top: %spx; border-color: transparent;'><span class='icon'></span><span class='text'>%s</span></span>", $dev->id, $dev->type_id, $dev->sub_type_id, $dev->sub_type_id, $dev->left, $dev->top, $dev->device_name);
				}				
				if ($has_old_device){ 
					echo "<script type='text/javascript'>$(function(){init_old_devices_draggable();})</script>";
				}			
			?>
			<div class='tooltip box'>
				<p id='t-device-name' class='ib b bb pb8 chip-black'></p>
				<p id='t-value' class='ib hidden'><label class='b'><?php echo $this->lang->line('value');?>: </label><span></span></p>
				<p id='t-image' class='ib hidden tc'><img src='' style='width:146px'/></p>
			</div>
		</div>
	</div>
	<div class='clear'></div>
</div>
<div id='overlay1' class="confirmOverlay" style="">
	<div id="confirmBox">
		<h1><?php echo $this->lang->line('confirmation');?></h1>
		<p><?php echo $this->lang->line('confirm-move-device');?></p><p><label><input id='no-display-again' type='checkbox' value='0'/> <?php echo $this->lang->line('dont-show-again');?></p>
		<div id="confirmButtons"><a id='btn-yes' href="javascript:void(0)" class="button blue"><?php echo $this->lang->line('yes');?><span></span></a><a id='btn-no' href="javascript:void(0)" class="button gray"><?php echo $this->lang->line('no');?><span></span></a>
		</div>
	</div>
</div>
<div id='overlay2' class="confirmOverlay" style="">
	<div id="confirmBox">
		<h1 class='device-name'></h1>
		<div id='confirmButtons'><span class='mr12'><?php echo $this->lang->line('value');?></span><input type='text' id='value' value=''/></div>
		<img src='<?php echo base_url('images/remove.png');?>' class='close'/>
	</div>
</div>
<div id='overlay3' class="confirmOverlay" style="">
	<div id="confirmBox">
		<h1 class='device-name'></h1>
		<div id='confirmButtons'>
			<div class='input-box'>
				<input id='manual' type='button' class='btn mr12' value='<?php echo $this->lang->line('manual');?>'/>
				<input id='auto' type='button' class='btn selected' value='<?php echo $this->lang->line('auto');?>'/>
			</div>
			<div class='input-box'>
				<input id='control-on' type='button' disabled class='btn mr12' value='<?php echo $this->lang->line('on');?>'/>
				<input id='control-off' type='button' disabled class='btn' value='<?php echo $this->lang->line('off');?>'/>
			</div>
		</div>
		<img src='<?php echo base_url('images/remove.png');?>' class='close'/>
	</div>
</div>

<script type='text/javascript' src='<?php echo base_url('js/fileuploader.js');?>'></script>
<script type='text/javascript'>	
	$(function(){			
		$('#device-alarm-icon').fileUpload({
			url: '<?php echo base_url('upload-zone-layout/' . $data['zone']->id);?>',
			done: function(data){
				if (data.error){
					alert(data.error);
				}
				else{
					var url = data.url + '?t=' + (new Date().getTime());
					if ($('#zone-layout').length == 1){
						$('#zone-layout').attr('src', url);
					}
					else{
						$('#image-box').append("<img src='" + url + "' id='zone-layout'/>");
					}
				}
			}
		});		
	});

	var mouse_inside_popup_list_icons = false;
	var mouse_inside_popup_list_alarm_minutes = false;
	var current_device_offset = null;
	var current_device = null;
	change_size_image_box();
	function change_size_image_box(){
		var width = $('.zone-layout').innerWidth() - 220;
		$('#box-right').width(width + 'px');
	}
	
	//TIMER
	//reload minutes disabled remaining
	var func_update_minutes_disabled_remaining = function(){
		$.post(base_url + 'minutes-disabled-remaining', {
				zone_id : '<?php echo $data['zone']->id;?>'
			},
			function(e){
				if (e && e > 0){
					$('#minutes-disabled-remaining').text(e + ' ');
				}
				else{
					$('#minutes-disabled-remaining').text('');
				}
			}
		);
		$('#minutes-disabled-remaining').text('');
	};
	//reload every 30 seconds
	setInterval(func_update_minutes_disabled_remaining, 30000);	

	//DISABLE DRAG IMAGE
	$('#image-box img').bind('dragstart', function(event){
		event.preventDefault();
		return false;
	});
	
	//HOVER ON DEVICES
	$('.devices li span').hover(function(){
		$('#image-box span[ref=' + $(this).attr('ref') + ']').css('border-color', 'red');
	}, function(){
		$('#image-box span[ref=' + $(this).attr('ref') + ']').css('border-color', 'transparent');
	});
	
	// EVENTS CHANGE ICON
	$('#disable-alarm').click(function(){
		var offset = $(this).position();
		var id = $(this).attr('ref');
		$('#' + id).css({left: (offset.left + 20) + 'px', top: (offset.top + $(this).outerHeight() + 10) + 'px'}).show();		
	});
		
	$('#list-icons').hover(function(){ 
		mouse_inside_popup_list_icons=true; 
	}, function(){ 
		mouse_inside_popup_list_icons=false; 
	});
	$('#disable-alarm-minutes').hover(function(){ 
		mouse_inside_popup_list_alarm_minutes=true; 
	}, function(){ 
		mouse_inside_popup_list_alarm_minutes=false; 
	});
	$("body").mouseup(function(){ 
		if(!mouse_inside_popup_list_icons){$('#list-icons').hide();}
		if(!mouse_inside_popup_list_alarm_minutes){$('#disable-alarm-minutes').hide();}
	});
	
	$('#list-icons li').click(function(){
		var val = $(this).attr('class');		
		$('.devices .chip, #image-box .chip').each(function(){			
			$(this).removeClass('chip-black chip-blue chip-red chip-yellow').addClass(val);
		});
		$(this).parent().parent().hide();
		// UPDATE COLOR
		$.post(base_url + 'update-device-color', {
				zone_id : '<?php echo $data['zone']->id;?>',
				color: val
			},
			function(e){
				if (e){
					alert(e);
				}
			}
		);
	});
	
	$('#disable-alarm-minutes li').click(function(){
		var val = $(this).attr('val');
		$.post(base_url + 'update-disable-alarm-minutes', {
				zone_id : '<?php echo $data['zone']->id;?>',
				minutes: val
			},
			function(e){
				if (e){
					alert(e);
				}
				else{
					func_update_minutes_disabled_remaining();
				}
			}
		);
		$('#disable-alarm-minutes').hide();
		$('#disable-alarm-minutes li').removeClass('checked');
		$(this).addClass('checked');
	});
	
	$('#enable-alarm').click(function(){
		var enabled = $(this).attr('checked') ? 1 : 0;
		$.post(base_url + 'enable-alarm', {
				zone_id : '<?php echo $data['zone']->id;?>',
				enabled: enabled
			},
			function(e){
				if (e){
					alert(e);
				}				
			}
		);		
	});
		
	// CONFIRM BOX
	$('#btn-yes').click(function(){
		update_device_position(current_device);
		$('#overlay1').hide();
	});
	
	$('#btn-no').click(function(){
		$('#overlay1').hide();
		current_device.animate({left: current_device_offset.left + 'px', top: current_device_offset.top + 'px'});
	});
	
	$('#overlay2 .close').click(function(){
		$(this).parent().parent().hide();
	});
	
	setTextboxNumeric('#overlay2 #value');
	$('.devices li').click(function(){
		var chip = $(this).find('.chip');
		var device_id = chip.attr('ref');
		var sub_type_id = chip.attr('sub_type_id');
		var type_id = chip.attr('type_id');
		if (type_id == 4){
			//adjustment type
			var popup = $('#overlay2');
			popup.find('.device-name').text($(this).find('.text').text());
			$.post(base_url + 'latest-value', {device_id: device_id}, function(e){
				if (e){
					e = $.parseJSON(e);
					popup.find('#value').val(e.value).spinner({
						stop: function(event, ui){
							set_value(device_id, popup.find('#value').val(), null);
						}
					});
					$('#overlay2').show();
				}
			});
		}
		else if (type_id == 3){
			//manual type
			var popup = $('#overlay3');
			popup.find('.device-name').text($(this).find('.text').text());
			//ACTIVATE ALL AT TIME FIRST TIME
			
			enable_events(device_id, 1, function(){
				$('#manual').removeClass('selected');
				$('#auto').addClass('selected');
				$('#control-on').attr('disabled', true);
				$('#control-off').attr('disabled', true);
				$('#overlay3').show();
				
				$('#overlay3 .close').unbind('click').bind('click', function(){
					//ACTIVATE ALL WHEN FORM IS CLOSED
					enable_events(device_id, 1, null);
					$(this).parent().parent().hide();
				});
			});
			$('#manual').unbind('click').bind('click', function(){	
				var btn = this;
				//DISABLE WHEN CHANGE TO MANUAL
				enable_events(device_id, 0, function(){
					$(btn).addClass('selected');
					$('#auto').removeClass('selected');
					$('#control-on').removeAttr('disabled');
					$('#control-off').removeAttr('disabled');
				});
			});
			$('#auto').unbind('click').bind('click', function(){
				var btn = this;
				//ENABLE WHEN CHANGE TO AUTO
				enable_events(device_id, 1, function(){
					$(btn).addClass('selected');
					$('#manual').removeClass('selected');
					$('#control-on').attr('disabled', true);
					$('#control-off').attr('disabled', true);
				});
			});
			$('#control-on').unbind('click').bind('click', function(){
				set_value(device_id, 1, null);
			});
			$('#control-off').unbind('click').bind('click', function(){
				set_value(device_id, 0, null);
			});
		}
	});
	
	function set_value(device_id, value, func){
		$.post(base_url + 'set-latest-value', {device_id: device_id, value: value}, function(e){
			if (func != null){
				func(e);
			}
		});
	}
	
	function enable_events(device_id, enabled, func){
		$.post(base_url + 'enable-all-events', {active: enabled, device_id: device_id}, function(e){
			if (func != null){
				func(e);
			}			
		});
	}
	
	/*
	// DROP & DROP CHIP
	$('.devices .chip').draggable({revert: 'invalid', helper: "clone"});
	$('#image-box').droppable({
		accept: '.chip-device,.added',
		activeClass: "ui-state-active",
		activeClass: "ui-state-hover",
		drop: function(event, ui){			
			if (ui.draggable.hasClass('added')){
				if (!$('#no-display-again').attr('checked')){
					$('#confirmOverlay').show();
				}
				else{
					//UPDATE POSITION
					update_device_position(current_device);
				}
			}
			else{
				var left = ui.offset.left - $(this).offset().left;
				var top = ui.offset.top - $(this).offset().top					
				var item = ui.draggable.clone();	
				item.attr('type_id', $(this).attr('type_id'));
				//remove the old one				
				$('#image-box span[ref=' + item.attr('ref') + ']').remove();				
				//add new one
				item.css({'left': left, top: top}).removeClass('chip-device').appendTo($(this)).addClass('added');
				item.draggable({containment: 'parent', start: function(){
					current_device = $(this);
					current_device_offset = $(this).position();
				}});
				bound_tooltip(item);
				update_device_position(item);
			}
		}
	});
	*/
	
	var key_timeout_tooltip = null;
	function bound_tooltip(item){		
		item.hover(function(){						
			$('#t-device-name').text(item.text());
			function set_position(){
				var tooltip = $('.tooltip');
				var image_box = $('#image-box');
				var offset = $(item).position();
				var tHeight = tooltip.outerHeight();
				var top = offset.top + item.outerHeight() - tHeight - 5;
				var left = offset.left + item.outerWidth();
				if (top < 0){
					top = 0;
				}
				if (left + tooltip.outerWidth() > image_box.outerWidth()){
					left = offset.left - tooltip.outerWidth();
				}
				tooltip.css({left: left + 'px', top: top + 'px'}).show();
			}
					
			if (item.attr('sub_type_id') == 1){
				$('#t-value').hide();
				var t = new Date().getTime();
				$('#t-image img').attr('src', base_url + 'image-device/' + item.attr('ref') + '?t=' + t).bind('load', function(){
					$('#t-image').show();			
					set_position();
					$(this).unbind('load');
				});				
			}
			else{
				$('#t-image').hide();
				clearTimeout(key_timeout_tooltip);
				key_timeout_tooltip = setTimeout(function(){								
					$.post(base_url + 'latest-value', {device_id: item.attr('ref')}, function(e){
						if (e){
							e = $.parseJSON(e);
							$('#t-value span').text(e.value).show();
							$('#t-value').show();						
							set_position();
						}
					});			
				} , 1);
			}			
		},
		function(){
			clearTimeout(key_timeout_tooltip);
			$('.tooltip').hide();
		});
		
	}
	$(document).click(function(){
		$('.tooltip').hide();
	}).keydown(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if(code == 27) { 
		   $('.confirmOverlay').hide();
		}
	});
	
	function init_old_devices_draggable(){
		$('#image-box span.chip').draggable({
			containment: 'parent', 
			accept: '.chip-device,.added',
			start: function(){
				current_device = $(this);
				current_device_offset = $(this).position();
			},
			stop: function(event, ui){	
				if (ui.helper.hasClass('added')){
					if (!$('#no-display-again').attr('checked')){
						$('#overlay1').show();
					}
					else{
						//UPDATE POSITION
						update_device_position(current_device);
					}
				}
				else{
					var left = ui.offset.left - $(this).offset().left;
					var top = ui.offset.top - $(this).offset().top					
					var item = ui.draggable.clone();	
					item.attr('type_id', $(this).attr('type_id'));
					//remove the old one				
					$('#image-box span[ref=' + item.attr('ref') + ']').remove();				
					//add new one
					item.css({'left': left, top: top}).removeClass('chip-device').appendTo($(this)).addClass('added');
					item.draggable({containment: 'parent', start: function(){
						current_device = $(this);
						current_device_offset = $(this).position();
					}});
					bound_tooltip(item);
					update_device_position(item);
				}
			}
		}).each(function(){
			bound_tooltip($(this));
		});
	}
	
	// UPDATE POSITION
	function update_device_position(device){
		var offset = device.position();		
		$.post(base_url + 'update-device-position', 
			{
				zone_id: '<?php echo $data['zone']->id;?>',
				device_id: device.attr('ref'),
				left: offset.left,
				top: offset.top
			}, function(e){
				if (e){
					//alert(e);
				}
			}
		);
	}
	$(function(){
		alarms_func[alarms_func.length] = function(e){
			clearInterval(alarm_flash_key);
			$('#image-box .chip').removeClass('bred');
			if (e.device_ids.length > 0){			
				$('#image-box .chip').each(function(){
					if ($.inArray($(this).attr('ref'), e.device_ids) >= 0){
						$(this).addClass('alarm');
					}
					else{
						$(this).removeClass('alarm');
					}
				});
				active_alarm_flash();
			}
			else{
				$('#image-box .chip').removeClass('alarm');				
			}
		}
		var on_status = false;
		var alarm_flash_key = null;
		function active_alarm_flash(){
			alarm_flash_key = setInterval(function(){
				if (on_status == false){
					$('.alarm').addClass('bred');
				}
				else{
					$('.alarm').removeClass('bred');
				}
				on_status = !on_status;
			}, 500);
		}
	});
	
</script>