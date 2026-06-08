<?php
/**
 * Site footer.
 *
 * @package Shop_Co
 */

?>
	<footer class="site-footer section-margin-top overflow-hidden">
		<div class="site-footer__inner">
			<div class="site-footer__banner">
				<div class="site-footer__banner-container container">
					<div class="site-footer__banner-inner">
						<div class="site-footer__banner-title h3">
							STAY UPTO DATE ABOUT OUR LATEST OFFERS
						</div>
						<form action="#" class="site-footer__banner-form">
							<?php echo ShopCo_UI::field(
								'mail',
								'email',
								'Enter your email address',
								'',
								'white',
							); ?>
							<button type="submit" class="site-footer__banner-submit site-button site-button--white">
								Subscribe to Newsletter
							</button>
						</form>
					</div>
				</div>
			</div>
			<div class="site-footer__body container">
				<div class="site-footer__body-top">
					<div class="site-footer__body-info">
						<?php shop_co_logo( 'site-footer__logo' ); ?>
						<p class="opacity-60">We have clothes that suits your style and which you’re proud to wear. From women to men.</p>
						<div class="site-footer__soc1als">
							<a class="site-footer__soc1als-link site-border" href="#" aria-label="<?php esc_attr_e( 'Twitter', 'shop-co' ); ?>">
								<img src="<?php echo esc_url( ShopCo_Assets::asset( 'icons/socials/twitter.svg' ) ); ?>" width="11" height="9" alt="">
							</a>
							<a class="site-footer__soc1als-link site-border" href="#" aria-label="<?php esc_attr_e( 'Facebook', 'shop-co' ); ?>">
								<img src="<?php echo esc_url( ShopCo_Assets::asset( 'icons/socials/fb.svg' ) ); ?>" width="6" height="12" alt="">
							</a>
							<a class="site-footer__soc1als-link site-border" href="#" aria-label="<?php esc_attr_e( 'Instagram', 'shop-co' ); ?>">
								<img src="<?php echo esc_url( ShopCo_Assets::asset( 'icons/socials/insta.svg' ) ); ?>" width="14" height="14" alt="">
							</a>
							<a class="site-footer__soc1als-link site-border" href="#" aria-label="<?php esc_attr_e( 'GitHub', 'shop-co' ); ?>">
								<img src="<?php echo esc_url( ShopCo_Assets::asset( 'icons/socials/gh.svg' ) ); ?>" width="13" height="13" alt="">
							</a>
						</div>
					</div>
					<nav class="site-footer__body-nav">
						<?php
						$footer_menus = array(
							'footer_company_menu'   => esc_html__( 'Company', 'shop-co' ),
							'footer_help_menu'      => esc_html__( 'Help', 'shop-co' ),
							'footer_faq_menu'       => esc_html__( 'FAQ', 'shop-co' ),
							'footer_resources_menu' => esc_html__( 'Resources', 'shop-co' ),
						);

						foreach ( $footer_menus as $theme_location => $menu_title ) :
							if ( ! has_nav_menu( $theme_location ) ) {
								continue;
							}
							?>
							<div class="site-footer__menu-column">
								<h2 class="site-footer__menu-title"><?php echo esc_html( $menu_title ); ?></h2>
								<?php
								wp_nav_menu(
									array(
										'theme_location' => $theme_location,
										'container'      => false,
										'menu_class'     => 'site-footer__menu',
										'fallback_cb'    => false,
										'depth'          => 1,
									)
								);
								?>
							</div>
						<?php endforeach; ?>
					</nav>
				</div>
				<hr class="site-footer__hr site-border">
				<div class="site-footer__body-bottom">
					<p class="site-footer__copyright opacity-60">
						<?php
						printf(
							esc_html__( 'Shop.co © 2000-%s, All Rights Reserved', 'shop-co' ),
							esc_html( gmdate( 'Y' ) )
						);
						?>
					</p>
					<div class="site-footer__pays pays">
						<div class="pays__badge">
							<img src="<?php echo esc_url( ShopCo_Assets::asset( 'icons/pays/visa.svg' ) ); ?>" alt="" width="32.5" height="11.5" >
						</div>
						<div class="pays__badge">
							<img src="<?php echo esc_url( ShopCo_Assets::asset( 'icons/pays/mastercard.svg' ) ); ?>" alt="" width="25.3" height="15.7" >
						</div>
						<div class="pays__badge">
							<img src="<?php echo esc_url( ShopCo_Assets::asset( 'icons/pays/paypal.svg' ) ); ?>" alt="" width="34.5" height="9.2" >
						</div>
						<div class="pays__badge">
							<img src="<?php echo esc_url( ShopCo_Assets::asset( 'icons/pays/apple-pay.svg' ) ); ?>" alt="" width="26.4" height="11.2" >
						</div>
						<div class="pays__badge">
							<img src="<?php echo esc_url( ShopCo_Assets::asset( 'icons/pays/g-pay.svg' ) ); ?>" alt="" width="28.5" height="11.2" >
						</div>
					</div>
				</div>
			</div>
		</div>

	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
