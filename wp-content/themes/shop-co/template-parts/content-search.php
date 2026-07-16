<?php
/**
 * Template part for a search result card.
 *
 * @package Shop_Co
 */

$post_type_object = get_post_type_object( get_post_type() );
$post_type_label  = $post_type_object ? $post_type_object->labels->singular_name : __( 'Content', 'shop-co' );
$excerpt          = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 22 );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'site-search-card' ); ?>>
	<a class="site-search-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium_large', array( 'class' => 'site-search-card__image' ) ); ?>
		<?php else : ?>
			<span class="site-search-card__placeholder">
				<?php echo ShopCo_Icons::search(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
		<?php endif; ?>
	</a>

	<div class="site-search-card__content">
		<span class="site-search-card__type"><?php echo esc_html( $post_type_label ); ?></span>
		<h2 class="site-search-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<?php if ( $excerpt ) : ?>
			<p class="site-search-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
		<?php endif; ?>

		<a class="site-search-card__link" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'View result', 'shop-co' ); ?>
		</a>
	</div>
</article>
