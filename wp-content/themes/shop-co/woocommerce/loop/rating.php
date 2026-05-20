<?php
/**
 * Loop Rating
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$average_rating = (float) $product->get_average_rating();

if ( $average_rating <= 0.0 && shop_co_use_demo_data() ) {
	$average_rating = (float) get_post_meta( $product->get_id(), '_demo_rating', true );
}

$average_rating = max( 0.0, min( 5.0, $average_rating ) );
$stars_count    = (int) ceil( $average_rating );
$star_icon      = ShopCo_Assets::asset( 'icons/star.svg' );

?>

<span class="site-product-card__rating">
	<span class="site-product-card__rating-stars">
		<?php for ( $i = 0; $i < $stars_count; $i++ ) : ?>
			<?php $star_fill = max( 0.0, min( 1.0, $average_rating - $i ) ) * 100; ?>

			<img
				src="<?php echo esc_url( $star_icon ); ?>"
				class="site-product-card__rating-star"
				alt=""
				width="18.5"
				height="18.5"
				style="--star-fill: <?php echo esc_attr( (string) $star_fill ); ?>%;"
			>
		<?php endfor; ?>
	</span>

	<span class="site-product-card__rating-value">
		<?php echo esc_html( (string) $average_rating ); ?>/<span class="opacity-60">5</span>
	</span>
</span>
