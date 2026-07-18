<?php
/**
 * Search form template.
 *
 * @package Shop_Co
 */

?>
<form role="search" method="get" class="search-form site-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="site-search-form__field">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'shop-co' ); ?></span>
		<span class="site-search-form__icon" aria-hidden="true">
			<?php echo shop_co_get_icon( 'search' ); ?>
		</span>
		<input
			type="search"
			class="search-field site-search-form__input"
			placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'shop-co' ); ?>"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			name="s"
		/>
	</label>
	<input type="hidden" name="post_type" value="product">
	<button type="submit" class="search-submit site-button site-button--small site-search-form__submit">
		<?php esc_html_e( 'Search', 'shop-co' ); ?>
	</button>
</form>
