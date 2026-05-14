<?php
/**
 * Page content template part.
 *
 * @package Shop_Co
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shop-co' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<?php edit_post_link( esc_html__( 'Edit', 'shop-co' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
</article>
