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
	 * @param array $args {
	 *     Field arguments.
	 *
	 *     @type string $icon        Icon name.
	 *     @type string $type        Input type. Default 'text'.
	 *     @type string $placeholder Input placeholder. Default empty string.
	 *     @type string $label       Accessible input label. Defaults to placeholder.
	 *     @type string $mode        Visual field mode. Default empty string.
	 *     @type string $classes     Additional CSS classes. Default empty string.
	 *     @type string $id          Input ID. Default empty string.
	 *     @type string $name        Input name. Default empty string.
	 *     @type bool   $required    Whether the input is required. Default false.
	 * }
	 * @return string Field markup.
	 */
	public static function field( array $args ): string {
		$args = wp_parse_args(
			$args,
			array(
				'icon'        => '',
				'type'        => 'text',
				'placeholder' => '',
				'label'       => '',
				'mode'        => '',
				'classes'     => '',
				'id'          => '',
				'name'        => '',
				'required'    => false,
			)
		);

		$modes = array(
			'white',
		);

		$svg_icon = shop_co_get_icon( $args['icon'] );
		$mode     = in_array( $args['mode'], $modes, true ) ? $args['mode'] : '';
		$label    = $args['label'] ? $args['label'] : $args['placeholder'];

		$classes     = $args['classes'] . ( $args['classes'] ? ' ' : '' ) . 'site-field' . ( $mode ? " site-field--$mode" : '' );
		$id_attr     = $args['id'] ? " id='" . esc_attr( $args['id'] ) . "'" : '';
		$name_attr   = $args['name'] ? " name='" . esc_attr( $args['name'] ) . "'" : '';
		$required    = $args['required'] ? ' required' : '';
		$type        = esc_attr( $args['type'] );
		$classes     = esc_attr( $classes );
		$placeholder = esc_attr( $args['placeholder'] );
		$label       = esc_html( $label );

		return "<label class=\"$classes\">
					<input type=\"$type\" class=\"site-field__input\" placeholder=\"$placeholder\"$id_attr$name_attr$required>
					<span class=\"site-field__icon opacity-40\">
						$svg_icon
                    </span>
                    <span class=\"visually-hidden\">$label</span>
                </label>";
	}
}
