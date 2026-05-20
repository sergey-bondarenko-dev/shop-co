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
