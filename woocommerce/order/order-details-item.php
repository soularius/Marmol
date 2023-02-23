<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
?>
<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ); ?>">

	<td class="woocommerce-table__product-name product-name" data-id="<?=$product->get_id()?>">
		<?php
		$is_visible        = $product && $product->is_visible();
		$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );

		echo apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$qty          = $item->get_quantity();
		$refunded_qty = $order->get_qty_refunded_for_item( $item_id );

		if ( $refunded_qty ) {
			$qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
		} else {
			$qty_display = esc_html( $qty );
		}

		echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $qty_display ) . '</strong> unidades', $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

		wc_display_item_meta( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
		?>
	</td>

	<td class="woocommerce-table__product-total product-total">
		<?php echo $order->get_formatted_line_subtotal( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</td>
	<td colspan="2">
		<?php
			$list_order = get_field("order", $order->get_id());

			$attributes = $product->get_attributes();
			$product_id = $product->get_id();
			$pa_color = $attributes["pa_color"];
			$pa_talla = $attributes["pa_talla"];
			$color_arr = array();
			$store_arr = array();
			$detail_arr = array();
			for($i = 0; $i < count($list_order); $i++){
				if($list_order[$i]['producto'] == $product->get_id()){
					for($j = 0; $j < count($list_order[$i]['color']); $j++){
						$color_arr[] = $list_order[$i]['color'][$j];
					}
					for($j = 0; $j < count($list_order[$i]['detalle']); $j++){
						$store_arr[] = $list_order[$i]['detalle'][$j]['tienda'];
						$detail_arr[] = $list_order[$i]['detalle'][$j]['talla__cantidad'];
					}
				}
			}
			
		?>
			<table>
				<tbody>
					<?php
						echo '<tr>';
						foreach ($pa_color["options"] as $color) {
							echo '<td class="custom-control custom-checkbox">';
								echo '<input type="checkbox" '.(in_array($color, $color_arr) ? "checked" : "").' disabled class="custom-control-input color-data color-'.$color.'-'.$product_id.'" data-id="'.$color.'" id="color-'.$color.'-'.$product_id.'">';
								echo '<label class="custom-control-label" for="color-'.$color.'-'.$product_id.'">'.get_term( $color )->name.'</label>';
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
							foreach ($pa_talla["options"] as $id_tal => $talla) {								
								echo '<th scope="col" class="data-table" data-id="'.$talla.'">'.get_term( $talla )->name.'</th>';
								$arr_size[] = 0;
							}
						?>
						<th class="data-table" scope="col">Total</th>
					</tr>
				</thead>
				<tbody>
						<?php
							$id_user = get_current_user_id();
							$stores = get_field('tiendas', 'user_'.$id_user);
							$cant_storage = count($stores);
							$cant_talla = count($pa_talla["options"]);
							$saltosFila = 0;
							$saltosColumna = 0;
							$band = 1;
							//$arr_size = array();
							$total = 0;
							
							foreach ($stores as $key => $store) {
								echo '<tr id="row-'.$key.'" class="data-row '.($band ? "original" : "copy").'" data-row="'.$key.'">';
									echo '<td data-id="'.$key.'" class="data-table" scope="row">'.$store["tienda"].'</td>';
									$pos = 0;
									$pos_des = 0;
									$acum = 0;
									foreach ($pa_talla["options"] as $id_tal => $talla) {
										echo '<td class="data-table" style="text-align:center;">';
											$pos = array_search($key, $store_arr);
											if(!is_bool($pos)){
												$pos_des = array_search($talla, array_column($detail_arr[$pos], 'talla'));

												if($detail_arr[$pos][$pos_des]['talla'] == $talla){
													echo '<span class="form-control cant-art '.$key.'-'.$talla.'-'.$product_id.'" data-tienda="'.$key.'" data-talla="'.$talla.'" data-id="'.$key.'-'.$talla.'" id="'.$key.'-'.$talla.'-'.$product_id.'">'.$detail_arr[$pos][$pos_des]['cantidad'].'</span>';
													$acum += $detail_arr[$pos][$pos_des]['cantidad'];
													$arr_size[$id_tal]  += $detail_arr[$pos][$pos_des]['cantidad'];
													$total += $detail_arr[$pos][$pos_des]['cantidad'];
												}
												else{
													echo '<span class="form-control cant-art '.$key.'-'.$talla.'-'.$product_id.'" data-tienda="'.$key.'" data-talla="'.$talla.'" data-id="'.$key.'-'.$talla.'" id="'.$key.'-'.$talla.'-'.$product_id.'">0</span>';
												}
											}
											else{
												echo '<span class="form-control cant-art '.$key.'-'.$talla.'-'.$product_id.'" data-tienda="'.$key.'" data-talla="'.$talla.'" data-id="'.$key.'-'.$talla.'" id="'.$key.'-'.$talla.'-'.$product_id.'">0</span>';
											}										
										echo '</td>';
										$saltosColumna += 1;
										if($saltosColumna == $cant_talla){
											$saltosColumna = 0;
										}
									}
									$band = 0;
									echo '<td class="cant-for-store" style="text-align:center;">';										
										echo '<span class="total-'.$saltosFila.'" data-tienda="'.$key.'" >'.$acum.'</span>';
									echo '</td>';
									$saltosFila += 1 ;
								echo '</tr>';
							}
						?>
				</tbody>
				<tfoot>
					<tr>
						<td style="text-align:center;"><span><strong>Total:</strong></span></td>
						<?php
							foreach ($pa_talla["options"] as $id_tal => $talla) {
								echo '<td class="cant-for-talla" style="text-align:center;">';	
									if($arr_size[$id_tal])									
										echo '<span data-tienda="'.$id_tal.'" data-talla="'.$talla.'" data-id="'.$id_tal.'-'.$talla.'" class="total-size-'.$id_tal.'">'.$arr_size[$id_tal].'</span>';
									else
										echo '<span data-tienda="'.$id_tal.'" data-talla="'.$talla.'" data-id="'.$id_tal.'-'.$talla.'" class="total-size-'.$id_tal.'">0</span>';
								echo '</td>';
							}
							echo '<td class="total-global" style="text-align:center;">';										
								echo '<span class="global-total">'.$total.'</span>';
							echo '</td>';
						?>
					</tr>
				</tfoot>
			</table>
	</td>
</tr>
<?php if ( $show_purchase_note && $purchase_note ) : ?>

<tr class="woocommerce-table__product-purchase-note product-purchase-note">

	<td colspan="2"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>

</tr>

<?php endif; ?>
