<?php
/**
 * Header navigation walker and menu helpers.
 *
 * @package Shop_Co
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the header menu with one-level Bootstrap dropdowns.
 */
class ShopCo_Header_Nav_Walker extends Walker_Nav_Menu {
	/**
	 * Starts a submenu.
	 *
	 * @param string   $output Used to append additional content.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ): void {
		if ( $depth > 0 ) {
			return;
		}

		$output .= '<ul class="dropdown-menu site-navigation__dropdown-menu">';
	}

	/**
	 * Ends a submenu.
	 *
	 * @param string   $output Used to append additional content.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ): void {
		if ( $depth > 0 ) {
			return;
		}

		$output .= '</ul>';
	}

	/**
	 * Starts a menu item.
	 *
	 * @param string   $output Used to append additional content.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ): void {
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );

		if ( 0 === $depth ) {
			$classes[] = 'site-navigation__list-item';
			$classes[] = 'nav-item';

			if ( $has_children ) {
				$classes[] = 'dropdown';
			}
		} else {
			$classes[] = 'site-navigation__dropdown-item';
		}

		$class_names = implode( ' ', array_filter( array_map( 'sanitize_html_class', $classes ) ) );
		$output     .= '<li class="' . esc_attr( $class_names ) . '">';

		$link_classes = 0 === $depth
			? array( 'site-navigation__link', 'nav-link' )
			: array( 'site-navigation__dropdown-link', 'dropdown-item' );

		$atts = array(
			'href'  => ! empty( $item->url ) ? $item->url : '',
			'class' => implode( ' ', $link_classes ),
		);

		if ( ! empty( $item->target ) ) {
			$atts['target'] = $item->target;
		}

		if ( ! empty( $item->xfn ) ) {
			$atts['rel'] = $item->xfn;
		}

		if ( ! empty( $item->attr_title ) ) {
			$atts['title'] = $item->attr_title;
		}

		if ( ! empty( $item->current ) ) {
			$atts['aria-current'] = 'page';
		}

		$output .= '<a' . $this->build_atts( $atts ) . '>';
		$output .= esc_html( $item->title );
		$output .= '</a>';

		if ( $has_children && 0 === $depth ) {
			$dropdown_button_atts = array(
				'type'           => 'button',
				'class'          => 'site-navigation__dropdown-toggle dropdown-toggle',
				'data-bs-toggle' => 'dropdown',
				'aria-expanded'  => 'false',
				'aria-label'     => sprintf(
					/* translators: %s: Menu item title. */
					__( 'Open %s submenu', 'shop-co' ),
					$item->title
				),
				'data-bs-offset' => "[-50, 10]",
			);

			$arrow_down_svg = ShopCo_Icons::arrow_down();

			$output .= '<button' . $this->build_atts( $dropdown_button_atts ) . '>' . $arrow_down_svg . '</button>';
		}
	}

	/**
	 * Ends a menu item.
	 *
	 * @param string  $output Used to append additional content.
	 * @param WP_Post $item   Menu item data object.
	 * @param int     $depth  Depth of menu item.
	 * @param object  $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ): void {
		$output .= '</li>';
	}
}

/**
 * Add top-level product categories under the shop menu item when it has no child items.
 *
 * @param array    $items Menu item objects.
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @return array
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

	$shop_item->classes   = array_unique( array_merge( (array) $shop_item->classes, array( 'menu-item-has-children' ) ) );
	$shop_item->current   = ! empty( $shop_item->current );
	$shop_item->current_item_ancestor = ! empty( $shop_item->current_item_ancestor );

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
