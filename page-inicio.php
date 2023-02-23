<?php
    get_header();
?>
 <main id="page-struct">
      <!-- Section banner -->
    <section id="section-1" style="background-image:url('<?=get_field('background_banner')?>')">    
        <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-banner-text bg-black-transparent d-flex flex-column">
                <div class="box-title-banner w-100 d-flex">
                  <h1 class="title-banner text-white d-flex  flex-column">
                    <span class="size-1"><?=get_field('title_big') ?></span>
                    <span class="size-2"><?=get_field('title_small_inicio') ?></span>
                  </h1>
                </div>
                <div class="box-btn-banner">
                <?php 
                    $see_more = get_field('see_more');
                ?>
                    <a href="<?=$see_more['url']?>"><?=$see_more['title']?></a>
                </div>
              </div>
              <div class="col-md-6 d-none d-md-block">

              </div>
            </div>
        </div>
        <section id="shadown-bann"></section>
    </section>
      <section id="banner-text">  
        <div class="container ">
          <div class="row justify-content-center">
              <h2 class="h2 text-h2-dat">
                <span class="text-1-section-2"><?=get_field('title_bit_part_1') ?> 
                <span class="number-text-1-section-2"><?=get_field('years_in_productions') ?>
                </span> <?=get_field('title_bit_part_2') ?></span>
                <span class="text-2-section-2"><?=get_field('title_small_section_2') ?></span>
              </h2>
          </div>
        </div>
      </section>
    <section id="banner-qs" style="background-image: url('<?=get_field('background_banner_column') ?>');">
        <div class="container">
          <div class="row">
            <div id="repart" class="position-absolute">
              <div class="box-transparent"></div>
              <div class="box-white"></div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="container-logo">
                <div class="box-img-logo">
                  <img class="img-logo-banner" src="<?=get_field('img_decoration_section_column_png') ?>" srcset="<?=get_field('img_decoration_section_column_svg') ?>">
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="box-text d-flex flex-column">
                <h1 class="title-text"><?=get_field('title_section_banner') ?></h1>
                <div class="parraf-int">
                  <p class="parraf-data">
                    <?=get_field('text_big_section_column') ?>
                  </p>
                </div>
                <div class="parraf-ext mt-4">
                  <p>
                    <?=get_field('text_small_section_column') ?>
                  </p>
                </div>
                <div class="btn-link-see">
                    <?php
                        $see_more_btn = get_field('see_more_section_column');
                    ?>
                    <?php if($see_more_btn): ?>
                    <a class="btn" href="<?=$see_more_btn['url']?>"><?=$see_more_btn['title']?></a>
                    <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
    <section id="section-2">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h1 class="text-title-sc-2 pb-2 text-black font-weight-light border-bottom border-dark border-2">
                <?=get_field('title_big_section_2')?>
              </h1>
            </div>
            <div class="col-12">
              <div class="card-group-flex">
                <div class="card text-center mt-2 mb-2 border-0 col-xl-3 col-md-6 col-sm-6 col-12 mr-0 ml-0">
                  <?php 
                    $card_1 = get_field('card_section_2_1');
                  ?>
                  <div class="card-header border-0">
                    <h2 class="text-card-header">
                      <span class="card-text-style-1"><?= $card_1['title_black_section_2']?></span>
                      <span class="card-text-style-2"><?= $card_1['title_gray_section_2']?></span>
                    </h2>
                  </div>
                  <div class="card-body p-0 border-0">
                    <img src="<?= $card_1['image_card_section_2']?>" class="card-img-top" alt="...">
                  </div>
                  <div class="card-footer border-0">
                    <div class="btn-link-see">
                      <a class="btn-a btn-e" href="<?= $card_1['see_more_section_2']['url']?>">
                        <?= $card_1['see_more_section_2']['title']?>
                        <span class="linea-left-hover-btn"></span>
                        <span class="linea-right-hover-btn"></span>
                        <span class="linea-top-hover-btn"></span>
                        <span class="linea-bottom-hover-btn"></span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card text-center mt-2 mb-2 border-0 col-xl-3 col-md-6 col-sm-6 col-12 mr-0 ml-0">
                  <?php 
                    $card_2 = get_field('card_section_2_2');
                  ?>
                  <div class="card-header border-0">
                    <h2 class="text-card-header">
                      <span class="card-text-style-1"><?= $card_2['title_black_section_2']?></span>
                      <span class="card-text-style-2"><?= $card_2['title_gray_section_2']?></span>
                    </h2>
                  </div>
                  <div class="card-body p-0 border-0">
                    <img src="<?= $card_2['image_card_section_2']?>" class="card-img-top" alt="...">
                  </div>
                  <div class="card-footer border-0">
                    <div class="btn-link-see">
                      <a class="btn-a btn-e" href="<?= $card_2['see_more_section_2']['url']?>">
                        <?= $card_2['see_more_section_2']['title']?>
                        <span class="linea-left-hover-btn"></span>
                        <span class="linea-right-hover-btn"></span>
                        <span class="linea-top-hover-btn"></span>
                        <span class="linea-bottom-hover-btn"></span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card text-center mt-2 mb-2 border-0 col-xl-3 col-md-6 col-sm-6 col-12 mr-0 ml-0">
                  <?php 
                    $card_3 = get_field('card_section_2_3');
                  ?>
                  <div class="card-header border-0">
                    <h2 class="text-card-header">
                      <span class="card-text-style-1"><?= $card_3['title_black_section_2']?></span>
                      <span class="card-text-style-2"><?= $card_3['title_gray_section_2']?></span>
                    </h2>
                  </div>
                  <div class="card-body p-0 border-0">
                    <img src="<?= $card_3['image_card_section_2']?>" class="card-img-top" alt="...">
                  </div>
                  <div class="card-footer border-0">
                    <div class="btn-link-see">
                      <a class="btn-a btn-e" href="<?= $card_3['see_more_section_2']['url']?>">
                          <?= $card_3['see_more_section_2']['title']?>
                          <span class="linea-left-hover-btn"></span>
                          <span class="linea-right-hover-btn"></span>
                          <span class="linea-top-hover-btn"></span>
                          <span class="linea-bottom-hover-btn"></span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card text-center mt-2 mb-2 border-0 col-xl-3 col-md-6 col-sm-6 col-12 mr-0 ml-0">
                  <?php 
                    $card_4 = get_field('card_section_2_4');
                  ?>  
                  <div class="card-header border-0">
                    <h2 class="text-card-header">
                      <span class="card-text-style-1"><?= $card_4['title_black_section_2']?></span>
                      <span class="card-text-style-2"><?= $card_4['title_gray_section_2']?></span>
                    </h2>
                  </div>
                  <div class="card-body p-0 border-0">
                    <img src="<?= $card_4['image_card_section_2']?>" class="card-img-top" alt="...">
                  </div>
                  <div class="card-footer border-0">
                    <div class="btn-link-see">
                      <a class="btn-a btn-e" href="<?= $card_4['see_more_section_2']['url']?>">
                          <?= $card_4['see_more_section_2']['title']?>
                          <span class="linea-left-hover-btn"></span>
                          <span class="linea-right-hover-btn"></span>
                          <span class="linea-top-hover-btn"></span>
                          <span class="linea-bottom-hover-btn"></span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
     </section>
    <section id="section-3" >
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h1 class="text-title-sc-3 pb-2 text-black font-weight-light border-bottom border-dark border-2">
              <?=get_field('title_big_section_3')?>
            </h1>
          </div>
          <div class="col-12">
            <div class="card-group-flex">
              <div class="card text-center mt-2 mb-2 border-0 col-xl-3 col-md-6 col-sm-6 col-12 mr-0 ml-0">
                <?php 
                  $card_1 = get_field('card_section_3_1');
                ?>
                <div class="card-header border-0 bg-transparent">
                  <img src="<?= $card_1['image_section_3']?>" class="card-img-top" alt="...">
                </div>
                <div class="card-body">
                  <p class="card-text">
                      <?= $card_1['texto_section_3']?>
                  </p>
                </div>
              </div>
              <div class="card text-center mt-2 mb-2 border-0 col-xl-3 col-md-6 col-sm-6 col-12 mr-0 ml-0">
                <?php 
                  $card_2 = get_field('card_section_3_2');
                ?>
                <div class="card-header border-0 bg-transparent">
                  <img src="<?= $card_2['image_section_3']?>" class="card-img-top" alt="...">
                </div>
                <div class="card-body">
                  <p class="card-text">
                    <?= $card_2['texto_section_3']?>
                  </p>
                </div>
              </div>
              <div class="card text-center mt-2 mb-2 border-0 col-xl-3 col-md-6 col-sm-6 col-12 mr-0 ml-0">
                <?php 
                  $card_3 = get_field('card_section_3_3');
                ?>
                <div class="card-header border-0 bg-transparent">
                  <img src="<?= $card_3['image_section_3']?>" class="card-img-top" alt="...">
                </div>
                <div class="card-body">
                  <p class="card-text">
                    <?= $card_3['texto_section_3']?>
                  </p>
                </div>
              </div>
              <div class="card text-center mt-2 mb-2 border-0 col-xl-3 col-md-6 col-sm-6 col-12 mr-0 ml-0">
                <?php 
                  $card_4 = get_field('card_section_3_4');
                ?>
                <div class="card-header border-0 bg-transparent">
                  <img src="<?= $card_4['image_section_3']?>" class="card-img-top" alt="...">
                </div>
                <div class="card-body">
                  <p class="card-text">
                    <?= $card_4['texto_section_3']?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="section-4">
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
              
              <!--<a href="<?=$see_more['url'] ?>" class="btn-sc-4 btn rounded-0">
                <span class="text-white"><?=$see_more['title']?></span>
                <span class="icon-wpp ml-2"><img src="<?=get_field('icon_whatsaap')?>"></span>
              </a>-->
                  <div class="box-btn-s3">
                  <?php if( get_field('activar_whatsapp_flotante','option') ): ?>
                    <?php $whatsapp = get_field('whatsapp_flotante','option'); ?>
                    <a class="btn-e btn-s3" href="<?php echo esc_url($whatsapp['url']); ?>" target="_blank" >
                          <ul class="list-inline mt-3">
                            <li class="list-inline-item mr-4">Contáctanos</li>
                            <li class="list-inline-item"><img src="https://inversionesmarmol.com/wp-content/uploads/2021/03/Whatsaap.png" alt=""></li>
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