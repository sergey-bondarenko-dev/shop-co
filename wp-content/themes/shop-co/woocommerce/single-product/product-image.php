<?php
/**
 * Single Product Image
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.5.0
 */

use Automattic\WooCommerce\Enums\ProductType;

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$post_thumbnail_id = $product->get_image_id();
$gallery_image_ids = $product->get_gallery_image_ids();
$image_ids         = array_values( array_unique( array_filter( array_merge( array( $post_thumbnail_id ), $gallery_image_ids ) ) ) );
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'site-product-gallery',
		'woocommerce-product-gallery--' . ( ! empty( $image_ids ) ? 'with-images' : 'without-images' ),
		'images',
	)
);
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-gallery-count="<?php echo esc_attr( count( $image_ids ) ); ?>">
	<div class="site-product-gallery__thumbs">
		<div class="site-product-gallery__thumbs-swiper swiper">
			<div class="swiper-wrapper">
				<?php if ( ! empty( $image_ids ) ) : ?>
					<?php foreach ( $image_ids as $index => $image_id ) : ?>
						<button class="site-product-gallery__thumb swiper-slide" type="button" data-gallery-index="<?php echo esc_attr( (string) $index ); ?>">
							<?php
							echo wp_get_attachment_image(
								$image_id,
								'woocommerce_thumbnail',
								false,
								array(
									'class' => 'site-product-gallery__thumb-image',
									'alt'   => trim( wp_strip_all_tags( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) ),
								)
							);
							?>
						</button>
					<?php endforeach; ?>
				<?php else : ?>
					<button class="site-product-gallery__thumb swiper-slide is-active" type="button" data-gallery-index="0">
						<img src="<?php echo esc_url( wc_placeholder_img_src( 'woocommerce_thumbnail' ) ); ?>" alt="<?php esc_attr_e( 'Awaiting product image', 'woocommerce' ); ?>" class="site-product-gallery__thumb-image">
					</button>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( count( $image_ids ) > 3 ) : ?>
			<div class="site-product-gallery__nav" aria-hidden="false">
				<button class="site-product-gallery__button site-product-gallery__button--prev site-button site-button--square" type="button" aria-label="<?php esc_attr_e( 'Previous product image', 'woocommerce' ); ?>">
					<span></span>
				</button>
				<button class="site-product-gallery__button site-product-gallery__button--next site-button site-button--square" type="button" aria-label="<?php esc_attr_e( 'Next product image', 'woocommerce' ); ?>">
					<span></span>
				</button>
			</div>
		<?php endif; ?>
	</div>

	<div class="woocommerce-product-gallery__wrapper site-product-gallery__main swiper">
		<div class="swiper-wrapper">
			<?php if ( ! empty( $image_ids ) ) : ?>
				<?php foreach ( $image_ids as $index => $image_id ) : ?>
					<?php
					$full_image = wp_get_attachment_image_src( $image_id, 'full' );
					$image_alt  = trim( wp_strip_all_tags( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) );
					?>
					<div class="woocommerce-product-gallery__image site-product-gallery__slide swiper-slide" data-gallery-index="<?php echo esc_attr( (string) $index ); ?>">
						<a href="<?php echo esc_url( $full_image[0] ?? '' ); ?>" data-fslightbox="product-gallery">
							<?php
							echo wp_get_attachment_image(
								$image_id,
								'woocommerce_single',
								false,
								array(
									'class' => 0 === $index ? 'wp-post-image site-product-gallery__image' : 'site-product-gallery__image',
									'alt'   => $image_alt,
								)
							);
							?>
						</a>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<?php
				$wrapper_classname = $product->is_type( ProductType::VARIABLE ) && ! empty( $product->get_visible_children() ) && '' !== $product->get_price() ?
					'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder site-product-gallery__slide swiper-slide' :
					'woocommerce-product-gallery__image--placeholder site-product-gallery__slide swiper-slide';
				?>
				<div class="<?php echo esc_attr( $wrapper_classname ); ?>" data-gallery-index="0">
					<img src="<?php echo esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ); ?>" alt="<?php esc_attr_e( 'Awaiting product image', 'woocommerce' ); ?>" class="wp-post-image site-product-gallery__image">
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
