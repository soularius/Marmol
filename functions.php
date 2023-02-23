<?php //Etiqueta PHP de inicio

// Funcion a nuestro gusto que queramos incluir
    function favicon_link() {
        echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />' . "\n";
    }
    add_action( 'wp_head', 'favicon_link' );

    
/* 
add_action('woocommerce_new_order', 'checkout_js_ajax' );

function checkout_js_ajax(){
	echo 'ORder new yeah';
	?>
    <script type="text/javascript">    
		console.log('End shop');
    </script>
    <?php
} */

//Insertar Javascript js y enviar ruta admin-ajax.php

add_action('wp_enqueue_scripts', 'add_ajax_script');

function add_ajax_script(){
    if(!is_user_logged_in())
        return;
    wp_register_script('ajax_js_order',get_stylesheet_directory_uri(). '/assets/js/ajax-file.js', array('jquery'), '1', true );
    wp_register_script('script_js_order',get_stylesheet_directory_uri(). '/assets/js/script-file.js', array('jquery'), '1', true );
    wp_enqueue_script('script_js_order');
    wp_enqueue_style( 'style_css_order', get_stylesheet_directory_uri(). '/assets/css/style.css');
    wp_enqueue_style( 'style_css_boostrap', get_stylesheet_directory_uri(). '/assets/css/bootstrap.min.css');

    if (is_page( 9 )){
        wp_enqueue_script('ajax_js_order');
        wp_localize_script('ajax_js_order','ajax_params',['ajax_url'=>admin_url('admin-ajax.php')]);        
    }

    if (is_page( 8 )){
        wp_register_script('script_js_cart',get_stylesheet_directory_uri(). '/assets/js/script-cart.js', array('jquery'), '1', true );
        wp_enqueue_script('script_js_cart');
        wp_localize_script('script_js_cart','cart_params',['cart_url'=>admin_url('admin-ajax.php')]);
    }    
    wp_enqueue_style( 'style_css_single_product', get_stylesheet_directory_uri(). '/assets/css/single-products.css');
}

// Data here ajax

add_action('woocommerce_thankyou', 'checkout_js_ajax' );

function checkout_js_ajax($order_id){
    if(!is_user_logged_in())
        return;
    wp_enqueue_script('ajax_js_order');
    wp_localize_script('ajax_js_order','ajax_params',['ajax_url'=>admin_url('admin-ajax.php')]);
	wp_localize_script('ajax_js_order','order',['order_id'=>$order_id]);
}

add_action('woocommerce_checkout_update_order_meta', 'ajax_register_order_data_custom' );

function ajax_register_order_data_custom($order_id){
    if(!is_user_logged_in())
        wc_add_notice( __( 'User not login.' ), 'error' );

    if( have_rows('order', $order_id) )
    {
        return;
    }

    if ( ! $_POST['product_json'] )
        wc_add_notice( __( 'Error Data product.' ), 'error' );

    $attr = $_POST['product_json'];


    for($i = 0; $i<count($attr); $i++){
        //$attr[$i] = json_decode(str_replace("\\", "",$attr[$i]));
        //print_r(json_decode($attr[$i]));
    }



    $color_id = array();
    $band = 0;
    $id_store = 0;
    $sub_size_cant = array();
    $sub_row = array();

    for($i = 0; $i<count($attr); $i++)
    {
        $vowels = array("\\");
        $attr[$i] = str_replace($vowels, "",$attr[$i]);
        $attr[$i] = substr($attr[$i], 0, -1);
        $attr[$i] = substr($attr[$i], 1);
        $attr[$i] = json_decode($attr[$i]);


        $sub_row = array();
        $color_id = array();
        $cont = 0;

        foreach($attr[$i]->talla as $talla){
            $cont++;
            if($id_store != $talla->store && $band){
                $sub_store = array(
                    'tienda' => $id_store,
                    'talla__cantidad' => $sub_size_cant
                );
                $sub_row[] = $sub_store;
                $sub_size_cant = array();
                $id_store = $talla->store;

                $detail = array(
                    'talla' => $talla->talla,
                    'cantidad' => $talla->cant
                );
                $sub_size_cant[] = $detail;
            }
            else{
                $id_store = $talla->store;
                $band = 1;
                $detail = array(
                    'talla' => $talla->talla,
                    'cantidad' => $talla->cant
                );
                $sub_size_cant[] = $detail;
            }
            //array_push($talla_id, $talla["talla"]);
            if(count($attr[$i]->talla) == $cont)
            {
                $sub_store = array(
                    'tienda' => $id_store,
                    'talla__cantidad' => $sub_size_cant
                );
                $sub_row[] = $sub_store;
                $sub_size_cant = array();
                $id_store = $talla->store;
                $band = 0;
            }
        }

        foreach($attr[$i]->color as $color){
            //array_push($color_id, $color["id"]);
            $color_id[] = $color->color;
        }

        $row = array(
            'producto' => intval($attr[$i]->product),
            'detalle' => $sub_row,
            'color' => $color_id
        );
        add_row('order', $row, $order_id);
    }
}

add_action('wp_ajax_ajax_register_order_data_custom_345645645', 'ajax_register_order_data_custom_345645645');
add_action('wp_ajax_nopriv_ajax_register_order_data_custom_345645645', 'ajax_register_order_data_custom_345645645');


// Aplica un precio especial dependiento del tipo de usuario
add_filter( 'woocommerce_product_get_price', 'aplica_precio_especial', 10, 2);
function aplica_precio_especial( $price, $product ) {
    
    if (!is_user_logged_in()) return $price;

    $id_user = get_current_user_id();
    $discount = 0;

    if(get_field('descuento_para_usuario', 'user_'.$id_user)){
        $discount = get_field('descuento_para_usuario', 'user_'.$id_user);
    }
    else{
        $discount = 0;
        return $price;
    }
    if ( $price ):
        $price = (float) $price - ($price * ($discount/ 100) );
    endif;


    return $price;
}

add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );

function my_custom_checkout_field( $checkout ) {

    global $woocommerce;
    $items = $woocommerce->cart->get_cart();

    foreach($items as $item => $values) { 
        //$_product =  wc_get_product( $values['data']->get_id());

        woocommerce_form_field( 'product_json[]', array(
            'type'          => 'hidden',
            'class'         => array('product_json form-row-wide'),
            'id'            => 'p-'.$values['data']->get_id()
            ), $checkout->get_value( 'product_json[]' ));
    } 

    /*print_r($items);
    echo '<div id="my_custom_checkout_field"><h2>' . __('My Field') . '</h2>';

    woocommerce_form_field( 'my_field_name', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Fill in this field'),
        'placeholder'   => __('Enter something'),
        ), $checkout->get_value( 'my_field_name' ));

    echo '</div>';*/

}
add_action( 'woocommerce_admin_order_data_after_order_details', 'item_simplify_custom_user', 10, 0 );
function item_simplify_custom_user( ){
    //echo 'HOLA';
}

// add the action 
add_action( 'woocommerce_admin_order_actions_start', 'action_woocommerce_admin_order_actions_start', 10, 1 ); 
function action_woocommerce_admin_order_actions_start( $the_order ) { 
    // make action magic happen here... 
    //echo 'BYE';
}; 
         

// add the action 
add_action( 'woocommerce_admin_order_data_after_order_details', 'action_woocommerce_admin_order_items_after_refunds', 10, 1 ); 
// define the woocommerce_admin_order_items_after_refunds callback 
function action_woocommerce_admin_order_items_after_refunds( $order ) {
    ?>
    <a id="dow-order" style="margin-top:15px;display: inline-block;" href="javascript:void(0)">Descargar Pedido</a>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
        document.getElementById("dow-order").addEventListener("click", function() {
            var data = {
                'action': 'my_action',
                'id_order': <?= $order->id ?>
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                if(response!="0"){
                    var win = window.open(response, '_blank');
                    win.focus();
                }
            });
        });
	});
	</script> <?php

}; 

add_action( 'wp_ajax_my_action', 'my_action' );

function my_action() {
	global $wpdb; // this is how you get access to the database

	$id_order = intval( $_POST['id_order'] );
    $order = wc_get_order($id_order);
    $order_items = $order->get_items();
    $order_id = $order->get_id();    
    
    $header_file = "NÚMERO PEDIDO,REFERENCIA,CANTIDAD,PRECIO (IVA INCLUIDO),TALLA";

	$pa_talla = get_terms( array(
		'taxonomy' => 'pa_talla',
		'hide_empty' => false
	) );

    
	$pa_color = get_terms( array(
		'taxonomy' => 'pa_color',
		'hide_empty' => false
	) );

    $count = 1;
    foreach($pa_color as $color)
    {
        $header_file.=",COLOR ".$count;
        $count++;
    }

    $row_order = "";
    //$item->get_quantity();
    foreach ( $order_items as $item_id => $item ) {
        $product = $item->get_product();

        $order_custom_products = get_field( 'order', $order_id );
        $data_product = [];

        foreach($order_custom_products as $id_custom_product => $custom_products)
        {
            if($custom_products['producto'] == $product->get_id())
            {
                $data_product = $custom_products;
                break;
            }
        }

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
            if($cant){
                $row_order.=$id_order.",".$product->get_sku().",".$cant.",".$product->get_price().",".$item_talla->name;

                $list_order = get_field("order", $order_id);
                $color_arr = array();
                for($i = 0; $i < count($list_order); $i++){
                    if($list_order[$i]['producto'] == $product->get_id()){
                        for($j = 0; $j < count($list_order[$i]['color']); $j++){
                            $color_arr[] = $list_order[$i]['color'][$j];
                        }
                        foreach ($pa_color as $color) {
                            if(in_array($color->term_id, $color_arr)){
                                $row_order.=",".$color->name;
                            }
                        }
                        $row_order.="\n";
                    }
                }
            }
        }
        
    }

    $file = fopen(TEMPLATEPATH." child/order-file/order-".$id_order.".csv","w");
      if( $file == false ) {
        echo 0;
      }
      else
      {
          // Escribir en el archivo:
           fwrite($file, $header_file."\n");
           fwrite($file, $row_order);
          // Fuerza a que se escriban los datos pendientes en el buffer:
           fflush($file);
           echo get_stylesheet_directory_uri()."/order-file/order-".$id_order.".csv";
      }

	wp_die(); // this is required to terminate immediately and return a proper response
}
    

         
// add the action 
add_action( 'woocommerce_admin_order_items_after_line_items', 'action_woocommerce_admin_order_items_after_line_items', 10, 1 ); 
// define the woocommerce_admin_order_items_after_line_items callback 
function action_woocommerce_admin_order_items_after_line_items( $order_get_id ) { 
    // make action magic happen here... 
    //echo "ORDER";
    //global $post;
    // The Order ID
    $order_id = $order_get_id;
    $order = wc_get_order($order_get_id);

	$pa_talla = get_terms( array(
		'taxonomy' => 'pa_talla',
		'hide_empty' => false
	) );
	?>
    <tr id="table-resumen" class="item ">
        <td colspan="8" data-sort="string-ins">
            <table id="table-custom-resumen" class="td woocommerce-table woocommerce-table--order-details shop_table order_details woocommerce_order_items" style="width: 100%;margin-bottom: 30px;">

                <thead>
                    <tr>
                        <th class="td woocommerce-table__product-name product-name"><?php esc_html_e( 'Producto / Talla', 'woocommerce' ); ?></th>

                        <?php
                            foreach ( $pa_talla as $id_talla => $item_talla ) {
                                echo '<th id="s-'.$item_talla->term_id.'" class="td woocommerce-table__product-name product-name">'.$item_talla->name.'</th>';
                            }
                        ?>

                        <th class="td woocommerce-table__product-table product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
                        <th class="td woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
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
                            $data_product = [];

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
        </td>
    </tr>
    <script> 
        jQuery(function() {
            jQuery( "#table-custom-resumen" ).prependTo( jQuery(".wc-order-items-editable") );
            jQuery( ".wc-order-totals-items #table-custom-resumen" ).remove();
            jQuery( "#table-resumen" ).remove();
        });
    </script>
    <?php
}; 

add_action( 'woocommerce_admin_order_item_headers', 'item_order_admin_header_custom_table', 10, 0 );
function item_order_admin_header_custom_table(){
    echo '<th class="item sortable" colspan="2" data-sort="string-ins">Resumen</th>';
}

add_action( 'woocommerce_admin_order_item_values', 'item_order_admin_custom_table', 10, 3 );
function item_order_admin_custom_table( $_product, $item, $item_id ){
    global $post;
    // The Order ID
    $order_id = $post->ID;
    $order = wc_get_order($order_id);
    $product = $_product;
    ?>
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
			<table class="woocommerce_order_items">
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
			<table class="table woocommerce_order_items">
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
    <?php
}


add_filter( 'woocommerce_checkout_fields' , 'default_values_checkout_fields' );
 
function default_values_checkout_fields( $fields ) {
    unset($fields['billing']['billing_first_name']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
    unset($fields['order']['order_comments']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_city']);
    unset($fields['additional_information'] );
    return $fields;
}

add_filter('woocommerce_enable_order_notes_field', '__return_false');

function marmol_scripts() {

	/** Esto es lo que necesito llevarme */
	wp_enqueue_style( 'twenty-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css', array(), '4.6.0' );
	wp_enqueue_style( 'twenty-main', get_stylesheet_directory_uri() . '/css/main.css', array(), '1.0.0' );
	wp_enqueue_style( 'twenty-icon', get_stylesheet_directory_uri() . '/css/icofont/icofont.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'twenty-icon-fontawesome', get_stylesheet_directory_uri() . '/css/font-awesome/css/font-awesome.min.css', array(), '1.0.0' );

	wp_enqueue_script( 'bootstra-script', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'app-script', get_stylesheet_directory_uri() . '/js/app.js', array( 'jquery' ) );

	if(is_page( 264 )){
		wp_enqueue_style( 'twenty-paquete_completo', get_stylesheet_directory_uri() . '/css/paquete_completo.css', array(), '1.0.0' );
	}
	if(is_page( 167 )){
		wp_enqueue_style( 'twenty-dotaciones_empresariales_2', get_stylesheet_directory_uri() . '/css/dotaciones_empresariales.css', array(), '1.0.0' );
	}
	if(is_page( 351 )){
		wp_enqueue_style( 'twenty-dotaciones_muelles', get_stylesheet_directory_uri() . '/css/muelles.css', array(), '1.0.0' );
	}
}
add_action( 'wp_enqueue_scripts', 'marmol_scripts' );

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Opciones generales el tema',
		'menu_title'	=> 'Opciones Marmol',
		'menu_slug' 	=> 'opciones-generales',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

    acf_add_options_sub_page(array(
		'page_title' 	=> 'Opciones del Header',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'opciones-generales',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Opciones del Footer',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'opciones-generales',
	));
	
}

function wc_custom_user_redirect( $redirect, $user ) {
    // Get the first of all the roles assigned to the user
    $role = $user->roles[0];
    $dashboard = admin_url();
    $myaccount = get_permalink( wc_get_page_id( 'shop' ) );
    $home = get_site_url();
    if( $role == 'administrator' ) {
      //Redirect administrators to the dashboard
      $redirect = $myaccount;
    } elseif ( $role == 'shop-manager' ) {
      //Redirect shop managers to the dashboard
      $redirect = $myaccount;
    } elseif ( $role == 'editor' ) {
      //Redirect editors to the dashboard
      $redirect = $myaccount;
    } elseif ( $role == 'author' ) {
      //Redirect authors to the dashboard
      $redirect = $myaccount;
    } elseif ( $role == 'customer' || $role == 'subscriber' ) {
      //Redirect customers and subscribers to the "My Account" page
      $redirect = $myaccount;
    } else {
      //Redirect any other role to the previous visited page or, if not available, to the home
      $redirect = wp_get_referer() ? wp_get_referer() : home_url();
    }
    return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 );

add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'storefront-icons' );
    wp_deregister_style('storefront-icons');
    wp_dequeue_style( 'storefront-style' );
    wp_deregister_style('storefront-style');
}, 11);

add_filter('login_errors','login_error_message');

function login_error_message($error){
    //check if that's the error you are looking for
    $pos = strpos($error, 'incorrect');
    if (is_int($pos)) {
        //its the right error so you can overwrite it
        $error = "ERROR: Usuario o contraseña no correcta.</a>";
    }
    return $error;
}

add_action( 'widgets_init', 'themename_widgets_init' );
function themename_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Marmol Tienda', 'storefront' ),
        'id'            => 'sidebar-marmol-custom',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}

// Desactivar anchos de imágenes en temas con soporte para WooCommerce.
add_action( 'after_setup_theme', 'ap_modify_theme_support', 11 );
function ap_modify_theme_support() {
    $theme_support = get_theme_support( 'woocommerce' );
    $theme_support = is_array( $theme_support ) ? $theme_support[0] : array();
    unset( $theme_support['single_image_width'], $theme_support['thumbnail_image_width'] );
    remove_theme_support( 'woocommerce' );
    add_theme_support( 'woocommerce', $theme_support );
}

add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url() {
	if ( isset( $_GET['add-to-cart'] ) ) {
		WC()->cart->empty_cart();
	}
}

/** Clear cart */
add_filter( 'woocommerce_persistent_cart_enabled', '__return_false' );

/*Add JS library */
function add_js_library() {
   
    wp_enqueue_style( 'slider', get_stylesheet_directory_uri() . '/library/lightslider/css/lightslider.css', array());
   
    wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/library/lightslider/js/lightslider.js', array());
   
}
add_action( 'wp_enqueue_scripts', 'add_js_library' );

/*Inicio - Nuevo orden personalizado*/
// Filters
add_filter( 'woocommerce_get_catalog_ordering_args',     'custom_woocommerce_get_catalog_ordering_args' );
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );

// Apply custom args to main query
function custom_woocommerce_get_catalog_ordering_args( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean(     $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

    if ( 'oldest_to_recent' == $orderby_value ) {
        $args['orderby'] = 'menu_order';
        //$args['order'] = 'DESC';
    }

    return $args;
}

/* Create new sorting method */
function custom_woocommerce_catalog_orderby( $sortby ) {    
    $sortby['oldest_to_recent'] = 
     __( 'Sólo orden personalizado ', 'woocommerce' );
    return $sortby;
}
/*Fin - Nuevo orden personalizado*/
