<?php
/**
 * WooCommerce template functions.
 *
 * @package Shop_Co
 */

/**
 * Get newest published WooCommerce products.
 *
 * @param int $limit Maximum number of products.
 * @return WC_Product[]
 */
function shop_co_get_new_products( int $limit = 8 ): array {
	return wc_get_products(
		array(
			'status'       => 'publish',
			'limit'        => $limit,
			'orderby'      => 'date',
			'order'        => 'DESC',
			'date_created' => '>=' . shop_co_get_new_arrivals_cutoff_timestamp(),
		)
	);
}

/**
 * Get the number of days products are considered new arrivals.
 */
function shop_co_get_new_arrivals_days(): int {
	/**
	 * Filter the new-arrivals period.
	 *
	 * @param int $days Number of days after publication.
	 */
	$days = (int) apply_filters( 'shop_co_new_arrivals_days', 30 );

	return max( 1, $days );
}

/**
 * Get the Unix timestamp after which products are considered new arrivals.
 */
function shop_co_get_new_arrivals_cutoff_timestamp(): int {
	return time() - ( shop_co_get_new_arrivals_days() * DAY_IN_SECONDS );
}

/**
 * Get a filtered WooCommerce catalog URL.
 *
 * @param string $collection Collection slug.
 */
function shop_co_get_catalog_collection_url( string $collection ): string {
	if ( ! in_array( $collection, array( 'sale', 'new-arrivals' ), true ) ) {
		return '';
	}

	$shop_url = wc_get_page_permalink( 'shop' );

	return $shop_url ? add_query_arg( 'collection', $collection, $shop_url ) : '';
}

/**
 * Get the brands index page URL.
 */
function shop_co_get_brands_page_url(): string {
	$page = get_page_by_path( 'brands' );

	return $page instanceof WP_Post ? get_permalink( $page ) : home_url( '/brands/' );
}

/**
 * Get top-selling published WooCommerce products.
 *
 * @param int $limit Maximum number of products.
 * @return WC_Product[]
 */
function shop_co_get_top_selling_products( int $limit = 8 ): array {
	return wc_get_products(
		array(
			'status'   => 'publish',
			'limit'    => $limit,
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Total sales determine the best-selling products.
			'meta_key' => 'total_sales',
			'orderby'  => 'meta_value_num',
			'order'    => 'DESC',
		)
	);
}

/**
 * Get products related to a product.
 *
 * @param WC_Product $product Product object.
 * @param int        $limit   Maximum number of products.
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

/**
 * Open the product loop link using theme markup.
 */
function shop_co_template_loop_product_link_open() {
	global $product;

	if ( ! ( $product instanceof WC_Product ) ) {
		return;
	}

	$link = apply_filters(
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WooCommerce hook.
		'woocommerce_loop_product_link',
		get_the_permalink(),
		$product
	);

	echo '<a href="' . esc_url( $link ) . '" class="site-product-card__link woocommerce-LoopProduct-link">';
}

/**
 * Print the product loop thumbnail using theme markup.
 */
function shop_co_template_loop_product_thumbnail() {
	$img = woocommerce_get_product_thumbnail(
		'woocommerce_thumbnail',
		array(
			'class' => 'site-product-card__thumbnail',
		),
	);
	echo '<span class="site-product-card__thumbnail-wrapper">' . wp_kses_post( $img ) . '</span>';
}

/**
 * Print the product loop title using theme markup.
 */
function shop_co_template_loop_product_title() {
	$classes = 'site-product-card__title woocommerce-loop-product__title h5';
	$classes = apply_filters(
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WooCommerce hook.
		'woocommerce_product_loop_title_classes',
		$classes
	);

	echo '<h2 class="' . esc_attr( $classes ) . '">' . esc_html( get_the_title() ) . '</h2>';
}

/**
 * Print product price markup.
 *
 * @param WC_Product $product       Product object.
 * @param bool       $show_discount Whether to show the discount percentage.
 * @param string     $wrapper_class Additional wrapper CSS class.
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

/**
 * Print product rating markup.
 *
 * @param float  $rating        Product rating.
 * @param string $wrapper_class Additional wrapper CSS class.
 * @param bool   $show_value    Whether to show the numeric rating.
 */
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
	$star_icon   = Shop_Co_Assets::asset( 'icons/star.svg' );
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

/**
 * Customize WooCommerce breadcrumb markup.
 *
 * @param array $defaults Breadcrumb defaults.
 * @return array Modified breadcrumb defaults.
 */
function shop_co_woocommerce_breadcrumb_defaults( array $defaults ): array {
	$chevron_right_svg = shop_co_get_icon( 'chevron_right' );

	$defaults['delimiter']   = '<span class="breadcrumbs__separator opacity-60">' . $chevron_right_svg . '</span>';
	$defaults['wrap_before'] = '<nav class="breadcrumbs woocommerce-breadcrumb" aria-label="Breadcrumbs">';
	$defaults['wrap_after']  = '</nav>';
	$defaults['before']      = '<span class="breadcrumbs__item">';
	$defaults['after']       = '</span>';
	$defaults['home']        = 'Home';

	return $defaults;
}

/**
 * Use the theme pagination labels in WooCommerce product archives.
 *
 * @param array $args Pagination arguments.
 * @return array Modified pagination arguments.
 */
function shop_co_woocommerce_pagination_args( array $args ): array {
	$args['prev_text'] = shop_co_get_pagination_previous_text();
	$args['next_text'] = shop_co_get_pagination_next_text();
	$args['end_size']  = 1;
	$args['mid_size']  = 1;

	return $args;
}
add_filter( 'woocommerce_pagination_args', 'shop_co_woocommerce_pagination_args' );

add_action( 'woocommerce_before_quantity_input_field', 'shop_co_woocommerce_before_quantity_input_field_action' );

/**
 * Print the decrement button before a quantity input.
 */
function shop_co_woocommerce_before_quantity_input_field_action(): void {
	?>
	<button type="button" class="quantity__button quantity__button--minus" aria-label="<?php esc_attr_e( 'Decrease quantity', 'shop-co' ); ?>">
		<?php echo shop_co_get_icon( 'minus' ); ?>
	</button>
	<?php
}

add_action( 'woocommerce_after_quantity_input_field', 'shop_co_woocommerce_after_quantity_input_field_action' );

/**
 * Print the increment button after a quantity input.
 */
function shop_co_woocommerce_after_quantity_input_field_action(): void {
	?>
	<button type="button" class="quantity__button quantity__button--plus" aria-label="<?php esc_attr_e( 'Increase quantity', 'shop-co' ); ?>">
		<?php echo shop_co_get_icon( 'plus' ); ?>
	</button>
	<?php
}

/**
 * Print radio buttons for a variation attribute.
 *
 * @param array $args Variation attribute arguments.
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
			$option_label = apply_filters(
				// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WooCommerce hook.
				'woocommerce_variation_option_name',
				$option,
				null,
				$attribute,
				$product
			);
			$color_value = $is_color_attribute ? shop_co_wc_get_variation_color_value( $option ) : '';
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

/**
 * Get the color palette shared by product variations and catalog filters.
 *
 * @return array<string, string>
 */
function shop_co_wc_get_variation_colors(): array {
	return apply_filters(
		'shop_co_wc_variation_colors',
		array(
			'black'    => '#000000',
			'white'    => '#ffffff',
			'red'      => '#ff3333',
			'green'    => '#01ab31',
			'blue'     => '#2f80ed',
			'navy'     => '#1f2a44',
			'yellow'   => '#ffc633',
			'orange'   => '#f2994a',
			'purple'   => '#9b51e0',
			'pink'     => '#eb5757',
			'gray'     => '#828282',
			'grey'     => '#828282',
			'brown'    => '#8b5e3c',
			'beige'    => '#d7c4a3',
			'burgundy' => '#800020',
			'olive'    => '#808000',
		)
	);
}

/**
 * Return the display value for a variation color.
 *
 * @param string $option Variation color option.
 * @return string CSS color value.
 */
function shop_co_wc_get_variation_color_value( string $option ): string {
	$colors = shop_co_wc_get_variation_colors();

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
 * Build color rules for Filter Everything swatches.
 */
function shop_co_wc_get_filter_color_styles(): string {
	$styles = array();

	foreach ( shop_co_wc_get_variation_colors() as $slug => $color ) {
		$slug  = sanitize_title( $slug );
		$color = sanitize_hex_color( $color );

		if ( ! $slug || ! $color ) {
			continue;
		}

		$styles[] = sprintf(
			'.wpc-filter-pa_color input[data-wpc-e-name="pa_color"][data-wpc-slug="%1$s"] + label .wpc-term-swatch{--shop-co-filter-color:%2$s}',
			$slug,
			$color
		);
	}

	return implode( '', $styles );
}

/**
 * Render the mobile catalog filters button.
 */
function shop_co_woocommerce_catalog_filters_button(): void {
	if ( ! ( is_shop() || is_product_taxonomy() ) || ! is_active_sidebar( 'shop-filters' ) ) {
		return;
	}
	?>
	<button
		type="button"
		class="catalog-filters-toggle site-button site-button--gray site-button--square visible-tablet"
		data-bs-toggle="offcanvas"
		data-bs-target="#catalog-filters-offcanvas"
		aria-controls="catalog-filters-offcanvas"
		aria-label="<?php esc_attr_e( 'Open catalog filters', 'shop-co' ); ?>">
		<?php echo shop_co_get_icon( 'settings' ); ?>
	</button>
	<?php
}

/**
 * Render a configurable catalog ordering widget with the WooCommerce control
 * as a fallback.
 *
 * @param string $sidebar_id Catalog ordering widget area ID.
 */
function shop_co_render_catalog_ordering( string $sidebar_id ): void {
	ob_start();

	$widget_rendered = dynamic_sidebar( $sidebar_id );
	$widget_html     = trim( (string) ob_get_clean() );

	if ( $widget_rendered && '' !== $widget_html ) {
		echo $widget_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered by registered widgets.
		return;
	}

	woocommerce_catalog_ordering(
		array(
			'useLabel' => true,
		)
	);
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

/**
 * Print review comment text using theme markup.
 */
function shop_co_woocommerce_review_display_comment_text() {
	echo '<div class="testimonial-card__content opacity-60">';
	comment_text();
	echo '</div>';
}

/**
 * Apply the theme button component to the checkout submit button.
 *
 * @param string $button_html Checkout button markup.
 * @return string Modified checkout button markup.
 */
function shop_co_woocommerce_order_button_html( string $button_html ): string {
	return str_replace( 'class="button alt', 'class="site-button button alt', $button_html );
}
