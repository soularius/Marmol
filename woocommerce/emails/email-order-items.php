<?php
/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$text_align  = is_rtl() ? 'right' : 'left';
$margin_side = is_rtl() ? 'left' : 'right';

foreach ( $items as $item_id => $item ) :
	$product       = $item->get_product();
	$sku           = '';
	$purchase_note = '';
	$image         = '';

	if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		continue;
	}

	if ( is_object( $product ) ) {
		$sku           = $product->get_sku();
		$purchase_note = $product->get_purchase_note();
		$image         = $product->get_image( $image_size );
	}

	?>
	<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
		<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word;">
		<?php

		// Show title/image etc.
		if ( $show_image ) {
			echo wp_kses_post( apply_filters( 'woocommerce_order_item_thumbnail', $image, $item ) );
		}

		// Product name.
		echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );

		// SKU.
		if ( $show_sku && $sku ) {
			echo wp_kses_post( ' (#' . $sku . ')' );
		}

		// allow other plugins to add additional product information here.
		do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text );

		wc_display_item_meta(
			$item,
			array(
				'label_before' => '<strong class="wc-item-meta-label" style="float: ' . esc_attr( $text_align ) . '; margin-' . esc_attr( $margin_side ) . ': .25em; clear: both">',
			)
		);

		// allow other plugins to add additional product information here.
		do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text );

		?>
		</td>
		<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
			<?php
			$qty          = $item->get_quantity();
			$refunded_qty = $order->get_qty_refunded_for_item( $item_id );

			if ( $refunded_qty ) {
				$qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
			} else {
				$qty_display = esc_html( $qty );
			}
			echo wp_kses_post( apply_filters( 'woocommerce_email_order_item_quantity', $qty_display, $item ) );
			?>
		</td>
		<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
			<?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
		</td>
	</tr>
	<tr>
		<td class="td" colspan="3">
			<?php
				$list_order = get_field("order", $order->get_id());

				$attributes = $product->get_attributes();
				$pa_color = $attributes["pa_color"];
				$pa_talla = $attributes["pa_talla"];
				$color_arr = array();
				$store_arr = array();
				$detail_arr = array();
				$product_id = $product->get_id();
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
			<table class="td">
				<tbody>
					<?php
						echo '<tr>';
						foreach ($pa_color["options"] as $color) {
							if(in_array($color, $color_arr)){
								echo '<td class="td custom-control custom-checkbox">';								
									echo '<label class="custom-control-label" for="color-'.$color.'-'.$product_id.'">'.get_term( $color )->name.'</label>';
								echo '</td>';
							}
						}
						echo '</tr>';
					?>

				</tbody>
			</table>
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th class="data-table td" scope="col">
							Tienda / Talla
						</th>
						
						<?php
							foreach ($pa_talla["options"] as $id_tal => $talla) {								
								echo '<th scope="col" class="td data-table" data-id="'.$talla.'">'.get_term( $talla )->name.'</th>';
								$arr_size[$id_tal] = 0;
							}
						?>
						<th class="data-table td" scope="col">Total</th>
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
							$arr_size = array();
							$total = 0;
							
							foreach ($stores as $key => $store) {
								echo '<tr id="row-'.$key.'" class="data-row '.($band ? "original" : "copy").'" data-row="'.$key.'">';
									echo '<td data-id="'.$key.'" class="data-table td" scope="row">'.$store["tienda"].'</td>';
									$pos = 0;
									$pos_des = 0;
									$acum = 0;
									foreach ($pa_talla["options"] as $id_tal => $talla) {
										echo '<td class="data-table td" style="text-align:center;">';
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
									echo '<td class="cant-for-store td" style="text-align:center;">';										
										echo '<span class="total-'.$saltosFila.'" data-tienda="'.$key.'" >'.$acum.'</span>';
									echo '</td>';
									$saltosFila += 1 ;
								echo '</tr>';
							}
						?>
				</tbody>
				<tfoot>
					<tr>
						<td class="td" style="text-align:center;"><span><strong>Total:</strong></span></td>
						<?php
							foreach ($pa_talla["options"] as $id_tal => $talla) {
								echo '<td class="cant-for-talla td" style="text-align:center;">';	
									if($arr_size[$id_tal])									
										echo '<span data-tienda="'.$id_tal.'" data-talla="'.$talla.'" data-id="'.$id_tal.'-'.$talla.'" class="total-size-'.$id_tal.'">'.$arr_size[$id_tal].'</span>';
									else
										echo '<span data-tienda="'.$id_tal.'" data-talla="'.$talla.'" data-id="'.$id_tal.'-'.$talla.'" class="total-size-'.$id_tal.'">0</span>';
								echo '</td>';
							}
							echo '<td class="total-global td" style="text-align:center;">';										
								echo '<span class="global-total">'.$total.'</span>';
							echo '</td>';
						?>
					</tr>
				</tfoot>
			</table>
		</td>
	</tr>
	<?php

	if ( $show_purchase_note && $purchase_note ) {
		?>
		<tr>
			<td colspan="3" class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
				<?php
				echo wp_kses_post( wpautop( do_shortcode( $purchase_note ) ) );
				?>
			</td>
		</tr>
		<?php
	}
	?>

<?php endforeach; ?>
