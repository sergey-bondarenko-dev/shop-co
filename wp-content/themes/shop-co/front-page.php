<?php
/**
 * Front page template.
 *
 * @package Shop_Co
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">

		<div class="" style="margin-block: 2rem;">
			<button class="site-button">Button</button>
			<a href="#" class="site-button">Link Button</a>

			<button class="site-button site-button--white site-button--border">Button</button>
			<a href="#" class="site-button site-button--white site-button--border">Link Button</a>

			<button class="site-button site-button--white">Button</button>
			<a href="#" class="site-button site-button--white">Link Button</a>

			<button class="site-button site-button--small">Button</button>
			<a href="#" class="site-button site-button--small">Link Button</a>

			<button class="site-button site-button--square">
				<?php echo ShopCo_Icons::settings(); ?>
			</button>
			<a href="#" class="site-button site-button--square">
				<?php echo ShopCo_Icons::settings(); ?>
			</a>
			
			<button class="site-button site-button--square" disabled>
				<?php echo ShopCo_Icons::settings(); ?>
			</button>

			<?php echo ShopCo_UI::field(
				'search',
				'search',
				'Search for products...',
			); ?>

			<div style="background-color: black; padding: 1rem;">
				<?php echo ShopCo_UI::field(
					'search',
					'email',
					'Enter your email address',
					'',
					'white'
				); ?>
			</div>
		</div>

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'page' );
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
