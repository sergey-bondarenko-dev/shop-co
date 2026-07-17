<?php
/**
 * WooCommerce catalog filters sidebar.
 *
 * @package Shop_Co
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! ( is_shop() || is_product_taxonomy() ) || ! is_active_sidebar( 'shop-filters' ) ) {
	return;
}
?>

<aside class="catalog-sidebar" aria-label="<?php esc_attr_e( 'Catalog filters', 'shop-co' ); ?>">
	<?php dynamic_sidebar( 'shop-filters' ); ?>
</aside>
