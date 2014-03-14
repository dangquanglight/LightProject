<h1 class="form-title" style='text-align:center'><?php echo $this->lang->line('alarms-history') . ' - ' . $data['device']->device_name;?></h1>
<div>
	<table class='setup-event'>
		<thead>
			<tr>
				<th style='width:80px;border-top:none;border-left:none;'></th>
				<th style='width:13%;'><?php echo $this->lang->line('monday');?></th>
				<th style='width:13%;'><?php echo $this->lang->line('tuesday');?></th>
				<th style='width:13%;'><?php echo $this->lang->line('wednesday');?></th>
				<th style='width:13%;'><?php echo $this->lang->line('thurday');?></th>
				<th style='width:13%;'><?php echo $this->lang->line('friday');?></th>
				<th style='width:13%;'><?php echo $this->lang->line('saturday');?></th>
				<th style='width:13%;'><?php echo $this->lang->line('sunday');?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$arr_mon = array();
			$arr_tue = array();
			$arr_wed = array();
			$arr_thu = array();
			$arr_fri = array();
			$arr_sat = array();
			$arr_sun = array();
			foreach($data['logs']->result() as $row){
				$hours = explode(',', $row->hours);
				$length = count($hours);
				//SUN
				if ($row->day_of_week == 0){
					for($i = 0; $i < $length; $i++){
						$arr_sun[] = $hours[$i];
					}
				}
				else if ($row->day_of_week == 1){
					//MON
					for($i = 0; $i < $length; $i++){
						$arr_mon[] = $hours[$i];
					}
				}
				else if ($row->day_of_week == 2){
					//TUE
					for($i = 0; $i < $length; $i++){
						$arr_tue[] = $hours[$i];
					}
				}
				else if ($row->day_of_week == 3){
					//WED
					for($i = 0; $i < $length; $i++){
						$arr_wed[] = $hours[$i];
					}
				}
				else if ($row->day_of_week == 4){
					//THU
					for($i = 0; $i < $length; $i++){
						$arr_thu[] = $hours[$i];
					}
				}else if ($row->day_of_week == 5){
					//FRI
					for($i = 0; $i < $length; $i++){
						$arr_fri[] = $hours[$i];
					}
				}
				else if ($row->day_of_week == 6){
					//SAT
					for($i = 0; $i < $length; $i++){
						$arr_sat[] = $hours[$i];
					}
				}
			}
			for($i = 0; $i < 24; $i++){ ?>
				<tr>
					<td style='text-align:center;'>
						<?php echo ($i < 10 ? '0' : '') . $i . ":00";?>
					</td>
					<?php 
						$is_mon = false;
						$is_tue = false;
						$is_wed = false;
						$is_thu = false;
						$is_fri = false;
						$is_sat = false;
						$is_sun = false;
						foreach($arr_mon as $hour){
							if ($i == $hour){
								$is_mon = true;
								break;
							}
						} 
						foreach($arr_tue as $hour){
							if ($i == $hour){
								$is_tue = true;
								break;
							}
						}
						foreach($arr_wed as $hour){
							if ($i == $hour){
								$is_wed = true;
								break;
							}
						}
						foreach($arr_thu as $hour){
							if ($i == $hour){
								$is_thu = true;
								break;
							}
						}
						foreach($arr_fri as $hour){
							if ($i == $hour){
								$is_fri = true;
								break;
							}
						}
						foreach($arr_sat as $hour){
							if ($i == $hour){
								$is_sat = true;
								break;
							}
						}
						foreach($arr_sun as $hour){
							if ($i == $hour){
								$is_sun = true;
								break;
							}
						}
						?>
					<td class='<?php echo $is_mon ? 'selected' : '';?>'></td>
					<td class='<?php echo $is_tue ? 'selected' : '';?>'></td>
					<td class='<?php echo $is_wed ? 'selected' : '';?>'></td>
					<td class='<?php echo $is_thu ? 'selected' : '';?>'></td>
					<td class='<?php echo $is_fri ? 'selected' : '';?>'></td>
					<td class='<?php echo $is_sat ? 'selected' : '';?>'></td>
					<td class='<?php echo $is_sun ? 'selected' : '';?>'></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<div class='actions'>
		<a href='<?php echo base_url('add-event-schedule');?>' class='btn btn-yellow'><?php echo $this->lang->line('add-time-based');?></a><a href='<?php echo $this->lang->line('add-event');?>' class='btn btn-yellow'><?php echo $this->lang->line('add-condition-based');?></a><a href='<?php echo base_url('devices');?>' class='btn btn-yellow'><?php echo $this->lang->line('back-to-devices');?></a>
	</div>
</div>	