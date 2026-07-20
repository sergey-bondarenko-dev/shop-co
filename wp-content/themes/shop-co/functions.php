<?php
/**
 * Shop Co theme functions.
 *
 * @package Shop_Co
 */

if ( ! defined( 'SHOP_CO_VERSION' ) ) {
	define( 'SHOP_CO_VERSION', '0.1.0' );
}

require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/shop-co-functions.php';
require get_template_directory() . '/inc/hooks.php';
require get_template_directory() . '/inc/woocommerce.php';
require get_template_directory() . '/inc/class-shop-co-header-nav-walker.php';
require get_template_directory() . '/inc/header-nav-functions.php';
require get_template_directory() . '/inc/nav-menu-admin-functions.php';
require get_template_directory() . '/inc/class-shop-co-icons.php';
require get_template_directory() . '/inc/icon-functions.php';
require get_template_directory() . '/inc/class-shop-co-ui.php';
require get_template_directory() . '/inc/class-shop-co-assets.php';
require get_template_directory() . '/inc/wc-template-functions.php';
require get_template_directory() . '/inc/wc-template-hooks.php';
