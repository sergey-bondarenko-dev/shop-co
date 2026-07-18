<?php
/**
 * Top-selling products section.
 *
 * @package Shop_Co
 */

if ( ! shop_co_is_woocommerce_active() || ! function_exists( 'shop_co_get_top_selling_products' ) ) {
	shop_co_admin_notice_section( __( 'Activate WooCommerce to show top-selling products.', 'shop-co' ), 'activate_plugins' );
	return;
}

$shop_co_products = shop_co_get_top_selling_products( 4 );

if ( empty( $shop_co_products ) ) {
	shop_co_admin_notice_section( __( 'No top-selling products are available yet.', 'shop-co' ), 'edit_products' );
	return;
}

shop_co_get_template_part(
	'products/section-with-slider',
	array(
		'title'    => __( 'top selling', 'shop-co' ),
		'products' => $shop_co_products,
	)
);
