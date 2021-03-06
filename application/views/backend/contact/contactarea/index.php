		<?php if($action_add): ?><button type="button" class="button add" data-action="<?=$action_add?>"><?=__('Create new')?></button><?php endif; ?>
		<div class="box">
			<div class="box-header clearfix">
				<h2><?=__('List')?></h2>
				<p class="filters">
					<span><?=__('View')?>:</span>
					<a href="#" data-status="-1"<?php if($status==-1): ?> class="selected"<?php endif; ?>><?=__('All')?></a>
					<a href="#" data-status="1"<?php if($status==1): ?> class="selected"<?php endif; ?>><?=__('Active')?></a>
					<a href="#" data-status="0"<?php if($status==0): ?> class="selected"<?php endif; ?>><?=__('Inactive')?></a>
				</p>
			</div>
			<div class="box-body">
				<form name="list" action="" method="get" class="clearfix" data-token="<?=Security::token()?>">
					<input type="hidden" name="id" value="" />
					<input type="hidden" name="csrf_token" value="" />
					<input type="hidden" name="page" value="<?=$page?>" />
					<input type="hidden" name="order_by" value="<?=$order_by?>" />
					<input type="hidden" name="sort" value="<?=$sort?>" />
					<input type="hidden" name="status" value="<?=$status?>" />
					<input type="hidden" name="serialized" value="" />
					<ul class="box-search clearfix">
						<li>
							<h3><?=__('Filters')?></h3>
							<p><?=__('Use the filters below to refine the results shown in the list')?>.</p>
						</li>
					</ul>
					<div class="box-table search clearfix">
						<?php if( ! count($data)): ?>
						<div class="message info"><?=__('No records were found')?>.</div>
						<?php else: ?>
						<div class="sortable-head wfilters">
							<strong>T&iacute;tulo</strong>
							<button type="button" class="button small cancel">Cancelar</button>
							<button type="button" class="button small serialize">Guardar</button>
						</div>
						<ol class="nested-sortable" data-maxLevels="1">
							<?php foreach($data as $item): ?>
							<li id="item-<?=$item['id']?>"><div><?=$item['title']?></div></li>
							<?php endforeach; ?>
						</ol>
						<table>
							<tbody>
								<tr>
									<th width="5"><input type="checkbox" name="select-all" value="1" data-tooltip="<?=__('Select all')?>" /></th>
									<th><?=__('Title')?></th>
									<th class="sortable" abbr="status" title="<?=__('Sort by status')?>"><?=__('Status')?></th>
									<th width="5"><?=__('Actions')?></th>
								</tr>
								<?php foreach($data as $item): ?>
								<tr class="<?=$item['mode']?>">
									<td data-itemname="<?=$item['name']?>"><input type="checkbox" name="id[]" value="<?=$item['id']?>" class="select" /></td>
									<td><?=Text::limit_chars($item['title'], 55)?></td>
									<td class="status"><?=__($item['status'])?></td>
									<td class="actions">
										<?php if($action_edit): ?><a href="<?=$action_edit?>?id=<?=$item['id']?>" class="edit" data-tooltip="<?=__('Edit')?>"><?=__('Edit')?></a><?php endif; ?>
										<?php if($action_delete): ?><a href="<?=$action_delete?>?id=<?=$item['id']?>" class="delete" data-tooltip="<?=__('Delete')?>" data-id="<?=$item['id']?>"><?=__('Delete')?></a><?php endif; ?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<div class="bulk">
							<?php if($action_delete): ?>
							<select name="command">
								<option value=""><?=__('Select action')?></option>
								<?php if($action_delete): ?><option value="delete"><?=__('Delete')?></option><?php endif; ?>
								<?php if($action_status): ?><option value="1"><?=__('Activate')?></option><?php endif; ?>
								<?php if($action_status): ?><option value="0"><?=__('Deactivate')?></option><?php endif; ?>
							</select>
							<button type="button" class="button small bulk disabled" data-action="<?=$action_status?>"><?=__('Apply to selected')?></button>
							<?php if($action_sort AND count($data) > 1): ?>
							<span class="sep">&nbsp;</span>
							<button type="button" class="button small sort" data-action="<?=$action_sort?>">Ordenar</button>
							<?php endif; ?>
							<?php endif; ?>
						</div>
						<?=$page_links?>
						<?php endif;?>
					</div>
				</form>
			</div>
		</div>