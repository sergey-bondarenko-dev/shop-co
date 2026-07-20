<?php
/**
 * Template Name: Brands
 *
 * Product brands index page.
 *
 * @package Shop_Co
 */

get_header();

$shop_co_brands = array();

if ( taxonomy_exists( 'product_brand' ) ) {
	$shop_co_brands = get_terms(
		array(
			'taxonomy'   => 'product_brand',
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);
}

if ( is_wp_error( $shop_co_brands ) ) {
	$shop_co_brands = array();
}

?>

<main id="primary" class="site-main brands-page">
	<div class="container">
		<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) : ?>
			<?php woocommerce_breadcrumb(); ?>
		<?php endif; ?>

		<section class="section">
			<header class="section__header">
				<h1 class="section__title"><?php the_title(); ?></h1>
			</header>

			<div class="section__body">
				<?php if ( $shop_co_brands ) : ?>
					<ul class="brands-grid">
						<?php foreach ( $shop_co_brands as $shop_co_brand ) : ?>
							<?php
							$shop_co_brand_url = get_term_link( $shop_co_brand );

							if ( is_wp_error( $shop_co_brand_url ) ) {
								continue;
							}

							$shop_co_brand_thumbnail_id = (int) get_term_meta( $shop_co_brand->term_id, 'thumbnail_id', true );
							?>
							<li class="brands-grid__item">
								<a class="brands-grid__link" href="<?php echo esc_url( $shop_co_brand_url ); ?>">
									<div class="brands-grid__media">
										<?php if ( $shop_co_brand_thumbnail_id ) : ?>
											<?php
											echo wp_get_attachment_image(
												$shop_co_brand_thumbnail_id,
												'medium',
												false,
												array(
													'class' => 'brands-grid__image',
													'alt' => $shop_co_brand->name,
												)
											);
											?>
										<?php else : ?>
											<span class="brands-grid__placeholder" aria-hidden="true">
												<?php echo esc_html( mb_substr( $shop_co_brand->name, 0, 1 ) ); ?>
											</span>
										<?php endif; ?>
									</div>

									<h2 class="brands-grid__title"><?php echo esc_html( $shop_co_brand->name ); ?></h2>
									<span class="brands-grid__count opacity-60">
										<?php
										printf(
											/* translators: %s: number of products assigned to a brand. */
											esc_html( _n( '%s product', '%s products', $shop_co_brand->count, 'shop-co' ) ),
											esc_html( number_format_i18n( $shop_co_brand->count ) )
										);
										?>
									</span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else : ?>
					<p><?php esc_html_e( 'No brands have been added yet.', 'shop-co' ); ?></p>
				<?php endif; ?>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
