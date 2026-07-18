<?php
/**
 * Theme UI helpers.
 *
 * @package Shop_Co
 */

/**
 * Builds reusable theme UI markup.
 */
class Shop_Co_UI {

	/**
	 * Return markup for a form field with an icon.
	 *
	 * @param string $icon        Icon name.
	 * @param string $type        Input type.
	 * @param string $placeholder Input placeholder.
	 * @param string $label       Accessible input label.
	 * @param string $mode        Visual field mode.
	 * @param string $classes     Additional CSS classes.
	 * @param string $id          Input ID.
	 * @param string $name        Input name.
	 * @return string Field markup.
	 */
	public static function field(
		string $icon,
		string $type = 'text',
		string $placeholder = '',
		string $label = '',
		string $mode = '',
		string $classes = '',
		string $id = '',
		string $name = '',
	): string {
		$modes = array(
			'white',
		);

		$svg_icon = shop_co_get_icon( $icon );
		$mode     = in_array( $mode, $modes, true ) ? $mode : '';
		$label    = $label ? $label : $placeholder;

		$classes    .= ( $classes ? ' ' : '' ) . 'site-field' . ( $mode ? " site-field--$mode" : '' );
		$id_attr     = $id ? "id='" . esc_attr( $id ) . "'" : '';
		$name_attr   = $name ? "name='" . esc_attr( $name ) . "'" : '';
		$type        = esc_attr( $type );
		$classes     = esc_attr( $classes );
		$placeholder = esc_attr( $placeholder );
		$label       = esc_html( $label );

		return "<label class=\"$classes\">
					<input type=\"$type\" class=\"site-field__input\" placeholder=\"$placeholder\" $id_attr $name_attr>
					<span class=\"site-field__icon opacity-40\">
						$svg_icon
                    </span>
                    <span class=\"visually-hidden\">$label</span>
                </label>";
	}
}
