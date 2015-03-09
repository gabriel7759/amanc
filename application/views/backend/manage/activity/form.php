		<form name="save" action="" method="post" class="form validate" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?=$data['id']?>" />
			<div class="sidebar">
				<?php if($action_status): ?>
				<div class="sidebox">
					<h2><?=__('Status')?></h2>
					<div class="field">
						<label class="option"><input type="radio" name="status" value="1"<?php if(Arr::get($data, 'status', 1)==1): ?> checked="checked"<?php endif; ?> /> <?=__('Active')?></label>
						<label class="option"><input type="radio" name="status" value="0"<?php if(Arr::get($data, 'status', 1)==0): ?> checked="checked"<?php endif; ?> /> <?=__('Inactive')?></label>
					</div>
				</div>
				<?php endif; ?>
                
				<?php if($data['id']): ?>
				<div class="sidebox">
					<h2><?=__('Last modified')?></h2>
					<p class="last-modified"><strong><?=$data['log_user']?></strong><br /> <?=Timestamp::format($data['log_time'], '%d/%B/%Y %H:%M')?></p>
				</div>
				<?php endif; ?>
			</div>
			<div class="fieldset">
				<h2><?=__('General details')?></h2>
				<div class="field full">
					<label><?=__('State')?> <span class="req">*</span></label>
                    <select name="state_id" class="required" title="Seleccione el estado">
                    	<option value="">- Seleccione -</option>
                        <?php foreach($state as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($row['id']==$data['state_id']) { echo "selected='selected'"; } ?>><?=$row['state']?></option>
                        <?php endforeach; ?>
                    </select>
				</div>   
				<div class="field full">
					<label><?=__('Title')?> <span class="req">*</span></label>
					<input type="text" name="title" value="<?=$data['title']?>" class="required" title="<?=__('Please enter the title')?>" />
				</div><br />
				<div class="field full">
					<label><?=__('Resumen')?> <span class="req"></span></label>
					<textarea name="summary" cols="50" rows="4" class=""><?=$data['summary']?></textarea>
				</div><br />
				<div class="field full">
					<label><?=__('Contenido')?> <span class="req"></span></label>
					<textarea name="content" cols="50" rows="6" class="ckeditor"><?=$data['content']?></textarea>
				</div><br />
				<div class="field full">
					<label><?=__('Url')?> <span class=""></span></label>
					<input type="text" name="url" value="<?=$data['url']?>" class="" title="<?=__('Ingresa el url')?>" />
				</div><br />
				<div class="field full">
					<label><?=__('Ventana nueva')?> <span class="req"></span></label>
					<input type="radio" name="newwindow" value="1" <?=($data['newwindow']==1)?'checked="checked"':''?> /> Si</input>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="newwindow" value="0" <?=($data['newwindow']==1)?'':'checked="checked"'?> /> No</input>
				</div><br />
				<div class="field full">
					<label><?=__('Thumbnail')?> <span class="req"></span> <span>(max JPG 673 x 586)</span></label>
					<div class="file">
						<div class="fileinput">
							<input type="text" name="thumbnail_tmp" value="" disabled="disabled">
							<div><input type="file" name="thumbnail" /></div>
						</div>
						<div class="fname"<?php if($data['thumbnail']!=""): ?>style="display:block;"<?php endif; ?>>
							<a href="../assets/files/activity/<?=$data['thumbnail']?>" target="_blank"><img src="../assets/files/activity/<?=$data['thumbnail']?>" height="75" alt="" /></a>
							<a href="#" class="del">Delete</a>
							<a href="../assets/files/activity/<?=$data['thumbnail']?>" target="_blank" class="iname"><?=$data['thumbnail']?></a>
							<input type="checkbox" name="thumbnail_del" value="1" />
						</div>
					</div>
				</div>
				<br />
				<div class="fields">
					<label style="font-weight:bolder">Tags  <span class="req">*</span></label><br />
					<select name="tag_id[]" class="required chosen" title="Seleccione los tags" multiple="multiple" style="height:100px">
						<!--<option value="">- Seleccione -</option>-->
						<?php 
						foreach($tags as $row) 
						{
                        	foreach($data['tags_selected'] as $tags_selected)
						  	{
								$selected = '';
								if($row['id'] == $tags_selected['tag_id'])
								{
									$selected = 'selected="selected"';
									break;
								}
							} ?>
                        <option value="<?=$row['id']?>" <?=$selected?>><?=$row['title']?></option>		
						<?php } ?>
					</select>
				</div>
				<div class="buttons">
					<button type="submit" class="button"><?=__('Save')?></button>
					<button type="button" class="button cancel"><?=__('Cancel')?></button>
				</div>
            </div>    
		</form>
<script>
	$(document).ready(function(){
					$(".chosen").data("placeholder","Selecciona los tags").chosen();
	});
</script>