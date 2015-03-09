<section id="content">
    <div class="pleca_colores top"></div>
    <div class="container_interior">
    	<div class="inner-block">
		    <div class="content_type1 nuestro_centro">  
			    <h3><?=$data['title']?></h3>
                <?=$data['content']?>       
		    </div>
			 <?php if($data['id']== 14): ?>      
			<div class="areas">
             
             	<ul class="filter-list">
				<li class="filter " data-filter="all">Todos</li>
				<?php foreach($data['galleries'] as $gallery): ?>
                	<li class="filter" data-filter=".category-<?=$gallery['id']?>"><?=$gallery['title']?></li>
                    <!--li class="filter" data-filter=".category-1"><?=$gallery['title']?></li>
                    <li class="filter" data-filter=".category-2"><?=$gallery['title']?></li-->
				<?php endforeach; ?>
                </ul>
                
       		<?php //var_dump($data['galleries']); exit; ?>
                
               <ul id="Container">
			   <?php foreach($data['galleries'] as $gallery): ?>
					<?php if(count($gallery['images'])>0): ?>
					<?php foreach($gallery['images'] as $imagenes): ?>
						<li class="mix category-<?=$imagenes['gallery_id']?>" data-myorder="<?=$imagenes['gallery_id']?>" >
									<a href="<?=$imagenes['src_picture']?>" class="swipebox" title="<?=$imagenes['title']?>">
										<span><i class="fa fa-eye"></i></span>
										<img src="<?=$imagenes['src_picture']?>" alt="<?=$imagenes['title']?>">
										 <strong><?=$imagenes['title']?></strong>
									</a	>
						</li>
					<?php endforeach; ?>
					<?php endif; ?>
			   <?php endforeach; ?>
               </ul>
             
             </div>   
			 <?php endif; ?>
	    </div>
		<?php if($data['id']== 14): ?>      
		<div class="encuentranos">
             	<div class="inner-block">
                	<h3>Encuéntranos</h3>
                	<div class="google_map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3766.0082608237417!2d-99.16522146299405!3d19.282006964939864!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ce00f3416dcc27%3A0x68699772459b89bb!2sMagisterio+Nacional+100!5e0!3m2!1ses!2ses!4v1403478063304" width="100%" height="450" frameborder="0" style="border:0"></iframe>
                
                </div>
                </div>
             	
             </div>   
			 <?php endif; ?>      
    </div>
</section>
  <script src="js/ios-orientationchange-fix.js"></script>
	<script src="js/jquery.swipebox.js"></script>
	<script type="text/javascript">
		;( function( $ ) {

			/* Basic Gallery */
			$( '.swipebox' ).swipebox();
			/*$('.filter').click(function(){
				$(".filter").removeClass("active");
				$(this).addClass("active");
			});*/
			
		} )( jQuery );
		  
		  $(function(){
			$('#Container').mixItUp();
	  	  });
	</script>