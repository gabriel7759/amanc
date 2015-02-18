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
					<label><?=__('Name')?> <span class="req">*</span></label>
					<input type="text" name="name" value="<?=$data['name']?>" class="required" title="<?=__('Please enter the role name')?>" />
				</div>
				<br />
				<h2><?=__('Permissions')?></h2>
				<table class="permissions" width="500">
					<?php foreach($modules as $level1): ?>
						<tr>
							<th style="background:#f3f3f3;"><?=__($level1['name'])?></th>
							<th style="background:#f3f3f3;"><?=__('View')?></th>
							<th style="background:#f3f3f3;"><?=__('Create')?></th>
							<th style="background:#f3f3f3;"><?=__('Edit')?></th>
							<th style="background:#f3f3f3;"><?=__('Delete')?></th>
							<th style="background:#f3f3f3;"><?=__('Status')?></th>
							<th style="background:#f3f3f3;"><?=__('Sort')?></th>
							<th style="background:#f3f3f3;"><?=__('Export')?></th>
						</tr>
						<?php foreach($level1['modules'] as $level2): ?>
						<tr>
							<td class="level2"><?=__($level2['name'])?></td>
							<td align="center"><?php if(in_array(1, $level2['permissions'])): ?><input type="checkbox" name="access_control[]" value="<?=$level2['id']?>.1"<?php if(in_array($level2['id'].'.1', (array)$data['access_control'])): ?> checked="checked"<?php endif; ?> /><?php endif; ?></td>
							<td align="center"><?php if(in_array(2, $level2['permissions'])): ?><input type="checkbox" name="access_control[]" value="<?=$level2['id']?>.2"<?php if(in_array($level2['id'].'.2', (array)$data['access_control'])): ?> checked="checked"<?php endif; ?> /><?php endif; ?></td>
							<td align="center"><?php if(in_array(3, $level2['permissions'])): ?><input type="checkbox" name="access_control[]" value="<?=$level2['id']?>.3"<?php if(in_array($level2['id'].'.3', (array)$data['access_control'])): ?> checked="checked"<?php endif; ?> /><?php endif; ?></td>
							<td align="center"><?php if(in_array(4, $level2['permissions'])): ?><input type="checkbox" name="access_control[]" value="<?=$level2['id']?>.4"<?php if(in_array($level2['id'].'.4', (array)$data['access_control'])): ?> checked="checked"<?php endif; ?> /><?php endif; ?></td>
							<td align="center"><?php if(in_array(5, $level2['permissions'])): ?><input type="checkbox" name="access_control[]" value="<?=$level2['id']?>.5"<?php if(in_array($level2['id'].'.5', (array)$data['access_control'])): ?> checked="checked"<?php endif; ?> /><?php endif; ?></td>
							<td align="center"><?php if(in_array(6, $level2['permissions'])): ?><input type="checkbox" name="access_control[]" value="<?=$level2['id']?>.6"<?php if(in_array($level2['id'].'.6', (array)$data['access_control'])): ?> checked="checked"<?php endif; ?> /><?php endif; ?></td>
							<td align="center"><?php if(in_array(7, $level2['permissions'])): ?><input type="checkbox" name="access_control[]" value="<?=$level2['id']?>.7"<?php if(in_array($level2['id'].'.7', (array)$data['access_control'])): ?> checked="checked"<?php endif; ?> /><?php endif; ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</table>
				<br />
				<div class="buttons">
					<button type="submit" class="button"><?=__('Save')?></button>
					<button type="button" class="button cancel"><?=__('Cancel')?></button>
				</div>
			</div>
		</form>
