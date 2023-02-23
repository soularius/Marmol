<?php
/**
 * Lost password confirmation text.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/lost-password-confirmation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.9.0
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
wc_print_notice( esc_html__( 'Password reset email has been sent.', 'woocommerce' ) );
?>

<?php do_action( 'woocommerce_before_lost_password_confirmation_message' ); ?>

<p><?php echo esc_html( apply_filters( 'woocommerce_lost_password_confirmation_message', esc_html__( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.', 'woocommerce' ) ) ); ?></p>

<?php do_action( 'woocommerce_after_lost_password_confirmation_message' ); ?>

</div>
</div>
