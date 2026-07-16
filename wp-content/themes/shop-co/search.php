<?php
/**
 * Search results template.
 *
 * @package Shop_Co
 */

get_header();
?>

<main id="primary" class="site-main site-search">
	<div class="container site-search__container">
		<header class="site-search__header">
			<h1 class="site-search__title h2">
				<?php esc_html_e( 'Search results for:', 'shop-co' ); ?>
				<span><?php echo esc_html( get_search_query() ); ?></span>
			</h1>

			<?php get_search_form(); ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="site-search__grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'search' );
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => esc_html__( 'Previous', 'shop-co' ),
					'next_text' => esc_html__( 'Next', 'shop-co' ),
				)
			);
			?>
		<?php else : ?>
			<section class="site-search__empty">
				<span class="site-search__empty-icon" aria-hidden="true">
					<?php echo ShopCo_Icons::search(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
				<h2><?php esc_html_e( 'Nothing found', 'shop-co' ); ?></h2>
				<p><?php esc_html_e( 'Try changing your search query or using fewer words.', 'shop-co' ); ?></p>
			</section>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
