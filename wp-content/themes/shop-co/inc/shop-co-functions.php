<?php
/**
 * General theme functions.
 *
 * @package Shop_Co
 */

/**
 * Return the selected product review order.
 *
 * @return string Review order, either newest or oldest.
 */
function shop_co_get_reviews_order(): string {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Read-only sorting preference.
	$order = isset( $_GET['reviews_order'] )
		? sanitize_key( wp_unslash( $_GET['reviews_order'] ) )
		: '';
	// phpcs:enable WordPress.Security.NonceVerification.Recommended

	if ( ! in_array( $order, array( 'newest', 'oldest' ), true ) ) {
		$order = get_option( 'comment_order' ) === 'asc' ? 'oldest' : 'newest';
	}

	return $order;
}
