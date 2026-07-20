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

/**
 * Get the requested custom catalog collection.
 */
function shop_co_get_current_catalog_collection(): string {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only public catalog filter.
	$collection = isset( $_GET['collection'] ) ? sanitize_key( wp_unslash( $_GET['collection'] ) ) : '';

	return in_array( $collection, array( 'sale', 'new-arrivals' ), true ) ? $collection : '';
}

/**
 * Filter the main product catalog by the requested collection.
 *
 * @param WP_Query $query Main catalog query.
 */
function shop_co_filter_catalog_by_collection( WP_Query $query ): void {
	$collection = shop_co_get_current_catalog_collection();

	if ( 'sale' === $collection ) {
		$query->set(
			'post__in',
			array_merge( array( 0 ), wc_get_product_ids_on_sale() )
		);
		return;
	}

	if ( 'new-arrivals' !== $collection ) {
		return;
	}

	$cutoff = getdate( shop_co_get_new_arrivals_cutoff_timestamp() );
	$query->set(
		'date_query',
		array(
			array(
				'after'     => array(
					'year'  => $cutoff['year'],
					'month' => $cutoff['mon'],
					'day'   => $cutoff['mday'],
				),
				'inclusive' => true,
			),
		)
	);
	$query->set( 'orderby', 'date' );
	$query->set( 'order', 'DESC' );
}
add_action( 'woocommerce_product_query', 'shop_co_filter_catalog_by_collection' );

/**
 * Use a collection-specific heading on the shop archive.
 *
 * @param string $title Default WooCommerce archive title.
 */
function shop_co_catalog_collection_page_title( string $title ): string {
	if ( ! is_shop() ) {
		return $title;
	}

	$collection = shop_co_get_current_catalog_collection();

	if ( 'sale' === $collection ) {
		return __( 'Sale', 'shop-co' );
	}

	if ( 'new-arrivals' === $collection ) {
		return __( 'New arrivals', 'shop-co' );
	}

	return $title;
}
add_filter( 'woocommerce_page_title', 'shop_co_catalog_collection_page_title' );
