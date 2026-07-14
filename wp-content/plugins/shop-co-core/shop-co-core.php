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

require __DIR__ . '/inc/class-testimonials.php';

$shop_co_core_autoloader = __DIR__ . '/vendor/autoload.php';

if ( is_readable( $shop_co_core_autoloader ) ) {
	require_once $shop_co_core_autoloader;

	add_action(
		'after_setup_theme',
		static function (): void {
			\Carbon_Fields\Carbon_Fields::boot();
		}
	);

	require __DIR__ . '/inc/class-product-faqs.php';
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

