<?php
/**
 * Product taxonomy archive header.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<header class="woocommerce-products-header">
	<?php
	/**
	 * Hook: woocommerce_show_page_title.
	 *
	 * Allow developers to remove the product taxonomy archive page title.
	 *
	 * @since 2.0.6.
	 */
	if ( apply_filters( 'woocommerce_show_page_title', true ) ) :
		?>
		<h1 class="woocommerce-products-header__title page-title h4"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>
	
	<div class="woocommerce-products-header__details">
		<?php
		/**
		 * Hook: woocommerce_archive_description.
		 *
		 * @since 1.6.2.
		 */
		do_action( 'woocommerce_archive_description' );
		?>
	</div>
</header>
