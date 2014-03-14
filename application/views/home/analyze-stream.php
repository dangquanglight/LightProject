<?php if ($data['device']){ ?>
<div class='relative'>
	<h1 class="form-title"><?php echo $this->lang->line('analyze-stream') . ' - ' . $data['device']->device_name;?></h1>
	<div class="ib stream">
		<div class='frame'>
			<div class='video'>
				
			</div>
			<div class='nav-video'>
				<div id="slider" class='left'></div>
				<div class='right'><img id='play' src='<?php echo base_url('images/play.png');?>' align='absmiddle' title='<?php echo $this->lang->line('play');?>'/><img id='pause' src='<?php echo base_url('images/pause.png');?>' align='absmiddle' title='<?php echo $this->lang->line('pause');?>'/><img id='stop' src='<?php echo base_url('images/stop.png');?>' align='absmiddle' title='<?php echo $this->lang->line('stop');?>'/></div>
				<div class='clear'></div>
			</div>
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
	<script type='text/javascript'>
		function load_stream(){
			var max= -1;
			var current_data = null;
			var status = 0;//stop
			var current_frame = 0;
			var key_frame = null;
			$.get(base_url + 'stream-info/<?php echo $data['id'];?>', function(e){
				data = $.parseJSON(e);
				if (current_data == null || current_data.length != data.length){
					current_data = data;
					var img = $('.video img');
					if (img.length == 0){
						img = $('<img/>').appendTo('.video');
						img.bind('load', function(){
							
							//alert('loaded');
						});
					}
					if (data.length == 0){
						img.attr('src', base_url + 'images/not-found.png');
					}
					else{
						current_frame = data.ids[data.ids.length - 1];
						img.attr('src', base_url + 'image-device/' + data.ids[data.ids.length - 1]);
					}
					$('#slider').slider({max: data.length - 1, change: function(event, ui){
						img.attr('src', base_url + 'image-device/' + current_data.ids[ui.value]);
						current_frame = parseInt(ui.value);
					}, value: data.length - 1});
				}
			});
			$('#play').click(function(){
				status = 1;
				clearInterval(key_frame);
				key_frame = setInterval(function(){
					if (current_data && current_frame < current_data.length){
						$('#slider').slider('value', current_frame);
						current_frame++;
					}
					else{
						clearInterval(key_frame);
					}				
				}, 1000);
			});
			$('#stop').click(function(){
				status = 0;
				clearInterval(key_frame);
				$('#slider').slider('value', 0);
			});
			$('#pause').click(function(){
				status = 2;
				clearInterval(key_frame);
			});
		}
		load_stream();
	</script>
</div>
<?php } else { ?>
	<h1 class="form-title"><?php echo $this->lang->line('camera-not-found');?></h1>
<?php } ?>