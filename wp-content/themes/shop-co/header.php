<?php
/**
 * Site header.
 *
 * @package Shop_Co
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

	<?php if ( shop_co_should_show_ads_banner() ) : ?>
	<div class="ads-banner" id="ads-banner">
		<div class="ads-banner__inner container">
			Sign up and get 20% off to your first order. 
			<a class="ads-banner__link" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) . '?action=register' ); ?>">
				Sign Up Now
			</a>
			<button class="ads-banner__close site-close-button hidden-mobile" type="button">
				<div class="screen-reader-text">Close Ads Banner</div>
			</button>
		</div>
	</div>
	<?php endif; ?>

	<header id="masthead" class="site-header">
		<div class="container site-header__inner">
			<div class="site-branding">
				<?php the_custom_logo(); ?>
				<div>
					<?php if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif; ?>

					<?php
					$shop_co_description = get_bloginfo( 'description', 'display' );
					if ( $shop_co_description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo esc_html( $shop_co_description ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'shop-co' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'header_menu',
						'menu_id'        => 'primary-menu',
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		</div>
	</header>
