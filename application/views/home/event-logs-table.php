<?php 		
	$paging_bar = paging_bar($data['num_rows'], $data['page_size'], $data['page'], $controller_name, "ajax_event_logs", get_url_navigate()); ?>
	<?php echo $paging_bar; ?>
<table cellpadding="0" cellspacing="0" width="100%" class="table-list" page_size="<?php echo $data['page_size'];?>">
	<thead>
		<tr>
			<th class="checkbox"></th>			
			<th>
				<a href='javascript:void(0)' sort=""><?php echo $this->lang->line('date');?></a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">00</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">01</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">02</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">03</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">04</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">05</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">06</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">07</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">08</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">09</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">10</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">11</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">12</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">13</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">14</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">15</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">16</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">17</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">18</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">19</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">20</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">21</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">22</a>
			</th>
			<th>
				<a href='javascript:void(0)' sort="">23</a>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total = $data['data']->num_rows;
		$start_index = ($data['page'] - 1) * $data['page_size'] + 1;
		if ($total > 0){
			$k = 0;			
			foreach($data['data']->result() as $row){ 
				$hours = explode(',', $row->hours);
				$ids = explode(',', $row->ids);
				$values = explode(',', $row->values);
				$minutes = explode(',', $row->minutes);
				$length = count($ids);
			?>
			<tr <?php echo $k++ % 2 == 0 ? "class='even'" : "";?>>
				<td class="checkbox"><?php echo $start_index; ?></td>				
				<td>
					<?php echo $row->date; ?>
				</td>				
				<?php 
					for($i = 0; $i < 24; $i++){ 
						
						//COUNT HOW MANY TIMES RAISED EVENT
						$total = 0;
						$minutes_log = '';
						$values_log = '';
						for($j = 0; $j < $length; $j++){
							if ($hours[$j] == $i){
								$total++;
								$minutes_log .= $hours[$j] . ':' . $minutes[$j] . ' ';
								$values_log .= $values[$j]. ' ';
							}
						}						
						$minutes_log = trim($minutes_log);
						echo '<td class="tc ' . ($total > 0 ? 'date-cell' : '') . '" minutes_log="' . $minutes_log . '" values="' . $values_log . '">';
						if ($total > 0){
							echo $total;
						}
						echo '</td>';
				} ?>
			</tr>
			<?php
			$start_index++;
			$i++;
			}
		}
		else{
		 ?>
			<tr>
				<td colspan="27">
					<?php echo $this->lang->line("data-not-found");?>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>	
<?php echo $paging_bar; ?>	