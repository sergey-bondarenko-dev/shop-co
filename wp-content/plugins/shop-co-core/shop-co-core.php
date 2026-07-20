<?php
/**
 * Plugin Name: Shop Co Core
 * Description: Content types and core data structures for the Shop Co site.
 * Version: 0.2.0
 * Author: Shop Co
 * Text Domain: shop-co-core
 *
 * @package Shop_Co_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require __DIR__ . '/inc/class-shop-co-core-testimonials.php';
require __DIR__ . '/inc/testimonial-functions.php';

Shop_Co_Core_Testimonials::init();

$shop_co_core_autoloader = __DIR__ . '/vendor/autoload.php';

if ( is_readable( $shop_co_core_autoloader ) ) {
	require_once $shop_co_core_autoloader;

	add_action(
		'after_setup_theme',
		static function (): void {
			\Carbon_Fields\Carbon_Fields::boot();
		}
	);

	require __DIR__ . '/inc/class-shop-co-core-product-faqs.php';
	require __DIR__ . '/inc/product-faq-functions.php';
	require __DIR__ . '/inc/class-shop-co-core-home-hero.php';
	require __DIR__ . '/inc/home-hero-functions.php';

	Shop_Co_Core_Product_FAQs::init();
	Shop_Co_Core_Home_Hero::init();
} else {
	add_action(
		'admin_notices',
		static function (): void {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}
			?>
			<div class="notice notice-error">
				<p>
					<?php
					esc_html_e(
						'Shop Co Core dependencies are missing. Run Composer install in the plugin directory.',
						'shop-co-core'
					);
					?>
				</p>
			</div>
			<?php
		}
	);
}
