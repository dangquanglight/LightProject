<?php if ($data['device']){ ?>
<div id="analyze" class='relative'>
	<h1 class='form-title'><?php echo $this->lang->line('analyze-details');?></h1>
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
		<div class='chart-area chart1 left'>
			<div class='zoom'>				
				<!--<span id='year'><?php echo $this->lang->line('this-year');?></span>-->
				<span id='month' class='active'><?php echo $this->lang->line('this-month');?></span>
				<span id='week'><?php echo $this->lang->line('this-week');?></span>
				<span id='day'><?php echo $this->lang->line('today');?></span>				
				<div class='clear'></div>
			</div>
			<div id='d-chart2' class='d-chart'></div>			
		</div>
		<div class='chart-area chart2 right' style=''>
			<div>
				<span class='right'><?php echo $this->lang->line('date');?><input type='text' id='trend-calendar' value='<?php echo date('m/d/Y');?>'/></span>
				<div class='clear'></div>
			</div>
			<div id='d-chart1' class='d-chart' style='margin-top:10px'></div>
		</div>
		<div class='mt12 chart-area chart3 left clear'>			
			<h2 class='header'><?php echo $this->lang->line('key-performance-indicators');?></h2>
			<div class='inner-box box deviations left'>
				<h3><?php echo $this->lang->line('std-deviation');?></h3>
				<p class='ids'><span><?php echo $data['device']->device_name;?></span> <span class='others'></span></p>
				<p class='values'><span>&nbsp;</span></p>
			</div>
			<div class='inner-box box max-values right'>
				<h3><?php echo $this->lang->line('max-value');?></h3>
				<p class='ids'><span><?php echo $data['device']->device_name;?></span> <span class='others'></span></p>
				<p class='values'><span>&nbsp;</span></p>
			</div>
			<div class='inner-box box medians left'>
				<h3><?php echo $this->lang->line('median');?></h3>
				<p class='ids'><span><?php echo $data['device']->device_name;?></span> <span class='others'></span></p>
				<p class='values'><span>&nbsp;</span></p>
			</div>
			<div class='inner-box box min-values right'>
				<h3><?php echo $this->lang->line('min-value');?></h3>
				<p class='ids'><span><?php echo $data['device']->device_name;?></span> <span class='others'></span></p>
				<p class='values'><span>&nbsp;</span></p>
			</div>
			<div class='clear'></div>
		</div>
		<div class='mt12 chart-area chart4 right'>			
			<h2 class='header'><?php echo $this->lang->line('improving-monitor');?></h2>
			<div>
				<div>
					<div class='inner-box box week left'>
						<h3><?php echo $this->lang->line('duration');?> 1</h3>
						<p><span class='mr12'><?php echo $this->lang->line('begin');?></span><input id='start-date-1' type='text'/>
						</p>
						<p><span class='mr12'><?php echo $this->lang->line('end');?></span><input id='end-date-1' type='text'/>
						</p>
						<h3><?php echo $this->lang->line('median-value-1');?></h3>					
						<p class='median-value-1' style='padding-top: 4px;padding-bottom: 8px;'><span>&nbsp;</span></p>
					</div>
					<div class='inner-box box week left'>
						<h3><?php echo $this->lang->line('duration');?> 2</h3>
						<p><span class='mr12'><?php echo $this->lang->line('begin');?></span><input id='start-date-2' type='text'/>
						</p>
						<p><span class='mr12'><?php echo $this->lang->line('end');?></span><input id='end-date-2' type='text'/>
						</p>
						<h3><?php echo $this->lang->line('median-value-2');?></h3>					
						<p class='median-value-2' style='padding-top: 4px;padding-bottom: 8px;'><span>&nbsp;</span></p>
					</div>
					<div class='clear'></div>
				</div>		
			</div>
			<div class='separate-bar mt20'><span><?php echo $this->lang->line('change-between-duration');?>:</span><span id='between-duration' class='ml12'></span></div>			
		</div>
		<div class='clear'></div>
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
<script type='text/javascript' src='<?php echo base_url('js/jquery-ui-timepicker-addon.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('js/highcharts.js');?>'></script>
<script type='text/javascript'>
	$(function(){
		var chart = null;
		var chart2 = null;
		function load_all_data(){
			analyze();
			draw_chart();
			draw_columns_chart();
		}
		load_all_data();
		setInterval(function(){
			load_all_data();
		}, 100000);
		
		function analyze(){
			var ids = get_ids();
			var type = get_type();
			var t = new Date().getTime();
			//var url = base_url + 'measurement-graph/type/' + type + '?t=' + t;
			//$('#chart1,#chart2').attr('src', url).show();
			
			show_loading();
			$.getJSON(base_url + 'measurement-info/' + ids + '/' + type, function(e){
				var mins = '';
				var maxs = '';
				var stddevs = '';
				var medians = '';
				if (e){
					for(var i = 0; i < e.length; i++){
						var data = e[i];
						mins += data.min + ' / ';
						maxs += data.max + ' / ';
						stddevs += data.stddev + ' / ';
						medians += data.median + ' / ';
					}
				}
				if (mins.length > 0){
					mins = mins.substring(0, mins.length - 3);
				}
				if (maxs.length > 0){
					maxs = maxs.substring(0, maxs.length - 3);
				}
				if (stddevs.length > 0){
					stddevs = stddevs.substring(0, stddevs.length - 3);
				}
				if (medians.length > 0){
					medians = medians.substring(0, medians.length - 3);
				}
				$('.min-values .values span').text(mins);
				$('.max-values .values span').text(maxs);
				$('.deviations .values span').text(stddevs);
				$('.medians .values span').text(medians);
				hide_loading();
			});
			
		}
		
		var times_draw_animation_chart = 1;
		function draw_chart(){
			var ids = get_ids();
			var data = new Array();
			var type = get_type();
			var date = '_';
			if ($('#trend-calendar').val()){
				date = $('#trend-calendar').val().replace(/\//g, '-');
			}
			var url = base_url + 'measurements-graph/' + ids + '/' + date;
			var text = "1. " + new Date().toString() + "\n";			
			
			show_loading();
			$.get(url, function(e){				
				if (e){
					e = $.parseJSON(e);
					text += "2. " + new Date().toString() + "\n";					
					text += "3. " + new Date().toString() + "\n";					
					if (chart != null){
						chart.destroy();
						chart = null;
					}					
					var categories = e.categories;
					var series = new Array();
					var names = get_devices_name();
					for(var i = 0; i < e.data.length; i++){
						var serie = new series_std(names[i], e.data[i], times_draw_animation_chart == 1);
						series[series.length] = serie;
					}
					text += "4. " + new Date().toString() + "\n";
					times_draw_animation_chart++;
					var date1 = new Date();
					
					
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'd-chart1',
							type: 'spline',
							marginRight: 0,
							marginBottom: 35,
							zoomType: 'x,y',
							events: {
								load: function(event){
									hide_loading();
									text += "5. " + new Date().toString() + "\n";
									//alert((new Date() - date1)/1000.0 + 's');
								}
							}
						},
						title: {
							text: 'Trend',
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
		
		var times_enimation_chart = 1;
		function draw_columns_chart(){
			var ids = get_ids();
			var type = get_type();
			var url = base_url + 'measurements-group-columns-chart/<?php echo $data['id'];?>/' + type;				
			$.getJSON(url, function(e){
				if (e){					
					if (chart2 != null){
						chart2.destroy();
						chart2 = null;
					}					
					var categories = e.categories;
					var series = new Array();					
					
					var serie = new series_std(e.categories, e.data, times_enimation_chart++ == 1);					
					series[series.length] = serie;
					
					chart2 = new Highcharts.Chart({
						chart: {
							renderTo: 'd-chart2',
							type: 'column',
							//marginRight: 0,
							marginBottom: 125,
							zoomType: 'x'
						},
						title: {
							text: 'Histogram',
							x: -20 //center							
						},
						xAxis: {
							categories: categories,
							labels: {
								rotation: -90,
								y: 50,
								style: {
									fontSize:'11px',
									fontWeight:'normal',
									color:'#333'
								}
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
							}],
							max: 100
						},
						tooltip: {
							formatter: function() {
									return '<b>Analyze groups</b><br/>'+
									this.x +': '+ this.y + '%';
							}
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'top',
							x: -10,
							y: 100,
							borderWidth: 0,
							enabled: false
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
		
		$('.zoom span').click(function(){
			$('.zoom span').removeClass('active');
			$(this).addClass('active');
			//analyze data
			analyze();
			//draw_chart();
			draw_columns_chart();
		});
		
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
					//draw_chart();
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
		
		//bound date picker
		//$('#start-date-1,#start-date-2,#end-date-1,#end-date-2').datetimepicker();
		var dateFormat = 'mm/dd/yy';
		var timeFormat = 'HH:mm';
		
		$('#trend-calendar').datepicker({dateFormat: dateFormat, onSelect: function(dateText){
			draw_chart();
		}});
		
		var boundDatePicker = function(start_date_id, end_date_id){
			$(start_date_id).datetimepicker({
				dateFormat: dateFormat,
				timeFormat: timeFormat,
				onSelect: function(dateText){
					//alert("Selected date: " + dateText + "; input's current value: " + this.value);
					
					var selectedDate = getDateTime(this.value);
					
					var endDate = getDateTime($(end_date_id).val());
					if (endDate == null || endDate < selectedDate){
						//alert(endDate + ' ---- ' + selectedDate);
						endDate = selectedDate;
						var year = endDate.getFullYear();
						var month = endDate.getMonth();
						var date = endDate.getDate();
						var hours = endDate.getHours();
						var minutes = endDate.getMinutes();
						month = month < 10 ? ('0' + month) : month;
						date = date < 10 ? ('0' + date) : date;
						hours = hours < 10 ? ('0' + hours) : hours;
						minutes = minutes < 10 ? ('0' + minutes) : minutes;
						var formatDate = month + '/' + date + '/' + year + ' ' + hours + ':' + minutes;
						//alert(endDate);
						endDate = new Date(year, month - 1, date, hours, minutes, 0);
						$(end_date_id).datetimepicker('destroy').datetimepicker({minDate: endDate, onSelect: function(dateText){
							cal_improment_monitor();
						}}).val(formatDate);
					}
					else{
						//alert(endDate + ' ---- ' + selectedDate);
						endDate = new Date(selectedDate.getFullYear(), selectedDate.getMonth() - 1, selectedDate.getDate(), selectedDate.getHours(), selectedDate.getMinutes(), 0);
						$(end_date_id).datetimepicker('destroy').datetimepicker({minDate: endDate, onSelect: function(dateText){
							cal_improment_monitor();
						}});
					}
					cal_improment_monitor();
				}
			});
			$(end_date_id).datetimepicker({
				onSelect: function(dateText){
					cal_improment_monitor();
				}
			});
		}
		boundDatePicker('#start-date-1', '#end-date-1');
		boundDatePicker('#start-date-2', '#end-date-2');
		$('#start-date-1,#end-date-1,#start-date-2,#end-date-2').keyup(function(e){
			if (!e){
				e = window.event;
			}			
			var k = e.which;

			// Verify that the key entered is not a special key
			if (k == 20 /* Caps lock */
				|| k == 16 /* Shift */
				|| k == 9 /* Tab */
				|| k == 27 /* Escape Key */
				|| k == 17 /* Control Key */
				|| k == 91 /* Windows Command Key */
				|| k == 19 /* Pause Break */
				|| k == 18 /* Alt Key */
				|| k == 93 /* Right Click Point Key */
				|| ( k >= 35 && k <= 40 ) /* Home, End, Arrow Keys */
				|| k == 45 /* Insert Key */
				|| ( k >= 33 && k <= 34 ) /*Page Down, Page Up */
				|| (k >= 112 && k <= 123) /* F1 - F12 */
				|| (k >= 144 && k <= 145 )) { /* Num Lock, Scroll Lock */
					return false;
			}
			else {
				//alert(e.keyCode);
				cal_improment_monitor();
			}			
		});
		
		function convertDateToTimestamp(dateValue){	
			if (dateValue){
				var year = dateValue.getFullYear();
				var month = dateValue.getMonth();
				var date = dateValue.getDate();
				var hours = dateValue.getHours();
				var minutes = dateValue.getMinutes();
				month = month < 10 ? ('0' + month) : month;
				date = date < 10 ? ('0' + date) : date;
				hours = hours < 10 ? ('0' + hours) : hours;
				minutes = minutes < 10 ? ('0' + minutes) : minutes;
				return year + '-' + month + '-' + date + '-' + hours + '-' + minutes + '-00';
			}
			else{
				return "_";
			}
		}
						
		function getDateTime(text){
			var date = null;
			if (text){
				//split by space
				var arTemp = text.split(' ');				
				if (arTemp.length == 2){
					//split by forward slash
					var arDate = arTemp[0].split('/');
					var arTime = arTemp[1].split(':');
					if (arDate.length == 3 && arTime.length == 2){
						date = new Date(arDate[2], arDate[0], arDate[1], arTime[0], arTime[1]);
					}
				}
			}
			return date;
		}
		
		function cal_improment_monitor(){
			setTimeout(function(){
				var err_msg = '';
				var start_date_1 = getDateTime($('#start-date-1').val());
				var end_date_1 = getDateTime($('#end-date-1').val());
				var start_date_2 = getDateTime($('#start-date-2').val());
				var end_date_2 = getDateTime($('#end-date-2').val());
				//alert($('#start-date-1').val() + ' ---- ' + $('#end-date-1').val());
				if (!start_date_1){
					//start_date_1 = '_';
					err_msg += '* Please select Begin date 1';
				}
				if (!end_date_1){
					//end_date_1 = '_';
					err_msg += (err_msg ? '\n' : '') + '* Please select End date 1';
				}
				if (!start_date_2){
					//start_date_2 = '_';
					err_msg += (err_msg ? '\n' : '') + '* Please select Begin date 2';
				}
				if (!end_date_2){
					//end_date_2 = '_';
					err_msg += (err_msg ? '\n' : '') + '* Please select End date 2';
				}
				if (err_msg){
					//alert(err_msg);
				}
				//else{
					show_loading();
					var date1 = convertDateToTimestamp(start_date_1);
					var date2 = convertDateToTimestamp(end_date_1);
					var date3 = convertDateToTimestamp(start_date_2);
					var date4 = convertDateToTimestamp(end_date_2);
					$.get(base_url + 'cal-median-by-date/<?php echo $data['device']->id;?>/' + date1 + '/' + 
						date2 + '/' + date3 + '/' + date4, function(e){
							e = $.parseJSON(e);
							$('.median-value-1').text(e.median1);
							$('.median-value-2').text(e.median2);
							$('#between-duration').text(e.durations);
						});
					hide_loading();
					
				//}
			}, 100);
		}
	});
	
	function load_image(){
		var t = new Date().getTime();
		var url = base_url + 'measurement-graph?t=' + t;
		//$('#chart1,#chart2').attr('src', url);
	}
	
	load_image();
</script>
<?php } else { ?>
	<h1 class="form-title"><?php echo $this->lang->line('device-not-found');?></h1>
<?php } ?>