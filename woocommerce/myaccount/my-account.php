<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
/**
 * My Account navigation.
 *
 * @since 2.6.0
 */

?>

<style>
	.entry-header{
		display:none;
	}
	label,
	input,
	.password-input{
		display:block;
		width:100%;
	}
	input{
		height:40px;
	}
	.woocommerce-form__input-checkbox{
		width: 12px;
		display:inline-block;
		margin-right:5px;
		height:inherit;
	}
	.btn-e{
		border:none;
	}
	.btn-e:hover{
		border:1px solid #444;
	}
	.woocommerce-MyAccount-content p:nth-of-type(2){
		display:none;
	}
	.woocommerce-message{
		margin-bottom:30px;
	}
</style>
<section id="section-1" style="background-image:url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>');">    
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 col-lg-6 col-xl-4 col-banner-text bg-black-transparent d-flex flex-column">
			<div class="box-title-banner w-100 d-flex">
				<h1 class="title-banner text-white d-flex  flex-column">
				<span class="size-1"><?=get_field('titulo_2') ?></span>
				<span class="size-2"><?=get_field('subtitulo_2') ?></span>
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
<div id="account-marmol" class="container mt-5 pt-5">
	<div class="d-flex">
		<div class="mc-account">
			<?php wp_nav_menu( array( 'theme_location' => 'max_mega_menu_1' ) ); ?>
		</div>
		<div class="d-flex flex-column align-items-center ml-auto mr-auto" style="max-width:400px;">
			<?php
			//do_action( 'woocommerce_account_navigation' ); ?>

			<div class="woocommerce-MyAccount-content">
				<?php
					/**
					 * My Account content.
					 *
					 * @since 2.6.0
					 */
					do_action( 'woocommerce_account_content' );
				?>
			</div>
		</div>
	</div>
</div>
