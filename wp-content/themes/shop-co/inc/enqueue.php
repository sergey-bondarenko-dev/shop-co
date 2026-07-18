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
 * Enqueue a compiled theme stylesheet with the main stylesheet as a dependency.
 *
 * @param string $handle Stylesheet handle.
 * @param string $entry  Build entry name without extension.
 */
function shop_co_enqueue_built_style( string $handle, string $entry ): void {
	$asset_path = get_theme_file_path( "build/css/{$entry}.asset.php" );

	if ( ! file_exists( $asset_path ) ) {
		return;
	}

	$asset        = include $asset_path;
	$dependencies = array_unique(
		array_merge(
			array( 'shop-co-style' ),
			$asset['dependencies'] ?? array()
		)
	);

	wp_enqueue_style(
		$handle,
		get_theme_file_uri( "build/css/{$entry}.css" ),
		$dependencies,
		$asset['version'] ?? SHOP_CO_VERSION
	);
}

/**
 * Enqueue front-end theme assets.
 */
function shop_co_scripts(): void {
	$screen_asset_path = get_theme_file_path( 'build/css/screen.asset.php' );

	if ( file_exists( $screen_asset_path ) ) {
		$screen_asset = include $screen_asset_path;

		wp_enqueue_style(
			'shop-co-style',
			get_theme_file_uri( 'build/css/screen.css' ),
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

	if ( shop_co_is_woocommerce_active() ) {
		if ( is_shop() || is_product_taxonomy() ) {
			shop_co_enqueue_built_style( 'shop-co-catalog', 'catalog' );
		}

		if ( is_product() ) {
			shop_co_enqueue_built_style( 'shop-co-product', 'product' );
		}

		if ( is_cart() ) {
			shop_co_enqueue_built_style( 'shop-co-cart', 'cart' );
		}

		if ( is_checkout() ) {
			shop_co_enqueue_built_style( 'shop-co-checkout', 'checkout' );
		}

		if ( is_account_page() ) {
			shop_co_enqueue_built_style( 'shop-co-account', 'account' );
		}
	}

	if ( function_exists( 'shop_co_wc_get_filter_color_styles' ) ) {
		$filter_color_styles = shop_co_wc_get_filter_color_styles();

		if ( $filter_color_styles ) {
			wp_add_inline_style( 'shop-co-style', $filter_color_styles );
		}
	}

	$custom_css_path = get_theme_file_path( 'resources/css/custom-css.css' );

	if ( file_exists( $custom_css_path ) ) {
		wp_enqueue_style(
			'shop-co-custom',
			get_theme_file_uri( 'resources/css/custom-css.css' ),
			array( 'shop-co-style' ),
			filemtime( $custom_css_path )
		);
	}

	$main_asset_path = get_theme_file_path( 'build/js/main.asset.php' );

	if ( file_exists( $main_asset_path ) ) {
		$main_asset = include $main_asset_path;

		wp_enqueue_script(
			'shop-co-main',
			get_theme_file_uri( 'build/js/main.js' ),
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
	$editor_script_asset_path = get_theme_file_path( 'build/js/editor.asset.php' );
	$editor_style_asset_path  = get_theme_file_path( 'build/css/editor.asset.php' );

	if ( file_exists( $editor_script_asset_path ) ) {
		$editor_script_asset = include $editor_script_asset_path;

		wp_enqueue_script(
			'shop-co-editor',
			get_theme_file_uri( 'build/js/editor.js' ),
			$editor_script_asset['dependencies'] ?? array(),
			$editor_script_asset['version'] ?? SHOP_CO_VERSION,
			true
		);
	}

	if ( file_exists( $editor_style_asset_path ) ) {
		$editor_style_asset = include $editor_style_asset_path;

		wp_enqueue_style(
			'shop-co-editor',
			get_theme_file_uri( 'build/css/editor.css' ),
			$editor_style_asset['dependencies'] ?? array(),
			$editor_style_asset['version'] ?? SHOP_CO_VERSION
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'shop_co_editor_assets' );
