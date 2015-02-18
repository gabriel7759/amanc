// JavaScript Document

$(document).ready(function(){


});

function validateForm(form){
	var result = true;
	form.find('.required').each(function(){
		if($(this).is('[type=checkbox]')){
			if(!$(this).is(':checked')){
				alert($(this).attr('title'));
				$(this).focus();
				result = false;
				return false;
			}
		} else if($(this).val().length == 0){
			alert($(this).attr('title'));
			$(this).focus();
			result = false;
			return false;
		} else if($(this).hasClass('email')){
			if(!$(this).val().isEmail()){
				alert($(this).attr('title'));
				$(this).focus();
				result = false;
				return false;
			}
		} else if($(this).hasClass('pwdconfirm')){
			if($(this).val() != $('input[name="'+$(this).attr('data-related')+'"]').val()){
				alert("Las contraseñas no coinciden");
				$(this).focus();
				result = false;
				return false;
			}
		}
	});
	return result;
}

String.prototype.isEmail = function(){
	return (this.valueOf().search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1);
}
