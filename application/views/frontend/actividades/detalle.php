   <!-- :: Content :: -->
            <section id="content">
              <div class="pleca_colores top"></div> 
              <div class="container_interior">      
                   <div class="inner-block">
                      <div class="actividades_interior">
                    <div class="dos_columnas">
                        <div class="col_izq">
                      <div class="descripcion_noticia">
                          <h2><?=$data['actividad']['title']?><span>14 de julio 2014</span></h2>
                          <div class="noticia_share">
                              <ol>
                                  <li><a class="facebook" href="#">  <span class='st_facebook' displayText='Facebook'><i class="fa fa-facebook"></i></span></a></li>
                                        <li><a class="twitter" href="#"><span class='st_twitter' displayText='Tweet'><i class="fa fa-twitter"></i></span></a></li>
                                         <li><a class="correo" href="#"><span class='st_email' displayText='Email'><i class="fa fa-envelope"></i></span></a></li>
                                   <li><a class="like" href="#"><span class='st_fblike' displayText='Facebook Like'></span></a></li>
                                
                                </ol>
                       </div>     
                                
                                <div>
                                
                                  <figure>
                                      <img src="<?=$data['actividad']['src_picture']?>"/> <small><?=$data['actividad']['state']?></small>
                                    </figure>
                                    <p><?=$data['actividad']['content']?></p>
                                </div>
                      </div>
                    </div>
                    <div class="col_der">
                      <div class="populares interior">
                          <h2>Populares</h2>
                          <ul>
                            <?php if($data['popular']){ ?>
                              <?php foreach($data['popular'] as $popular){ ?>
                                <li>
                                    <a href="/actividades/detalle/<?=$popular['id']?>"><img src="<?=$popular['src_picture']?>"/></a>
                                      
                                      <div>
                                      <a href="/actividades/detalle/<?=$popular['id']?>">
                                        <span><?=$popular['state']?></span>
										<p><?=Text::limit_chars($popular['summary'], 150, '...')?></p>
                                      </a>
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