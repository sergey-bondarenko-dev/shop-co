<?php
/**
 * Front page template.
 *
 * @package Shop_Co
 */

get_header();
?>

<main id="primary" class="site-main">

	<div class="hero">
		<div class="hero__inner container">
			<div class="hero__content">
				<h1 class="hero__title">FIND CLOTHES THAT MATCH YOUR STYLE</h1>
				<div class="hero__description opacity-60">Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.</div>
				<a href="#" class="hero__button site-button">Shop Now</a>
				<div class="hero__benefits">
					<div class="hero__benefits-item">
						<div class="hero__benefits-item-value">200+</div>
						<div class="hero__benefits-item-label opacity-60">International Brands</div>
					</div>
					<div class="hero__benefits-item">
						<div class="hero__benefits-item-value">2,000+</div>
						<div class="hero__benefits-item-label opacity-60">High-Quality Products</div>
					</div>
					<div class="hero__benefits-item">
						<div class="hero__benefits-item-value">30,000+</div>
						<div class="hero__benefits-item-label opacity-60">Happy Customers</div>
					</div>
				</div>
			</div>
		</div>
		<div class="hero__decor container">
			<div class="hero__decor-inner">
				<img 
					class="hero__decor-image" 
					src="<?php echo esc_url( ShopCo_Assets::asset( 'images/hero.png' ) ); ?>"
					width="640"
					height="960"
					alt=""
					fetchpriority="high"
					loading="eager"
				>
				<img 
					class="hero__decor-star hero__decor-star--big"
					src="<?php echo esc_url( ShopCo_Assets::asset( '/icons/decor-star.svg' ) ); ?>"
					alt=""
					width="104"
					height="104"
					loading="lazy"
					decoding="async"
				>
				<img 
					class="hero__decor-star"
					src="<?php echo esc_url( ShopCo_Assets::asset( '/icons/decor-star.svg' ) ); ?>"
					alt=""
					width="56"
					height="56"
					loading="lazy"
					decoding="async"
				>
			</div>
		</div>
		<div class="hero__brands">
			<div class="hero__brands-inner container">
				<img src="<?php echo esc_url( ShopCo_Assets::asset( 'images/brands/1.svg' ) ); ?>" width="167" height="33" alt="">
				<img src="<?php echo esc_url( ShopCo_Assets::asset( 'images/brands/2.svg' ) ); ?>" width="91" height="38" alt="">
				<img src="<?php echo esc_url( ShopCo_Assets::asset( 'images/brands/3.svg' ) ); ?>" width="156" height="36" alt="">
				<img src="<?php echo esc_url( ShopCo_Assets::asset( 'images/brands/4.svg' ) ); ?>" width="194" height="32" alt="">
				<img src="<?php echo esc_url( ShopCo_Assets::asset( 'images/brands/5.svg' ) ); ?>" width="207" height="33" alt="">
			</div>
		</div>
	</div>

	<div class="container">
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
