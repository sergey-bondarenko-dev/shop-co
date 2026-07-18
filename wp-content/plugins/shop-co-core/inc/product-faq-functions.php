<?php
/**
 * Product FAQ public functions.
 *
 * @package Shop_Co_Core
 */

/**
 * Get FAQ entries for a WooCommerce product.
 *
 * @param int $product_id Product ID.
 * @return array<int, array<string, mixed>>
 */
function shop_co_core_get_product_faqs( int $product_id ): array {
	return Shop_Co_Core_Product_FAQs::get_items( $product_id );
}
