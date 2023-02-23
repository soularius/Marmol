<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>
<style>
.products{
	display:flex;
	flex-wrap:wrap;
	padding-left:0;
}
.product{
	width:33.33%;
	list-style:none;
	padding-right: 40px;
    padding-bottom: 40px;
}
.product img{
	width:100%;
	height:auto;
}
@media (max-width:1140px){
	.product{
		width:50%;
		padding-right:10px;
	}
	.product:nth-of-type(2n){
		padding-left:10px;
		padding-right:0;
	}
}
.sidebar-marmol{
	min-width:300px;
	padding-right: 30px;
}
li.cat-item{
	list-style:none;
}
.product-categories{
	padding-left:0;
}
.product-categories .children{
	padding-left:20px;
}
.product-categories a{
	font-size:15px;
}
.cat-parent{
	margin-top:15px;
}
.widget-title{
	text-transform: uppercase;
    font-size: 1.25rem;
}
.current-cat > a{
	font-weight:bold;
	text-decoration:underline;
}
.post-type-archive-product #bar-nav,
.tax-product_cat #bar-nav{
	box-shadow:inherit;
	border-bottom:1px solid rgba(0,0,0,0.5);
}
.price_slider{
	margin-bottom: 20px;
    margin-top: 20px;
    height: 3px;
    background: #000000;
    width: 100%;
    padding-right: 7px;
}
.ui-slider-handle{
    height: 18px;
    display: inline-block;
    background: #dc5045;
    position: relative;
    width: 4px !important;
    outline: 0px !important;
    top: -7px;
	cursor:pointer;
}
.ui-slider-handle:hover{
	width:6px!important;
}
.price_slider_amount{
	display:flex;
	flex-direction:column;
	align-items: start;
}
.price_slider_amount button{
	order:2;
}
.price_slider_amount div{
	order:1;
}
.price_label{
	margin-bottom:5px;
}
.widget{
	margin-bottom:30px;
}
.widget button{
	padding:6px 25px;
}
.widget button:hover{
	background-color:white;
}
.site-main ul.products.columns-3 li.product .woocommerce-loop-product__title{
	font-size:1.2rem;
	margin-top:20px;
}
.add_to_cart_button{
	display:none;
}
.woocommerce-Price-amount,
.onsale{
	color: #939393;
}
</style>
<div class="container-fluid pl-0 pr-0 pl-lg-5 mt-5 pt-5 mb-5">
<?php
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<div class="d-flex flex-column flex-lg-row">
<!--<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>-->
<div class="sidebar-marmol d-none d-lg-block">
	<div id="eliminar-filtros" class="btn-link-see d-none">
		<a href="/tienda" class="btn-a btn-e mb-4" style="border:1px solid black;max-width:250px;">Eliminar filtros</a>
	</div>
	<script>
		var url = location.pathname;
		var busqueda = location.search;
		if( url != '/tienda/' || busqueda != '' ){
			jQuery('#eliminar-filtros').removeClass('d-none');
		}
	</script>
	<?php
	dynamic_sidebar( 'sidebar-marmol-custom' );
	?>
</div>
<div class="w-100">
<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	//do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();
	
	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	//do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}
?>
</div>
<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
?>
</div>
<?php
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */

do_action( 'woocommerce_sidebar' );
?>
</div>
<?php
get_footer( 'shop' );
