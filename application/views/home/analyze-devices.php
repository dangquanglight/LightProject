<?php 
	$text_compare = '';
	foreach($devices->result() as $row) { 
		if ($sort_by == 'type'){
			if ($text_compare != $row->sub_type_id){
				echo "<div class='separate-bar clear'>" . htmlspecialchars($row->sub_type_name) . "</div>";
				$text_compare = $row->sub_type_id;
			}			
		}
		else if ($sort_by == 'zone'){
			if ($text_compare != $row->zone_name){
				echo "<div class='separate-bar clear'>" . htmlspecialchars($row->zone_name) . "</div>";
				$text_compare = $row->zone_name;
			}
		}
		$type = 'measurement';
		//var_dump($row);
		if ($row->sub_type_id == 1){
			$type = 'cam';
		}
		else if ($row->sub_type_id == 2){
			$type = 'on-off';
		}		
		else if ($row->sub_type_id == 4){
			$type = 'humidity';
		}
		else if ($row->sub_type_id == 5){
			$type = 'luminance';
		}
		else if ($row->sub_type_id == 6){
			$type = 'temperature';
		}
		else if ($row->sub_type_id == 7){
			$type = 'unspecified';
		}
		else if ($row->sub_type_id == 8){
			$type = 'gas';
		}		
		else if ($row->sub_type_id == 9){
			$type = 'co2';			
		}
		else if ($row->sub_type_id == 10){
			$type = 'pressure';			
		}
		else if ($row->sub_type_id == 11){
			$type = 'power';			
		}
		else if ($row->sub_type_id == 12){
			$type = 'energy';			
		}
		else if ($row->sub_type_id == 13){
			$type = 'smoke';			
		}
		else if ($row->sub_type_id == 15){
			$type = 'window-break';			
		}
		else if ($row->sub_type_id == 16){
			$type = 'door-switch';			
		}
		else if ($row->sub_type_id == 17){
			$type = 'door-bell';			
		}
		else if ($row->sub_type_id == 18){
			$type = 'control-device';			
		}
		else if ($row->sub_type_id == 19){
			$type = 'adjustment-device';			
		}
		else if ($row->sub_type_id == 20){
			$type = 'motion-detection';			
		}
		else if ($row->sub_type_id == 21){
			$type = 'garage-door';			
		}
		$title_box = $this->lang->line($type);
		//var_dump($row);		
	?>
	<div class="item box" ref='<?php echo $row->id; ?>' dtype='<?php echo $row->sub_type_id; ?>'>
		<h3 class="title"><?php echo htmlspecialchars($row->device_name);?></h3>
		<div class="info">
			<?php if ($row->type_id != 1){ ?>
				<img src='<?php echo base_url('images/' . $type . '.png');?>' align='absmiddle' class='icon'/><?php echo $title_box;?><span class="value"><?php echo number_format($row->last_value) ;?></span> <?php echo $row->unit_name;?>
			<?php } else { 
				echo "<img src='" . base_url('images/' . $type . '.png') . "' align='absmiddle' class='icon'/>";
				$images = $this->measurement->get_lastest_data($row->id, 2);
				$index = 1;
				foreach($images->result() as $image){
					echo "<img class='image$index " . ($index++ == 1 ? 'mr12' : '') . "' src='" . base_url('image-device/' . $image->id) . "'/>";
				}
			} ?>
		</div>
	</div>
<?php } ?>
<div class='clear'></div>