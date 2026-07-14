<?php
/**
 * The template to display the reviewers meta data (name, verified owner, review date)
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $comment;
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

if ( '0' === $comment->comment_approved ) { ?>

	<p class="meta">
		<em class="woocommerce-review__awaiting-approval">
			<?php esc_html_e( 'Your review is awaiting approval', 'woocommerce' ); ?>
		</em>
	</p>

<?php } else { ?>

	<strong class="testimonial-card__name h5 woocommerce-review__author"><?php comment_author(); ?> </strong>
	<?php
	if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
		echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'woocommerce' ) . ')</em> ';
	}

	?>

	<?php
}
