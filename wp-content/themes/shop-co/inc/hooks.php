<?php
/**
 * Theme hooks and filters.
 *
 * @package Shop_Co
 */

add_filter( 'comments_template_query_args', 'shop_co_comments_template_query_args' );

/**
 * Apply the selected review order to product comment queries.
 *
 * @param array $query_args Comment query arguments.
 * @return array Modified comment query arguments.
 */
function shop_co_comments_template_query_args( array $query_args ): array {
	if ( is_admin() || ! is_product() ) {
		return $query_args;
	}

	$query_args['orderby'] = 'comment_date_gmt';
	$query_args['order']   =
		'oldest' === shop_co_get_reviews_order()
			? 'ASC'
			: 'DESC';

	return $query_args;
}

add_filter( 'pre_option_default_comments_page', 'shop_co_pre_option_default_comments_page' );

/**
 * Use the oldest comments page as the default on product pages.
 *
 * @param mixed $pre Pre-filtered option value.
 * @return mixed Filtered option value.
 */
function shop_co_pre_option_default_comments_page( $pre ) {
	if ( is_admin() ) {
		return $pre;
	}

	if ( is_product() ) {
		return 'oldest';
	}

	return $pre;
}

add_filter( 'comment_post_redirect', 'shop_co_product_review_redirect', 10, 2 );

/**
 * Redirect product review submissions back to the reviews section.
 *
 * @param string     $location Original redirect URL.
 * @param WP_Comment $comment  Submitted comment object.
 * @return string Product review redirect URL.
 */
function shop_co_product_review_redirect( string $location, WP_Comment $comment ): string {
	if ( 'product' !== get_post_type( $comment->comment_post_ID ) ) {
		return $location;
	}

	$redirect_url = get_permalink( $comment->comment_post_ID );
	$query        = wp_parse_url( $location, PHP_URL_QUERY );

	if ( $query ) {
		parse_str( $query, $query_args );
		unset( $query_args['cpage'] );

		$redirect_url = add_query_arg( $query_args, $redirect_url );
	}

	return $redirect_url . '#reviews';
}

add_filter(
	'body_class',
	function ( $classes ) {
		if ( is_shop() || is_product_taxonomy() ) {
			$classes[] = 'shopco-catalog-page';
		}

		return $classes;
	}
);
