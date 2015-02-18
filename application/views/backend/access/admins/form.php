		<form name="save" action="" method="post" class="form validate">
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
				<div class="field">
					<label><?=__('First name')?> <span class="req">*</span></label>
					<input type="text" name="first_name" value="<?=$data['first_name']?>" class="required" title="<?=__('Please enter the first name')?>" />
				</div>
				<div class="field">
					<label><?=__('Last name')?> <span class="req">*</span></label>
					<input type="text" name="last_name" value="<?=$data['last_name']?>" class="required" title="<?=__('Please enter the last name')?>" />
				</div>
				<div class="field">
					<label><?=__('E-mail')?> <span class="req">*</span></label>
					<input type="text" name="email" value="<?=$data['email']?>" class="required email" title="<?=__('Please enter the e-mail')?>" />
				</div>
				<br />
				<h2><?=__('Access details')?></h2>
				<div class="field">
					<label><?=__('Role')?> <span class="req">*</span></label>
					<select name="role_id" class="required" title="<?=__('Please select the role')?>">
						<option value="">- <?=__('Select')?> -</option>
						<?php foreach($roles as $role): ?>
						<option value="<?=$role['id']?>"<?php if($role['id']==$data['role_id']): ?> selected="selected"<?php endif; ?>><?=$role['name']?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<br />
				<?php if($data['id']): ?>
				<div class="message info"><?=__('If you want to change the password, fill in the following fields')?>.</div>
				<?php endif; ?>
				<div class="field">
					<label><?=__('Password')?><?php if(!$data['id']): ?> <span class="req">*</span><?php endif; ?></label>
					<input type="password" name="password" class="<?php if(!$data['id']): ?>required <?php endif; ?>password" title="<?=__('Please enter the password')?>" />
				</div>
				<div class="field third">
					<label><?=__('Confirm password')?><?php if(!$data['id']): ?> <span class="req">*</span><?php endif; ?></label>
					<input type="password" name="confirm_password" class="<?php if(!$data['id']): ?>required <?php endif; ?>confirm password" title="<?=__('Please enter your password confirmation')?>" />
				</div>
				<br />
				<div class="buttons">
					<button type="submit" class="button"><?=__('Save')?></button>
					<button type="button" class="button cancel"><?=__('Cancel')?></button>
				</div>
			</div>
		</form>
