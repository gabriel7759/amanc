		<form name="save" action="" method="post" class="form validate" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?=$data['id']?>" />
			<div class="sidebar">
				<div class="sidebox">
					<h2>P&aacute;gina de nivel superior</h2>
					<div class="field">
						<select name="parent_id" class="func_selector">
							<option value="0">- Ra&iacute;z del sitio -</option>
							<?php foreach($sections as $section): ?>
								<option value="<?=$section['id']?>"<?php if($section['id']==$id_parent): ?> selected="selected"<?php endif; ?>><?=$section['title']?></option>
								<?php if(count($section['pages'])>0): ?>
									<?php foreach($section['pages'] as $ssection): ?>
										<option value="<?=$ssection['id']?>"<?php if($ssection['id']==$id_parent): ?> selected="selected"<?php endif; ?> style="padding-left: 25px;"><?=$ssection['title']?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</div>
					<h2 class="is_func prod_func_0 <?=($id_parent==0)?'func_active':''?>">Mostrar en menú</h2>
					<div class="field is_func prod_func_0 <?=($id_parent==0)?'func_active':''?>">
						<label class="option"><input type="radio" name="in_menu" value="1"<?php if(Arr::get($data, 'in_menu', 1)==1): ?> checked="checked"<?php endif; ?> /> Si</label>
						<label class="option"><input type="radio" name="in_menu" value="0"<?php if(Arr::get($data, 'in_menu', 1)==0): ?> checked="checked"<?php endif; ?> /> No</label>
					</div>
					<?php if($action_status): ?>
					<h2>Estatus</h2>
					<div class="field">
						<label class="option"><input type="radio" name="status" value="1"<?php if(Arr::get($data, 'status', 1)==1): ?> checked="checked"<?php endif; ?> /> Activo</label>
						<label class="option"><input type="radio" name="status" value="0"<?php if(Arr::get($data, 'status', 1)==0): ?> checked="checked"<?php endif; ?> /> Inactivo</label>
					</div>
					<?php endif; ?>
				</div>
				<?php if($data['id']): ?>
				<div class="sidebox">
					<h2>&Uacute;ltima modificaci&oacute;n</h2>
					<p class="last-modified"><strong><?=$data['log_user']?></strong><br /> <?=Timestamp::format($data['log_time'], '%d de %B del %Y a las %H:%M')?></p>
				</div>
				<?php endif; ?>
			</div>
			<div class="fieldset">
				<h2>Datos generales</h2>
				<div class="field full">
					<label>T&iacute;tulo <span class="req">*</span></label>
					<input type="text" name="title" value="<?=$data['title']?>" class="required" title="Escriba el t&iacute;tulo" />
				</div>
				<br />
				<div class="field full">
					<label>Subt&iacute;tulo <span class="req"></span></label>
					<input type="text" name="subtitle" value="<?=$data['subtitle']?>" class="" title="Escriba el subt&iacute;tulo" />
				</div>
				<br />
				<div class="field full">
					<label>Contenido</label>
					<textarea name="content" cols="50" rows="8" class="ckeditor"><?=$data['content']?></textarea>
				</div>
				<br />
				<div class="field full">
					<label>Redireccionar <span>Utilice este campo para ir a una URL en lugar de mostrar el contenido</span></label>
					<input type="text" name="link" value="<?=$data['link']?>" />
				</div>
				<br />
                <h2>Seo</h2>
				<div class="field full">
					<label>T&iacute;tulo SEO<span class="req"></span></label>
					<input type="text" name="seo_title" value="<?=$data['seo_title']?>" />
				</div>
				<br />
				<div class="field full">
					<label>Keywords SEO<span class="req"></span></label>
					<input type="text" name="seo_keywords" value="<?=$data['seo_keywords']?>" />
				</div>
				<br />
				<div class="field full">
					<label>Abstract SEO<span class="req"></span></label>
					<textarea name="seo_abstract" cols="50" rows="4" class=""><?=$data['seo_abstract']?></textarea>
				</div>
				<br />
				<div class="field full">
					<label>Description SEO<span class="req"></span></label>
					<textarea name="seo_description" cols="50" rows="4" class=""><?=$data['seo_description']?></textarea>
				</div>
				<br />
				<div class="buttons">
					<button type="submit" class="button">Guardar</button>
					<button type="button" class="button cancel">Cancelar</button>
					<?php if($data['id'] AND $action_delete): ?><button type="button" class="button delete">Eliminar</button><?php endif; ?>
				</div>
			</div>
		</form>
