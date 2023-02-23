<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

?>	<?php if( get_field('activar_formulario','option') && !is_user_logged_in() || get_field('activar_formulario','option') && is_front_page() || get_field('activar_formulario','option') && is_page('paquete-completo') || get_field('activar_formulario','option') && is_page('muelles') || get_field('activar_formulario','option') && is_page('dotaciones-empresariales') ): ?>
    <section id="contacto">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="box-section-contact">
              <div class="box-contact d-flex flex-wrap">
                <div class="col-12">
                  <h1 class="h1 title-sc-6"><?php the_field('contacto_titulo','option') ?></h1>
                </div>
                <div class="col-12">
                  <h1 class="h2 sub-title-sc-6"><?php the_field('contacto_subtitulo','option') ?></h1>
                </div>
                <div>
                  <?php
                    $shortcode_contact = get_field('shortcode_de_contact_form','option');
                    echo do_shortcode( $shortcode_contact ); 
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <footer id="footer-main">
      <div class="container-fluid">
        <div class="row flex-column">
          <section id="footer-info" class="pt-lg-0 pb-lg-0 pt-5 pb-5" style="background-image:url('<?php echo get_field('imagen_de_fondo', 'option')['url']; ?>');">
            <div class="container-form-info d-flex flex-wrap">
              <div id="column-1" class="col-md-6 col-lg-3 d-flex justify-content-center align-items-center flex-column">
                <div class="box-logo-footer">
                  <img src="<?=get_field('logo_png_foo', 'option')?>" srcset="<?=get_field('logo_svg_foo', 'option')?>">
                </div>
              </div>
              <div id="column-2" class="col-md-6 col-lg-3 d-flex justify-content-center align-items-center flex-column border-left border-right border-white mt-md-0 mt-5">
                <div class="box-nav-footer">
                  <ul class="list-group list-group-flush">
                    <?php menuFooter(); ?>
                  </ul>
                </div>
              </div>
              <div id="column-3" class="col-md-6 col-lg-6 d-flex justify-content-center align-items-start flex-column m-lg-0 mt-4">
                <div id="box-column" class="d-flex justify-content-center align-items-start flex-column">
                  <div class="media d-flex mb-4">
                    <div class="media-icon">
                      <img src="<?=get_field('icon_direction', 'option')?>" class="align-self-center" alt="...">
                    </div>
					<?php
						$url = get_field('direction', 'option');
					?>
                    <div class="media-body">                    
                      <a href="<?=$url['url']?>" class="btn mb-0 text-white"><?=$url['title']?></a>
                    </div>
                  </div>
                  <div class="media d-flex align-items-center mb-4">
                    <div class="media-icon">
                      <img src="<?=get_field('icon_tlf', 'option')?>" class="align-self-center" alt="...">
                    </div>
                    <div class="media-body d-flex align-items-center flex-wrap">
                      <div class="box-url-telf d-flex flex-column flex-wrap">
						<?php
							$url = get_field('celular', 'option');
						?>
                        <a href="<?=$url['url']?>" class="btn mb-0 text-white">Celular: <?=$url['title']?></a>
						<?php
							$url = get_field('telephone', 'option');
						?>
                        <a href="<?=$url['url']?>" class="btn mb-0 text-white">Fijo: <?=$url['title']?></a>
                      </div>
                      <div class="box-url-wpp d-flex align-items-center flex-wrap">
            <?php
							$url = get_field('whatsapp', 'option');
              if($url):
						?>
                        <span class="logo-footer-wpp mr-2"><img src="<?=get_field('icon_wpp', 'option')?>"></span>
                        <a href="<?=$url['url']?>" class="btn mb-0 text-white">
                          <span><?=$url['title']?></span>
                        </a>
              <?php endif; ?>
                      </div>
                    </div>
                  </div>
                  <div class="media d-flex mb-4 flex-wrap">
                    <div class="media-icon">
                      <img src="<?=get_field('icon_email', 'option')?>" class="align-self-center" alt="...">
                    </div>
                    <div class="media-body">
						<?php
							$url = get_field('email', 'option');
						?>
                      <a href="mailto:ventas@inversionesmarmol.com.co" class="btn mb-0 text-white">ventas@inversionesmarmol.com.co</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section id="footer-copy" class="footer-copy d-flex justify-content-center align-items-center">
            <div class="container">
              <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center p-3">
                  <span class="copyryght text-center">Diseñado y desarrollado por B-The Click 2021 ©</span>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>

    </footer>

<?php wp_footer(); ?>

</body>
</html>

<?php

function menuFooter()
{    
    $menu_name = 'Menu Footer';
	global $post;
	$thePostID = $post->ID;

    if (  wp_get_nav_menu_object($menu_name) ) {
        $menu = wp_get_nav_menu_object($menu_name);
    
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        foreach( $menu_items as $current ) {
        ?>		
			<li class="list-group-item bg-transparent pt-2 pb-2 pl-5 pr-1 position-relative ">
					<a href="<?= $current->url ?>" class="url-footer text-white btn text-left p-0 d-flex w-100">
					<?=$current->title?>
					</a>
			</li>
		<?php
        }
    } else {
        ?>
            <div id="item" class="col-12"></div>
        <?php
    }
    
}