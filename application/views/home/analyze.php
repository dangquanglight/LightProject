<h1 class='form-title'><?php echo $this->lang->line('analyze');?></h1>
<div id="analyze">
	<div id="tabs">
		<ul class="tabs">
			<li ref='id'><a href="javascript:void(0)" class="active"><span class="down"><?php echo $this->lang->line('sort-by-id');?></span></a></li>
			<li ref='name'><a href="javascript:void(0)"><span><?php echo $this->lang->line('sort-by-name');?></span></a></li>
			<li ref='type'><a href="javascript:void(0)"><span><?php echo $this->lang->line('sort-by-type');?></span></a></li>
			<li ref='zone'><a href="javascript:void(0)"><span><?php echo $this->lang->line('sort-by-zone');?></span></a></li>
		</ul>
		<div class='clear'></div>
	</div>	
	<div id="tabs-analyze">		
	</div>	
</div>
<script type='text/javascript'>
	$(function(){
		var isDown = true;
		$('.tabs li').click(function(){
			isDown = !isDown;
			$('.tabs li a').removeClass('active');
			$(this).find('a').addClass('active');
			$('.tabs li span').removeClass('up down');
			if (isDown){
				$(this).find('span').addClass('down');
			}
			else{
				$(this).find('span').addClass('up');
			}
			
			load_devices($(this).attr('ref'), (isDown ? 1 : 0));
		});
		
		setInterval(function(){
			load_devices($('.tabs li a.active').parent().attr('ref'), (isDown ? 1 : 0));
		}, 10000);
		
		$('#tabs-analyze .item').live('click', function(){
			if ($(this).attr('dtype') == 1){
				window.location = base_url + 'stream/' + $(this).attr('ref') + '/' + text_to_title($(this).find('.title').text());
			}
			else if ($(this).attr('dtype') == 2){
				window.location = base_url + 'analyze-status/' + $(this).attr('ref') + '/' + text_to_title($(this).find('.title').text());
			}
			else{
				window.location = base_url + 'analyze-details/' + $(this).attr('ref') + '/' + text_to_title($(this).find('.title').text());
			}
		});
		
		function load_devices(sort, direction){
			show_loading();
			var scrollTop = $(window).scrollTop();
			$.get(base_url + 'analyze-devices/' + sort + '/' + direction, function(e){
				$('#tabs-analyze').html(e);
				$(window).scrollTop(scrollTop);
				hide_loading();
			});
		}
		
		//LOAD DEVICES THE FIRST TIME
		load_devices('id', 1 );
	});
</script>