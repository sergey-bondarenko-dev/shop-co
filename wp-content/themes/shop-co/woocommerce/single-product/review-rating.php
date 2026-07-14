<?php
/**
 * The template to display the reviewers star rating in reviews
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $comment;

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

shop_co_template_rating( $rating, 'testimonial-card__rating', false );
