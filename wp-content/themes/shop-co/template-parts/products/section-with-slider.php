<?php

/**
 * @var array $args
 */

/** @var string $title */
$title = $args['title'] ?? '';
/** @var WC_Product[] $products */
$products = $args['products'] ?? array();

$products = array_filter(
	$products,
	static fn ( $product ): bool => $product instanceof WC_Product
);

if ( empty( $products ) ) {
	return;
}

$product_ids = array_map(
	static fn ( WC_Product $product ): int => $product->get_id(),
	$products
);

_prime_post_caches( $product_ids );

$add_slide_classes = static function ( array $classes ): array {
	$classes[] = 'products-slider__slide';
	$classes[] = 'swiper-slide';

	return $classes;
};

wc_set_loop_prop( 'name', 'products-slider' );
add_filter( 'post_class', $add_slide_classes );

?>

<section class="section products-section overflow-hidden">
	<div class="section__header container">
		<h2 class="section__title text-center">
			<?php echo esc_html( $title ); ?>
		</h2>
	</div>
	<div class="section__body container">
		<div class="products-slider">
			<div class="products-slider__swiper swiper">
				<ul class="products-slider__wrapper swiper-wrapper">
					<?php foreach ( $products as $product ) : ?>
						<?php
						$post_object = get_post( $product->get_id() );

						setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

						wc_get_template_part( 'content', 'product' );
						?>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<a class="site-button site-border site-button--white" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
			<?php esc_html_e( 'View all', 'shop-co' ); ?>
		</a>
	</div>
</section>

<?php

wp_reset_postdata();
wc_reset_loop();
remove_filter( 'post_class', $add_slide_classes );
