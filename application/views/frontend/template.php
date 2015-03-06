<!doctype html>
<html>
<head>
			<!-- Title -->
            <title>AMANC</title>
            <base href="<?=URL::base(TRUE)?>" />
            <!-- Iso -->
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <!-- Description -->
            <meta name="description" content="" />
          	<!-- Keywords -->
            <meta name="keywords" content="" />
          	<!-- Fonts -->
           <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
            <!-- Share -->
            <meta property="og:image" content="" />
            <link rel="image_src" type="image/jpeg" href="">
            <!-- Viewport -->
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
            <!-- Phone -->
            <meta name="format-detection" content="telephone=no">
            <!-- Icon -->
            <link rel="shortcut icon" href="favicon.ico">
         
            <!-- ++ CSS ++ -->
            <link href="css/style.css" rel="stylesheet" type="text/css">
            <!-- Font awsome -->
            <link rel="stylesheet" href="css/font-awesome.css">
            <!-- Plugin -->
            <link class="rs-file" href="css/royalslider.css" rel="stylesheet">
            <!-- slider stylesheets -->
            <link class="rs-file" href="css/rs-minimal-white.css" rel="stylesheet">
			<link rel="stylesheet" href="css/swipebox.css">
    
         	<!-- ////////////////////////// BEGIN MEDIA QUIERIES ///////////////////////////// -->
                <link rel="stylesheet" type="text/css" media="all and (max-width: 320px)" href="css/1_portrait.css" />
                <link rel="stylesheet" type="text/css" media="all and (min-width: 321px) and (max-width:618px)" href="css/2_movil_landscape.css" />
                <link rel="stylesheet" type="text/css" media="all and (min-width: 619px) and (max-width:700px)" href="css/3_tablet_mini_portrait.css" />
                <link rel="stylesheet" type="text/css" media="all and (min-width: 701px) and (max-width:800px)" href="css/4_ipad_portrait.css" />
                <link rel="stylesheet" type="text/css" media="all and (min-width: 801px) and (max-width:1024px)" href="css/5_ipad_landscape.css" />
                <link rel="stylesheet" type="text/css" media="all and (min-width: 1025px)" href="css/6_laptop_medium.css" />
                <!--[if IE]>
                <script type="text/javascript">
                        var e = ("abbr,article,aside,audio,canvas,datalist,details,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video").split(',');
                        for (var i=0; i<e.length; i++) {
                            document.createElement(e[i]);
                        }
                </script>
                <style type="text/css">
                        .gradient {filter: none;}
                </style>
            	<![endif]-->
                
               <!--[if lte IE 8]>
            		<link rel="stylesheet" type="text/css" href="css/ie8.css" />
                <![endif]-->
                
                <!-- Jquery 1.9.1 -->
                <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
              
               <script class="rs-file" src="js/jquery.royalslider.min.js"></script>
			    <script type="text/javascript" src="js/jquery.mixitup.js"></script>
                 <script type="text/javascript" src="js/scripts.js"></script>
                 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
                <script src="//code.jquery.com/jquery-1.10.2.js"></script>
                <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
                <script>
                    var $j = $.noConflict(true);
                  </script>
   			    <!-- syntax highlighter -->
         <script type="text/javascript">var switchTo5x=true;</script>
          <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
          <script type="text/javascript">stLight.options({publisher: "83be2daf-8b92-45c5-883e-398d5d870512", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
</head>

<body>
		<!-- Wrapper -->
        <div  id="wrapper">
        <div class="velo"></div>
            
        	<!-- :: Header :: -->
            <header>
               <div class="velo"></div>
               <section class="inner-block clear">
               <div class="menu_hidden_mask">
                    <nav class="menu_hidden">
                    
                       <ul class="first">
                             <li><a href="#">Actividades</a></li>
                            <li><a href="#">Noticias</a></li> 
                            <li><a href="#">Voluntariado</a></li>
                            <li><a href="#">Sistema AMANC</a></li>
                            <li><a href="#">Aliados</a></li>
                            <li><a href="#">Escuelas Amigas</a></li>
                            <li><a href="#">Nómina con Causa</a></li>
                            <li><a href="#"> Maratón</a></li>
                        </ul>
                        
                        <ul class="second">    
                            <li><a href="#">Modelo de acompañamiento</a></li> 
                            <li><a  href="#">Beneficios</a></li>
                            <li><a href="#">Campañas de Detección Oportuna</a></li>
                            <li><a href="#">Comunidad de Supervivientes</a></li>
                            <li><a href="#">Fomento al Empleo</a></li>
                        </ul>
                  
                    </nav>
               	</div>
                    <a href="index" class="logo"><img src="img/logo/amanc.png" alt="AMANC"></a>
                    <div class="navigation">
                        <nav class="social">
                            <ul>
                               <li><a href=""><i class="fa fa-facebook"></i></a></li>
                               <li><a href=""><i class="fa fa-twitter"></i></a></li>
                               <li><a href=""><i class="fa fa-youtube-play"></i></a></li>
                               <li><a href=""><i class="fa fa-instagram"></i></a></li>
                               <li><a href=""><i class="fa fa-envelope"></i></a></li>
                               <li><a class="search_btn" href="javascript:void(0);"><i class="fa fa-search"></i></a></li>
                                <li><a href="">Eng</a></li>
                            </ul>
                        </nav>
                        <nav id="menu">
                            <ul class="main-menu">
                                <?php foreach($menu as $row): ?>
                                <li><a href="<?=$row['url']?>" <?php if($section.'/'.$page == $row['url']) { echo 'class="active"'; }?>><?=$row['title']?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="other-menu">
                                <a href="javascript:void(0);" class="open-other"><i class="fa fa-bars"></i></a>
                            </div>
                        </nav>
                    </div>
               </section>
            	
            </header><!-- end header -->
             
             <div class="search_block">	
             <form>
                    	<input placeholder="Buscar" type="text"/>
                        <input type="submit"/> 
                    </form> 
        	</div>
            
            <?=$content?>            
            
            <!-- fix -->
            <div class="fix"></div>
            
            <!-- :: Footer :: -->
            <footer>
         
            <div class="mapa_sitio">
            	<div class="inner-block">
                  <?php if(count($sitemap)): ?>
                  <?php foreach($sitemap as $row): ?>
                  <ul>
                  	    <li><h4><?=$row['title']?></h4></li>
                    	<?php foreach($row['sub'] as $page): ?>
                        <li><a href="<?=$page['link']?>"><?=$page['title']?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endforeach; ?>
                   <?php endif; ?>
                	
                
                
                </div>
            </div>
            <div class="contactanos">
              	<div class="inner-block">
                	<div class="redes_direccion">
                        <ul>
                            <li><a  href=""><i class="fa fa-facebook"></i></a></li>
                               <li><a href=""><i class="fa fa-twitter"></i></a></li>
                               <li><a href=""><i class="fa fa-youtube-play"></i></a></li>
                                <li><a href=""><i class="fa fa-instagram"></i></a></li>
                        
                        </ul>
                		<p>Tel. 5513.7111 / 01800.627.7860 Magisterio Nacional No. 100, <br/>
Col. Tlalpan Centro, Distrito Federal, C.P. 14000</p>

						<p><a href="#">Aviso de privacidad</a> | <a href="#">Prensa</a></p>
				    </div>
                        <form>
                        	<h4>Contactanos</h4>
                            <input type="text" placeholder="nombre"/>
                            <input type="email" placeholder="email"/>
                            <textarea placeholder="Mensaje"></textarea>
                            <input type="submit"  value="enviar"/>
                        </form>
                </div>
              
              </div>
                
            </footer><!-- end footer -->
            
        </div><!-- end wrapper -->
<script id="addJS">jQuery(document).ready(function($) {
		  $('#full-width-slider').royalSlider({
			arrowsNav: true,
			arrowsNavAutoHide: false,
			startSlideId: 0,
			 slidesSpacing: 0,
			transitionType:'move',
			sliderTouch: false,
			globalCaption: false,
			
			autoPlay: {
				delay:8000,
				// autoplay options go gere
				enabled: true,
				pauseOnHover: true
			  }
  });
  
	   $('#full-width-slider2').royalSlider({
				arrowsNav: false,
				startSlideId: 0,
				slidesSpacing: 0,
				transitionType:'move',
				sliderTouch: false,
				globalCaption: false,
			
				autoPlay: {
						delay:8000,
					// autoplay options go gere
					enabled: true,
					pauseOnHover: true
				  }
	  });
	});
</script>   		
</body>
</html>
