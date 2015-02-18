
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
					<label><?=__('Title')?> <span class="req">*</span></label>
					<input type="text" name="title" value="<?=$data['title']?>" class="required" title="<?=__('Please enter the title')?>" />
				</div><br />

				<div class="field half">
					<label><?=__('Fecha')?> <span class="req">*</span></label>
					<input type="text" name="date_marathon" value="<?=Timestamp::format($data['date_marathon'], '%Y-%m-%d')?>" class="required date" title="<?=__('Seleccione la fecha')?>" />
				</div><br />
				
				<div class="field full">
					<label><?=__('Resumen')?> <span class="req"></span></label>
					<textarea name="summary" cols="50" rows="5"><?=$data['summary']?></textarea>
				</div><br />

				<div class="field full">
					<label><?=__('Contenido')?> <span class="req"></span></label>
					<textarea name="content" cols="50" rows="5" class="ckeditor"><?=$data['content']?></textarea>
				</div><br />

				<div class="field full">
					<label><?=__('GoogleMap')?> <span class="req"></span></label>
					<textarea name="google_map" cols="50" rows="5" class=""><?=$data['google_map']?></textarea>
				</div><br />

				
				
				<div class="field full">
					<label><?=__('Thumbnail')?> <span class="req"></span> <span>(max JPG 540 x 500)</span></label>
					<div class="file">
						<div class="fileinput">
							<input type="text" name="thumbnail_tmp" value="<?=$data['thumbnail']?>" disabled="disabled">
							<div><input type="file" name="thumbnail" /></div>
						</div>
						<div class="fname"<?php if($data['thumbnail']!=""): ?>style="display:block;"<?php endif; ?>>
							<a href="../assets/files/news/<?=$data['thumbnail']?>" target="_blank"><img src="../assets/files/news/<?=$data['thumbnail']?>" height="75" alt="" /></a>
							<a href="#" class="del">Delete</a>
							<a href="../assets/files/news/<?=$data['thumbnail']?>" target="_blank" class="iname"><?=$data['thumbnail']?></a>
							<input type="checkbox" name="thumbnail_del" value="1" />
						</div>
					</div>
				</div>

				<div class="field full">
					<label><?=__('Imagen')?> <span class="req"></span> </label>
					<div class="file">
						<div class="fileinput">
							<input type="text" name="picture_tmp" value="<?=$data['picture']?>" disabled="disabled">
							<div><input type="file" name="picture" /></div>
						</div>
						<div class="fname"<?php if($data['picture']!=""): ?>style="display:block;"<?php endif; ?>>
							<a href="../assets/files/marathon/<?=$data['picture']?>" target="_blank"><img src="../assets/files/marathon/<?=$data['picture']?>" height="75" alt="" /></a>
							<a href="#" class="del">Delete</a>
							<a href="../assets/files/marathon/<?=$data['picture']?>" target="_blank" class="iname"><?=$data['picture']?></a>
							<input type="checkbox" name="picture_del" value="1" />
						</div>
					</div>
				</div>

				<br />
				<div class="buttons">
					<button type="submit" class="button"><?=__('Save')?></button>
					<button type="button" class="button cancel"><?=__('Cancel')?></button>
				</div>
            </div>
		</form>
<script>
	$(document).ready(function(){
		//$(".chosen").data("placeholder","Selecciona los tags").chosen();
	});
</script>