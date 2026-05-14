<?php
/**
 * 404 template.
 *
 * @package Shop_Co
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="container error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Page not found', 'shop-co' ); ?></h1>
		</header>

		<div class="page-content">
			<p><?php esc_html_e( 'The page you requested could not be found. Try search or return to the homepage.', 'shop-co' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</section>
</main>

<?php
get_footer();
