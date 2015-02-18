$(document).ready(function(){
	
	
	
	/* DEFAULT */
	
	/* identity options */
	$('#header .identity').on('mouseenter', function(){
		$('#header .identity ul').show();
	}).on('mouseleave', function(){
		$('#header .identity ul').hide();
	});
	
	/* menu options */
	$('#menu > li').on('mouseenter', function(){
		$(this).find('ul').show();
	}).on('mouseleave', function(){
		$(this).find('ul').hide();
	});
	
	/* dropdown*/
	$('div.dropdown').on('mouseenter', function(){
		$(this).addClass('hover').find('ul').show();
	}).on('mouseleave', function(){
		$(this).removeClass('hover').find('ul').hide();
	});
	
	/* message */
	$('div.message a.close').on('click', function(e){
		e.preventDefault();
		$(this).parent().fadeOut();
	});
	
	/* tooltips */
	$('*[data-tooltip]').on('mouseover', function(){
		var elem = $(this);
		var tip  = $('#tooltip');
		var text = elem.data('tooltip');
			tip.text(text);
		var left = parseInt(elem.offset().left-tip.width()/2-2)+'px';
		var top  = parseInt(elem.offset().top+elem.height()+9)+'px';
			tip.css({'left': left, 'top': top}).show(0);
	}).on('mouseout', function(){
		$('#tooltip').hide(0);
	});
	
	/* delete */
	$('td a.delete').on('click', function(e){
		e.preventDefault();
		var itemname = $(this).parent().parent().find('td[data-itemname]').data('itemname');
		var url = $(this).attr('href').split('?id=');
		$('#modal-confirm .box-body p span').html('Está a punto de eliminar <strong>'+itemname+'</strong>');
		$('#modal-overlay').fadeIn(300, function(){
			$('#modal-confirm').data('action', url[0]).data('itemid', url[1]).show(0);
		});
	});
	
	/* delete */
	$('td a.delete').on('click', function(e){
		e.preventDefault();
		var itemname = $(this).parent().parent().find('td[data-itemname]').data('itemname');
		var url = $(this).attr('href').split('?id=');
		$('#modal-confirm .box-body p span').html('Está a punto de eliminar <strong>'+itemname+'</strong>');
		$('#modal-overlay').fadeIn(300, function(){
			$('#modal-confirm').data('action', url[0]).data('itemid', url[1]).show(0);
		});
	});
	

	/* bulk action */
	$('div.box-table button.bulk').on('click', function(){
		if ($(this).hasClass('disabled')) {
			return false;
		}
		if ( ! $('form[name="list"] select[name="command"]').val().length) {
			alert('Seleccione una acción');
			return;
		}
		var command = $('div.box-table div.bulk select option:selected').text().toLowerCase();
		var value   = $('div.box-table div.bulk select option:selected').val();
		var count   = $('div.box-table input.select:checked').length;
		var url     = self.location.href.split('?');
//		var action  = (value=='delete') ? $(this).data('action').replace('/status', '/delete') : $(this).data('action');
		if(command=='activate' || command=='activar' || command=='deactivate' || command=='desactivar' || command=='publish' || command=='publicar')
			var action  = url[0].replace('/index', '/status');
		else
			var action  = url[0].replace('/index', '/'+value);
		var status  = (command=='activate' || command=='activar' || command=='publish' || command=='publicar') ? 1 : 0;
		$('#modal-confirm .box-body p span').html('Está a punto de <strong>'+command+'</strong> '+count+' elementos.');
		$('#modal-overlay').fadeIn(300, function(){
			$('#modal-confirm').data('action', action).data('status', status).show(0);
		});
	});
	
	/* modal */
	$('#modal-confirm a.close, #modal-confirm button.cancel').on('click', function(e){
		e.preventDefault();
		$('#modal-confirm').data('action', '').data('itemid', '').hide(0);
		$('#modal-overlay').fadeOut();
	});
	$('#modal-confirm button.accept').on('click', function(){
		if ( ! $(this).hasClass('disabled')) {
			var action = $('#modal-confirm').data('action');
			var id     = $('#modal-confirm').data('itemid');
			var status = $('#modal-confirm').data('status');
			var token  = $('form[name="list"]').data('token');
			if (id.length) {
				$('form[name="list"] input.select').attr('checked', false);
			}
			$(this).addClass('disabled');
			$('form[name="list"] input[name="id"]').val(id);
			$('form[name="list"] input[name="status"]').val(status);
			$('form[name="list"] input[name="csrf_token"]').val(token);
			$('form[name="list"]').attr('action', action).attr('method', 'post').submit();
//			$('form[name="list"]').attr('action', action).attr('method', 'post');
		}
	});
	
	/* blank */
	$('a.blank').on('click', function(e){
		e.preventDefault();
	});
	
	/* filters */
	$('.box-search').each(function(){
		var obj = $(this);
			obj.height(obj.parent().height());
	});
	
	$('input[name="select-all"]').on('click', function(){
		var table = $(this).parent().parent().parent().parent();
		var box   = table.parent();
		if ($(this).is(':checked')) {
			table.find('input.select').attr('checked', true);
			table.find('tr:gt(0)').addClass('selected');
			box.find('button.bulk').removeClass('disabled');
		} else {
			table.find('input.select').attr('checked', false);
			table.find('tr:gt(0)').removeClass('selected');
			box.find('button.bulk').addClass('disabled');
		}
	});
	$('input.select').on('click', function(){
		var row   = $(this).parent().parent();
		var table = row.parent().parent();
		var box   = table.parent();
		var total = table.find('input.select').length;
		($(this).is(':checked')) ? row.addClass('selected') : row.removeClass('selected');
		var checked = table.find('input.select:checked').length;
		(checked==0) ? box.find('button.bulk').addClass('disabled') : box.find('button.bulk').removeClass('disabled');
		(checked==total) ? table.find('input[name="select-all"]').attr('checked', true) : table.find('input[name="select-all"]').attr('checked', false);
	});
	
	// disabled button
	$('button.disabled, a.disabled').on('click', function(e){
		e.preventDefault();
	});
	
	// action buttons
	$('#content button.add').on('click', function(){
		var url = self.location.href.split('/');
			url.pop();
			url.push('form');
		self.location.href = url.join('/');
	});
	$('form.form button.cancel').on('click', function(){
		var url = self.location.href.split('/');
			url.pop();
			url.push('index');
		self.location.href = url.join('/');
	});
	
	// form validation
	$('form.validate').on('submit', function(){
		var success  = true;
		var form     = $(this);
		// prevent submitting the form twice
		if (form.find('button.disabled').length>0)
			return false;
		// remove error
		form.off('keydown').on('keydown, change', 'input, select', function(){ // ensure that the same handler isn't binded twice
			$(this).removeClass('error');
		});
		// validate non empty elements
		form.find('input.required, select.required, textarea.required').each(function(){
			if ($.trim($(this).val()) == '') {
				alert($(this).attr('title'));
				$(this).focus().addClass('error');
				success = false;
				return false;
			}
		});
		// form didn't pass validations
		if (!success) {
			return false;
		} else {
			form.find('button[type="submit"]').addClass('disabled');
			return true;
		}
	});
	
	// date picker
	$("input.date").datepicker({ dateFormat: "yy-mm-dd", firstDay: 0, changeMonth: true, changeYear: true, yearRange: '1940:2015' });
	
	// sticky menu
	$(document).scroll(function(){
		($('html').offset().top <= -43) ? $('#menu').addClass('sticky') : $('#menu').removeClass('sticky');
	});
	
	// filters
	$('div.box-header p.filters a').on('click', function(e){
		e.preventDefault();
		$('form[name="list"] input[name="status"]').val($(this).data('status'));
		$('form[name="list"] input[name="page"]').val(1);
		$('form[name="list"]').submit();
	});
	
	// pagination
	$('div.box-table div.pagination a').on('click', function(e){
		e.preventDefault();
		if ( ! $(this).hasClass('disabled')) {
			$('form[name="list"] input[name="page"]').val($(this).data('page'));
			$('form[name="list"]').submit();
		}
	});
	
	// sort
	if ($('.sortable').length) {
		$('.sortable').sortable({
			handle: '.handle'
		});
	}
	
	// export
	$('button.export').on('click', function(){
		self.location.href = $(this).data('action');
	});
	
	// custom select control
	$('div.select p').on('click', function(){
		var list = $(this).parent().find('ul');
		if (list.is(':visible')) { 
			list.hide();
			$('#select-overlay').remove();
		} else {
			list.show();
		}
		$('body').append('<div id="select-overlay"></div>');
	});
	$('div.select ul span.option').on('click', function(){
		var value = $(this).data('value');
		var id = $(this).data('id');
		$('#'+id).hide();
		$('#'+id+' span.option').removeClass('selected');
		$(this).addClass('selected');
		$('#'+id).parent().find('p').text($(this).text());
		$('#'+id).parent().find('input[type="hidden"]').val(value);
		$('#select-overlay').remove();
	});
	$('#select-overlay').on('click', function(){ 
		$(this).remove();
		$('div.select > ul').hide();
	});
	
	// quizzes
	if ($('input[name="type"]').length) {
		var quizz = $('input[name="type"]:checked').val();
		$('.quizztype input[type="text"]').removeClass('required');
		$('.quizztype').hide();
		$('#quizztype'+quizz+' input[type="text"]').addClass('required');
		$('#quizztype'+quizz).show();
	}
	$('input[name="type"]').on('click', function(){
		var quizz = $(this).val();
		$('.quizztype input[type="text"]').removeClass('required');
		$('.quizztype').hide();
		$('#quizztype'+quizz+' input[type="text"]').addClass('required');
		$('#quizztype'+quizz).show();
	});
	
	$('input[type="file"]').on('change', function(e){
		$(this).parent().parent().find('input[type="text"]').val($(this).val());
		var fname = $(this).parent().parent().parent().find('.fname');
		fname.show();
		fname.find('input[type="checkbox"]').removeAttr('checked');
		
		var files = e.target.files;
		for (var i = 0, f; f = files[i]; i++) {
			
			if (!f.type.match('image.*')) {
				continue;
			}
				var reader = new FileReader();
				reader.onload = (function(theFile) {
					return function(e) {
						fname.find('img').attr('src', e.target.result);
						fname.find('a.iname').text(theFile.name);
					};
				})(f);
				reader.readAsDataURL(f);
/*
			if (!f.type.match('image.*')) {
				var reader = new FileReader();
				reader.onload = (function(theFile) {
					return function(e) {
						fname.find('img').attr('src', e.target.result);
						fname.find('a.iname').text(theFile.name);
					};
				})(f);
				reader.readAsDataURL(f);
			} else {
				var reader = new FileReader();
				reader.onload = (function(theFile) {
					return function(e) {
						fname.find('a.iname').text(theFile.name);
					};
				})(f);
				reader.readAsDataURL(f);
			}
*/
		}
	});
	
	$('.fname a.del').on('click', function(e){
		e.preventDefault();
		$(this).parent().hide();
		$(this).parent().parent().find('input[type="text"]').val($(this).val());
		$(this).parent().find('input[type="checkbox"]').attr('checked', 'checked');
	});
	
	$('textarea.ckeditor_').each(function(i){
		var textarea = $(this);
		var id = textarea.attr('id');
		CKEDITOR.replace(id);
	});
	
	$('textarea.ckeditorsml').each(function(i){
		var textarea = $(this);
		var id = textarea.attr('id');

		CKEDITOR.replace(id, {
			width: '380px',
			height: '300px',
			toolbar: [
				{ name: 'basicstyles', items: [ 'Font', 'FontSize', 'Bold', 'Italic', 'Underline', 'Strike', 'TextColor', 'BGColor' ] },
				{ name: 'lists', items: [ 'RemoveFormat', '-','NumberedList', 'BulletedList','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
				{ name: 'links', items: [ 'Link','Unlink','Anchor' ] },
				{ name: 'clipboard', items: [ 'Paste', 'PasteFromWord' ] },
				{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule', 'SpecialChar','PageBreak','Iframe' ] },
				{ name: 'tools', items: [ 'Source' ] },
			],
		});
	});
	
	
	if ($('.nested-sortable').length) {
		nestedMaxLevels = parseInt($('.nested-sortable').attr('data-maxLevels'));
		$('.nested-sortable').nestedSortable({
			disableNesting: 'no-nest',
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			maxLevels: nestedMaxLevels,
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div'
		});
		$('div.box-table button.serialize').click(function(){
			var serialized = $('.nested-sortable').nestedSortable('serialize');
			var action = $('div.box-table button.sort').data('action');
			var token  = $('form[name="list"]').data('token');
			$('form[name="list"] input[name="serialized"]').val(serialized);
			$('form[name="list"] input[name="csrf_token"]').val(token);
			$('form[name="list"]').attr('action', action).attr('method', 'post').submit();
		})
		
		$('div.box-table button.sort').on('click', function(){
			$(this).addClass('disabled');
			$('ul.box-search').css('minHeight', ($('div.box-table .nested-sortable').height()+40));
			$('div.box-table .nested-sortable').parent().css('minHeight', ($('div.box-table .nested-sortable').height()+40));
			$('div.box-table div.sortable-head, div.box-table .nested-sortable').fadeIn(300);
		});
		$('div.sortable-head button.cancel').on('click', function(){
			$('div.box-table button.sort').removeClass('disabled');
			$('div.box-table div.sortable-head, div.box-table .nested-sortable').fadeOut(300);
			$('ul.box-search').css('minHeight', 100);
			$('div.box-table .nested-sortable').parent().css('minHeight', 100);
		});
	}

	$('select.func_selector').on('change', function(){
		var mytype = $(this).val();
		$('form.form .is_func').hide();
		$('form.form .prod_func_'+mytype).show();
	});

	$('select#failprice_load_type, select#failprice_load_section').on('change', function(e){
		var section_id = $('select#failprice_load_section').val();
		var type_id = $('select#failprice_load_type').val();
		$.post('/api/loadFailsByType', { type_id: type_id, section_id: section_id }, function(data){
			var opts = '<option value="0">- Seleccione -</option>';
			for(i=0; i<data.length; i++){
				opts += '<option value="'+data[i].id+'">'+data[i].title+'</option>';;
			}
			$('select#failprice_load_fail').html(opts);
		}, 'json');
	});
	$('select#failprice_load_brand').on('change', function(e){
		var brand_id = $('select#failprice_load_brand').val();
		$.post('/api/loadModelsAll', { id: brand_id }, function(data){
			var opts = '<option value="0">- Seleccione Modelo -</option>';
			for(i=0; i<data.length; i++){
				opts += '<option value="'+data[i].id+'">'+data[i].title+'</option>';;
			}
			$('select#failprice_load_model').html(opts);
		}, 'json');
	});
	$("input.uploadify_pdf").uploadify({
		'width'           : 101, 
		'height'          : 27,
		'buttonImage'     : '/assets/img/backend/browse.png',
		'fileTypeDesc'    : 'PDF',
        'fileTypeExts'    : '*.pdf; *.doc; *.docx', 
		'fileSizeLimit'   : '50MB',
		'auto'            : true,
		'multi'           : false,
		'removeCompleted' : true,
		'swf'             : '/assets/uploadify/uploadify.swf',
		'uploader'        : '/assets/uploadify/uploadify.php',
		'onUploadSuccess' : function(file, data, response) {
			var original = $('#'+this.original.attr('id'));
			original.parent().find('input.file').val(file.name);
        }
    });
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
	
	$("input.uploadify_mp3").uploadify({
		'width'           : 101, 
		'height'          : 27,
		'buttonImage'     : '/assets/img/backend/browse.png',
		'fileTypeDesc'    : 'Mp3',
        'fileTypeExts'    : '*.mp3', 
		'fileSizeLimit'   : '50MB',
		'auto'            : true,
		'multi'           : false,
		'removeCompleted' : true,
		'swf'             : '/assets/uploadify/uploadify.swf',
		'uploader'        : '/assets/uploadify/uploadify.php',
		'onUploadSuccess' : function(file, data, response) {
			var original = $('#'+this.original.attr('id'));
			original.parent().find('input.file').val(file.name);
        }
    });	 

});