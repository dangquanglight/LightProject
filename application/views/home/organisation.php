<?php $company = $data['company']; ?>
<style type='text/css'>
	.google-visualization-orgchart-node-medium{font-size:13px;}
</style>
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script type='text/javascript'>
  google.load('visualization', '1', {packages:['orgchart']});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Name');
	data.addColumn('string', 'Manager');
	data.addColumn('string', 'ToolTip');
	data.addRows([		
	  [{v:'1', f:"<span class='company'><?php echo htmlspecialchars($company->company_name);?></span>"}, "", "<?php echo $company->description;?>"]
	  <?php
		//write sites and zones
		$text = "";
		foreach($data['sites']->result() as $site){			
			$text .= sprintf("[{v:'s.%s', f:\"%s\"}, '1', \"%s\"],", $site->id, "<span class='sites' id='" . $site->id . "'>" . htmlspecialchars($site->site_name) . "</span>", htmlspecialchars($site->description));
			foreach($data['zones'] as $zone){
				$text .= sprintf("[{v:'z.%s', f:\"%s\"}, 's.%s', \"%s\"],", $zone->id, "<a class='zones' id='" . $zone->id . "' href='" . base_url('zone-layout/' . $zone->id . '/' . text_to_title($zone->zone_name)) . "'>" . htmlspecialchars($zone->zone_name) . "</a>", $zone->site_id, htmlspecialchars($zone->description));
			}
		}
		if ($text != ''){
			echo ',' . rtrim($text, ',');
		}
	  ?>
	]);
	var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
	google.visualization.events.addListener(chart, 'ready', function(){
		alarms_func[alarms_func.length] = function(e){	
			clearInterval(alarm_flash_key);
			$('.alarm').removeClass('alarm-red');
			if (e.device_ids.length > 0){
				$('.company').parent().addClass('alarm');
				$('.sites').each(function(){
					if ($.inArray($(this).attr('id'), e.site_ids) >= 0){
						$(this).parent().addClass('alarm');
					}
					else{
						$(this).parent().removeClass('alarm');
					}
				});
				$('.zones').each(function(){
					if ($.inArray($(this).attr('id'), e.zone_ids) >= 0){
						$(this).parent().addClass('alarm');
					}
					else{
						$(this).parent().removeClass('alarm');
					}
				});
				active_alarm_flash();
			}
			else{
				$('.company,.sites,.zones').parent().removeClass('alarm');				
			}			
		}
	});
	chart.draw(data, {allowHtml:true});
	var on_status = false;
	var alarm_flash_key = null;
	function active_alarm_flash(){
		alarm_flash_key = setInterval(function(){
			if (on_status == false){
				$('.alarm').addClass('alarm-red');
			}
			else{
				$('.alarm').removeClass('alarm-red');
			}
			on_status = !on_status;
		}, 500);
	}
  }
</script>
<h1 class='form-title'><?php echo $this->lang->line('organisation');?></h1>
<div id='chart_div'></div>