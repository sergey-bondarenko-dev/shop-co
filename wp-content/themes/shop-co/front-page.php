<?php
/**
 * Front page template.
 *
 * @package Shop_Co
 */

get_header();

$shop_co_hero = function_exists( 'shop_co_core_get_home_hero' )
	? shop_co_core_get_home_hero()
	: array();

$shop_co_hero_title = ! empty( $shop_co_hero['title'] )
	? $shop_co_hero['title']
	: __( 'FIND CLOTHES THAT MATCH YOUR STYLE', 'shop-co' );

$shop_co_hero_description = ! empty( $shop_co_hero['description'] )
	? $shop_co_hero['description']
	: __( 'Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.', 'shop-co' );

$shop_co_hero_button_text = ! empty( $shop_co_hero['button_text'] )
	? $shop_co_hero['button_text']
	: __( 'Shop Now', 'shop-co' );

$shop_co_shop_link       = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '';
$shop_co_hero_button_url = ! empty( $shop_co_hero['button_url'] ) ? $shop_co_hero['button_url'] : $shop_co_shop_link;
$shop_co_hero_image_id   = ! empty( $shop_co_hero['image_id'] ) ? (int) $shop_co_hero['image_id'] : 0;

$shop_co_hero_benefits = ! empty( $shop_co_hero['benefits'] )
	? $shop_co_hero['benefits']
	: array(
		array(
			'amount' => '200+',
			'label'  => __( 'International Brands', 'shop-co' ),
		),
		array(
			'amount' => '2,000+',
			'label'  => __( 'High-Quality Products', 'shop-co' ),
		),
		array(
			'amount' => '30,000+',
			'label'  => __( 'Happy Customers', 'shop-co' ),
		),
	);

$shop_co_hero_brands = ! empty( $shop_co_hero['brands'] )
	? $shop_co_hero['brands']
	: array(
		array(
			'src'    => Shop_Co_Assets::asset( 'images/brands/1.svg' ),
			'width'  => 167,
			'height' => 33,
		),
		array(
			'src'    => Shop_Co_Assets::asset( 'images/brands/2.svg' ),
			'width'  => 91,
			'height' => 38,
		),
		array(
			'src'    => Shop_Co_Assets::asset( 'images/brands/3.svg' ),
			'width'  => 156,
			'height' => 36,
		),
		array(
			'src'    => Shop_Co_Assets::asset( 'images/brands/4.svg' ),
			'width'  => 194,
			'height' => 32,
		),
		array(
			'src'    => Shop_Co_Assets::asset( 'images/brands/5.svg' ),
			'width'  => 207,
			'height' => 33,
		),
	);

?>

<main id="primary" class="site-main section-list">

	<div class="hero">
		<div class="hero__inner container">
			<div class="hero__content">
				<h1 class="hero__title"><?php echo esc_html( $shop_co_hero_title ); ?></h1>
				<div class="hero__description opacity-60"><?php echo esc_html( $shop_co_hero_description ); ?></div>
				<?php if ( $shop_co_hero_button_url ) : ?>
				<a href="<?php echo esc_url( $shop_co_hero_button_url ); ?>" class="hero__button site-button"><?php echo esc_html( $shop_co_hero_button_text ); ?></a>
				<?php endif; ?>
				<div class="hero__benefits">
					<?php foreach ( $shop_co_hero_benefits as $shop_co_hero_benefit ) : ?>
						<div class="hero__benefits-item">
							<div class="hero__benefits-item-value"><?php echo esc_html( $shop_co_hero_benefit['amount'] ); ?></div>
							<div class="hero__benefits-item-label opacity-60"><?php echo esc_html( $shop_co_hero_benefit['label'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="hero__decor container">
			<div class="hero__decor-inner">
				<?php if ( $shop_co_hero_image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$shop_co_hero_image_id,
						'full',
						false,
						array(
							'class'         => 'hero__decor-image',
							'fetchpriority' => 'high',
							'loading'       => 'eager',
						)
					);
					?>
				<?php else : ?>
				<img 
					class="hero__decor-image" 
					src="<?php echo esc_url( Shop_Co_Assets::asset( 'images/hero.png' ) ); ?>"
					width="640"
					height="960"
					alt=""
					fetchpriority="high"
					loading="eager"
				>
				<?php endif; ?>
				<img 
					class="hero__decor-star hero__decor-star--big"
					src="<?php echo esc_url( Shop_Co_Assets::asset( '/icons/decor-star.svg' ) ); ?>"
					alt=""
					width="104"
					height="104"
					loading="lazy"
					decoding="async"
				>
				<img 
					class="hero__decor-star"
					src="<?php echo esc_url( Shop_Co_Assets::asset( '/icons/decor-star.svg' ) ); ?>"
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
				<?php foreach ( $shop_co_hero_brands as $shop_co_hero_brand ) : ?>
					<?php if ( ! empty( $shop_co_hero_brand['url'] ) ) : ?>
						<a href="<?php echo esc_url( $shop_co_hero_brand['url'] ); ?>">
					<?php endif; ?>

					<?php
					if ( ! empty( $shop_co_hero_brand['image'] ) ) {
						$shop_co_brand_image_attributes = array();

						if ( ! empty( $shop_co_hero_brand['alt'] ) ) {
							$shop_co_brand_image_attributes['alt'] = $shop_co_hero_brand['alt'];
						}

						echo wp_get_attachment_image(
							(int) $shop_co_hero_brand['image'],
							'full',
							false,
							$shop_co_brand_image_attributes
						);
					} else {
						?>
						<img
							src="<?php echo esc_url( $shop_co_hero_brand['src'] ); ?>"
							width="<?php echo esc_attr( $shop_co_hero_brand['width'] ); ?>"
							height="<?php echo esc_attr( $shop_co_hero_brand['height'] ); ?>"
							alt=""
						>
						<?php
					}
					?>

					<?php if ( ! empty( $shop_co_hero_brand['url'] ) ) : ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	
	<?php shop_co_get_template_part( 'products/new-arrivals' ); ?>
	<?php shop_co_get_template_part( 'products/top-selling' ); ?>
	<?php shop_co_get_template_part( 'products/categories-section' ); ?>
	<?php shop_co_get_template_part( 'testimonials/section' ); ?>
</main>

<?php
get_footer();
