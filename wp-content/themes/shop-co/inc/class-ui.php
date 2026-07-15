<?php

require_once __DIR__ . '/class-icons.php';

class ShopCo_UI {

	public static function field(
		string $icon,
		string $type = 'text',
		string $placeholder = '',
		string $label = '',
		string $mode = '',
		string $classes = '',
		string $id = '',
		string $name = '',
	) {
		$modes = array(
			'white',
		);

		$svgIcon = ShopCo_Icons::get_icon( $icon );
		$mode    = in_array( $mode, $modes, true ) ? $mode : '';
		$label   = $label ?: $placeholder;

		$classes  .= ( $classes ? ' ' : '' ) . 'site-field' . ( $mode ? " site-field--$mode" : '' );
		$id_attr   = $id ? "id='" . esc_attr( $id ) . "'" : '';
		$name_attr = $name ? "name='" . esc_attr( $name ) . "'" : '';

		return "<label class=\"$classes\">
                    <input type=\"$type\" class=\"site-field__input\" placeholder=\"$placeholder\" $id_attr $name_attr>
                    <span class=\"site-field__icon opacity-40\">
                        $svgIcon
                    </span>
                    <span class=\"visually-hidden\">$label</span>
                </label>";
	}
}
