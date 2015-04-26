            <!-- :: Content :: -->
            <section class="home" id="content">
      
            	<div class="banner">
                    <div class="sliderContainer fullWidth clearfix">
                        <div id="full-width-slider" class="royalSlider heroSlider rsMinW" >
                        
                          <?php foreach($slide as $row): ?>
                          <div class="rsContent">
                            <div class=" image_back img_1">
                            <img src="<?=$row['src_picture']?>"/>
                            <div class="infoBlock infoBlockLeftBlack rsABlock" data-rsDelay="8000" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
                              <h4><?=$row['title']?></h4>
                              <p><?=$row['summary']?></p>
                      
                               <a href="<?=$row['url']?>" target="<?php if($row['newwindow']) { echo "_blank"; } else { echo "_self"; } ?>">Ver más</a>
                            </div>
                            
                            </div>
                             <div class="shade"></div>
                          </div>
                          <?php endforeach; ?>
                          
                         
                            
                        </div>
                      </div>
                    <div class="inf_banner">
                         <div class="pleca_colores"></div>
               		 </div>
                </div>
                        <div class="pleca_colores top"></div>
                <div class="actividades">
                	<div class="inner-block">
                     <div class="estados">
                            <h5> Selecciona estado</h5>	
                            <ul>
                                <?php foreach($state as $row): ?>
                                <li><a href="actividades/estado/<?=$row['slug']?>"><?=$row['state']?></a></li>
                                <?php endforeach; ?>
                            </ul>
                    </div>
                    <h2><a href="/actividades">Actividades</a></h2>
                <div class="blocks">
                	<?php $i=1; foreach($activities as $row): ?>
                    
                    <?php if($i==1): ?>
                    <article class="big">
                   		 <a href="actividades/detalle/<?=$row['id']?>"><img src="assets/files/activity/<?=$row['thumbnail']?>" width="672" height="486" alt="<?=$row['title']?>" /></a>	
                    	<span>
                     	   <small><?=$row['state']?></small>
						</span>
                    	<div class="descripcion">
                    		<a href="actividades/detalle/<?=$row['id']?>">
	                    		<h3><?=substr($row['title'], 0, 50)?>..</h3>
	                            <p><?=substr($row['summary'], 0, 400)?>..</p>
                    		</a>
                            <a href="actividades/detalle/<?=$row['id']?>"></a>	
						</div>
                    </article>
                    <?php else: ?>
                    <article>
                    	<a href="actividades/detalle/<?=$row['id']?>"><img src="assets/files/activity/<?=$row['thumbnail']?>" width="225" height="141" alt="<?=$row['title']?>" /></a>
                    	<div class="descripcion">
                    		<a href="actividades/detalle/<?=$row['id']?>">
	                    		<h3><?=substr($row['title'], 0, 50)?></h3>
	                            <span>
	                     	   		<small><?=$row['state']?></small>
								</span>
                    		</a>
                            <a href="actividades/detalle/<?=$row['id']?>"></a>	
						</div>
                    </article>
                    <?php endif; ?>
                    <?php $i++; endforeach; ?>
                    </div>
                </div>
                </div>
                <div class="proyectos_noticias">
              		<div class="inner-block">
                    <div class="proyectos">
                        <h2>Proyectos</h2>                
                        
                        
                        <div class="sliderContainer fullWidth clearfix">
                            <div id="full-width-slider2" class="royalSlider heroSlider rsMinW" >
                                  
								<?php foreach($projects as $row): ?>
                                <div class="rsContent">
                                    <div class="img_1">
                                        <img src="assets/files/project/<?=$row['thumbnail']?>" />
                                        <div class="infoBlock rsABlock infoBlockLeftBlack" style="color:#000;" data-rsDelay="8000"  data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200"><?=$row['title']?> </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                
                                </div>
                              </div>
                                
                            </div>
                     
                    <div class="noticias">
                   	    <h2>Noticias</h2>  
                        <div>
                        <ul>
                            <?php foreach($news as $row): ?>
                            <li>
                                <a href="<?=$row['href']?>" target="<?=$row['target']?>">
                                  	<div class="txt">
                                        <strong><?=substr($row['title'], 0, 50)?>...</strong>
                                        <span><?=substr($row['summary'], 0, 150)?>..</span>
                                        <p>&nbsp;</p>
                                        <small><?=Timestamp::format($row['newsdate'], '%d-%m-%Y')?></small>
                                   		<sub>Leer mas</sub>  
                                    </div>
                                   
                                    <img align="right" src="assets/files/news/<?=$row['thumbnail']?>"/>                          
                                </a>
                            </li>
                            <?php endforeach; ?>

                        </ul>
                        </div>
                    </div>
              </div> 
                
                        
                    </div>
           
              <div class="nuestra_casa">
              		<div class="inner-block">
                   		 <h2>Nuestra casa del centro amanac - mexico</h2>
                        <div> 
                     	   <a href="#"><img src="img/secciones/nuestra_casa.jpg" alt=""/></a>
                          
                           <div class="descripcion"><h3>Chocolate bar jelly beans fruitcake icing powder.</h3>
                       		    <p>Sweet roll wafer gummies oat cake pudding pie gummies applicake ice cream. Sweet sugar plum halvah cupcake pudding tootsie roll icing. </p>	
                             <a href="#"></a>	    	
                          </div>
                        </div>
                    </div>
                
              </div>
              
              <div class="aliados">
              	<div class="inner-block">
                    <h2>Aliados a nuestra causa</h2>
                    <ul>
                        <?php foreach($partner as $row): ?>
                        <li><a href="<?=$row['url']?>" target="<?php if($row['new_window']) { echo "_blank"; } else { echo "_self"; } ?>"><img src="<?=$row['src_picture']?>"/></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                  </div>     
            </section><!-- end content -->