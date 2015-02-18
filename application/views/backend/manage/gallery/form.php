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
					<label>Contenido asociado <span class="req">*</span></label>
						<select name="content_id" class="func_selector">
							<option value="0">- Contenido -</option>
							<?php foreach($sections as $section): ?>
								<option value="<?=$section['id']?>"<?php if($section['id']==$id_parent): ?> selected="selected"<?php endif; ?>><?=$section['title']?></option>
								<?php if(count($section['pages'])>0): ?>
									<?php foreach($section['pages'] as $ssection): ?>
										<option value="<?=$ssection['id']?>"<?php if($ssection['id']==$id_parent): ?> selected="selected"<?php endif; ?> style="padding-left: 25px;"><?=$ssection['title']?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
				</div><br />
				<div class="field full">
					<label><?=__('Title')?> <span class="req">*</span></label>
					<input type="text" name="title" value="<?=$data['title']?>" class="required" title="<?=__('Please enter the title')?>" />
				</div><br />
				<div class="field full">
					<label><?=__('Descripción')?> <span class="req">*</span></label>
					<textarea name="summary" cols="50" rows="10"><?=$data['summary']?></textarea>
				</div><br />
				<div class="field full">
				<button type="button" class="button" id="add">Agregar imagen</button>
				</div><br/>
				<!--div class="field full" id="gallery">
				<?php //if(isset($data['gallery']) && count($data['gallery'])>0){
							//$i=0;
							//foreach($data['gallery'] as $gallery){ ?>
					<div class="file" id="num-gal-<?=$i?>">
						<label><?=__('Imagen')?> <span class="req">*</span> <span>(max JPG 540 x 500)</span> <a href="#" class="delet" data-num="num-gal-<?=$i?>" >Delete</a></label>
						<div class="fileinput">
							<input type="text" name="picture[]" value="<?=$gallery['thefile']?>" class="file" disabled="disabled" >
							<input type="file" id="picture_upload-<?=$i?>" name="picture_tmp" class="uploadify"/>
							<?php //if($gallery['thefile']!='') { ?>
										<div class="preview">
										<img src="<?=$gallery['src_file']?>" alt="" /></div>
										</div>
										<?php //}else{} ?>
						</div>
					<?php //	$i++;
								//} ?>
                    <?php// } ?>
				</div-->
				<div id="div-gallery"  class="field full">
                	<?php if(isset($data['gallery']) && count($data['gallery'])>0){
							$i=0;
							foreach($data['gallery'] as $gallery){ ?>
                        	
                            	<div class="file num-gal" id="num-gal-<?=$i?>"><br />
                                    <label><?=__('Imagen')?> <span class="req">*</span> <span>(max JPG 540 x 500)</span><a href="javascript:void(0);" class="delet" data-num="num-gal-<?=$i?>">borrar</a></label>
									<label><?=__('Title')?></label>
										<input type="text" name="gallery-title[]" value="<?=$gallery['title']?>" style="width:303px;" title="Selecccione el titulo"  /><br/>
										<label><?=__('Descripción')?></label>
										<textarea name="gallery-summary[]" cols="50" style="width:303px;" rows="10"><?=$gallery['summary']?></textarea><br/>
									<label>Archivo <span>(max JPG 540 x 500)</span></label>
									<!--div class="fileinput">
										<input type="text" name="gallery-file[]" value="<?=$gallery['picture']?>" class="file" title="Selecccione el archivo" readonly="readonly" />
										<input type="file" id="" name="picture_upload" class="" />
										
									</div-->
									<div class="fileinput">
									<input type="text" name="pictures[]" value="<?=$gallery['picture']?>" disabled="disabled"/>
										<div><input type="file" name="picture[]" /></div>
									</div>
									<div class="fname"<?php if($gallery['picture']!=""): ?>style="display:block;"<?php endif; ?>>
										<a href="../assets/files/gallery/<?=$gallery['id']?>/<?=$gallery['picture']?>" target="_blank"><img src="../assets/files/gallery/<?=$gallery['id']?>/<?=$gallery['picture']?>" height="75" alt="" /></a>
										<a href="#" class="del">Delete</a>
										<a href="../assets/files/gallery/<?=$gallery['id']?>/<?=$gallery['picture']?>" target="_blank" class="iname"><?=$gallery['picture']?></a>
										<input type="checkbox" name="picture_del" value="1" />
									</div>
								</div>
                       
                        <?php 	$i++;
								} ?>
                    <?php } ?>
                </div>			
				<br />
				<div class="buttons">
					<button type="submit" class="button"><?=__('Save')?></button>
					<button type="button" class="button cancel"><?=__('Cancel')?></button>
				</div>
			</div>
		</form>
		<script>
		function upload(){
				$("input.uploadify").uploadify({
					'width'           : 70, 
					'height'          : 31,
					'buttonImage'     : '/assets/img/backend/browse.png',
					'fileTypeDesc'    : 'Image Files',
					'fileTypeExts'    : '*.gif; *.jpg; *.jpeg; *.png', 
					'fileSizeLimit'   : '3MB',
					'auto'            : true,
					'multi'           : false,
					'removeCompleted' : true,
					'swf'             : '/assets/uploadify/uploadify.swf',
					'uploader'        : '/assets/uploadify/uploadify.php',
					'onUploadSuccess' : function(file, data, response) {
						var original = $('#'+this.original.attr('id'));
						original.parent().find('input.file').val(file.name);
						original.parent().find('div.preview img').attr('src', '/assets/files/tmp/'+file.name);
					}
				});
			}
		$(document).ready(function(){
				$("body").delegate(".delet", "click", function(){
					var num = $(this).data("num");
					$("div#"+num).remove();
					var cont = 0;
					var arr_num = num.split("-");
					$("."+arr_num[0]+"-"+arr_num[1]).each(function(){
						$(this).attr("id", arr_num[0]+"-"+arr_num[1]+"-"+cont);
						$(this).find(".field label a.delete").data("num", arr_num[0]+"-"+arr_num[1]+"-"+cont);
						cont++;
					});
				});							
					$("#add").click(function(){
					var num_fields = $("#div-gallery .num-gal").size();
					//alert(num_fields);
					var gallery_field = '<div class="file num-gal" id="num-gal-'+num_fields+'"><br />'+
											'<label>Imagen<span class="req">*</span> <span>(max JPG 540 x 500)</span><a href="javascript:void(0);" class="delet" data-num="num-gal-'+num_fields+'">borrar</a></label>'+
												
											'   <label>Título</label>'+
								'<input type="text" name="gallery-title[]" value=""  style="width:303px;" title="Selecccione el titulo"  /><br>'+
								
								
								' <label>Resumen</label>'+
								' <textarea name="gallery-summary[]" cols="50" style="width:303px;" rows="10"></textarea><br>'+
									
									'   <label>Archivo <span>(max JPG 540 x 500)</span></label>'+
								'	<div class="fileinput">'+
								'<input type="text" name="pictures[]" value="" disabled="disabled">'+
										'<div><input type="file" name="picture[]" /></div>'+
									'</div>'+
									'<div class="fname">'+
										'<a href="" target="_blank"><img src="" height="75" alt="" /></a>'+
										'<a href="#" class="del">Delete</a>'+
										'<a href="../assets/files/marathon/<?=$data['picture']?>" target="_blank" class="iname"><?=$data['picture']?></a>'+
										'<input type="checkbox" name="picture_del" value="1" />'+
									'</div>'+
									/*
								'		<input type="text" name="gallery-file[]" value="" style="width:234px;" class="file" title="Selecccione el archivo" readonly="readonly" />'+
								'		<input type="file" id="picture_upload" name="picture_upload" class="uploadify" />'+			
								'	</div>'+
							*/
								'</div>  ';
					$("#div-gallery").append(gallery_field);
					upload();
				});
			});
		</script>
		<!--script>
		function upload(){
				$("input.uploadify").uploadify({
					'width'           : 101, 
					'height'          : 27,
					'buttonImage'     : '/assets/img/backend/browse.png',
					'fileTypeDesc'    : 'Image Files',
					'fileTypeExts'    : '*.gif; *.jpg; *.jpeg; *.png', 
					'fileSizeLimit'   : '3MB',
					'auto'            : true,
					'multi'           : false,
					'removeCompleted' : true,
					'swf'             : '/assets/uploadify/uploadify.swf',
					'uploader'        : '/assets/uploadify/uploadify.php',
					'onUploadSuccess' : function(file, data, response) {
						var original = $('#'+this.original.attr('id'));
						original.parent().find('input.file').val(file.name);
						original.parent().find('div.preview img').attr('src', '/assets/files/tmp/'+file.name);
					}
				});
			}
		$(document).ready(function(){
				$("body").delegate(".delet", "click", function(e){
					e.preventDefault();
					var num = $(this).data("num");
					$("div#"+num).remove();
					var cont = 0;
					var arr_num = num.split("-");
					$("."+arr_num[0]+"-"+arr_num[1]).each(function(){
						$(this).attr("id", arr_num[0]+"-"+arr_num[1]+"-"+cont);
						$(this).find(".field label a.delete").data("num", arr_num[0]+"-"+arr_num[1]+"-"+cont);
						cont++;
						
					});
				});							
					$("#add").click(function(){
					var num_fields = $("#gallery .file").size();
					//alert(num_fields);
					var gallery_field = '<div class="file" id="num-gal-'+num_fields+'">'+
						'<label>Imagen<span class="req">*</span><span>(max JPG 540 x 500)</span> <a href="#" class="delet" data-num="num-gal-'+num_fields+'" >Delete</a></label>'+
						'<div class="fileinput">'+
							'<input type="text" name="picture_tmp[]" value="" class="file" disabled="disabled" >'+
							'<div><input type="file" id="picture_upload-'+num_fields+'" name="picture" class="uploadify"/></div>'+	
							'<div class="preview"><img src="" alt="" /></div>'+
						'</div>'+
					'</div>';
					$("#gallery").append(gallery_field);
					upload();
				});
			});
		</script-->
