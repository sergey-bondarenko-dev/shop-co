<?php
/**
 * Product slider section template.
 *
 * @package Shop_Co
 */

/**
 * Template arguments passed to the product slider.
 *
 * @var array $args Template arguments.
 */

$shop_co_title     = $args['title'] ?? '';
$shop_co_products  = $args['products'] ?? array();
$shop_co_url       = $args['url'] ?? wc_get_page_permalink( 'shop' );
$shop_co_contained = ! empty( $args['contained'] );

$shop_co_section_classes = array( 'section', 'products-section', 'overflow-hidden' );
$shop_co_extra_classes   = preg_split( '/\s+/', (string) ( $args['class'] ?? '' ), -1, PREG_SPLIT_NO_EMPTY );

if ( $shop_co_extra_classes ) {
	$shop_co_section_classes = array_merge(
		$shop_co_section_classes,
		array_map( 'sanitize_html_class', $shop_co_extra_classes )
	);
}

$shop_co_header_classes = array( 'section__header' );
$shop_co_body_classes   = array( 'section__body' );

if ( ! $shop_co_contained ) {
	$shop_co_header_classes[] = 'container';
	$shop_co_body_classes[]   = 'container';
}

$shop_co_products = array_filter(
	$shop_co_products,
	static fn ( $product ): bool => $product instanceof WC_Product
);

if ( empty( $shop_co_products ) ) {
	return;
}

$shop_co_product_ids = array_map(
	static fn ( WC_Product $product ): int => $product->get_id(),
	$shop_co_products
);

_prime_post_caches( $shop_co_product_ids );

$shop_co_add_slide_classes = static function ( array $classes ): array {
	$classes[] = 'products-slider__slide';
	$classes[] = 'swiper-slide';

	return $classes;
};

wc_set_loop_prop( 'name', 'products-slider' );
add_filter( 'post_class', $shop_co_add_slide_classes );

?>

<section class="<?php echo esc_attr( implode( ' ', $shop_co_section_classes ) ); ?>">
	<div class="<?php echo esc_attr( implode( ' ', $shop_co_header_classes ) ); ?>">
		<?php if ( $shop_co_title ) : ?>
			<h2 class="section__title">
				<?php echo esc_html( $shop_co_title ); ?>
			</h2>
		<?php endif; ?>
		<?php if ( count( $shop_co_products ) > 1 ) : ?>
			<div class="section__extra">
				<div class="slider-arrows">
					<button class="slider-arrows__button products-slider__button--prev" type="button">
						<?php echo shop_co_get_icon( 'arrow_left' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( 'Previous products', 'shop-co' ); ?></span>
					</button>
					<button class="slider-arrows__button products-slider__button--next" type="button">
						<?php echo shop_co_get_icon( 'arrow_right' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( 'Next products', 'shop-co' ); ?></span>
					</button>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<div class="<?php echo esc_attr( implode( ' ', $shop_co_body_classes ) ); ?>">
		<div class="products-slider">
			<div class="products-slider__swiper swiper">
				<ul class="products-slider__wrapper swiper-wrapper">
					<?php foreach ( $shop_co_products as $shop_co_product ) : ?>
						<?php
						$shop_co_post_object = get_post( $shop_co_product->get_id() );

						setup_postdata( $GLOBALS['post'] = $shop_co_post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

						wc_get_template_part( 'content', 'product' );
						?>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php if ( $shop_co_url ) : ?>
			<a class="site-button site-border site-button--white" href="<?php echo esc_url( $shop_co_url ); ?>">
				<?php esc_html_e( 'View all', 'shop-co' ); ?>
			</a>
		<?php endif; ?>
	</div>
</section>

<?php

wp_reset_postdata();
wc_reset_loop();
remove_filter( 'post_class', $shop_co_add_slide_classes );
