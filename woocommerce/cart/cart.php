<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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

defined( 'ABSPATH' ) || exit;
?>
<style>
	.entry-title{
		display:none;
	}
	.woocommerce-cart #bar-nav{
		box-shadow: inherit;
    	border-bottom: 1px solid rgba(0,0,0,0.5);
	}
	.woocommerce-cart img{
		width: 70px;
    	height: auto;
	}
	.shop_table thead tr {
		background-color: #F8F8F8;
	}
	.shop_table thead tr th {
		color: #666666;
		font-weight: 400;
		padding: 24px 0 15px 0;
	}
	.shop_table thead tr th:nth-of-type(1),
	.shop_table thead tr th:nth-of-type(2),
	.shop_table thead tr th:nth-of-type(6) {
		text-align: center;
	}
	.shop_table .collapsible{
		text-align:center;
	}
	.shop_table td.product-thumbnail {
		padding: 5px 0;
	}
	.shop_table .product-remove a{
		display:flex;
		align-items:center;
		justify-content:center;
		background-color:black;
		color:white;
		width:20px;
		height:20px;
		margin:auto;
		border-radius:100px;
		text-decoration:none;
	}
	.shop_table .product-remove a:hover{
		opacity:0.7;
	}
</style>
<div class="container mt-5 pt-5 mb-5 pb-5">
<?php
do_action( 'woocommerce_before_cart' ); ?>

<form id="<?php (is_user_logged_in() ? "loggin_user" : "loggin_out") ?>" class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove"><?php esc_html_e( 'Borrar', 'woocommerce' ); ?></th>
				<th class=""><?php esc_html_e( 'Editar', 'woocommerce' ); ?></th>
				<th class="product-thumbnail">&nbsp;</th>
				<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php			
			$id_user = get_current_user_id();
			$stores = get_field('tiendas', 'user_'.$id_user);
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr  id="product-<?=$product_id?>" class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
						</td>

						
						<td class="collapsible">
							<span class="td-arrow" data-idtab="p-<?=$product_id?>">
								<span class="arrow">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10.024 4h6.015l7.961 8-7.961 8h-6.015l7.961-8-7.961-8zm-10.024 16h6.015l7.961-8-7.961-8h-6.015l7.961 8-7.961 8z"/></svg>
								</span>
							</span>
						</td>

						<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo $thumbnail; // PHPCS: XSS ok.
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
						}
						?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
						}
						?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
						} else {
							$product_quantity = woocommerce_quantity_input(
								array(
									'input_name'   => "cart[{$cart_item_key}][qty]",
									'input_value'  => $cart_item['quantity'],
									'max_value'    => $_product->get_max_purchase_quantity(),
									'min_value'    => '0',
									'product_name' => $_product->get_name(),
								),
								$_product,
								false
							);
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>
					</tr>
					<?php 
						$attributes = $_product->get_attributes();
						$pa_color = $attributes["pa_color"];
						$pa_talla = $attributes["pa_talla"];
						
						$pc_talla = wp_get_object_terms($_product->get_id(), 'pa_talla', array('orderby' => 'menu_order', 'order' => 'ASC', 'fields' => 'all'));
						$pc_color = wp_get_object_terms($_product->get_id(), 'pa_color', array('orderby' => 'menu_order', 'order' => 'ASC', 'fields' => 'all'));
					?>
					<?php 
					
					if ( is_user_logged_in() )
					{ ?>
						<tr id="p-<?=$product_id?>" data-id="<?=$product_id?>" class="product-tab" style="display: none;">
							<td colspan="7" class="content">
								<table>
									<tbody>
										<?php
											echo '<tr>';
											foreach ($pc_color as $colors) {
												echo '<td class="custom-control custom-checkbox">';
													echo '<input type="checkbox" class="custom-control-input color-data color-'.$colors->term_id.'-'.$product_id.'" data-id="'.$colors->term_id.'" id="color-'.$colors->term_id.'-'.$product_id.'">';
													echo '<label class="custom-control-label" for="color-'.$colors->term_id.'-'.$product_id.'">'.$colors->name.'</label>';
												echo '</td>';
											}
											echo '</tr>';
										?>

									</tbody>
								</table>
								<table class="table">
									<thead class="thead-dark">
										<tr>
											<th class="data-table" scope="col">
												Tienda / Talla
											</th>
											
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
												$cant_storage = count($stores);
												$cant_talla = count($pc_talla);
												$saltosFila = 0;
												$saltosColumna = 0;
												$band = 1;
												foreach ($stores as $key => $store) {
													echo '<tr id="row-'.$key.'" class="data-row '.($band ? "original" : "copy").'" data-row="'.$key.'">';
														echo '<td data-id="'.$key.'" class="data-table" scope="row">'.$store["tienda"].'</td>';
														foreach ($pc_talla as $id_tal => $talla) {
															echo '<td class="data-table">';										
																echo '<input type="number" class="form-control cant-art '.$key.'-'.$talla->term_id.'-'.$product_id.'" min="0" data-tienda="'.$key.'" data-talla="'.$talla->term_id.'" data-id="'.$key.'-'.$talla->term_id.'" value="0" id="'.$key.'-'.$talla->term_id.'-'.$product_id.'">';
															echo '</td>';
															$saltosColumna += 1;
															if($saltosColumna == $cant_talla){
																$saltosColumna = 0;
															}
														}
														$band = 0;
														echo '<td class="cant-for-store">';										
															echo '<span class="total-'.$saltosFila.'" data-tienda="'.$key.'" >0</span>';
														echo '</td>';
														$saltosFila += 1 ;
													echo '</tr>';
												}
											?>
									</tbody>
									<tfoot>
										<tr>
											<td><span><br>Total:</br></span></td>
											<?php
												foreach ($pc_talla as $id_tal => $talla) {
													echo '<td class="cant-for-talla">';										
														echo '<span data-tienda="'.$id_tal.'" data-talla="'.$talla->term_id.'" data-id="'.$id_tal.'-'.$talla->term_id.'" class="total-size-'.$id_tal.'">0</span>';
													echo '</td>';
												}
												echo '<td class="total-global">';										
													echo '<span class="global-total">0</span>';
												echo '</td>';
											?>
										</tr>
									</tfoot>
								</table>							
								<table class="table">
									<thead class="thead-dark">
										<tr>
											<th class="box-edit-detail" scope="col">
												<span id="edit-detail-<?=$product_id?>" class="edit-detail" data-id="<?=$product_id?>" style="display: none;">Editar</span>
												<span id="save-detail-<?=$product_id?>" class="save-detail" data-id="<?=$product_id?>" >Actualizar</span>
												<!-- <span id="cancel-detail-<?=$product_id?>" class="cancel-detail" data-id="<?=$product_id?>" style="display: none;" >Cancelar</span> -->
												
												<input id="product-id-<?=$product_id?>" type="hidden" value="<?php echo esc_attr( $product_id ); ?>">
												<input class="cntStore" type="hidden" value="<?=count($stores)?>">
												<input class="cntTalla" type="hidden" value="<?=count($pc_talla)?>">
												<input class="bas-sub-price" type="hidden" value="<?= $_product->get_regular_price() ?>">
												<input class="bas-price" type="hidden" value="<?= $_product->get_price() ?>">
											</th>
										</tr>
									</thead>
								</table>
							</td>
						</tr>
					<?php
					}
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
</div>
