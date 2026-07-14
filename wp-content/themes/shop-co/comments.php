<?php
/**
 * Comments template.
 *
 * @package Shop_Co
 */

if ( post_password_required() ) {
	return;
}

$comments_number = get_comments_number();

?>

<div id="comments" class="comments-area site-comments">
	<div class="site-comments__header">
		<h2 class="site-comments__title h4">
			<?php echo __( 'All Reviews', 'shop-co' ); ?>
			<span>(<?php echo $comments_number; ?>)</span> 
		</h2>
		<div class="site-comments__actions">
			<select name="comments-sort" id="comments-sort">
				<option value="latest"><?php _e( 'Latest', 'shop-co' ); ?></option>
			</select>
			<button class="site-button" type="button">
				<?php _e( 'Write a Review', 'shop-co' ); ?>
			</button>
		</div>
	</div>
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$shop_co_comment_count = get_comments_number();
			printf(
				/* translators: %s: Number of comments. */
				esc_html( _nx( '%1$s comment', '%1$s comments', $shop_co_comment_count, 'comments title', 'shop-co' ) ),
				esc_html( number_format_i18n( $shop_co_comment_count ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	if ( ! comments_open() && get_comments_number() ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'shop-co' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>
