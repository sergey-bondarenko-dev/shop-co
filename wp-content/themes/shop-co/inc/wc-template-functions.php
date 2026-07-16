<?php

/**
 * Get newest published WooCommerce products.
 *
 * @return WC_Product[]
 */
function shop_co_get_new_products( int $limit = 8 ): array {
	return wc_get_products(
		array(
			'status'  => 'publish',
			'limit'   => $limit,
			'orderby' => 'date',
			'order'   => 'DESC',
		)
	);
}

/**
 * Get top-selling published WooCommerce products.
 *
 * @return WC_Product[]
 */
function shop_co_get_top_selling_products( int $limit = 8 ): array {
	return wc_get_products(
		array(
			'status'   => 'publish',
			'limit'    => $limit,
			'meta_key' => 'total_sales',
			'orderby'  => 'meta_value_num',
			'order'    => 'DESC',
		)
	);
}

/**
 * Get products related to a product.
 *
 * @return WC_Product[]
 */
function shop_co_get_related_products( WC_Product $product, int $limit = 4 ): array {
	$product_ids = wc_get_related_products( $product->get_id(), $limit );

	if ( empty( $product_ids ) ) {
		return array();
	}

	return wc_get_products(
		array(
			'status'  => 'publish',
			'limit'   => $limit,
			'include' => $product_ids,
			'orderby' => 'include',
		)
	);
}

function shop_co_template_loop_product_link_open() {
	global $product;

	if ( ! ( $product instanceof WC_Product ) ) {
		return;
	}

	$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

	echo '<a href="' . esc_url( $link ) . '" class="site-product-card__link woocommerce-LoopProduct-link">';
}

function shop_co_template_loop_product_thumbnail() {
	$img = woocommerce_get_product_thumbnail(
		'woocommerce_thumbnail',
		array(
			'class' => 'site-product-card__thumbnail',
		),
	);
	echo "<span class='site-product-card__thumbnail-wrapper'>$img</span>";
}

function shop_co_template_loop_product_title() {
	$classes = 'site-product-card__title woocommerce-loop-product__title h5';

	echo '<h2 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', $classes ) ) . '">' . get_the_title() . '</h2>';
}

/**
 * @param WC_Product&WC_Product_Variable $product
 */
function shop_co_template_price( WC_Product $product, bool $show_discount = true, string $wrapper_class = '' ): void {
	if ( ! ( $product instanceof WC_Product ) ) {
		return;
	}

	if ( $product->is_type( 'variable' ) ) {
		$variation_prices = $product->get_variation_prices( true );
		$variation_id     = 0;
		$current_price    = 0.0;

		foreach ( $variation_prices['price'] ?? array() as $id => $price ) {
			$price = (float) $price;

			if ( $price <= 0 ) {
				continue;
			}

			if ( 0.0 === $current_price || $price < $current_price ) {
				$variation_id  = (int) $id;
				$current_price = $price;
			}
		}

		$regular_price = (float) ( $variation_prices['regular_price'][ $variation_id ] ?? $current_price );
	} else {
		$regular_price = (float) $product->get_regular_price();
		$current_price = (float) $product->get_price();
	}

	if ( $current_price <= 0 ) {
		return;
	}

	$discount_percent = 0;

	if ( $product->is_on_sale() && $regular_price > 0 && $current_price < $regular_price ) {
		$discount_percent = (int) round( ( ( $regular_price - $current_price ) / $regular_price ) * 100 );
	}

	$classes = array_filter(
		array(
			'site-price',
			'price',
			$wrapper_class,
		)
	);
	?>
	<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<span class="site-price__current">
			<?php echo wp_kses_post( wc_price( $current_price ) ); ?>
		</span>

		<?php if ( $show_discount && $discount_percent > 0 ) : ?>
			<del class="site-price__regular opacity-40">
				<?php echo wp_kses_post( wc_price( $regular_price ) ); ?>
			</del>

			<span class="site-price__discount">
				-<?php echo esc_html( (string) $discount_percent ); ?>%
			</span>
		<?php endif; ?>
	</span>
	<?php
}

function shop_co_template_rating( float $rating, string $wrapper_class = '', bool $show_value = true ): void {
	$rating = max( 0.0, min( 5.0, $rating ) );

	if ( $rating <= 0.0 ) {
		return;
	}

	$classes     = array_filter(
		array(
			'site-rating',
			$wrapper_class,
		)
	);
	$stars_count = (int) ceil( $rating );
	$star_icon   = ShopCo_Assets::asset( 'icons/star.svg' );
	?>
	<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<span class="site-rating__stars">
			<?php for ( $i = 0; $i < $stars_count; $i++ ) : ?>
				<?php $star_fill = max( 0.0, min( 1.0, $rating - $i ) ) * 100; ?>

				<img
					src="<?php echo esc_url( $star_icon ); ?>"
					class="site-rating__star"
					alt=""
					width="18.5"
					height="18.5"
					style="--star-fill: <?php echo esc_attr( (string) $star_fill ); ?>%;"
				>
			<?php endfor; ?>
		</span>

		<?php if ( $show_value ) : ?>
			<span class="site-rating__value">
				<?php echo esc_html( number_format_i18n( $rating, 1 ) ); ?>/<span class="opacity-60">5</span>
			</span>
		<?php endif; ?>
	</span>
	<?php
}

function shop_co_woocommerce_breadcrumb_defaults( array $defaults ): array {
	$chevron_right_svg = ShopCo_Icons::chevron_right();

	$defaults['delimiter']   = '<span class="breadcrumbs__separator opacity-60">' . $chevron_right_svg . '</span>';
	$defaults['wrap_before'] = '<nav class="breadcrumbs woocommerce-breadcrumb" aria-label="Breadcrumbs">';
	$defaults['wrap_after']  = '</nav>';
	$defaults['before']      = '<span class="breadcrumbs__item">';
	$defaults['after']       = '</span>';
	$defaults['home']        = 'Home';

	return $defaults;
}

add_action( 'woocommerce_before_quantity_input_field', 'shop_co_woocommerce_before_quantity_input_field_action' );

function shop_co_woocommerce_before_quantity_input_field_action(): void {
	?>
	<button type="button" class="quantity__button quantity__button--minus" aria-label="<?php esc_attr_e( 'Decrease quantity', 'woocommerce' ); ?>">
		<?php echo ShopCo_Icons::minus(); ?>
	</button>
	<?php
}

add_action( 'woocommerce_after_quantity_input_field', 'shop_co_woocommerce_after_quantity_input_field_action' );

function shop_co_woocommerce_after_quantity_input_field_action(): void {
	?>
	<button type="button" class="quantity__button quantity__button--plus" aria-label="<?php esc_attr_e( 'Increase quantity', 'woocommerce' ); ?>">
		<?php echo ShopCo_Icons::plus(); ?>
	</button>
	<?php
}

/**
 * @param array{
 *  options: array<int, string>,
 *  attribute: string,
 *  product: WC_Product
 * } $args
 */
function shop_co_wc_radio_buttons_variation_attribute_options( $args = array() ) {
	$options   = $args['options'] ?? null;
	$attribute = $args['attribute'] ?? null;
	$product   = $args['product'] ?? null;

	if ( ! $options || ! $attribute || ! $product ) {
		return;
	}

	$name               = 'attribute_' . sanitize_title( $attribute );
	$field_name         = 'shop_co_' . $name;
	$is_color_attribute = in_array( sanitize_title( $attribute ), array( 'pa_color', 'color' ), true );

	?>

	<div class="site-variations__options<?php echo $is_color_attribute ? ' site-variations__options--color' : ''; ?>">
		<?php foreach ( $options as $option ) : ?>
			<?php $id = sanitize_title( $field_name . '_' . $option ); ?>
			<?php
			$option_label = apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product );
			$color_value  = $is_color_attribute ? shop_co_wc_get_variation_color_value( $option ) : '';
			?>
			<label
				class="site-variations__option<?php echo $is_color_attribute ? ' site-variations__option--color' : ''; ?>"
				for="<?php echo esc_attr( $id ); ?>"
				<?php echo $is_color_attribute ? 'aria-label="' . esc_attr( $option_label ) . '"' : ''; ?>
				<?php echo $color_value ? 'style="--site-variation-color: ' . esc_attr( $color_value ) . ';"' : ''; ?>
			>
				<?php if ( $is_color_attribute ) : ?>
					<span class="site-variations__swatch" aria-hidden="true"></span>
					<span class="screen-reader-text"><?php echo esc_html( $option_label ); ?></span>
				<?php else : ?>
					<span class="opacity-60"><?php echo esc_html( $option_label ); ?></span>
				<?php endif; ?>
				<input type="radio" 
					id="<?php echo esc_attr( $id ); ?>" 
					name="<?php echo esc_attr( $field_name ); ?>" 
					data-attribute-name="<?php echo esc_attr( $name ); ?>"
					value="<?php echo esc_attr( $option ); ?>">
			</label>
		<?php endforeach; ?>
	</div>

	<?php
}

function shop_co_wc_get_variation_color_value( string $option ): string {
	$colors = array(
		'black'  => '#000000',
		'white'  => '#ffffff',
		'red'    => '#ff3333',
		'green'  => '#01ab31',
		'blue'   => '#2f80ed',
		'navy'   => '#1f2a44',
		'yellow' => '#ffc633',
		'orange' => '#f2994a',
		'purple' => '#9b51e0',
		'pink'   => '#eb5757',
		'gray'   => '#828282',
		'grey'   => '#828282',
		'brown'  => '#8b5e3c',
		'beige'  => '#d7c4a3',
	);

	$key = sanitize_title( $option );

	if ( isset( $colors[ $key ] ) ) {
		return $colors[ $key ];
	}

	if ( preg_match( '/^#[0-9a-f]{3}([0-9a-f]{3})?$/i', $option ) ) {
		return $option;
	}

	return $key;
}

/**
 * Customize product detail tabs.
 *
 * @param array $tabs Product tabs.
 * @return array
 */
function shop_co_woocommerce_product_tabs( array $tabs ): array {

	global $product;

	unset(
		$tabs['description'],
		$tabs['additional_information']
	);

	$tabs['details'] = array(
		'title'    => __( 'Product details', 'shop-co' ),
		'priority' => 10,
		'callback' => 'woocommerce_product_additional_information_tab',
	);

	if (
		$product instanceof WC_Product
	&& function_exists( 'shop_co_core_get_product_faqs' )
		&& shop_co_core_get_product_faqs( $product->get_id() )
	) {
		$tabs['faqs'] = array(
			'title'    => __( 'FAQs', 'shop-co' ),
			'priority' => 30,
			'callback' => 'shop_co_woocommerce_product_faqs_tab',
		);
	}

	return $tabs;
}

/**
 * Render the product FAQs tab.
 */
function shop_co_woocommerce_product_faqs_tab() {

	wc_get_template( 'single-product/tabs/faqs.php' );
}
function shop_co_woocommerce_review_display_comment_text() {
	echo '<div class="testimonial-card__content opacity-60">';
	comment_text();
	echo '</div>';
}

/**
 * Apply the theme button component to the checkout submit button.
 */
function shop_co_woocommerce_order_button_html( string $button_html ): string {
	return str_replace( 'class="button alt', 'class="site-button button alt', $button_html );
}
