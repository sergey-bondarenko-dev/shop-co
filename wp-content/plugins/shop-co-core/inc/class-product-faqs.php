<?php
/**
 * Product FAQ fields and data access.
 *
 * @package Shop_Co_Core
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers product FAQ fields and exposes their values.
 */
class ShopCo_Product_FAQs {
	public const META_KEY = 'shop_co_product_faqs';

	/**
	 * Register plugin hooks.
	 */
	public static function init(): void {
		add_action( 'carbon_fields_register_fields', array( __CLASS__, 'register_fields' ) );
	}

	/**
	 * Register the Carbon Fields container for WooCommerce products.
	 */
	public static function register_fields(): void {
		Container::make( 'post_meta', esc_html__( 'Product FAQs', 'shop-co-core' ) )
			->where( 'post_type', '=', 'product' )
			->set_context( 'normal' )
			->set_priority( 'high' )
			->add_fields(
				array(
					Field::make(
						'complex',
						self::META_KEY,
						esc_html__( 'FAQs', 'shop-co-core' )
					)
						->set_layout( 'grid' )
						->set_collapsed( true )
						->setup_labels(
							array(
								'plural_name'   => esc_html__( 'FAQs', 'shop-co-core' ),
								'singular_name' => esc_html__( 'FAQ', 'shop-co-core' ),
							)
						)
						->add_fields(
							array(
								Field::make( 'text', 'question', esc_html__( 'Question', 'shop-co-core' ) )
									->set_required( true ),
								Field::make( 'rich_text', 'answer', esc_html__( 'Answer', 'shop-co-core' ) )
									->set_required( true ),
							)
						)
						->set_header_template( '<%- question ? question : "FAQ" %>' ),
				)
			);
	}

	/**
	 * Get complete FAQ entries for a product.
	 *
	 * @param int $product_id Product ID.
	 * @return array<int, array<string, mixed>>
	 */
	public static function get_items( int $product_id ): array {
		if ( $product_id <= 0 || ! function_exists( 'carbon_get_post_meta' ) ) {
			return array();
		}

		$items = carbon_get_post_meta( $product_id, self::META_KEY );

		if ( ! is_array( $items ) ) {
			return array();
		}

		$items = array_filter(
			$items,
			static function ( $item ): bool {
				return is_array( $item )
					&& ! empty( $item['question'] )
					&& ! empty( $item['answer'] );
			}
		);

		return array_values( $items );
	}
}

ShopCo_Product_FAQs::init();

/**
 * Get FAQ entries for a WooCommerce product.
 *
 * @param int $product_id Product ID.
 * @return array<int, array<string, mixed>>
 */
function shop_co_core_get_product_faqs( int $product_id ): array {
	return ShopCo_Product_FAQs::get_items( $product_id );
}
