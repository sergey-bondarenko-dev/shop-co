<?php
/**
 * Theme icon functions.
 *
 * @package Shop_Co
 */

/**
 * Return a trusted SVG icon from the theme icon allowlist.
 *
 * @param string $icon Icon name.
 * @return string SVG markup or an empty string when the icon is unknown.
 */
function shop_co_get_icon( string $icon ): string {
	return Shop_Co_Icons::get_icon( $icon );
}
