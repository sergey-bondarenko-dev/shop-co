<?php

function shop_co_get_reviews_order() {
	$order = $_GET['reviews_order'] ?? '';

	if ( ! in_array( $order, array( 'newest', 'oldest' ), true ) ) {
		$order = get_option( 'comment_order' ) === 'asc' ? 'oldest' : 'newest';
	}

	return $order;
}
