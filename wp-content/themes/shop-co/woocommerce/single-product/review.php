<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! isset( $comment ) || ! is_a( $comment, WP_Comment::class ) ) {
	return;
}

/** @var WP_Comment $comment */

?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container testimonial-card site-border">

		<?php
		/**
		 * The woocommerce_review_before hook
		 */
		do_action( 'woocommerce_review_before', $comment );
		?>

			<?php
			/**
			 * The woocommerce_review_before_comment_meta hook.
			 *
			 * @hooked woocommerce_review_display_rating - 10
			 */
			do_action( 'woocommerce_review_before_comment_meta', $comment );

			/**
			 * The woocommerce_review_meta hook.
			 *
			 * @hooked woocommerce_review_display_meta - 10
			 */
			do_action( 'woocommerce_review_meta', $comment );

			do_action( 'woocommerce_review_before_comment_text', $comment );

			/**
			 * The woocommerce_review_comment_text hook
			 *
			 * @hooked shop_co_woocommerce_review_display_comment_text - 10
			 */
			do_action( 'woocommerce_review_comment_text', $comment );

			?>

			<time class="testimonial-card__time opacity-60" 
				datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>">
				
				<b>
					<?php _e( 'Posted on', 'shop-co' ); ?>
					<?php echo esc_html( get_comment_date( 'd.m.Y H:i:s' ) ); ?>
				</b>
			</time>

			<?php do_action( 'woocommerce_review_after_comment_text', $comment ); ?>

	</div>
