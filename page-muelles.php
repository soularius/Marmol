<?php

    get_header();
?>
    <!-- Init body page -->
    <main id="page-struct">
      <!-- Section banner -->
      <section id="section-1" style="background-image:url('<?=get_field('backgroud_banner_1')?>')">    
          <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-6 col-xl-4 col-banner-text bg-black-transparent d-flex flex-column">
                <div class="box-title-banner w-100 d-flex">
                  <h1 class="title-banner text-white d-flex flex-column ml-md-0 mr-md-auto">
                    <span class="size-1"><?php the_field('title_big'); ?></span>
                    <span class="size-2"><?php the_field('title_small_sub'); ?></span>
                  </h1>
                </div>
                <?php if( get_field('see_more') ): ?>
                <div class="box-btn-banner">
                    <a href="<?php echo get_field('see_more')['url']; ?>"><?php echo get_field('see_more')['title']; ?></a>
                </div>
                <?php endif; ?>
              </div>
              <div class="col-md-6 d-none d-md-block">

              </div>
            </div>
        </div>
        <section id="shadown-bann"></section>
      </section>

      <!--SECCION-Intermedia-->


      <Section id="section-intermedio">
        <div class="row align-items-center">
          <div class="col text-center justify-content-center align-items-center">
            <div class="titulo-intermedio " >
              <h2 class="titulo-inter"><?=get_field('title_big_part_1') ?><span class="t-size-intermedio"><br><?=get_field('title_big_part_2') ?></span></h2>
            </div>
          </div>
        </div>
      </Section>


      <!--SECCION-catalogo-2-->

      <section id="section-catalogo-2" class="d-flex align-items-center justify-content-center ">
            <div class="container ">
                <div class="row ">

                  <div class="col-md-6  d-flex justify-content-center order-2  order-sm-2 order-md-1 justify-content-lg-end justify-content-md-center align-items-center">
                    <div class="card-catalogo">
                      <div class="card-body-catalogo ">
                          <h4 class="titulo-card-catalogo"> Marca<span class="t-size-card-s2"><br> MUELLLES</span></h4>
                          <p class="card-text-s2-catalogo">Es una marca con más de 20 años de presencia en el mercado nacional. Su diseño es moderno y actual. Tiene productos para todos los géneros: Masculino, Femenino e Infantil. Cuenta con un amplio portafolio de productos donde se pueden encontrar Camisetas, Polos, Buzos, Chompas, Joggers y muchos más.</p>
                          
                          <?php $marca_muelles = get_field('card_catalogo_muelles'); ?>
                          <?php if( $marca_muelles ): ?>
                          <div class="box-btn-s2-2"> 
                                <a class="btn-e btn-s2-2" href="<?php echo $marca_muelles['boton_comprar_catalogo_muelles']['url'] ?>" >
                                  <div class="row d-flex justify-content-center align-items-center ml-0">
                                      <div class="texto-cart col-8 justify-content-center align-items-center "><?php echo $marca_muelles['boton_comprar_catalogo_muelles']['title'] ?></div>
                                        <div class=" col-4 justify-content-center align-items-center  pl-0">
                                          <div class="cart d-flex justify-content-center align-items-center">
                                            <i class="bi bi-cart2"></i>
                                          </div>
                                      </div>
                                  </div> 
                                  <span class="linea-left-hover-btn"></span>
                                  <span class="linea-right-hover-btn"></span>
                                  <span class="linea-top-hover-btn"></span>
                                  <span class="linea-bottom-hover-btn"></span> 
                                </a>
                          </div>
                          <?php endif; ?>
                       </div>
                    </div>
                  </div> 

                  <div class="col-md-6  d-flex  order-1 order-sm-1 order-md-2 justify-content-center  justify-content-md-center align-items-center">
                    <div class="align-items-center d-flex justify-content-center">
                        <div class="box-border-catalogo">
                            <div class="box-img-dotacion-hombre_y_mujer">
                              <img class="img-s2-catalogo" src="<?=get_field('img_section_catalogo_muelles')?>" class="img-fluid" alt="">
                            </div> 
                        </div> 
                    </div> 
                  </div>
              </div>
            </div>
      </section>
    
        <!--Section intermedia entre section catalogo y section 4(aliados comerciales)-->
        <!--
        <Section id="section-intermedio1">
          <div class="row align-items-center">
            <div class="backg col text-center justify-content-center align-items-center">
              <div class="titulo-intermedio1 " >
                <h2 class="titulo-inter1">Lorem ipsum dolor sit amet cons<span class="t-size-intermedio1"><br> Lorem ipsum dolor sit a met</span></h2>
              </div>
            </div>
          </div>
        </section>
        -->


      <section id="section-4" class="mt-5 pt-5">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-md-6 col-12">
              <div class="box-text">
                <h1 class="title-text-s4">
                  <span class="title-type-1"><?=get_field('title_normal')?></span>
                  <span class="title-type-2"><?=get_field('title_medium')?></span>
                  <span class="title-type-3"><?=get_field('title_small')?></span>
                </h1>
                  <?php 
                      $see_more = get_field('contact');
                  ?>
              
                <!--<a href="<?=$see_more['url'] ?>" class="btn-e btn-s3 ">
                  <span class="text-white"><?=$see_more['title']?></span>
                  <span class="icon-wpp ml-2"><img src="<?=get_field('icon_whatsaap')?>"></span>
                </a>-->
                
                <div class="box-btn-s3"> 
                  <?php if( get_field('activar_whatsapp_flotante','option') ): ?>
                    <?php $whatsapp = get_field('whatsapp_flotante','option'); ?>
                    <a class="btn-e btn-s3" href="<?php echo esc_url($whatsapp['url']); ?>" target="_blank" >
                          <ul class="list-inline mt-3">
                            <li class="list-inline-item mr-4">Contáctanos</li>
                            <li class="list-inline-item"><img src="https://nuevo.inversionesmarmol.com/wp-content/uploads/2021/03/Whatsaap.png" alt=""></li>
                          </ul>
                      <span class="linea-left-hover-btn"></span>
                      <span class="linea-right-hover-btn"></span>
                      <span class="linea-top-hover-btn"></span>
                      <span class="linea-bottom-hover-btn"></span>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div id="bg-color" class="col-xl-8 col-md-6 col-12 d-none d-md-block"></div>
          </div>
        </div>
      </section>
      <section id="section-5">
        <div class="container">
          <div class="" id="clients-logos">
            <?php if( get_field('imagen_logo_1') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_1')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_2') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_2')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_3') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_3')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_4') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_4')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_5') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_5')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_6') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_6')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_7') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_7')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_8') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_8')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_9') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_9')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_10') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_10')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_11') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_11')?>">
              </div>
            </div>
            <?php endif; ?>
            <?php if( get_field('imagen_logo_12') ): ?>
            <div class="">
              <div class="box-img-s5 m-auto">
                <img src="<?=get_field('imagen_logo_12')?>">
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </section>
      <script type="text/javascript">
      jQuery(document).ready(function() {
          jQuery("#clients-logos").lightSlider({
              item: 6,
              autoWidth: false,
              slideMove: 1, // slidemove will be 1 if loop is true
              slideMargin: 10,
      
              addClass: '',
              mode: "slide",
              useCSS: true,
              cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
              easing: 'linear', //'for jquery animation',////
      
              speed: 400, //ms'
              auto: false,
              loop: false,
              slideEndAnimation: true,
              pause: 2000,
      
              keyPress: false,
              controls: true,
              prevHtml: '',
              nextHtml: '',
      
              rtl:false,
              adaptiveHeight:false,
      
              vertical:false,
              verticalHeight:500,
              vThumbWidth:100,
      
              thumbItem:10,
              pager: true,
              gallery: false,
              galleryMargin: 5,
              thumbMargin: 5,
              currentPagerPosition: 'middle',
      
              enableTouch:true,
              enableDrag:true,
              freeMove:true,
              swipeThreshold: 40,
      
              responsive : [
                  {
                      breakpoint:1024,
                      settings: {
                          item:3,
                          slideMove:1,
                          slideMargin:6,
                        }
                  },
                  {
                      breakpoint:580,
                      settings: {
                          item:2,
                          slideMove:1
                        }
                  }
              ],
      
              onBeforeStart: function (el) {},
              onSliderLoad: function (el) {},
              onBeforeSlide: function (el) {},
              onAfterSlide: function (el) {},
              onBeforeNextSlide: function (el) {},
              onBeforePrevSlide: function (el) {}
          });
      });
      </script>
    </main>
<?php
    get_footer();