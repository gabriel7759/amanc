$(document).ready(function(){	  
	$(".redes_direccion ul li a").addClass(function( index ) {
		    return "social-" + index;
	}); 
	$(".aliados ul li").addClass(function( index ) {
		    return "aliado-" + index;
	});    
	$('.estados h5').click(function(){	
	  		$('.estados ul').stop().slideToggle();
			$(this).toggleClass("active");
	});
	$('.search_btn').click(function(){	
	  		$('.search_block').stop().slideToggle();
	});
	$('.inner-block h2').click(function(){
		  var width = $(window).width();
		  if (width <= 620) { 
	 		  if($(this).hasClass("active")) {
			   $(this).next("div").stop().slideUp(500);
			   $(this).removeClass("active");
		   } 
		   else {
			   $(".inner-block h2").next("div").slideUp();
			   $(this).next("div").stop().slideDown(500);
			   $('.royalSlider').royalSlider('updateSliderSize', true);
			   $('.inner-block h2').removeClass("active");
			   $(this).addClass("active");
			} 
		  }
     });
	  $('#full-width-slider .rsContent div > img').replaceWith(function(i, v){
   		 return $('<div/>', {
        	style: 'background-image: url('+this.src+')',	
  	 }); 
     });
	 
	 
	 
	 $(".image_back").each(function(){	
		 $(this).find("div:eq(0)").addClass("cont_image");
	 });
	 $('#full-width-slider2 .rsContent div > img').replaceWith(function(i, v){
   		 return $('<article/>', {
        	style: 'background-image: url('+this.src+')',
  	 	}) 
     });
	 $('#full-width-slider3 .rsContent > img').replaceWith(function(i, v){
   		 return $('<div/>', {
        	style: 'background-image: url('+this.src+')',	
  	 }); 
     });
	$(window).resize(function(){
	  var width = $(window).width();
	    $('.suscribete').css({
               position:'fixed',
               left: ($(window).width() - $('.suscribete').outerWidth())/2        
      });
	  
	  if (width >= 900) { 
		$('.menu_2 ul').show();
	  $('.search_block').css({
               position:'fixed',
               left: ($(window).width() - $('.search_block').outerWidth())/2        
      });
	  

	  
	  }
	  if (width >= 801) { 
			$(".main-menu").prependTo('#menu');
	  }  
	  if (width <= 800) { 
			$("#menu .main-menu").prependTo('.menu_hidden');
	  }
	 
	    if (width >= 701) { 


		    $('.program  ol li:even').each(function(){
				 $(this).find("div").insertBefore($(this).find("img")); 
		    });
			  $('.program  ol li:odd').each(function(){
				 $(this).find("div").insertAfter($(this).find("img")); 
		    });
			$(".mision_vision img").insertBefore(".mision_vision div");
	  }  
	  if (width <= 700) { 
			$('.program  ol li').each(function(){
				 $(this).find("div").insertBefore($(this).find("img"));
		      });
			  
			  $(".mision_vision img").insertAfter(".mision_vision div");
			
	  }
	    
	  if (width <= 600) { 
			$(".inf_banner").insertBefore('.actividades');
			$(".contactanos .redes_direccion").insertAfter('.contactanos form');
			$(".home .inner-block h2").next("div").hide();	
			$(".voluntariado .tipos h4").next("div").hide();
	  }
	  else  { 
			$(".inf_banner").appendTo($(".banner"));
			$(".contactanos .redes_direccion").insertBefore('.contactanos form');
			$(".inner-block h2").next("div").show();
			$(".voluntariado .tipos h4").next("div").show();
			
			 
			
	  }	
	  
	   if( width >= 400 && width <= 619 ) {
	   		  $('.directory ul').each(function(){
				 $(this).find("li:odd").addClass("dir_right");
		      });
	   }else {
	   		 $(this).find("li").removeClass("dir_right");
	   }
	  
	  if (width >= 321) {
			if (toggle == true) {
						$(".other-menu").css({
								'right': '245px'
						});
					}  	
					
	  } 
	   if (width <= 320) {
			if (toggle == true) {
						$(".other-menu").css({
								'right': '0'
						});
			}  		
					
	  } 
	  $('#full-width-slider .infoBlock').css({
               position:'absolute',
               left: ($(window).width() - $('#full-width-slider .infoBlock').outerWidth())/2      
      });
	 $('header').css({
               position:'fixed',
               left: ($(window).width() - $('header').outerWidth())/2        
     });
	 $('.rsBullets').css({
               position:'absolute',
               left: ($(window).width() - $('.rsBullets').outerWidth())/2      
     });
	
	 }); 
	    $(window).resize();
		var stickyNavTop = $('.pleca_colores.top').offset().top;    
		var stickyNav = function(){  
		var scrollTop = $(window).scrollTop();  
			   
		if (scrollTop > stickyNavTop) {   
			$('.pleca_colores.top').addClass('sticky');  
		} else {  
			$('.pleca_colores.top').removeClass('sticky');   
		}  
		};  
		stickyNav();    
		$(window).scroll(function() {  
			stickyNav();  
		});  	
			var toggle = false;
			$('.other-menu a').on('click', function () {
					$('.velo').fadeIn();
				 	 var width = $(window).width();	
						if (toggle == false) {
							if (width >= 321) { 		
							$(this).parent().stop().animate({
								'right': '245px'
							});
						 }else {
							$(this).parent().stop().animate({
								'right': '0px'
							}); 
						 }
						  $('.menu_hidden_mask').css({
									"height" : "100vh",
									"min-height":"600px"
									
					      });
						  $('.menu_hidden').stop().animate({
									'right': '0px'
						  });
						 
						  toggle = true;
					} else {
						
						$('.velo').fadeOut();
						$('.menu_hidden').stop().animate({
							'right': '-320px'
						},
						{
						  complete: function() {
							   $('.menu_hidden_mask').css({
									"height" : "0px",
									"min-height":"0"
								});
								 $('.menu_hidden_mask').removeClass("altura");
							},
						  queue: false
						}
						);
						$(this).parent().stop().animate({
								'right': '0px'
							});
							toggle = false;
						}
	});
	$('.menu_2 h6').click(function(){	
	  		$('.menu_2 ul').stop().slideToggle();
			$(this).toggleClass("active");
	});



	
	  //$(function(){
		//$('#Container').mixItUp();

	//  });
	  
	 

	  $('#playvideo').click(function(){
			$("#video")[0].src += "&autoplay=1";
			$(this).unbind("click");
	 		$(this).fadeOut("slow");
	  });
		 $('.sumarse form ul li.acepto label').click(function(){
		 	if($(this).hasClass("active")) {
				$(this).find("i").removeClass("fa-check-square").addClass("fa-square");
				$(this).removeClass("active");
			}else{
				$(this).find("i").removeClass("fa-square").addClass("fa-check-square");
				$(this).addClass("active");
			}
		 
		 });
		 
		  $('.check label').click(function(){
			    $(this).parent().find("label").removeClass("active");
		 		$(this).addClass("active");
		  });
		  
		  $(".voluntariado .tipos h4").click(function(){
			   var width = $(window).width();	
			   if (width <= 601) { 	
					if($(this).hasClass("active")) {
						$(this).next("div").slideUp();
						$(this).removeClass("active");
					}else {
						$(".voluntariado .tipos h4").removeClass("active");
						$(".voluntariado .tipos div").slideUp();
						$(this).next("div").slideDown();
						$(this).addClass("active");
					
					}
				}
		  });
		  
		   $(".tipo_form  li a").click(function(){
		 		 clase = $(this).attr('class');
					$('div.'+clase).hide()
					.siblings(".formulario").slideUp();
					$('div.'+clase).slideDown();
					$(".tipo_form  li a").removeClass("active");
					$(this).addClass("active");	

			});
			
			$('.open_lightbox').click(function(){	
	  			$('.lightbox').fadeIn();
			});
			
			$('.close_lightbox').click(function(){	
	  			$('.lightbox').fadeOut();
			});
			
			
			
			
			
			$('.tipo_tarjeta ol li label').click(function(){
				$('.tipo_tarjeta ol li label').removeClass("active");
			    $(this).addClass("active");

		  });
		  $('.acepto_terminos label').click(function(){
		 	if($(this).hasClass("active")) {
				$(this).find("i").removeClass("fa-check-square").addClass("fa-square");
				$(this).removeClass("active");
			}else{
				$(this).find("i").removeClass("fa-square").addClass("fa-check-square");
				$(this).addClass("active");
			}
		 
		 });
		
		  $('.donativos_como > div').hide();
			$('.donativos_como > div:eq(0)').show();
			$('.donativos_como > h2:eq(0)').addClass("active");
			$('.donativos_como h2').click(function(){	
	  			if($(this).hasClass("active")) {
					$(this).next("div").slideUp();	
					$(this).removeClass("active");
					
				}else {
					$('.donativos_como h2').removeClass("active");
					$(this).addClass("active");
					$('.donativos_como > div').slideUp();
					$(this).next("div").slideDown();	
				

				}
			});
			
			   $(".codigo_esquema a")
					 .mouseenter(function(){
							  $('.esquema').stop().fadeIn();
					  })
					  .mouseleave(function(){
							$('.esquema').fadeOut();
					  });	
			 
		 
		  
		  	   $(window).resize();	   
		   
		   $(window).load(function(){
				/* image preview */
				$('.cargar_imagen').change(function(){
					var boton= $(this);
					var oFReader = new FileReader();
					oFReader.readAsDataURL(this.files[0]);
					console.log(this.files[0]);
					oFReader.onload = function (oFREvent) {
					boton.parent().find(".imagen_ife").addClass("active").html('<img src="'+oFREvent.target.result+'">');
				
					boton.parent().find(".borrar").removeClass("disable");
					boton.parent().find(".fake-file input").addClass("disable");
				
					};
				});


});//]]>  
 	 $('.borrar').addClass("disable");
	 $('.borrar').click(function(e){ 
			$(this).parent().find(".imagen_ife img").remove();  
			$(this).parent().find(".imagen_ife").removeClass("active")
			$(this).parent().find(".fake-file input").removeClass("disable");
			e.preventDefault()
		    $(this).addClass("disable");

	}); 
	
		  
		  
});
 
 