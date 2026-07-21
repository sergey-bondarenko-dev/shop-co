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
	<?php
	$shop_co_account_url  = shop_co_get_woocommerce_page_url( 'myaccount', wp_login_url() );
	$shop_co_register_url = add_query_arg( 'action', 'register', $shop_co_account_url );
	?>

	<?php if ( shop_co_should_show_ads_banner() ) : ?>
	<div class="ads-banner" id="ads-banner">
		<div class="ads-banner__inner container">
			Sign up and get 20% off to your first order. 
			<a class="ads-banner__link" href="<?php echo esc_url( $shop_co_register_url ); ?>">
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
			<button class="site-header__burger-button site-button site-button--square site-button--white visible-tablet"
				type="button"
				data-bs-toggle="offcanvas"
				data-bs-target="#offcanvas-header-navigation"
				aria-controls="offcanvas-header-navigation">
				<?php echo shop_co_get_icon( 'list' ); ?>
			</button>
			<?php shop_co_logo( 'site-header__logo' ); ?>
			<div class="offcanvas-xl offcanvas-start"
				tabindex="-1" 
				id="offcanvas-header-navigation" 
				aria-labelledby="offcanvas-header-navigation-label"
				>
				<div class="offcanvas-header">
					<div class="offcanvas-title" id="offcanvas-header-navigation-label">Navigation Menu</div>
					<button
						type="button" 
						class="btn-close" 
						data-bs-dismiss="offcanvas" 
						data-bs-target="#offcanvas-header-navigation" 
						aria-label="Close">
					</button>
				</div>
				<div class="offcanvas-body">
					<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'header_menu',
							'depth'           => 2,
							'container'       => 'nav',
							'container_class' => 'site-header__navigation site-navigation',
							'container_id'    => 'site-navigation',
							'menu_class'      => 'site-navigation__list',
							'fallback_cb'     => false,
							'walker'          => new Shop_Co_Header_Nav_Walker(),
						)
					);
					?>
				</div>
			</div>
			<div class="site-header__search-wrapper collapse" id="search-field">
				<form
					role="search"
					method="get"
					class="site-header__search site-field"
					action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="header-search">
						<?php esc_html_e( 'Search for:', 'shop-co' ); ?>
					</label>
					<input
						type="search"
						class="site-field__input"
						id="header-search"
						name="s"
						value="<?php echo esc_attr( get_search_query() ); ?>"
						required
						placeholder="<?php echo esc_attr_x( 'Search for products...', 'placeholder', 'shop-co' ); ?>"
					/>
					<input type="hidden" name="post_type" value="product">
					<button
						type="submit"
						class="site-header__search-submit site-field__icon"
						aria-label="<?php esc_attr_e( 'Search', 'shop-co' ); ?>">
						<?php echo shop_co_get_icon( 'search' ); ?>
					</button>
				</form>
			</div>
			<div class="site-header__actions">
				<button class="site-button site-button--square site-button--white visible-mobile"
					type="button"
					data-bs-toggle="collapse" 
					data-bs-target="#search-field" 
					aria-expanded="false" 
					aria-controls="search-field">
					<?php echo shop_co_get_icon( 'search' ); ?>
				</button>
				<button
					type="button"
					class="site-header-cart__button site-button site-button--square site-button--white"
					data-bs-toggle="offcanvas"
					data-bs-target="#site-mini-cart"
					aria-controls="site-mini-cart"
					aria-label="<?php esc_attr_e( 'Open cart', 'shop-co' ); ?>">
					<?php echo shop_co_get_icon( 'cart' ); ?>
					<?php echo shop_co_get_header_cart_count_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
				<a href="<?php echo esc_url( $shop_co_account_url ); ?>" 
					class="site-button site-button--square site-button--white"
					aria-label="<?php esc_attr_e( 'My account', 'shop-co' ); ?>">
					<?php echo shop_co_get_icon( 'user' ); ?>
				</a>
			</div>
		</div>

		<div
			class="site-mini-cart offcanvas offcanvas-end"
			tabindex="-1"
			id="site-mini-cart"
			aria-labelledby="site-mini-cart-label">
			<div class="offcanvas-header">
				<h2 class="offcanvas-title h4" id="site-mini-cart-label">
					<?php esc_html_e( 'Your cart', 'shop-co' ); ?>
				</h2>
				<button
					type="button"
					class="btn-close"
					data-bs-dismiss="offcanvas"
					aria-label="<?php esc_attr_e( 'Close', 'shop-co' ); ?>">
				</button>
			</div>
			<div class="offcanvas-body">
				<div class="widget_shopping_cart_content">
					<?php woocommerce_mini_cart(); ?>
				</div>
			</div>
		</div>
		
	</header>
	<?php if ( ! is_front_page() ) : ?>
		<hr class="site-border container" style="margin-block: 0;">
	<?php endif; ?>
