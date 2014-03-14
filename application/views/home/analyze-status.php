<?php if ($data['device']){ ?>
<div id="analyze" class='relative chart-area-status'>
	<h1 class='form-title'><?php echo $this->lang->line('analyze-status');?></h1>
	<div>
		<ul id='devices-compare'>
			<li id='device1' class='relative' ref='<?php echo $data['device']->device_name;?>'>
				<p><label><?php echo $this->lang->line('device');?></label>:<span class='device-name'><?php echo $data['device']->device_name;?></span></p>
				<p><label><?php echo $this->lang->line('zone');?></label>:<span class='zone'><?php echo $data['device']->zone_name;?></span></p>
				<p><label><?php echo $this->lang->line('site');?></label>:<span class='site'><?php echo $data['device']->site_name;?></span></p>
			</li>
			<li id='device2' class='relative' title='<?php echo $this->lang->line('click-to-add-device-to-compare');?>' style='display:none'>
				<div class='item device2'>
					<p><label><?php echo $this->lang->line('device');?></label>:<span class='device-name'></span></p>
					<p><label><?php echo $this->lang->line('zone');?></label>:<span class='zone'></span></p>
					<p><label><?php echo $this->lang->line('site');?></label>:<span class='site'></span></p>					
					<img class='abs remove' style='top:3px;right:3px;' src='<?php echo base_url('images/remove.png');?>' alt='<?php echo $this->lang->line('remove');?>' title='<?php echo $this->lang->line('remove');?>'/>					
				</div>
				<div class='add-icon abs'>
					<img align='absmiddle' src='<?php echo base_url('images/add.png');?>' alt='' class='mr12'/><?php echo $this->lang->line('add-device-to-compare');?>
				</div>
			</li>
			<li id='device3' class='relative hidden' title='<?php echo $this->lang->line('click-to-add-device-to-compare');?>'>
				<div class='item device3'>
					<p><label><?php echo $this->lang->line('device');?></label>:<span class='device-name'></span></p>
					<p><label><?php echo $this->lang->line('zone');?></label>:<span class='zone'></span></p>
					<p><label><?php echo $this->lang->line('site');?></label>:<span class='site'></span></p>
					<img class='abs remove' style='top:3px;right:3px;' src='<?php echo base_url('images/remove.png');?>' alt='<?php echo $this->lang->line('remove');?>' title='<?php echo $this->lang->line('remove');?>'/>
				</div>
				<div class='add-icon ads'>
					<img align='absmiddle' src='<?php echo base_url('images/add.png');?>' alt='' class='mr12'/><?php echo $this->lang->line('add-device-to-compare');?>
				</div>				
			</li>
		</ul>
		<div class='clear'></div>
	</div>
	<div class='mt20'>
		<div class='chart-area-status'>
			<div>
				<div class='zoom mb12' style='display:inline'>
					<!--<span id='year' class='active'><?php echo $this->lang->line('this-year');?></span>-->				
					<span id='month' class='active'><?php echo $this->lang->line('this-month');?></span>
					<span id='week'><?php echo $this->lang->line('this-week');?></span>
					<span id='day'><?php echo $this->lang->line('today');?></span>
				</div>
				<span class='right'><?php echo $this->lang->line('date');?><input type='text' id='trend-calendar' value='<?php echo date('m/d/Y');?>'/></span>
				<div class='clear'></div>
			</div>
			<div id='d-chart' style='height:300px;'></div>
		</div>		
		<div class='mt12 chart-area chart3' style='margin:20px 0;width:100%'>			
			<h2 class='header'><?php echo $this->lang->line('key-performance-indicators');?></h2>
			<div class='inner-box box times-on left'>
				<h3><?php echo $this->lang->line('time-been-on');?></h3>
				<p class='ids'><span><?php echo $data['device']->device_name;?></span> <span class='others'></span></p>
				<p class='values'><span>&nbsp;</span></p>
			</div>
			<div class='inner-box box times-off left'>
				<h3><?php echo $this->lang->line('time-been-off');?></h3>
				<p class='ids'><span><?php echo $data['device']->device_name;?></span> <span class='others'></span></p>
				<p class='values'><span>&nbsp;</span></p>
			</div>
			<div class='inner-box box times-overlapped right'>
				<h3><?php echo $this->lang->line('overlapped-on-time');?></h3>
				<p class='ids'><span><?php echo $data['device']->device_name;?></span> <span class='others'></span></p>
				<p class='values'><span>&nbsp;</span></p>
			</div>
			<div class='inner-box box times-change-status right'>
				<h3><?php echo $this->lang->line('time-changing-status');?></h3>
				<p class='ids'><span><?php echo $data['device']->device_name;?></span> <span class='others'></span></p>
				<p class='values'><span>&nbsp;</span></p>
			</div>			
			<div class='clear'></div>
		</div>
	</div>
	<span class='next-pre-device'><?php 
	if ($data['previous-device-url']){
		echo "<a href='" . $data['previous-device-url'] . "' title='" . $this->lang->line('previous-device') . "'><img src='" . base_url('images/previous.png') . "' align='absmiddle'/></a>";			
	}
	if ($data['next-device-url']){
		if ($data['previous-device-url']){
			echo "&nbsp;&nbsp;&nbsp;";
		}
		echo "<a href='" . $data['next-device-url'] . "' title='" . $this->lang->line('next-device') . "'><img src='" . base_url('images/next.png') . "' align='absmiddle'/></a>";		
	}	
?></span>
</div>
<div id='dlg-devices' title='<?php echo $this->lang->line('devices');?>' class='hidden'>
	<form id='f-devices' action='' method='post'>
		<p class='tips'>Select a device to compare. Using zone to filter devices</p>
		<div class='mt12'>
			<div class='ib'>
				<label for='zone_id' class='text'><?php echo $this->lang->line('zone');?><span class='required'>*</span></label>
				<select id='zone_id' name='zone_id' class='normal'>
					<option value=''><?php echo $this->lang->line('please-select');?></option>
					<?php foreach($data['sites']->result() as $site){
						echo "<optgroup label='" . htmlspecialchars($site->site_name) . "'>";
						foreach($data['zones']->result() as $zone){
							if ($zone->site_id == $site->id){
								echo "<option value='" . htmlspecialchars($zone->id) . "'>" . htmlspecialchars($zone->zone_name) . " (" . $zone->devices .  ")</option>";
							}
						}
						echo "</optgroup>";
					} ?>			
				</select>
			</div>
			<div class='ib'>
				<label for='device_id' class='text'><?php echo $this->lang->line('device');?><span class='required'>*</span></label>
				<select id='device_id' name='device_id' class='normal'>					
				</select>
			</div>
		</div>	
	</form>
</div>
<script type='text/javascript' src='<?php echo base_url('js/highcharts.js');?>'></script>
<script type='text/javascript'>
	$(function(){
		
		analyze();
		var chart = null;		
		draw_chart();
		
		var dateFormat = 'mm/dd/yy';
		$('#trend-calendar').datepicker({dateFormat: dateFormat, onSelect: function(dateText){
			draw_chart();
		}});
		
		function draw_chart(){
			var ids = get_ids();
			var type = get_type();
			var date = '_';
			if ($('#trend-calendar').val()){
				date = $('#trend-calendar').val().replace(/\//g, '-');
			}
			var url = base_url + 'measurements-graph/' + ids + '/' + date;
			show_loading();
			$.get(url, function(e){
				if (e){
					e = $.parseJSON(e);					
					if (chart != null){
						chart.destroy();
					}					
					var categories = e.categories;
					var series = new Array();
					var names = get_devices_name();
					for(var i = 0; i < e.data.length; i++){
						var serie = new series_std(names[i], e.data[i]);
						series[series.length] = serie;
					}				
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'd-chart',
							type: 'line',
							marginRight: 130,
							marginBottom: 25,
							zoomType: 'x',
							events: {
								load: function(event){
									hide_loading();									
								}
							}
						},
						title: {
							text: 'Analyze status',
							x: -20 //center
						},
						xAxis: {
							categories: categories,
							labels: {
								enabled: false
							}
						},
						yAxis: {
							title: {
								text: 'Value'
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#808080'
							}]
						},
						tooltip: {
							formatter: function() {
									return '<b>'+ this.series.name +'</b><br/>'+
									this.x +': '+ this.y;
							}
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'top',
							x: -10,
							y: 100,
							borderWidth: 0
						},
						series: series
					});				
				}
			});
		}
		
		function get_ids(){
			var ids = '<?php echo $data['device']->id;?>';
			var li = $('#device1');
			var next_li = li.next();
			if (next_li.attr('ref') && next_li.attr('ref') != ''){
				ids += '-' + next_li.attr('ref');
				next_li = next_li.next();
				if (next_li.attr('ref') && next_li && next_li.attr('ref') != ''){
					ids += '-' + next_li.attr('ref');
				}
			}
			return ids;
		}
		
		function get_devices_name(){
			var names = new Array();
			names[names.length] = "<?php echo htmlspecialchars($data['device']->device_name);?>";
			var li = $('#device1');
			var next_li = li.next();
			if (next_li.attr('ref') && next_li.attr('ref') != ''){
				names[names.length] = next_li.find('.device-name').text();
				next_li = next_li.next();
				if (next_li.attr('ref') && next_li && next_li.attr('ref') != ''){
					names[names.length] = next_li.find('.device-name').text();
				}
			}
			return names;
		}
		
		function analyze(){			
			var ids = get_ids();			
			var type = get_type();
			
			show_loading();
			var t = new Date().getTime();
			var url = base_url + 'status-graph/<?php echo $data['device']->id;?>/' + type + '?t=' + t;
			$('#chart1').attr('src', url).show();
			$.get(base_url + 'status-info/' + ids + '/' + type, function(e){
				var times_on = '';
				var times_off = '';
				var times_change_status = '';
				var times_overlapped = '';
				
				e = $.parseJSON(e);								
				if (e){
					for(var i = 0; i < e.length; i++){
						var data = e[i];
						times_on += data.times_on + ' / ';
						times_off += data.times_off + ' / ';
						times_change_status += data.times_change_status + ' / ';
						times_overlapped = data.times_overlapped;
					}
				}
				if (times_on.length > 0){
					times_on = times_on.substring(0, times_on.length - 3);
				}
				if (times_off.length > 0){
					times_off = times_off.substring(0, times_off.length - 3);
				}
				if (times_change_status.length > 0){
					times_change_status = times_change_status.substring(0, times_change_status.length - 3);
				}				
				$('.times-on .values span').text(times_on);
				$('.times-off .values span').text(times_off);
				$('.times-change-status .values span').text(times_change_status);
				$('.times-overlapped .values span').text(times_overlapped);
				hide_loading();
			});
		}
		$('.zoom span').click(function(){
			$('.zoom span').removeClass('active');
			$(this).addClass('active');
			//analyze data
			analyze();
			draw_chart();
		});
		
		function get_type(){
			var type = 1;
			if ($('#year').hasClass('active')){
				type = 4;
			}
			else if ($('#month').hasClass('active')){
				type = 3;
			}
			else if ($('#week').hasClass('active')){
				type = 2;
			}
			else{
				type = 1;
			}
			return type;
		}
		
		var ref_device_box = null;
		$('#device2,#device3').click(function(){
			ref_device_box = $(this);
			var text = "<option value=''><?php echo $this->lang->line('please-select');?></option>";
			$('#device_id').html(text);
			$('#zone_id').val('');			
			$('#dlg-devices label.error').remove();
			$('#dlg-devices select').removeClass('error');
			$('#dlg-devices').dialog({modal: true, width: 400, 
				buttons: [
				{
					text: 'OK', click : function(){
						$('#f-devices').submit();						
					}
				}, 
				{
					text: '<?php echo $this->lang->line('cancel');?>', click: function(){$(this).dialog('close');}
				}]
			});
		});
		
		$('#zone_id').change(function(){
			if (!$(this).val()){
				var text = "<option value=''><?php echo $this->lang->line('please-select');?></option>";
				$('#device_id').html(text);
			}
			else{
				$.get(base_url + 'ajax-devices-by-type-in-zone/<?php echo $data['device']->type_id;?>/' + $(this).val(), function(e){
					e = $.parseJSON(e);
					var text = "<option value=''><?php echo $this->lang->line('please-select');?></option>";
					for(var i = 0; i < e.length; i++){
						//if (e[i].id != '<?php echo $data['device']->id;?>'){
							text += "<option value='" + e[i].id + "' zone='" + e[i].zone_name + "' site='" + e[i].site_name + "'>" + e[i].device_name + "</option>";
						//}
					}
					$('#device_id').html(text);
				});
			}
		});
		
		$('#f-devices').validate({
			rules: {
				zone_id: 'required',
				device_id: 'required'
			},
			messages:{
				zone_id: '<?php echo htmlspecialchars($this->lang->line('required-select-zone'));?>',
				device_id: '<?php echo htmlspecialchars($this->lang->line('required-select-device'));?>'
			},
			submitHandler: function(){
				if (ref_device_box){
					var device_id = $('#device_id').val();
					var zone_id = $('#zone_id').val();
					var opt = $('#device_id option[value=' + device_id + ']');
					var device_name = opt.text();
					var zone = opt.attr('zone');
					var site = opt.attr('site');
					ref_device_box.attr('ref', device_id);
					ref_device_box.attr('zone_id', zone_id);
					ref_device_box.find('.device-name').text(device_name);
					ref_device_box.find('.site').text(site);
					ref_device_box.find('.zone').text(zone);
					ref_device_box.find('.add-icon').hide();
					ref_device_box.find('.item').show();
					changeDevicesText();
					$('#device1').next().next().show();
					//analyze data
					analyze();
					draw_chart();
				}
				$('#dlg-devices').dialog('close');
			}
		});
		
		$('.item .remove').click(function(){
			var li = $(this).parent().parent();
			li.attr('ref', '');
			li.attr('zone_id', '');
			li.find('.device-name').text('');
			li.find('.site').text('');
			li.find('.zone').text('');
			li.find('.add-icon').show();
			li.find('.item').hide();
			changeDevicesText();
			event.stopPropagation();
			//swap two items
			var next_li = li.next();
			if (li.index() == 1){
				if (next_li.attr('ref') && next_li.attr('ref') != ''){					
					li.before(next_li);
				}
				else{
					next_li.hide();
				}
			}
			else{
				next_li.hide();
			}
			//analyze data
			analyze();
			draw_chart();
		});
		
		function changeDevicesText(){
			var device1 = $('#device1');
			var device2 = device1.next().find('.device-name').text();
			var device3 = device1.next().next().find('.device-name').text();			
			var text = '';
			if (device2){
				text += ' / ' + device2;
			}
			if (device3){
				text += ' / ' + device3;
			}			
			
			$('.ids .others').text(text);			
		}
	});
</script>
<?php } else { ?>
	<h1 class="form-title"><?php echo $this->lang->line('device-not-found');?></h1>
<?php } ?>