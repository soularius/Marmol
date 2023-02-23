<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

?>
<!DOCTYPE html>
	<html lang="es">
		<head>
			<meta charset="<?php bloginfo( 'charset' ); ?>" />
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<?php wp_head(); ?>
			<title><?php the_title();?></title>
				<link rel="preconnect" href="https://fonts.gstatic.com">
				<!--Css de bootstrap-->
		</head>
		<body id="page-struct" <?php body_class(); ?>>
			<?php if( get_field('activar_whatsapp_flotante','option') ): ?>
				<?php $whatsapp = get_field('whatsapp_flotante','option'); ?>
				<div style="position:fixed;bottom:95px;right:15px;z-index:9999;">
					<a href="<?php echo esc_url($whatsapp['url']); ?>" target="_blank">
						<img style="width:35px;height:35px;" src="https://inversionesmarmol.com/wp-content/uploads/2021/03/icon-wpp.png" alt="">
					</a>
				</div>
			<?php endif; ?>
			<?php wp_body_open(); ?>
		<!-- Nav Bar -->
			<header id="bar-nav" class="b-block bg-white"> 
				<nav id="nav-desktop" class="navbar navbar-light">
					<div class="col-lg-3 col-8">
						<div class="box-logo d-flex">
							<a href="/" class="navbar-brand d-flex">
								<img class="logo w-100" src="<?= get_field('logo_png', 'option'); ?>" srcset="<?= get_field('logo_svg', 'option'); ?>">
							</a>
						</div>
					</div>
					<div id="nav-list" class="box-list-menu col-lg-9 col-4 pl-md-0 pr-md-0">
					<?php
						$classLog = is_user_logged_in() ? 'user-login': '';
					?>
						<div class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between">
							<ul id="items" class="w-100 navbar-nav nav d-flex flex-nowrap flex-row justify-content-start justify-content-md-end <?php echo $classLog; ?>">
								<?php //menuPrincipal(); ?>
									<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
									<?php								
										if ( storefront_is_woocommerce_activated() && is_user_logged_in() ) {
												if ( is_cart() ) {
													$class = 'current-menu-item';
												} else {
													$class = '';
												}
											?>
											<ul id="site-header-cart" class="site-header-cart menu d-none d-lg-block">
												<li class="d-flex align-items-center justify-content-around <?php echo esc_attr( $class ); ?>">
													<?php storefront_cart_link(); ?>
													<i class="fa fa-shopping-cart" style="font-size:1.2rem;"></i>
												</li>
												<li class="dropdown-cart-mar" style="display:none;">
													<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
												</li>
											</ul>
										<?php
										}
									?>
							</ul>
							<div class="box-redes">
								<?php $rrss = get_field('rrss_twitter' , 'option');?>
								<a class="tw" href="<?=$rrss['url']['url']?>" target="_blank"><i class="<?=$rrss['icon_text']?>" aria-hidden="true"></i></a>
								<?php $rrss = get_field('rrss_facebook' , 'option')?>
								<a class="face" href="<?=$rrss['url']['url']?>" target="_blank"><i class="<?=$rrss['icon_text']?>" aria-hidden="true"></i></a>
								<?php $rrss = get_field('rrss_instagram', 'option')?>
								<a class="insta" href="<?=$rrss['url']['url']?>" target="_blank"><i class="<?=$rrss['icon_text']?>"></i></a>
							</div>
						</div>
					</div>
				</nav>
			</header>
			<?php
			$current_user = wp_get_current_user();
			if (user_can( $current_user, 'administrator' )) {
				?>
					<style>
						.logged-in #bar-nav {
							margin-top: 30px;
						}
					</style>
				<?php
			}
			if( is_woocommerce() && !is_user_logged_in() || is_page('carrito') && !is_user_logged_in() ){
				global $wp_query;
				$wp_query->set_404();
				status_header( 404 );
				get_template_part( 404 ); exit();
			}
			?>
<?php

function menuPrincipal()
{    
    $menu_name = 'Menu header';
	global $post;
	$thePostID = $post->ID;

    if (  wp_get_nav_menu_object($menu_name) ) {
        $menu = wp_get_nav_menu_object($menu_name);
    
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        foreach( $menu_items as $current ) {
			if($thePostID == $current->object_id){
        ?>		
				<li class="mr-3 nav-item item d-flex align-items-center">
					<a class="nav-link active" href="<?php echo $current->url; ?>"><?php echo $current->title; ?></a>
				</li>
        <?php
			}
			else{
		?>	
				<li class="mr-3 nav-item item d-flex align-items-center">
					<a class="nav-link" href="<?php echo $current->url; ?>"><?php echo $current->title; ?></a>
				</li>
		<?php
			}
        }
    } else {
        ?>
            <div id="item" class="col-12"></div>
        <?php
    }
    
}