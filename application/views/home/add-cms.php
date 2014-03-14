<script type="text/javascript" src="<?php echo base_url("ckeditor/ckeditor.js"); ?>"></script>
<h1 class="form-title"><?php echo $this->lang->line('cms'); ?></h1>
<?php if ($data['data']){ ?>
	<?php echo show_saved_data($data['result'], $data['err_msg']); ?>
	<form id="form-data" class='f-cms' method="post" enctype="multipart/form-data">	
		<div ref='english' class='separate-bar <?php echo $data['en_open_status'] ? 'maximize' : 'minimize';?>'><?php echo $this->lang->line('content-en');?></div>
		<div id='english' style='<?php echo !$data['en_open_status'] ? 'display:none' : '';?>'>
			<div class="ib">
				<label class="text" for="title_en"><?php echo $this->lang->line('title-en'); ?></label>
				<input type="textbox" id="title_en" name="title_en" class="normal" value="<?php echo $data['data']->title_en; ?>"/>		
			</div>
			<div class="ib">			
				<textarea id="content_en" name="content_en"><?php echo htmlspecialchars($data['data']->content_en); ?></textarea>
				<script type="text/javascript">
					CKEDITOR.replace( 'content_en');
				</script>
			</div>			
			<input type='hidden' id='en_open_status' name='en_open_status' class='open-status' value='<?php echo $data['en_open_status'];?>'/>
		</div>
		<div ref='finland' class='separate-bar <?php echo $data['fi_open_status'] ? 'maximize' : 'minimize';?>'><?php echo $this->lang->line('content-fi');?></div>
		<div id='finland' style='<?php echo !$data['fi_open_status'] ? 'display:none' : '';?>'>
			<div class="ib">
				<label class="text" for="title_fi"><?php echo $this->lang->line('title-fi'); ?></label>
				<input type="textbox" id="title_fi" name="title_fi" class="normal" value="<?php echo $data['data']->title_fi; ?>"/>		
			</div>
			<div class="ib">			
				<textarea id="content_fi" name="content_fi"><?php echo htmlspecialchars($data['data']->content_fi); ?></textarea>
				<script type="text/javascript">
					CKEDITOR.replace( 'content_fi');
				</script>
			</div>			
			<input type='hidden' id='fi_open_status' name='fi_open_status' class='open-status' value='<?php echo $data['fi_open_status'];?>'/>
		</div>
		<div ref='china' class='separate-bar <?php echo $data['ci_open_status'] ? 'maximize' : 'minimize';?>'><?php echo $this->lang->line('content-ci');?></div>
		<div id='china' style='<?php echo !$data['ci_open_status'] ? 'display:none' : '';?>'>
			<div class="ib">
				<label class="text" for="title_kr"><?php echo $this->lang->line('title-ci'); ?></label>
				<input type="textbox" id="title_kr" name="title_kr" class="normal" value="<?php echo $data['data']->title_kr; ?>"/>		
			</div>
			<div class="ib">			
				<textarea id="content_kr" name="content_kr"><?php echo htmlspecialchars($data['data']->content_kr); ?></textarea>
				<script type="text/javascript">
					CKEDITOR.replace( 'content_kr');
				</script>
			</div>			
			<input type='hidden' id='ci_open_status' name='ci_open_status' class='open-status' value='<?php echo $data['ci_open_status'];?>'/>
		</div>
		<div class="ib">
			<label for='status'><?php echo $this->lang->line('status');?></label>
			<select id="status" name="status" class="normal">
				<option value="1" <?php echo $data['data']->status == 1 ? "selected" : ""; ?>><?php echo $this->lang->line('enabled');?></option>
				<option value="0" <?php echo $data['data']->status == 0 ? "selected" : ""; ?>><?php echo $this->lang->line('disabled');?></option>
			</select>
		</div>
		<div class="actions">			
			<input type="submit" name="save" value="<?php echo $this->lang->line('save'); ?>" class="btn btn-yellow"/>
			<?php if (!$data['id']){ ?>
			<input name="save_and_continue" type="submit" class="btn btn-yellow" value="<?php echo $this->lang->line('save-and-continue');?>"/>
			<?php } ?>
			<a class="btn btn-yellow history-back" href='<?php echo $data['back-url'];?>'><?php echo $this->lang->line('back-to-list');?></a>
		</div>
	</form>
	<script type="text/javascript">
		$("#form-data").validate({
			rules:{
				title: "required"
			},
			messages:{
				title: "<?php echo $this->lang->line('required_title');?>"
			}
		});
		
		$('.separate-bar').click(function(){
			var div = $('#' + $(this).attr('ref'));
			var open_status = div.find('.open-status');
			//minimize
			if (open_status.val() != 1){
				open_status.val(1);
				div.slideDown();				
				$(this).addClass('maximize').removeClass('minimize');
			}
			else{
				open_status.val(0);
				div.slideUp();
				$(this).addClass('minimize').removeClass('maximize');
			}
		});
	</script>
<?php } else { ?>
	<div class="fail"><?php echo get_not_found_long('cms', $this->lang->line('cms'));?></div>
<?php } ?>