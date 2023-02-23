<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;
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
</style>
<section id="section-1" style="background-image:url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>');">    
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 col-lg-6 col-xl-4 col-banner-text bg-black-transparent d-flex flex-column">
			<div class="box-title-banner w-100 d-flex">
				<h1 class="title-banner text-white d-flex  flex-column">
				<span class="size-1"><?=get_field('titulo') ?></span>
				<span class="size-2"><?=get_field('subtitulo') ?></span>
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
<div class="container mt-5 pt-5">
	<div class="d-flex flex-column align-items-center ml-auto mr-auto" style="max-width:400px;">
<?php
do_action( 'woocommerce_before_lost_password_form' );
?>

<form method="post" class="woocommerce-ResetPassword lost_reset_password">

	<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
		<label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?></label>
		<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
	</p>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_lostpassword_form' ); ?>

	<p class="woocommerce-form-row form-row">
		<input type="hidden" name="wc_reset_password" value="true" />
		<div class="btn-link-see">
			<button type="submit" class="woocommerce-Button button btn-a btn-e" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
		</div>
	</p>

	<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

</form>
<?php
do_action( 'woocommerce_after_lost_password_form' );
?>
	</div>
</div>

