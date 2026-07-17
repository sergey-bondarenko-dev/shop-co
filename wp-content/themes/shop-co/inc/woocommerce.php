<?php
/**
 * WooCommerce integration.
 *
 * @package Shop_Co
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register WooCommerce theme support.
 */
function shop_co_woocommerce_setup(): void {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 450,
			'single_image_width'    => 700,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 2,
				'max_rows'        => 6,
				'default_columns' => 4,
				'min_columns'     => 2,
				'max_columns'     => 5,
			),
		)
	);

	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
}
add_action( 'after_setup_theme', 'shop_co_woocommerce_setup' );

/**
 * Load WooCommerce cart fragments because the mini-cart is rendered in the header.
 */
function shop_co_enqueue_cart_fragments(): void {
	wp_enqueue_script( 'wc-add-to-cart' );
	wp_enqueue_script( 'wc-cart-fragments' );
}
add_action( 'wp_enqueue_scripts', 'shop_co_enqueue_cart_fragments', 20 );

/**
 * Return the header cart counter markup.
 */
function shop_co_get_header_cart_count_html(): string {
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

	return sprintf(
		'<span class="site-header-cart__count" aria-hidden="true">%s</span>',
		esc_html( (string) $count )
	);
}

/**
 * Refresh the header cart counter together with the native mini-cart fragment.
 *
 * @param array<string, string> $fragments Cart fragments.
 * @return array<string, string>
 */
function shop_co_add_header_cart_count_fragment( array $fragments ): array {
	$fragments['.site-header-cart__count'] = shop_co_get_header_cart_count_html();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'shop_co_add_header_cart_count_fragment' );
