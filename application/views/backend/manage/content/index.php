		<?php if($action_add): ?><button type="button" class="button add" data-action="<?=$action_add?>">Agregar nuevo</button><?php endif; ?>
		<div class="box">
			<div class="box-header clearfix">
				<h2>Listado</h2>
				<?php if($companies): ?>
				<div class="dropdown clearfix">
					<p><?=$company_name?> <span></span></p>
					<ul>
						<li<?php if($company_id==0): ?> class="selected"<?php endif; ?>><a href="<?=$_module?>index?company_id=0">- Seleccione -</a></li>
						<?php foreach($companies as $company): ?>
						<li<?php if($company['id']==$company_id): ?> class="selected"<?php endif; ?>><a href="<?=$_module?>index?company_id=<?=$company['id']?>"><?=$company['name']?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<p class="filters">Empresa:</p>
				<?php endif; ?>
			</div>
			<div class="box-body">
				<form name="list" action="" method="get" class="clearfix" data-token="<?=Security::token()?>">
					<input type="hidden" name="id" value="" />
					<input type="hidden" name="csrf_token" value="" />
					<input type="hidden" name="status" value="" />
					<input type="hidden" name="serialized" value="" />
					<div class="box-table clearfix">
						<?php if( ! count($data)): ?>
						<div class="message info">No existen registros.</div>
						<?php else: ?>
						<div class="sortable-head">
							<strong>T&iacute;tulo</strong>
							<button type="button" class="button small cancel">Cancelar</button>
							<button type="button" class="button small serialize">Guardar</button>
						</div>
						<ol class="nested-sortable" data-maxLevels="3">
							<?php foreach($data as $item): ?>
							<li id="item-<?=$item['id']?>"><div><?=$item['title']?></div>
								<?php if(count($item['pages'])): ?>
								<ol>
									<?php foreach($item['pages'] as $sub): ?>
									<li id="item-<?=$sub['id']?>"><div><?=$sub['title']?></div>
									<?php if(count($sub['pages'])): ?>
									<ol>
										<?php foreach($sub['pages'] as $subsub): ?>
										<li id="item-<?=$subsub['id']?>"><div><?=$subsub['title']?></div></li>
										<?php endforeach; ?>
									</ol>
									<?php endif; ?>
									</li>
									<?php endforeach; ?>
								</ol>
								<?php endif; ?>
							</li>
							<?php endforeach; ?>
						</ol>
						<table>
							<tbody>
								<tr>
									<th width="5"><input type="checkbox" name="select-all" value="1" data-tooltip="Seleccionar" /></th>
									<th width="570">T&iacute;tulo</th>
									<th>Estatus</th>
									<th width="5">Acciones</th>
								</tr>
								<?php foreach($data as $item): ?>
								<tr class="<?=$item['mode']?>">
									<td data-itemname="<?=$item['title']?>"><input type="checkbox" name="id[]" value="<?=$item['id']?>" class="select" /></td>
									<td><?=$item['title']?></td>
									<td class="status"><?=$item['status']?></td>
									<td class="actions">
										<?php if($action_add): ?><a href="<?=$action_add?>?parent_id=<?=$item['id']?>" class="add" data-tooltip="Agregar">Agregar</a><?php endif; ?>
										<?php if($action_edit): ?><a href="<?=$action_edit?>?id=<?=$item['id']?>" class="edit" data-tooltip="Editar">Editar</a><?php endif; ?>
										<?php if($action_delete): ?><a href="<?=$action_delete?>?id=<?=$item['id']?>" class="delete" data-tooltip="Borrar" data-id="<?=$item['id']?>">Borrar</a><?php endif; ?>
									</td>
								</tr>
								<?php foreach($item['pages'] as $sub): ?>
								<tr class="<?=$sub['mode']?>">
									<td data-itemname="<?=$sub['title']?>"><input type="checkbox" name="id[]" value="<?=$sub['id']?>" class="select" /></td>
									<td class="subpage"><?=$sub['title']?></td>
									<td class="status"><?=$sub['status']?></td>
									<td class="actions">
										<?php if($action_add): ?><a href="<?=$action_add?>?parent_id=<?=$sub['id']?>" class="add" data-tooltip="Agregar">Agregar</a><?php endif; ?>
									<!--
										<?php if($action_add): ?><a href="#" class="blank">Blank</a><?php endif; ?>
									-->
										<?php if($action_edit): ?><a href="<?=$action_edit?>?id=<?=$sub['id']?>" class="edit" data-tooltip="Editar">Editar</a><?php endif; ?>
										<?php if($action_delete): ?><a href="<?=$action_delete?>?id=<?=$sub['id']?>" class="delete" data-tooltip="Borrar" data-id="<?=$sub['id']?>">Borrar</a><?php endif; ?>
									</td>
								</tr>
								<?php foreach($sub['pages'] as $subsub): ?>
								<tr class="<?=$subsub['mode']?>">
									<td data-itemname="<?=$subsub['title']?>"><input type="checkbox" name="id[]" value="<?=$subsub['id']?>" class="select" /></td>
									<td class="subsubpage"><?=$subsub['title']?></td>
									<td class="status"><?=$subsub['status']?></td>
									<td class="actions">
										<?php if($action_add): ?><a href="#" class="blank">Blank</a><?php endif; ?>
										<?php if($action_edit): ?><a href="<?=$action_edit?>?id=<?=$subsub['id']?>" class="edit" data-tooltip="Editar">Editar</a><?php endif; ?>
										<?php if($action_delete): ?><a href="<?=$action_delete?>?id=<?=$subsub['id']?>" class="delete" data-tooltip="Borrar" data-id="<?=$subsub['id']?>">Borrar</a><?php endif; ?>
									</td>
								</tr>
								<?php endforeach; ?>
								<?php endforeach; ?>
								<?php endforeach; ?>
							</tbody>
						</table>
						<div class="bulk">
							<?php if($action_delete OR $action_status OR $action_sort): ?>
							<select name="command">
								<option value="">Seleccione acci&oacute;n</option>
								<?php if($action_delete): ?><option value="delete">Borrar</option><?php endif; ?>
								<?php if($action_status): ?><option value="1">Activar</option><?php endif; ?>
								<?php if($action_status): ?><option value="0">Desactivar</option><?php endif; ?>
							</select>
							<button type="button" class="button small bulk disabled" data-action="<?=$action_status?>">Aplicar a seleccionados</button>
							<?php if($action_sort AND count($data) > 1): ?>
							<span class="sep">&nbsp;</span>
							<button type="button" class="button small sort" data-action="<?=$action_sort?>">Ordenar</button>
							<?php endif; ?>
							<?php endif; ?>
						</div>
						<?php endif; ?>
					</div>
				</form>
			</div>
		</div>