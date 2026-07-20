<?php
/**
 * Header navigation functions.
 *
 * @package Shop_Co
 */

/**
 * Add top-level product categories under the shop menu item when it has no child items.
 *
 * @param array    $items Menu item objects.
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @return array Menu item objects.
 */
function shop_co_add_header_menu_shop_categories( array $items, stdClass $args ): array {
	if ( 'header_menu' !== ( $args->theme_location ?? '' ) || ! function_exists( 'wc_get_page_id' ) ) {
		return $items;
	}

	$shop_page_id = wc_get_page_id( 'shop' );

	if ( $shop_page_id <= 0 ) {
		return $items;
	}

	$shop_item = null;

	foreach ( $items as $item ) {
		if ( shop_co_is_shop_nav_menu_item( $item, $shop_page_id ) ) {
			$shop_item = $item;
			break;
		}
	}

	if ( ! $shop_item || shop_co_nav_menu_item_has_children( $items, (int) $shop_item->ID ) ) {
		return $items;
	}

	$shop_item->classes = array_unique( array_merge( (array) $shop_item->classes, array( 'menu-item-has-children' ) ) );
	$shop_item->current = ! empty( $shop_item->current );

	$categories = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'parent'     => 0,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);

	if ( is_wp_error( $categories ) || empty( $categories ) ) {
		return $items;
	}

	foreach ( $categories as $category ) {
		$link = get_term_link( $category );

		if ( is_wp_error( $link ) ) {
			continue;
		}

		$items[] = shop_co_create_product_category_menu_item( $category, $link, (int) $shop_item->ID );
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'shop_co_add_header_menu_shop_categories', 10, 2 );

/**
 * Check whether a menu item points to the WooCommerce shop page.
 *
 * @param object $item         Menu item object.
 * @param int    $shop_page_id WooCommerce shop page ID.
 * @return bool Whether the item links to the shop page.
 */
function shop_co_is_shop_nav_menu_item( object $item, int $shop_page_id ): bool {
	if ( 'post_type' === ( $item->type ?? '' ) && 'page' === ( $item->object ?? '' ) && (int) ( $item->object_id ?? 0 ) === $shop_page_id ) {
		return true;
	}

	$item_url = untrailingslashit( (string) ( $item->url ?? '' ) );
	$shop_url = untrailingslashit( get_permalink( $shop_page_id ) );

	return $item_url && $shop_url && $item_url === $shop_url;
}

/**
 * Check whether a nav menu item already has child items.
 *
 * @param array $items     Menu item objects.
 * @param int   $parent_id Parent menu item ID.
 * @return bool Whether child items exist.
 */
function shop_co_nav_menu_item_has_children( array $items, int $parent_id ): bool {
	foreach ( $items as $item ) {
		if ( (int) ( $item->menu_item_parent ?? 0 ) === $parent_id ) {
			return true;
		}
	}

	return false;
}

/**
 * Create a lightweight nav menu item object from a product category.
 *
 * @param WP_Term $category Product category.
 * @param string  $url      Product category URL.
 * @param int     $parent_id Parent menu item ID.
 * @return stdClass Menu item object.
 */
function shop_co_create_product_category_menu_item( WP_Term $category, string $url, int $parent_id ): stdClass {
	$item = new stdClass();

	$item->ID                    = -100000 - (int) $category->term_id;
	$item->db_id                 = 0;
	$item->menu_item_parent      = (string) $parent_id;
	$item->object_id             = (string) $category->term_id;
	$item->object                = 'product_cat';
	$item->type                  = 'taxonomy';
	$item->type_label            = __( 'Product category', 'shop-co' );
	$item->title                 = $category->name;
	$item->url                   = $url;
	$item->target                = '';
	$item->attr_title            = '';
	$item->description           = '';
	$item->classes               = array( 'menu-item', 'menu-item-type-taxonomy', 'menu-item-object-product_cat' );
	$item->xfn                   = '';
	$item->current               = false;
	$item->current_item_ancestor = false;
	$item->current_item_parent   = false;
	$item->menu_order            = 0;

	return $item;
}
