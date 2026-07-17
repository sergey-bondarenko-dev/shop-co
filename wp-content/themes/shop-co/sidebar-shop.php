<?php
/**
 * WooCommerce catalog filters sidebar.
 *
 * @package Shop_Co
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! ( is_shop() || is_product_taxonomy() ) || ! is_active_sidebar( 'shop-filters' ) ) {
	return;
}
?>

<aside
	class="catalog-sidebar offcanvas-xl offcanvas-bottom"
	tabindex="-1"
	id="catalog-filters-offcanvas"
	aria-labelledby="catalog-filters-title">
	<div class="catalog-sidebar__header">
		<div class="d-flex align-items-center gap-3">
			<p class="catalog-sidebar__title h5" id="catalog-filters-title"><?php esc_html_e( 'Filters', 'shop-co' ); ?></p>
			<span class="icon opacity-60 hidden-mobile" aria-hidden="true">
				<?php echo ShopCo_Icons::settings(); ?>
			</span>
		</div>
		<button
			type="button"
			class="site-close-button visible-tablet"
			data-bs-dismiss="offcanvas"
			data-bs-target="#catalog-filters-offcanvas"
			aria-label="<?php esc_attr_e( 'Close catalog filters', 'shop-co' ); ?>">
		</button>
	</div>
	<div class="catalog-sidebar__body offcanvas-body">
		<div class="catalog-sidebar__ordering visible-tablet">
			<?php
			woocommerce_catalog_ordering(
				array(
					'useLabel' => true,
				)
			);
			?>
		</div>
		<?php dynamic_sidebar( 'shop-filters' ); ?>
	</div>
</aside>
