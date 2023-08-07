<?php
add_action( 'woocommerce_add_to_cart', 'misha_if_product_in_cart', 10, 6);

function misha_if_product_in_cart() {
	$giftCardID = 25;
	if( in_array( $giftCardID, array_column( WC()->cart->get_cart(), 'product_id' ) ) ) {
		foreach( WC()->cart->get_cart() as $item_key => $cart_item ){
            if($cart_item['product_id'] != 25) {
                WC()->cart->remove_cart_item( $item_key );
            }
		}
	}
}

add_filter( 'woocommerce_add_to_cart_validation', 'check_and_limit_cart_items', 10, 3 );
function check_and_limit_cart_items ( $passed, $product_id, $quantity ){
    // HERE set your product category (can be term IDs, slugs or names)
    $giftCardID = 25;

    // We exit if the cart is empty
    if( WC()->cart->is_empty() )
        return $passed;

    // CHECK CART ITEMS: search for items from product category
    if( in_array( $giftCardID, array_column( WC()->cart->get_cart(), 'product_id' ) ) ) {
            // Display an warning message
            wc_add_notice( __('A Gift Card is added in the cart (Other items are not allowed in cart).', 'woocommerce' ), 'error' );
            // Avoid add to cart
            return false;
	}
    return $passed;
}

add_filter( 'wc_add_to_cart_message_html', 'quadlayers_custom_add_to_cart_message' );
function quadlayers_custom_add_to_cart_message($message) {
	$giftCardID = 25;
	
	if(sizeof( WC()->cart->get_cart() ) > 0 && in_array( $giftCardID, array_column( WC()->cart->get_cart(), 'product_id' ) )){
   		$message = __('A Gift Card is added in the cart (Other items are not allowed in the cart).', 'woocommerce' ) ;
	}
   return $message;
}