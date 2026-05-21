<?php
/**
 * Theme setup.
 *
 * @package Shop_Co
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SHOP_CO_USE_DEMO_DATA', true );

/**
 * Register theme supports and menus.
 */
function shop_co_setup(): void {
	load_theme_textdomain( 'shop-co', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( file_exists( get_theme_file_path( 'build/css/editor.css' ) ) ? 'build/css/editor.css' : 'style.css' );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary menu', 'shop-co' ),
			'footer'  => esc_html__( 'Footer menu', 'shop-co' ),
		)
	);
}
add_action( 'after_setup_theme', 'shop_co_setup' );

/**
 * Set the maximum content width.
 */
function shop_co_content_width(): void {
	$GLOBALS['content_width'] = apply_filters( 'shop_co_content_width', 1180 );
}
add_action( 'after_setup_theme', 'shop_co_content_width', 0 );

/**
 * Register widget areas.
 */
function shop_co_widgets_init(): void {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'shop-co' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'shop-co' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'shop_co_widgets_init' );

function shop_co_use_demo_data(): bool
{
	return defined( 'SHOP_CO_USE_DEMO_DATA' ) && SHOP_CO_USE_DEMO_DATA;
}
