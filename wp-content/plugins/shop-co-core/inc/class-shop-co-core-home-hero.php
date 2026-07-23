<?php
/**
 * Home page hero fields and data access.
 *
 * @package Shop_Co_Core
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the home page hero fields and exposes their values.
 */
class Shop_Co_Core_Home_Hero {
	public const TITLE_KEY       = 'shop_co_hero_title';
	public const DESCRIPTION_KEY = 'shop_co_hero_description';
	public const BUTTON_TEXT_KEY = 'shop_co_hero_button_text';
	public const BUTTON_URL_KEY  = 'shop_co_hero_button_url';
	public const IMAGE_KEY       = 'shop_co_hero_image';
	public const BENEFITS_KEY    = 'shop_co_hero_benefits';
	public const BRANDS_KEY      = 'shop_co_hero_brands';

	/**
	 * Register plugin hooks.
	 */
	public static function init(): void {
		add_action( 'carbon_fields_register_fields', array( __CLASS__, 'register_fields' ) );
	}

	/**
	 * Register the home page settings screen.
	 */
	public static function register_fields(): void {
		Container::make( 'theme_options', esc_html__( 'Home page', 'shop-co-core' ) )
			->set_page_menu_title( esc_html__( 'Home page', 'shop-co-core' ) )
			->set_page_file( 'shop-co-home-page.php' )
			->set_icon( 'dashicons-admin-home' )
			->add_fields(
				array(
					Field::make( 'text', self::TITLE_KEY, esc_html__( 'Title', 'shop-co-core' ) )
						->set_default_value( esc_html__( 'FIND CLOTHES THAT MATCH YOUR STYLE', 'shop-co-core' ) ),
					Field::make( 'textarea', self::DESCRIPTION_KEY, esc_html__( 'Description', 'shop-co-core' ) )
						->set_rows( 4 )
						->set_default_value( esc_html__( 'Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.', 'shop-co-core' ) ),
					Field::make( 'text', self::BUTTON_TEXT_KEY, esc_html__( 'Button text', 'shop-co-core' ) )
						->set_default_value( esc_html__( 'Shop Now', 'shop-co-core' ) ),
					Field::make( 'text', self::BUTTON_URL_KEY, esc_html__( 'Button URL', 'shop-co-core' ) )
						->set_attribute( 'type', 'url' )
						->set_help_text( esc_html__( 'Leave empty to link to the WooCommerce shop page.', 'shop-co-core' ) ),
					Field::make( 'image', self::IMAGE_KEY, esc_html__( 'Hero image', 'shop-co-core' ) )
						->set_value_type( 'id' ),
					Field::make( 'complex', self::BENEFITS_KEY, esc_html__( 'Benefits', 'shop-co-core' ) )
						->set_layout( 'grid' )
						->set_collapsed( true )
						->setup_labels(
							array(
								'plural_name'   => esc_html__( 'Benefits', 'shop-co-core' ),
								'singular_name' => esc_html__( 'Benefit', 'shop-co-core' ),
							)
						)
						->add_fields(
							array(
								Field::make( 'text', 'amount', esc_html__( 'Value', 'shop-co-core' ) )
									->set_required( true ),
								Field::make( 'text', 'label', esc_html__( 'Label', 'shop-co-core' ) )
									->set_required( true ),
							)
						)
						->set_default_value(
							array(
								array(
									'amount' => '200+',
									'label'  => esc_html__( 'International Brands', 'shop-co-core' ),
								),
								array(
									'amount' => '2,000+',
									'label'  => esc_html__( 'High-Quality Products', 'shop-co-core' ),
								),
								array(
									'amount' => '30,000+',
									'label'  => esc_html__( 'Happy Customers', 'shop-co-core' ),
								),
							)
						)
						->set_header_template( '<%- amount ? amount : "Benefit" %>' ),
					Field::make( 'complex', self::BRANDS_KEY, esc_html__( 'Brands', 'shop-co-core' ) )
						->set_layout( 'grid' )
						->set_collapsed( true )
						->setup_labels(
							array(
								'plural_name'   => esc_html__( 'Brands', 'shop-co-core' ),
								'singular_name' => esc_html__( 'Brand', 'shop-co-core' ),
							)
						)
						->add_fields(
							array(
								Field::make( 'image', 'image', esc_html__( 'Logo', 'shop-co-core' ) )
									->set_value_type( 'id' )
									->set_required( true ),
								Field::make( 'text', 'alt', esc_html__( 'Alternative text', 'shop-co-core' ) ),
								Field::make( 'text', 'url', esc_html__( 'Link', 'shop-co-core' ) )
									->set_attribute( 'type', 'url' ),
							)
						)
						->set_help_text( esc_html__( 'When one or more brands are added, this list replaces the default logos.', 'shop-co-core' ) ),
				)
			);
	}

	/**
	 * Get saved hero data.
	 *
	 * @return array<string, mixed>
	 */
	public static function get_data(): array {
		$data = array(
			'title'       => '',
			'description' => '',
			'button_text' => '',
			'button_url'  => '',
			'image_id'    => 0,
			'benefits'    => array(),
			'brands'      => array(),
		);

		if ( ! function_exists( 'carbon_get_theme_option' ) ) {
			return $data;
		}

		$data['title']       = self::get_text_value( self::TITLE_KEY );
		$data['description'] = self::get_text_value( self::DESCRIPTION_KEY );
		$data['button_text'] = self::get_text_value( self::BUTTON_TEXT_KEY );
		$data['button_url']  = self::get_text_value( self::BUTTON_URL_KEY );
		$data['image_id']    = absint( carbon_get_theme_option( self::IMAGE_KEY ) );
		$data['benefits']    = self::get_complete_items(
			carbon_get_theme_option( self::BENEFITS_KEY ),
			array( 'amount', 'label' )
		);
		$data['brands']      = self::get_complete_items(
			carbon_get_theme_option( self::BRANDS_KEY ),
			array( 'image' )
		);

		return $data;
	}

	/**
	 * Get a scalar option value as a trimmed string.
	 *
	 * @param string $key Option key.
	 */
	private static function get_text_value( string $key ): string {
		$value = carbon_get_theme_option( $key );

		return is_scalar( $value ) ? trim( (string) $value ) : '';
	}

	/**
	 * Keep only complete complex-field items.
	 *
	 * @param mixed         $items         Raw Carbon Fields value.
	 * @param array<string> $required_keys Required non-empty keys.
	 * @return array<int, array<string, mixed>>
	 */
	private static function get_complete_items( $items, array $required_keys ): array {
		if ( ! is_array( $items ) ) {
			return array();
		}

		$items = array_filter(
			$items,
			static function ( $item ) use ( $required_keys ): bool {
				if ( ! is_array( $item ) ) {
					return false;
				}

				foreach ( $required_keys as $key ) {
					if ( empty( $item[ $key ] ) ) {
						return false;
					}
				}

				return true;
			}
		);

		return array_values( $items );
	}
}
