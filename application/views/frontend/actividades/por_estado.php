  <!-- :: Content :: -->
            
            
            
            
            <section id="content">
              <div class="pleca_colores top"></div> 
              <div class="container_interior">      
                   <div class="inner-block">
                      <div class="actividades_interior">
                               <div class="titulo_estados">  
                                    <h3>Actividades</h3> 
                                            <div class="estados">
                                                     <h5> Selecciona estado</h5>  
                                                    <ul>
                                                      <?php if($data['estados']){ ?>
                                                        <?php foreach($data['estados'] as $estado){ ?>
                                                          <li><a href="<?='actividades/estado/'.$estado['slug']?>"><?=$estado['state']?></a></li>
                                                        <?php } ?>
                                                      <?php } ?>
                                                    </ul>
                                             </div>
                    </div>
                 
                      
                    <div class="slider">
                      <div class="sliderContainer fullWidth clearfix">
                        <div id="full-width-slider3" class="royalSlider heroSlider rsMinW" >
                        
                        
                          <div class="rsContent">
                          
                          
                      <img src="../img/secciones/slider_temporal.jpg"/>  
                       <div class="infoBlock infoBlockLeftBlack rsABlock" data-rsDelay="8000" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
                        <div class="block">
                          <span>
                                    <small>San Luis Potosí</small>
                            </span>
                          
                            <div class="caption">
                             <h4>Blueberry</h4>
                        <h2>owder gingerbread carrot cake jujubes halvah cake pastry fruitcake candy.</h2>
                          <a href="#">ver mas</a> 
                         
                           </div>
                           </div>
                       </div>     
                    </div>
                    
                    
                    <div class="rsContent">
                          
                          
                      <img src="../img/secciones/slider_temporal.jpg"/>  
                       <div class="infoBlock infoBlockLeftBlack rsABlock" data-rsDelay="8000" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
                        <div class="block">
                          <span>
                                    <small>San Luis Potosí</small>
                            </span>
                          
                            <div class="caption">
                             <h4>Blueberry</h4>
                        <h2>owder gingerbread carrot cake jujubes halvah cake pastry fruitcake candy.</h2>
                          <a href="#">ver mas</a> 
                         
                           </div>
                           </div>
                       </div>     
                    </div>
                    
                         
                           </div>
                       </div>     
                    </div>
                    
                    <div class="dos_columnas">
                        <h3><?=$data['titulo']?></h3>
                        <div class="col_izq">
                      <?=$data['pagination']?> 
                      <ul class="items">
                        <?php if($data['actividades']->as_array()){ ?>
                          <?php foreach($data['actividades']->as_array() as $act){ ?>
                          <li>
                                <figure><img src="<?=$act['src_picture']?>"/> <small><?=$act['state']?></small></figure>
                                <div>
                                     <h4><?=$act['title']?></h4>
                                     <p><?=Text::limit_chars($act['summary'], 300, '...')?></p> 
                                     <span>30 de enero 2014</span>
                                     <ol>
                                          <li><a class="facebook" href="javascript:void(0);"><span class='st_facebook' st_url="<?=URL::base(TRUE)?>actividades/detalle/<?=$act['id']?>" st_title="<?=$act['title']?>" st_image="<?=URL::base(TRUE).$act['src_picture']?>" st_summary="<?=$act['summary']?>" displayText='Facebook'><i class="fa fa-facebook"></i></span></a></li>
                                          <li><a class="twitter" href="#"><span st_url="<?=URL::base(TRUE)?>actividades/detalle/<?=$act['id']?>" st_title="<?=$act['title']?>" st_image="<?=URL::base(TRUE).$act['src_picture']?>" st_summary="<?=$act['summary']?>"  class='st_twitter' displayText='Tweet'><i class="fa fa-twitter"></i></span></a></li>
                                          <li><a class="correo" href="#"><span st_url="<?=URL::base(TRUE)?>actividades/detalle/<?=$act['id']?>" st_title="<?=$act['title']?>" st_image="<?=URL::base(TRUE).$act['src_picture']?>" st_summary="<?=$act['summary']?>"  class='st_email' displayText='Email'><i class="fa fa-envelope"></i></span></a></li>
                                     </ol>
                                            <a href="<?='/actividades/detalle/'.$act['id']?>"></a>
                                </div>
                           </li>
                           <?php } ?>
                        <?php }else print '<h2>No hay activiades para mostrar</h2>' ?>
                      </ul>  
                      
                      
                      
                    </div>
                    <div class="col_der">
                      <div class="populares">
                          <h2>Populares</h2>
                          <ul>
                            <?php if($data['popular']){ ?>
                              <?php foreach($data['popular'] as $popular){ ?>
                                <li>
                                    <a href="/actividades/detalle/<?=$popular['id']?>"><img src="<?=$popular['src_picture']?>"/></a>
                                      
                                      <div>
                                        <span><?=$popular['state']?></span>
                                      <p><?=Text::limit_chars($popular['summary'], 150, '...')?></p>
                                      </div> 
                                  </li>
                              <?php } ?>
                            <?php } ?>
                            </ul>
                        </div>
                        <?php if($data['tags']){ ?>
                        <div class="etiquetas">
                          <h2>Etiquetas</h2>
                          <ul>
                            <?php foreach($data['tags'] as $tag){ ?>
                              <li><a href="/actividades/tag/<?=$tag['id']?>"><?=$tag['title']?></a></li>
                              <?php } ?>
                            </ul> 
                        </div>
                        <?php } ?>
                    
                        <div class="container_twitter">
                          <a class="twitter-timeline" href="https://twitter.com/AMANCMEXICO" data-widget-id="490975105405575168">Tweets por @AMANCMEXICO</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


                       </div>
                        <div class="facebook">
                            
                    
                     <div class="fb-post" data-href="https://www.facebook.com/FacebookDevelopers/posts/10151471074398553" data-width="300"></div>
                              <div class="fb-follow" data-href="https://www.facebook.com/zuck" data-width="300" data-colorscheme="light" data-layout="standard" data-show-faces="true"></div>
                            
                            </div>
                      </div>
                    </div>
              
                     
                   </div>
                   </div>
                   
                   
                   
                   
                   </div>
                   
            </section><!-- end content -->

<script>
  $(function(){
    $('#go_to').click(function(e){
      e.preventDefault();
      var value = parseInt($("#num_text").val());
      var all_items = $('#total_pages').val();
      console.log('<?=$data["uri"]?>?page='+value);
      if(value<=all_items&&value>0){
        window.location='<?=$data["uri"]?>?page='+value;
      }
    });

  });
</script>
       