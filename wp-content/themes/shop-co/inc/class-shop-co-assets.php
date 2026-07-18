<?php
/**
 * Theme asset helpers.
 *
 * @package Shop_Co
 */

/**
 * Provides URLs and markup for theme assets.
 */
class Shop_Co_Assets {

	/**
	 * Return the URL of a theme asset.
	 *
	 * @param string $path Relative asset path.
	 * @return string Asset URL.
	 */
	public static function asset(
		string $path,
	): string {
		$path = trim( $path, '/' );

		return get_template_directory_uri() . '/resources/' . $path;
	}

	/**
	 * Return image markup for a theme asset.
	 *
	 * @param string $path    Relative image path.
	 * @param string $alt     Alternative text.
	 * @param string $classes CSS classes.
	 * @param array  $sizes   Image width and height.
	 * @return string Image markup.
	 */
	public static function img(
		string $path,
		string $alt = '',
		string $classes = '',
		array $sizes = array(),
	): string {
		$path   = trim( $path, '/' );
		$source = get_template_directory_uri() . '/resources/' . $path;
		$width  = $sizes[0] ?? '';
		$height = $sizes[1] ?? $sizes[0] ?? '';

		return "<img src=\"$source\" class=\"$classes\" alt=\"$alt\" width=\"$width\" height=\"$height\">";
	}
}
