<?php

remove_action(
	'woocommerce_before_shop_loop_item',
	'woocommerce_template_loop_product_link_open',
	10
);

add_action(
	'woocommerce_before_shop_loop_item',
	'shop_co_template_loop_product_link_open',
	10,
);

remove_action(
	'woocommerce_before_shop_loop_item_title',
	'woocommerce_show_product_loop_sale_flash',
	10,
);

remove_action(
	'woocommerce_before_shop_loop_item_title',
	'woocommerce_template_loop_product_thumbnail',
	10,
);

add_action(
	'woocommerce_before_shop_loop_item_title',
	'shop_co_template_loop_product_thumbnail',
	10,
);

remove_action(
	'woocommerce_shop_loop_item_title',
	'woocommerce_template_loop_product_title',
	10,
);

add_action(
	'woocommerce_shop_loop_item_title',
	'shop_co_template_loop_product_title',
	10,
);

remove_action(
	'woocommerce_after_shop_loop_item',
	'woocommerce_template_loop_add_to_cart',
	10
);

add_filter( 'woocommerce_price_trim_zeros', '__return_true' );

add_filter(
	'woocommerce_breadcrumb_defaults',
	'shop_co_woocommerce_breadcrumb_defaults'
);

add_filter( 'woocommerce_product_tabs', 'shop_co_woocommerce_product_tabs' );
add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );

remove_filter( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
remove_filter( 'woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10 );

add_filter( 'woocommerce_review_comment_text', 'shop_co_woocommerce_review_display_comment_text', 10 );

add_filter( 'woocommerce_order_button_html', 'shop_co_woocommerce_order_button_html' );
