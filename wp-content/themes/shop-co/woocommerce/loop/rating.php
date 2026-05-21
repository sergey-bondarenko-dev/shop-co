<?php
/**
 * Loop Rating
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$average_rating = (float) $product->get_average_rating();

if ( $average_rating <= 0.0 && shop_co_use_demo_data() ) {
	$average_rating = (float) get_post_meta( $product->get_id(), '_demo_rating', true );
}

$average_rating = max( 0.0, min( 5.0, $average_rating ) );

shop_co_template_rating( $average_rating, 'site-product-card__rating' );
