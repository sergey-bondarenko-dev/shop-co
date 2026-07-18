<?php
/**
 * Template helper functions.
 *
 * @package Shop_Co
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load a template part from the theme template-parts directory.
 *
 * @param string      $slug Template part slug.
 * @param array       $args Variables passed to the template part.
 * @param string|null $name Optional specialized template name.
 */
function shop_co_get_template_part( string $slug, array $args = array(), ?string $name = null ): void {
	get_template_part( 'template-parts/' . ltrim( $slug, '/' ), $name, $args );
}

/**
 * Print site logo with a text fallback.
 *
 * @param string $classes Additional logo CSS classes.
 */
function shop_co_logo( string $classes = '' ): void {
	shop_co_get_template_part(
		'global/logo',
		array(
			'class' => $classes,
		)
	);
}

/**
 * Determine whether WooCommerce is active.
 *
 * @return bool Whether WooCommerce functions are available.
 */
function shop_co_is_woocommerce_active(): bool {
	return function_exists( 'wc_get_products' );
}

/**
 * Return a WooCommerce page URL with a fallback.
 *
 * @param string $page         WooCommerce page key.
 * @param string $fallback_url URL used when the WooCommerce page is unavailable.
 * @return string Resolved page URL.
 */
function shop_co_get_woocommerce_page_url( string $page, string $fallback_url = '' ): string {
	if ( 'cart' === $page && function_exists( 'wc_get_cart_url' ) ) {
		return wc_get_cart_url();
	}

	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$page_url = wc_get_page_permalink( $page );

		if ( $page_url ) {
			return $page_url;
		}
	}

	return $fallback_url ? $fallback_url : home_url( '/' );
}

/**
 * Determine whether the theme core plugin is active.
 *
 * @return bool Whether the plugin API is available.
 */
function shop_co_is_core_plugin_active(): bool {
	return function_exists( 'shop_co_get_testimonials' );
}

/**
 * Determine whether the visitor closed the advertisement banner.
 *
 * @return bool Whether the banner is closed.
 */
function shop_co_is_ads_banner_closed(): bool {
	if ( ! isset( $_COOKIE['shop_co_ads_banner_closed'] ) ) {
		return false;
	}

	return 'yes' === sanitize_text_field( wp_unslash( $_COOKIE['shop_co_ads_banner_closed'] ) );
}

/**
 * Determine whether the advertisement banner should be shown.
 *
 * @return bool Whether the banner should be displayed.
 */
function shop_co_should_show_ads_banner(): bool {
	return ! is_user_logged_in() && ! shop_co_is_ads_banner_closed();
}

/**
 * Return the previous-page pagination label.
 */
function shop_co_get_pagination_previous_text(): string {
	return sprintf(
		'<span class="site-pagination__icon" aria-hidden="true">%1$s</span><span class="site-pagination__label">%2$s</span>',
		shop_co_get_icon( 'arrow_left' ),
		esc_html__( 'Previous', 'shop-co' )
	);
}

/**
 * Return the next-page pagination label.
 */
function shop_co_get_pagination_next_text(): string {
	return sprintf(
		'<span class="site-pagination__label">%1$s</span><span class="site-pagination__icon" aria-hidden="true">%2$s</span>',
		esc_html__( 'Next', 'shop-co' ),
		shop_co_get_icon( 'arrow_right' )
	);
}

/**
 * Print a capability-gated administrative notice section.
 *
 * @param string $message    Notice message.
 * @param string $capability Capability required to view the notice.
 */
function shop_co_admin_notice_section( string $message, string $capability = 'edit_posts' ): void {
	if ( ! current_user_can( $capability ) ) {
		return;
	}
	?>
	<section class="section">
		<div class="container">
			<p><?php echo esc_html( $message ); ?></p>
		</div>
	</section>
	<?php
}

/**
 * Print the post publish date.
 */
function shop_co_posted_on(): void {
	printf(
		'<span class="posted-on">%s <a href="%s" rel="bookmark"><time class="entry-date published" datetime="%s">%s</time></a></span>',
		esc_html__( 'Posted on', 'shop-co' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);
}

/**
 * Print the post author link.
 */
function shop_co_posted_by(): void {
	printf(
		'<span class="byline"> %s <span class="author vcard"><a class="url fn n" href="%s">%s</a></span></span>',
		esc_html__( 'by', 'shop-co' ),
		esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
}

/**
 * Print entry footer metadata.
 */
function shop_co_entry_footer(): void {
	$categories = get_the_category_list( esc_html__( ', ', 'shop-co' ) );
	if ( $categories ) {
		printf( '<span class="cat-links">%s %s</span>', esc_html__( 'Categories:', 'shop-co' ), wp_kses_post( $categories ) );
	}

	$tags = get_the_tag_list( '', esc_html__( ', ', 'shop-co' ) );
	if ( $tags ) {
		printf( '<span class="tags-links"> %s %s</span>', esc_html__( 'Tags:', 'shop-co' ), wp_kses_post( $tags ) );
	}

	edit_post_link(
		esc_html__( 'Edit', 'shop-co' ),
		'<span class="edit-link"> ',
		'</span>'
	);
}

/**
 * Print product rating markup.
 *
 * @param WC_Product $product       Product object.
 * @param string     $wrapper_class Additional wrapper CSS class.
 */
function shop_co_product_rating_html( WC_Product $product, string $wrapper_class = '' ): void {
	$average_rating = (float) $product->get_average_rating();

	if ( $average_rating <= 0.0 && shop_co_use_demo_data() ) {
		$average_rating = (float) get_post_meta( $product->get_id(), '_demo_rating', true );
	}

	$average_rating = max( 0.0, min( 5.0, $average_rating ) );

	shop_co_template_rating( $average_rating, $wrapper_class );
}
