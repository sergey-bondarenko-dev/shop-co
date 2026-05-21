<?php
/**
 * Template helper functions.
 *
 * @package Shop_Co
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load a template part from the theme template-parts directory.
 */
function shop_co_get_template_part( string $slug, array $args = array(), ?string $name = null ): void {
	get_template_part( 'template-parts/' . ltrim( $slug, '/' ), $name, $args );
}

/**
 * Print the post publish date.
 */
function shop_co_posted_on(): void {
	printf(
		'<span class="posted-on">%s <a href="%s" rel="bookmark"><time class="entry-date published" datetime="%s">%s</time></a></span>',
		esc_html__( 'Posted on', 'shop-co' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);
}

/**
 * Print the post author link.
 */
function shop_co_posted_by(): void {
	printf(
		'<span class="byline"> %s <span class="author vcard"><a class="url fn n" href="%s">%s</a></span></span>',
		esc_html__( 'by', 'shop-co' ),
		esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
}

/**
 * Print entry footer metadata.
 */
function shop_co_entry_footer(): void {
	$categories = get_the_category_list( esc_html__( ', ', 'shop-co' ) );
	if ( $categories ) {
		printf( '<span class="cat-links">%s %s</span>', esc_html__( 'Categories:', 'shop-co' ), wp_kses_post( $categories ) );
	}

	$tags = get_the_tag_list( '', esc_html__( ', ', 'shop-co' ) );
	if ( $tags ) {
		printf( '<span class="tags-links"> %s %s</span>', esc_html__( 'Tags:', 'shop-co' ), wp_kses_post( $tags ) );
	}

	edit_post_link(
		esc_html__( 'Edit', 'shop-co' ),
		'<span class="edit-link"> ',
		'</span>'
	);
}
