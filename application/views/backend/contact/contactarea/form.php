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
				<div class="field full">
					<label><?=__('Email')?> <span class="req">*</span></label>
					<input type="text" name="email" value="<?=$data['email']?>" class="required email" title="<?=__('Ingrese el email')?>" />
				</div><br />
				<div class="buttons">
					<button type="submit" class="button"><?=__('Save')?></button>
					<button type="button" class="button cancel"><?=__('Cancel')?></button>
				</div>
			</div>
		</form>
