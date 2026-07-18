<?php
/**
 * Testimonial card template.
 *
 * @package Shop_Co
 */

/**
 * Template arguments passed to the testimonial card.
 *
 * @var array $args Template arguments.
 */

$shop_co_testimonial = $args['testimonial'] ?? null;

if ( ! ( $shop_co_testimonial instanceof WP_Post ) ) {
	return;
}

?>

<article class="testimonial-card site-border">
	<?php shop_co_template_rating( 5, 'testimonial-card__rating', false ); ?>
	<h3 class="testimonial-card__name h5 is-verified">
		<?php echo esc_html( get_the_title( $shop_co_testimonial ) ); ?>
	</h3>
	<div class="testimonial-card__content opacity-60">
		<?php // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Applying the core WordPress content filter. ?>
		<?php echo wp_kses_post( apply_filters( 'the_content', $shop_co_testimonial->post_content ) ); ?>
	</div>
</article>
