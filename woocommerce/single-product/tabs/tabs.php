<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
?>
<div class="box-detail-product">

	<?php
		global $product;
		$id_user = get_current_user_id();
		$stores = get_field('tiendas', 'user_'.$id_user);
		$attributes = $product->get_attributes();
		$pa_color = $attributes["pa_color"];
		$pa_talla = $attributes["pa_talla"];
	 	 
		$pc_talla = wp_get_object_terms($product->get_id(), 'pa_talla', array('orderby' => 'menu_order', 'order' => 'ASC', 'fields' => 'all'));
		$pc_color = wp_get_object_terms($product->get_id(), 'pa_color', array('orderby' => 'menu_order', 'order' => 'ASC', 'fields' => 'all'));
		/* print_r($pa_talla['options'] );
		print_r($pc_talla ); */

		if(is_user_logged_in()){			
		?>
			<div id="list-color" class="mb-4">
				<div class="box-size d-flex flex-wrap was-validated align-items-center bg-gray-50">
					<div class="d-flex">
						<h3 class="h3 mb-0 title-table">Colores</h3>
					</div>
					<div class="d-flex box-colr flex-wrap">
						<?php
							if(!empty($pc_color)):
								foreach ($pc_color as $color) {
									echo '<div class="custom-control custom-checkbox">';							
									echo '<input type="checkbox" checked="checked" class="custom-control-input color-data" data-id="'.$color->term_id.'" id="color-'.$color->term_id.'-'.$product->get_id().'">';
									echo '<label class="custom-control-label" for="color-'.$color->term_id.'-'.$product->get_id().'">';
									echo $color->name.'</label>';
									echo '</div>';
								}
							else:
								echo "No hay colores registrados";
							endif;
						?>
					</div>
				</div>
				<div id="duplicate-qty" class="box-size flex-wrap was-validated align-items-center bg-gray-50 mt-4 d-none">
					<div class="d-flex flex-column col-lg-9 col-12">
						<h3 class="h3 mb-0 title-table">¿Desea Duplicar su orden anterior?</h3>
						<p><small>Esta acción duplicara las cantidades de su ultimo producto añadido a su carrito, las tallas que no coincidan sera omitidas</small></p>
					</div>
					<div class="d-flex flex-wrap col-lg-3 col-12">
							<a id="duplicate-qty-btn" class="btn-main text-center d-flex justify-content-center align-items-center" href="javascript:void(0)">Duplicar</a>
					</div>
				</div>
			</div>

			<div class="table-responsive">
				<?php
					if(!empty($pc_talla)):
				?>
						<div class="table-dat">
							<table class="table">
								<thead class="thead-dark">
									<tr>
										<th class="data-table" scope="col">
											<span class="title-table-size">Talla</span>
										</th>
										<th class="data-table" scope="col">Editar</th>
										<?php
											foreach ($pc_talla as $talla) {								
												echo '<th scope="col" class="data-table" data-id="'.$talla->term_id.'">'.$talla->name.'</th>';
											}
										?>
										<th class="data-table" scope="col">Total</th>
									</tr>
								</thead>
								<tbody>
										<?php
										
											if(!empty($stores)):
												$cant_storage = count($stores);
												$cant_talla = count($pc_talla);
												$saltosFila = 0;
												$saltosColumna = 0;
												$band = 1;
												foreach ($stores as $key => $store) {
													echo '<tr id="row-'.$key.'" class="data-row '.($band ? "original" : "copy").'" data-row="'.$key.'">';
														echo '<td data-id="'.$key.'" class="data-table" scope="row">'.$store["tienda"].'</td>';
														echo '<td data-id="'.$key.'" data-row="'.$saltosFila.'" class="data-check" scope="row">';														
															echo '<div class="custom-control custom-checkbox">
															'.($band ? "" : '<input type="checkbox" class="custom-control-input check-data" data-id="'.$key.'" id="check-'.$saltosFila.'">
															<label class="custom-control-label" for="check-'.$saltosFila.'">').'
															</div>
														</td>';
														foreach ($pc_talla as $id_tal => $talla) {
															echo '<td class="data-table">';										
																echo '<input type="number" '.($band ? "" : "disabled").' class="form-control cant-art" min="0" data-row="'.$saltosFila.'" data-col="'.$saltosColumna.'" data-space="'.$saltosFila.'-'.$saltosColumna.'" data-tienda="'.$key.'" data-talla="'.$talla->term_id.'" data-id="'.$key.'-'.$talla->term_id.'" value="0" id="'.$key.'-'.$talla->term_id.'-'.$product->get_id().'">';
															echo '</td>';
															$saltosColumna += 1;
															if($saltosColumna == $cant_talla){
																$saltosColumna = 0;
															}
														}
														$band = 0;
														echo '<td class="cant-for-store">';										
															echo '<span id="total-'.$saltosFila.'" data-tienda="'.$key.'" data-talla="'.$talla->term_id.'" data-id="'.$key.'-'.$talla->term_id.'" id="store-'.$key.'-'.$talla->term_id.'-'.$product->get_id().'">0</span>';
														echo '</td>';
														$saltosFila += 1 ;
													echo '</tr>';
												}
											endif;
										?>
								</tbody>
								<tfoot>
									<tr>
										<td>Total:</td>
										<td></td>
										<?php
											foreach ($pc_talla as $id_tal => $talla) {
												echo '<td class="cant-for-talla">';										
													echo '<span data-tienda="'.$id_tal.'" data-talla="'.$talla->term_id.'" data-id="'.$id_tal.'-'.$talla->term_id.'" id="total-size-'.$id_tal.'">0</span>';
												echo '</td>';
											}
											echo '<td class="total-global">';										
												echo '<span id="global-total">0</span>';
											echo '</td>';
										?>
									</tr>
								</tfoot>
							</table>
						</div>
				<?php
					else:
						echo "Producto sin tallas registradas";
					endif;
				?>
				
				<input id="cntStore" type="hidden" value="<?=count($stores)?>">
				<input id="cntTalla" type="hidden" value="<?=count($pc_talla)?>">
				<input id="bas-sub-price" type="hidden" value="<?= $product->get_regular_price() ?>">
				<input id="bas-price" type="hidden" value="<?= $product->get_price() ?>">
				<input id="product-id-rt" type="hidden" value="<?php echo esc_attr( $product->get_id() ); ?>">
			</div>
		<?php
		}
			
		add_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
		remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',8);
		remove_action('woocommerce_single_product_summary','detectClassInit',4);
		remove_action('woocommerce_single_product_summary','detectClassEnd',9);
		remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);
		remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
		remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);

		do_action( 'woocommerce_single_product_summary' );
	?>
</div>
<?php

/*
if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">
		<ul class="tabs wc-tabs" role="tablist">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
					<a href="#tab-<?php echo esc_attr( $key ); ?>">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
				<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				?>
			</div>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

<?php endif;*/ 



?>
