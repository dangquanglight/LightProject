<h1 class="form-title"><?php echo $this->lang->line('event-logs');?></h1>
<div class="input-box">
	<label class="text"><?php echo $this->lang->line('device');?>:</label>
	<b><?php echo $data['device']->device_name;?></b>
</div>
<div class="ib">		
	<input type="hidden" id="ajax_view" value="ajax_event_logs"/>
	<input type="hidden" id="sort_by" value=""/>
	<input type="hidden" id="ascending" value=""/>	
</div>
<div id="d-list-data">	
	<?php include "event-logs-table.php"; ?>
</div>
<div class="actions">
	<a class="btn btn-yellow" href='<?php echo base_url('devices');?>'><?php echo $this->lang->line('back-to-devices');?></a>
</div>
<div class='popup log-popup'>
	<h2><img align='absmiddle' class='mr8' src='<?php echo base_url('images/event.png');?>' alt=''/><?php echo $this->lang->line('log-time');?></h2>
	<div class='content'></div>
</div>
<script type='text/javascript'>
	$(function(){
		var timeout_key = null;
		$('.date-cell').hover(function(){			
			var text = '';
			var minutes = $(this).attr('minutes_log').split(' ');
			var date = $.trim($(this).parent().find('td:nth(1)').text());
			var values = $(this).attr('values').split(' ');
			for(var i = 0; i < minutes.length; i++){
				text += '<p class="mb8">' + date + ' ' + minutes[i] + '<span class="red ml12">' + format_number(values[i]) + '</span></p>';
			}
			var offset = $(this).position();
			clearTimeout(timeout_key);
			$('.popup .content').html(text).parent().css({top: (offset.top - 20) + 'px', left: (offset.left + $(this).outerWidth()) + 'px'}).show();			
		}, function(){
			timeout_key = setTimeout(function(){
				$('.popup').hide();
			}, 300);
		});
		$('.popup').hover(function(){
			clearTimeout(timeout_key);
		}, function(){
			timeout_key = setTimeout(function(){
				$('.popup').hide();
			}, 300);
		});
	});
</script>