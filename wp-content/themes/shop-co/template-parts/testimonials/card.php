<?php

/**
 * @var array $args
 */

$testimonial = $args['testimonial'] ?? null;

if ( ! ( $testimonial instanceof WP_Post ) ) {
	return;
}

?>

<article class="testimonial-card site-border">
    <?php shop_co_template_rating( 5, 'testimonial-card__rating', false ); ?>
    <h3 class="testimonial-card__name h5">
        <?php echo esc_html( get_the_title( $testimonial ) ); ?>
    </h3>
    <div class="testimonial-card__content opacity-60">
        <?php echo wp_kses_post( apply_filters( 'the_content', $testimonial->post_content ) ); ?>
    </div>
</article>
