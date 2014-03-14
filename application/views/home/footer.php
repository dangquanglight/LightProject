<div id='footer-page'>					
	
		<div id='footer-line'>
			<table style='width:100%'>
				<thead>
					<tr>
						<th>
							<?php echo $this->lang->line('popular-links');?>
						</th>
						<th style='width:50%'>
							<?php echo $this->lang->line('social-media');?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<?php if (is_login()){ 
								$popular_links = array();
								foreach($favorite_menu_home->result() as $favorite){
									$menu = null;
									$link = null;
									if ($favorite->is_menu){
										$menu = $this->menu->get_id($favorite->favorite_id);
										if ($menu){
											set_title_by_language($menu, $menu);
											$link = correct_link($menu->link . '?m_id=' . $menu->id);
										}
									}
									else{										
										$menu = $this->submenu->get_id($favorite->favorite_id);
										if ($menu){
											set_title_by_language($menu, $menu);
											$link = correct_link($menu->link . '?sm_id=' . $menu->id);
										}
									}
									if ($menu){
										$popular_links[] = array($menu->title, $link);
									}
								}
								
							?>
							<ul>
								<?php foreach($popular_links as $link){ ?>
									<li>
										<a href="<?php echo $link[1];?>"><?php echo $link[0];?></a>
									</li>
								<?php } ?>
							</ul>
							<?php } ?>	
						</td>
						<td align='center' valign='top'>
							<a target="_blank" href="javascript:void(0)" class="followusa likeus"></a>
							<a target="_blank" href="javascript:void(0)" class="followusa befriend"></a>
							<a target="_blank" href="javascript:void(0)" class="followusa flickr"></a>
							<a target="_blank" href="javascript:void(0)" class="followusa youtube"></a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>	
	<div class='tc'> 
		<?php
			$footer_text = get_content_cms($footer_cms);
			echo $footer_text;
		?>
	</div>
</div>