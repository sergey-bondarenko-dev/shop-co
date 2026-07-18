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
class Shop_Co_Header_Nav_Walker extends Walker_Nav_Menu {
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
				'data-bs-offset' => '[-50, 10]',
			);

			$arrow_down_svg = shop_co_get_icon( 'arrow_down' );

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
