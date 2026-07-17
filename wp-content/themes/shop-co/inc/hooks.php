<?php

add_filter( 'comments_template_query_args', 'shop_co_comments_template_query_args' );

function shop_co_comments_template_query_args( array $query_args ) {
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

add_filter('body_class', function ($classes) {
    if (is_shop() || is_product_taxonomy()) {
        $classes[] = 'shopco-catalog-page';
    }

    return $classes;
});
