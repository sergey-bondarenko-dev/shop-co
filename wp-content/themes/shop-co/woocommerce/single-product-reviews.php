<?php
/**
 * Display single product reviews (comments)
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.WP.I18n -- Reuse WooCommerce translations in this template override.

global $product;

if ( ! comments_open() ) {
	return;
}

$shop_co_count                 = $product->get_review_count();
$shop_co_per_page              = get_option( 'comments_per_page' );
$shop_co_total_pages           = (int) ceil( $shop_co_count / $shop_co_per_page );
$shop_co_reviews_order         = shop_co_get_reviews_order();
$shop_co_current_comment_page  = max( 1, get_query_var( 'cpage' ) );
$shop_co_default_comments_page = get_option( 'default_comments_page' );

$shop_co_title_reply = have_comments() ?
	esc_html__( 'Add a review', 'woocommerce' ) :
	/* translators: %s: Product title. */
	sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() );

$shop_co_comment_options = array(
	'totalCount'          => $shop_co_count,
	'totalPages'          => $shop_co_total_pages,
	'perPage'             => $shop_co_per_page,
	'currentPage'         => $shop_co_current_comment_page,
	'defaultCommentsPage' => $shop_co_default_comments_page,
);

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments" class="site-comments"
		data-options="<?php echo esc_attr( wp_json_encode( $shop_co_comment_options ) ); ?>">

		<div class="site-comments__loading" id="comments-loading" role="status" aria-hidden="true">
			<div class="spinner-border">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>
		

		<div class="site-comments__header">
			<h2 class="site-comments__title h4">
				<span>
					<?php esc_html_e( 'All Reviews', 'shop-co' ); ?>
				</span>
				<span class="value opacity-60">(<?php echo esc_html( $shop_co_count ); ?>)</span>
			</h2>
			
			<div class="site-comments__actions">
				<select class="site-select" name="comments-sort" id="comments-sort">
					<option <?php echo 'newest' === $shop_co_reviews_order ? 'selected' : ''; ?> value="newest"><?php esc_html_e( 'Newest', 'shop-co' ); ?></option>
					<option <?php echo 'oldest' === $shop_co_reviews_order ? 'selected' : ''; ?> value="oldest"><?php esc_html_e( 'Latest', 'shop-co' ); ?></option>
				</select>
				<button class="site-button" type="button" data-bs-toggle="modal" data-bs-target="#review-modal">
					<?php esc_html_e( 'Write a Review', 'shop-co' ); ?>
				</button>
			</div>
		</div>

		<?php if ( have_comments() ) : ?>
			<ol class="site-comments__list commentlist" id="comment-list">
				<?php
				wp_list_comments(
					apply_filters(
						// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WooCommerce hook.
						'woocommerce_product_review_list_args',
						array(
							'callback'          => 'woocommerce_comments',
							'reverse_top_level' => false,
							'reverse_children'  => false,
						)
					)
				);
				?>
			</ol>

			<button type="button" class="site-button site-button--white site-border align-self-center" id="load-more-comments">
				<?php esc_html_e( 'Load More Reviews', 'shop-co' ); ?>
			</button>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
		<?php endif; ?>
	</div>

	<div class="clear"></div>
</div>

<div class="modal fade" tabindex="-1" id="review-modal">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title"><?php echo esc_html( $shop_co_title_reply ); ?></h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
		<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
			<div id="review_form_wrapper" class="site-review-form-wrapper">
				<div id="review_form" class="site-review-form">
					<?php
					$shop_co_commenter    = wp_get_current_commenter();
					$shop_co_comment_form = array(
						/* translators: %s is product title */
						'title_reply'         => null,
						/* translators: %s is product title */
						'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
						'title_reply_before'  => '<span id="reply-title" class="comment-reply-title" role="heading" aria-level="3">',
						'title_reply_after'   => '</span>',
						'comment_notes_after' => '',
						'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
						'class_submit'        => 'site-button',
						'class_form'          => 'comment-form site-review-form__form',
						'logged_in_as'        => '',
						'comment_field'       => '',
					);

					$shop_co_name_email_required = (bool) get_option( 'require_name_email', 1 );
					$shop_co_fields              = array(
						'author' => array(
							'label'        => __( 'Name', 'woocommerce' ),
							'type'         => 'text',
							'value'        => $shop_co_commenter['comment_author'],
							'required'     => $shop_co_name_email_required,
							'autocomplete' => 'name',
						),
						'email'  => array(
							'label'        => __( 'Email', 'woocommerce' ),
							'type'         => 'email',
							'value'        => $shop_co_commenter['comment_author_email'],
							'required'     => $shop_co_name_email_required,
							'autocomplete' => 'email',
						),
					);

					$shop_co_comment_form['fields'] = array();

					foreach ( $shop_co_fields as $shop_co_key => $shop_co_field ) {
						$shop_co_field_html  = '<p class="comment-form-' . esc_attr( $shop_co_key ) . '">';
						$shop_co_field_html .= '<label for="' . esc_attr( $shop_co_key ) . '">' . esc_html( $shop_co_field['label'] );

						if ( $shop_co_field['required'] ) {
							$shop_co_field_html .= '&nbsp;<span class="required">*</span>';
						}

						$shop_co_field_html .= '</label><input id="' . esc_attr( $shop_co_key ) . '" name="' . esc_attr( $shop_co_key ) . '" type="' . esc_attr( $shop_co_field['type'] ) . '" autocomplete="' . esc_attr( $shop_co_field['autocomplete'] ) . '" value="' . esc_attr( $shop_co_field['value'] ) . '" size="30" ' . ( $shop_co_field['required'] ? 'required' : '' ) . ' /></p>';

						$shop_co_comment_form['fields'][ $shop_co_key ] = $shop_co_field_html;
					}

					$shop_co_account_page_url = wc_get_page_permalink( 'myaccount' );
					if ( $shop_co_account_page_url ) {
						/* translators: %s opening and closing link tags respectively */
						$shop_co_comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $shop_co_account_page_url ) . '">', '</a>' ) . '</p>';
					}

					if ( wc_review_ratings_enabled() ) {
						$shop_co_comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating" id="comment-form-rating-label">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
						</select></div>';
					}

					$shop_co_comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

					// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WooCommerce hook.
					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $shop_co_comment_form ) );
					?>
				</div>
			</div>
		<?php else : ?>
			<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
		<?php endif; ?>
		</div>
	</div>
	</div>
</div>
