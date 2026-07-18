<?php
/**
 * Testimonial public functions.
 *
 * @package Shop_Co_Core
 */

/**
 * Get testimonial posts.
 *
 * @param int $limit Maximum number of testimonials.
 * @return WP_Query Testimonial query.
 */
function shop_co_core_get_testimonials( int $limit = 10 ): WP_Query {
	return Shop_Co_Core_Testimonials::get_items( $limit );
}
