<?php
/**
 * Asset loading.
 *
 * @package Shop_Co
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end theme assets.
 */
function shop_co_scripts(): void {
	$screen_asset_path = get_theme_file_path( 'public/css/screen.asset.php' );

	if ( file_exists( $screen_asset_path ) ) {
		$screen_asset = include $screen_asset_path;

		wp_enqueue_style(
			'shop-co-style',
			get_theme_file_uri( 'public/css/screen.css' ),
			$screen_asset['dependencies'] ?? array(),
			$screen_asset['version'] ?? SHOP_CO_VERSION
		);
	} else {
		wp_enqueue_style(
			'shop-co-style',
			get_stylesheet_uri(),
			array(),
			SHOP_CO_VERSION
		);
	}

	$main_asset_path = get_theme_file_path( 'public/js/main.asset.php' );

	if ( file_exists( $main_asset_path ) ) {
		$main_asset = include $main_asset_path;

		wp_enqueue_script(
			'shop-co-main',
			get_theme_file_uri( 'public/js/main.js' ),
			$main_asset['dependencies'] ?? array(),
			$main_asset['version'] ?? SHOP_CO_VERSION,
			true
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'shop_co_scripts' );

/**
 * Enqueue block editor assets.
 */
function shop_co_editor_assets(): void {
	$editor_script_asset_path = get_theme_file_path( 'public/js/editor.asset.php' );
	$editor_style_asset_path  = get_theme_file_path( 'public/css/editor.asset.php' );

	if ( file_exists( $editor_script_asset_path ) ) {
		$editor_script_asset = include $editor_script_asset_path;

		wp_enqueue_script(
			'shop-co-editor',
			get_theme_file_uri( 'public/js/editor.js' ),
			$editor_script_asset['dependencies'] ?? array(),
			$editor_script_asset['version'] ?? SHOP_CO_VERSION,
			true
		);
	}

	if ( file_exists( $editor_style_asset_path ) ) {
		$editor_style_asset = include $editor_style_asset_path;

		wp_enqueue_style(
			'shop-co-editor',
			get_theme_file_uri( 'public/css/editor.css' ),
			$editor_style_asset['dependencies'] ?? array(),
			$editor_style_asset['version'] ?? SHOP_CO_VERSION
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'shop_co_editor_assets' );
