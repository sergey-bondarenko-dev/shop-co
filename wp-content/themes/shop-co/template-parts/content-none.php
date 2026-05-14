<?php
/**
 * Empty state template part.
 *
 * @package Shop_Co
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing found', 'shop-co' ); ?></h1>
	</header>

	<div class="page-content">
		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'No results matched your search. Try another query.', 'shop-co' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No content has been published yet.', 'shop-co' ); ?></p>
		<?php endif; ?>
	</div>
</section>
