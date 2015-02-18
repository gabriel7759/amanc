		<form name="save" action="" method="post" class="form validate" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?=$data['id']?>" />
			<div class="sidebar">
				<?php if($action_status): ?>
				<div class="sidebox">
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
				<h2><?=__('Configuración del sitio')?></h2>
				<div class="field full">
					<label><?=$data[0]['var_description']?> <span class="req">*</span></label>
					<input type="text" name="<?=$data[0]['var_name']?>" value="<?=$data[0]['var_value']?>" class="required" title="<?=$data[0]['var_description']?>" />
				</div><br />
				<div class="field full">
					<label><?=$data[1]['var_description']?> <span class="req">*</span></label>
					<input type="text" name="<?=$data[1]['var_name']?>" value="<?=$data[1]['var_value']?>" class="required" title="<?=$data[1]['var_description']?>" />
				</div><br />
				<div class="field full">
					<label><?=$data[2]['var_description']?> <span class="req">*</span> <span>(max JPG 100 x 100)</span></label>
					<div class="file">
						<div class="fileinput">
							<input type="text" name="<?=$data[2]['var_value']?>_tmp" value="" disabled="disabled">
							<div><input type="file" name="<?=$data[2]['var_name']?>" /></div>
						</div>
						<div class="fname"<?php if($data[2]['var_value']!=""): ?>style="display:block;"<?php endif; ?>>
							<a href="../assets/files/siteconfig/<?=$data[2]['var_value']?>" target="_blank"><img src="../assets/files/siteconfig/<?=$data[2]['var_value']?>" height="75" alt="" /></a>
							<a href="#" class="del">Delete</a>
							<a href="../assets/files/slide/<?=$data[2]['var_value']?>" target="_blank" class="iname"><?=$data[2]['var_value']?></a>
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
