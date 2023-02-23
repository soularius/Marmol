<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$text_align = is_rtl() ? 'right' : 'left';

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<h2>
	<?php
	if ( $sent_to_admin ) {
		$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
		$after  = '</a>';
	} else {
		$before = '';
		$after  = '';
	}
	/* translators: %s: Order ID. */
	echo wp_kses_post( $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
	?>
</h2>

<div style="margin-bottom: 40px;">
	<?php
	$pa_talla = get_terms( array(
		'taxonomy' => 'pa_talla',
		'hide_empty' => false
	) );
	?>
	<table style="width: 100%;" class="td woocommerce-table woocommerce-table--order-details shop_table order_details">

		<thead>
			<tr>
				<th class="td woocommerce-table__product-name product-name"><?php esc_html_e( 'Producto / Talla', 'woocommerce' ); ?></th>

				<?php
					foreach ( $pa_talla as $id_talla => $item_talla ) {
						echo '<th id="s-'.$item_talla->term_id.'" class="td woocommerce-table__product-name product-name">'.$item_talla->name.'</th>';
					}
				?>

				<th class="td woocommerce-table__product-table product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
				<th class="yd woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<?php
		$order_items = $order->get_items();
		$order_id = $order->get_id();
		?>
		<tbody>
			<?php
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

					<td class="td woocommerce-table__product-name product-name" data-id="<?=$product->get_id()?>">
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

						echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $qty_display ) . '</strong>', $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

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
							echo '<td class="td cant-size">N/A</td>';
						}
						else
						{
							echo '<td class="td cant-size">'.$cant.'</td>';
						}
					}
					
					?>

					<td class="td subprice"><?= wc_price( wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) ) ); ?></td>
					<td class="td woocommerce-table__product-total product-total"><?= $order->get_formatted_line_subtotal( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						<!-- <th><?php print_r($order_custom_product); ?></th> -->
				</tr>
			
			<?php
			}
			?>
		</tbody>

		<tfoot>
			<tr>
				<td  class="td" style="text-align:left;"><span><strong>Total:</strong></span></td>
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
						echo '<td class="td cant-size">N/A</td>';
					}
					else
					{
						echo '<td class="td cant-size">'.$cant_talla.'</td>';
					}
				}
				//print_r($cant_arr);
				?>
				<td class="td vacio"></td>

				<td class="td total"><?= wc_price($order->get_total()); ?></td>
			</tr>
		</tfoot>
	</table>
	
	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
		<thead>
			<tr>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$order,
				array(
					'show_sku'      => $sent_to_admin,
					'show_image'    => false,
					'image_size'    => array( 32, 32 ),
					'plain_text'    => $plain_text,
					'sent_to_admin' => $sent_to_admin,
				)
			);
			?>
		</tbody>
		<tfoot>
			<?php
			$item_totals = $order->get_order_item_totals();

			if ( $item_totals ) {
				$i = 0;
				foreach ( $item_totals as $key => $total ) {
					$i++;
					if($key != 'payment_method')
					{
						?>
						<tr>
							<th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post( $total['label'] ); ?></th>
							<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post( $total['value'] ); ?></td>
						</tr>
						<?php
					}
				}
			}
			if ( $order->get_customer_note() ) {
				?>
				<tr>
					<th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
					<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
				</tr>
				<?php
			}
			?>
		</tfoot>
	</table>
</div>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
