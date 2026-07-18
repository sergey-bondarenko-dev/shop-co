<?php
/**
 * Product categories section template.
 *
 * @package Shop_Co
 */

if ( ! shop_co_is_woocommerce_active() ) {
	shop_co_admin_notice_section( __( 'Activate WooCommerce to show product categories.', 'shop-co' ), 'activate_plugins' );
	return;
}

$shop_co_slugs = array( 'casual', 'formal', 'party', 'gym' );

$shop_co_categories = get_terms(
	array(
		'taxonomy'   => 'product_cat',
		'slug'       => $shop_co_slugs,
		'hide_empty' => false,
	)
);

if ( is_wp_error( $shop_co_categories ) || empty( $shop_co_categories ) ) {
	return;
}

$shop_co_categories_by_slug = array();

foreach ( $shop_co_categories as $shop_co_category ) {
	$shop_co_categories_by_slug[ $shop_co_category->slug ] = $shop_co_category;
}

$shop_co_ordered_categories = array();

foreach ( $shop_co_slugs as $shop_co_slug ) {
	if ( isset( $shop_co_categories_by_slug[ $shop_co_slug ] ) ) {
		$shop_co_ordered_categories[] = $shop_co_categories_by_slug[ $shop_co_slug ];
	}
}

?>

<div class="container">
	<section class="section section--box">
		<div class="section__header">
			<h2 class="section__title text-center">
				<?php esc_html_e( 'Browse by dress style', 'shop-co' ); ?>
			</h2>
		</div>
		<div class="section__body">
			<div class="categories-grid">
				<?php
				foreach ( $shop_co_ordered_categories as $shop_co_category ) :
					$shop_co_category_link = get_term_link( $shop_co_category );
					$shop_co_thumbnail_id  = get_term_meta( $shop_co_category->term_id, 'thumbnail_id', true );
					$shop_co_slug          = $shop_co_category->slug;
					?>
					<a 
						class="categories-grid__link <?php echo esc_attr( $shop_co_slug ); ?>"
						href="<?php echo esc_url( $shop_co_category_link ); ?>">
						<?php
						echo wp_get_attachment_image(
							$shop_co_thumbnail_id,
							'large',
							false,
							array( 'class' => 'categories-grid__image' )
						);
						?>

						<h3 class="categories-grid__title"><?php echo esc_html( $shop_co_category->name ); ?></h3>
					</a>
				<?php endforeach; ?>
			</div>

		</div>
	</section>
</div>
