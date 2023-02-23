<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.6.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<section class="woocommerce-order-details">
	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

	<h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Order details', 'woocommerce' ); ?></h2>

	<?php
	$pa_talla = get_terms( array(
		'taxonomy' => 'pa_talla',
		'hide_empty' => false
	) );
	?>
	<table style="width: 100%;" class="woocommerce-table woocommerce-table--order-details shop_table order_details">

		<thead>
			<tr>
				<th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Producto / Talla', 'woocommerce' ); ?></th>

				<?php
					foreach ( $pa_talla as $id_talla => $item_talla ) {
						echo '<th id="s-'.$item_talla->term_id.'" class="woocommerce-table__product-name product-name">'.$item_talla->name.'</th>';
					}
				?>

				<th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
				<th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			do_action( 'woocommerce_order_details_before_order_table_items', $order );

			foreach ( $order_items as $item_id => $item ) {

				$product = $item->get_product();

				/*wc_get_template(
					'order/order-details-item.php',
					array(
						'order'              => $order,
						'item_id'            => $item_id,
						'item'               => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'      => $product ? $product->get_purchase_note() : '',
						'product'            => $product,
					)
				);*/
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
							$qty_display = '<del>' . esc_html( $qty ) . '</del> unidades <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
						} else {
							$qty_display = esc_html( $qty );
						}

						echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $qty_display ) . '</strong>' . ' unidades', $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

						do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

						wc_display_item_meta( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

						do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
						?>
					</td>
					<?php
					$order_custom_products = get_field( 'order', $order_id );
					$data_product;

					foreach($order_custom_products as $id_custom_product => $custom_products)
					{
						if($custom_products['producto'] == $product->get_id())
						{
							$data_product = $custom_products;
							break;
						}
					}
					/*
					echo '<th>';
					print_r($data_product);
					echo '<th>';*/

					foreach ( $pa_talla as $id_talla => $item_talla ){
						$cant = 0;
						foreach($data_product["detalle"] as $item_cant => $tallas)
						{
							//print_r($tallas["talla__cantidad"]);
							foreach($tallas["talla__cantidad"] as $it => $talla_c)
							{
								if($talla_c["talla"] == $item_talla->term_id){
									$cant += intval($talla_c["cantidad"]);
								}
							}
						}
						if(!$cant)
						{
							echo '<td class="cant-size">N/A</td>';
						}
						else
						{
							echo '<td class="cant-size">'.$cant.'</td>';
						}
					}
					
					?>

					<td class="subprice"><?= wc_price( wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) ) ); ?></td>
					<td class="woocommerce-table__product-total product-total"><?= $order->get_formatted_line_subtotal( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						<!-- <th><?php print_r($order_custom_product); ?></th> -->
				</tr>
			
			<?php
			}
			do_action( 'woocommerce_order_details_after_order_table_items', $order );
			?>
		</tbody>

		<tfoot>
			<tr>
				<td style="text-align:left;"><span><strong>Total:</strong></span></td>
				<?php
				$cant_arr = [];
				foreach ( $pa_talla as $id_talla => $item_talla ){
					$cant_arr[] = 0;
				}
				foreach ( $order_items as $item_id => $item ) {

					$product = $item->get_product();
					$cont = 0;
					$data_product;

					foreach($order_custom_products as $id_custom_product => $custom_products)
					{
						if($custom_products['producto'] == $product->get_id())
						{
							$data_product = $custom_products;
							break;
						}
					}
					foreach ( $pa_talla as $id_talla => $item_talla ){
						foreach($data_product["detalle"] as $item_cant => $tallas)
						{
							//print_r($tallas["talla__cantidad"]);
							foreach($tallas["talla__cantidad"] as $it => $talla_c)
							{
								if($talla_c["talla"] == $item_talla->term_id){
									$cant_arr[$cont] += intval($talla_c["cantidad"]);
								}
							}
						}
						$cont ++;
					}					
				}


				foreach ( $cant_arr as $id_cant_talla => $cant_talla )
				{
					if(!$cant_talla)
					{
						echo '<td class="cant-size">N/A</td>';
					}
					else
					{
						echo '<td class="cant-size">'.$cant_talla.'</td>';
					}
				}
				//print_r($cant_arr);
				?>
				<td class="vacio"></td>

				<td class="total"><?= wc_price($order->get_total()); ?></td>
			</tr>
		</tfoot>
	</table>
	<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

		<thead>
			<tr>
				<th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php
			do_action( 'woocommerce_order_details_before_order_table_items', $order );

			foreach ( $order_items as $item_id => $item ) {
				$product = $item->get_product();
				wc_get_template(
					'order/order-details-item.php',
					array(
						'order'              => $order,
						'item_id'            => $item_id,
						'item'               => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'      => $product ? $product->get_purchase_note() : '',
						'product'            => $product,
					)
				);
			}

			do_action( 'woocommerce_order_details_after_order_table_items', $order );
			?>
		</tbody>

		<tfoot>
			<?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
				?>
					<tr>
						<th scope="row"><?php echo esc_html( $total['label'] ); ?></th>
						<td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
					</tr>
					<?php
			}
			?>
			<?php if ( $order->get_customer_note() ) : ?>
				<tr>
					<th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
					<td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
				</tr>
			<?php endif; ?>
		</tfoot>
	</table>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
</section>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action( 'woocommerce_after_order_details', $order );

if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
