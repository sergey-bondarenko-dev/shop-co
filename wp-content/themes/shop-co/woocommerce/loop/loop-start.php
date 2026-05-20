<?php
/**
 * Product Loop Start
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$columns = (int) wc_get_loop_prop( 'columns' );
?>
<ul
	class="products columns-<?php echo esc_attr( (string) $columns ); ?>"
	style="
		--products-desktop-columns: <?php echo esc_attr( (string) $columns ); ?>;
		--products-container-columns: <?php echo esc_attr( (string) min( 4, $columns ) ); ?>;
		--products-tablet-columns: <?php echo esc_attr( (string) min( 3, $columns ) ); ?>;
		--products-mobile-columns: <?php echo esc_attr( (string) min( 2, $columns ) ); ?>;
		--products-mobile-xs-columns: 1;
	"
>
