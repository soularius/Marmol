<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
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
do_action( 'woocommerce_before_reset_password_form' );
?>

<form method="post" class="woocommerce-ResetPassword lost_reset_password">

	<p><?php echo apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
		<label for="password_1"><?php esc_html_e( 'New password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" />
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
		<label for="password_2"><?php esc_html_e( 'Re-enter new password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" />
	</p>

	<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
	<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

	<div class="clear"></div>

	<?php do_action( 'woocommerce_resetpassword_form' ); ?>

	<p class="woocommerce-form-row form-row">
		<input type="hidden" name="wc_reset_password" value="true" />
		<div class="btn-link-see">
			<button type="submit" class="woocommerce-Button button btn-a btn-e" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>"><?php esc_html_e( 'Save', 'woocommerce' ); ?></button>
		</div>
	</p>

	<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

</form>
<?php
do_action( 'woocommerce_after_reset_password_form' );
?>
</div>
</div>

