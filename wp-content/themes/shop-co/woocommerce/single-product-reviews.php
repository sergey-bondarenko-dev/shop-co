<?php
/**
 * Display single product reviews (comments)
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

$count                 = $product->get_review_count();
$per_page              = get_option( 'comments_per_page' );
$total_pages           = (int) ceil( $count / $per_page );
$reviews_order         = shop_co_get_reviews_order();
$current_comment_page  = max( 1, get_query_var( 'cpage' ) );
$default_comments_page = get_option( 'default_comments_page' );

$title_reply = have_comments() ?
	esc_html__( 'Add a review', 'woocommerce' ) :
	sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() );

$comment_options = array(
	'totalCount'          => $count,
	'totalPages'          => $total_pages,
	'perPage'             => $per_page,
	'currentPage'         => $current_comment_page,
	'defaultCommentsPage' => $default_comments_page,
);

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments" class="site-comments"
		data-options="<?php echo esc_attr( wp_json_encode( $comment_options ) ); ?>">

		<div class="site-comments__loading" id="comments-loading" role="status" aria-hidden="true">
			<div class="spinner-border">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>
		

		<div class="site-comments__header">
			<h2 class="site-comments__title h4">
				<span>
					<?php echo __( 'All Reviews', 'shop-co' ); ?>
				</span>
				<span class="value opacity-60">(<?php echo $count; ?>)</span> 
			</h2>
			
			<div class="site-comments__actions">
				<select class="site-select" name="comments-sort" id="comments-sort">
					<option <?php echo $reviews_order === 'newest' ? 'selected' : ''; ?> value="newest"><?php _e( 'Newest', 'shop-co' ); ?></option>
					<option <?php echo $reviews_order === 'oldest' ? 'selected' : ''; ?> value="oldest"><?php _e( 'Latest', 'shop-co' ); ?></option>
				</select>
				<button class="site-button" type="button" data-bs-toggle="modal" data-bs-target="#review-modal">
					<?php _e( 'Write a Review', 'shop-co' ); ?>
				</button>
			</div>
		</div>

		<?php if ( have_comments() ) : ?>
			<ol class="site-comments__list commentlist" id="comment-list">
				<?php
				wp_list_comments(
					apply_filters(
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
				<?php _e( 'Load More Reviews', 'shop-co' ); ?>
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
		<h5 class="modal-title"><?php echo esc_html( $title_reply ); ?></h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
		<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
			<div id="review_form_wrapper" class="site-review-form-wrapper">
				<div id="review_form" class="site-review-form">
					<?php
					$commenter    = wp_get_current_commenter();
					$comment_form = array(
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

					$name_email_required = (bool) get_option( 'require_name_email', 1 );
					$fields              = array(
						'author' => array(
							'label'        => __( 'Name', 'woocommerce' ),
							'type'         => 'text',
							'value'        => $commenter['comment_author'],
							'required'     => $name_email_required,
							'autocomplete' => 'name',
						),
						'email'  => array(
							'label'        => __( 'Email', 'woocommerce' ),
							'type'         => 'email',
							'value'        => $commenter['comment_author_email'],
							'required'     => $name_email_required,
							'autocomplete' => 'email',
						),
					);

					$comment_form['fields'] = array();

					foreach ( $fields as $key => $field ) {
						$field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
						$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

						if ( $field['required'] ) {
							$field_html .= '&nbsp;<span class="required">*</span>';
						}

						$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" autocomplete="' . esc_attr( $field['autocomplete'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

						$comment_form['fields'][ $key ] = $field_html;
					}

					$account_page_url = wc_get_page_permalink( 'myaccount' );
					if ( $account_page_url ) {
						/* translators: %s opening and closing link tags respectively */
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
					}

					if ( wc_review_ratings_enabled() ) {
						$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating" id="comment-form-rating-label">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
						</select></div>';
					}

					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
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
