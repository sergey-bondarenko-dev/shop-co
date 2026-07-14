<?php
/**
 * FAQs tab
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product || ! function_exists( 'shop_co_core_get_product_faqs' ) ) {
	return;
}

$faqs = shop_co_core_get_product_faqs( $product->get_id() );

if ( ! $faqs ) {
	return;
}

$accordion_id = 'product-faqs-' . $product->get_id();
?>

<div class="accordion site-accordion" id="<?php echo esc_attr( $accordion_id ); ?>">
	<?php foreach ( $faqs as $index => $faq ) : ?>
		<?php
		$heading_id = $accordion_id . '-heading-' . $index;
		$content_id = $accordion_id . '-content-' . $index;
		$is_first   = 0 === $index;
		?>
		<div class="accordion-item">
			<h2 class="accordion-header" id="<?php echo esc_attr( $heading_id ); ?>">
				<button
					class="accordion-button<?php echo $is_first ? '' : ' collapsed'; ?>"
					type="button"
					data-bs-toggle="collapse"
					data-bs-target="#<?php echo esc_attr( $content_id ); ?>"
					aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
					aria-controls="<?php echo esc_attr( $content_id ); ?>">
					<?php echo esc_html( $faq['question'] ); ?>
				</button>
			</h2>
			<div
				id="<?php echo esc_attr( $content_id ); ?>"
				class="accordion-collapse collapse<?php echo $is_first ? ' show' : ''; ?>"
				aria-labelledby="<?php echo esc_attr( $heading_id ); ?>"
				data-bs-parent="#<?php echo esc_attr( $accordion_id ); ?>">
				<div class="accordion-body">
					<?php echo wp_kses_post( $faq['answer'] ); ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
