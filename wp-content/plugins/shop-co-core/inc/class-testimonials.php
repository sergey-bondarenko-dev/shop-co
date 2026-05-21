<?php
/**
 * Testimonials post type.
 *
 * @package Shop_Co_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ShopCo_Testimonials {
	public const POST_TYPE = 'testimonial';

	public static function init(): void {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notice' ) );
		add_filter( 'enter_title_here', array( __CLASS__, 'enter_title_here' ), 10, 2 );
	}

	public static function register_post_type(): void {
		register_post_type(
			self::POST_TYPE,
			array(
				'labels'       => array(
					'name'          => esc_html__( 'Testimonials', 'shop-co-core' ),
					'singular_name' => esc_html__( 'Testimonial', 'shop-co-core' ),
				),
				'public'       => false,
				'show_ui'      => true,
				'show_in_rest' => false,
				'menu_icon'    => 'dashicons-star-filled',
				'supports'     => array( 'title', 'editor', 'page-attributes' ),
			)
		);
	}

	public static function get_items( int $limit = 10 ): WP_Query {
		return new WP_Query(
			array(
				'post_type'      => self::POST_TYPE,
				'post_status'    => 'publish',
				'posts_per_page' => $limit,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				),
				'no_found_rows'  => true,
			)
		);
	}

	public static function admin_notice(): void {
		$screen = get_current_screen();

		if ( ! $screen || self::POST_TYPE !== $screen->post_type ) {
			return;
		}
		?>
		<div class="notice notice-info inline">
			<p><?php esc_html_e( 'The title is used as the reviewer name.', 'shop-co-core' ); ?></p>
		</div>
		<?php
	}

	public static function enter_title_here( string $text, WP_Post $post ): string {
		if ( self::POST_TYPE !== $post->post_type ) {
			return $text;
		}

		return esc_html__( 'Reviewer name', 'shop-co-core' );
	}
}

ShopCo_Testimonials::init();

function shop_co_get_testimonials( int $limit = 10 ): WP_Query {
	return ShopCo_Testimonials::get_items( $limit );
}

