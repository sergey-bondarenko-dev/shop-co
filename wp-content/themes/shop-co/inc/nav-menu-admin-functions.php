<?php
/**
 * Navigation menu editor integrations.
 *
 * @package Shop_Co
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the shop collections metabox to the classic menu editor.
 */
function shop_co_add_nav_menu_collections_metabox(): void {
	if ( ! function_exists( 'shop_co_get_catalog_collection_url' ) ) {
		return;
	}

	add_meta_box(
		'shop_co_collections_nav_link',
		esc_html__( 'Shop collections', 'shop-co' ),
		'shop_co_render_nav_menu_collections_metabox',
		'nav-menus',
		'side',
		'low'
	);
}
add_action( 'admin_head-nav-menus.php', 'shop_co_add_nav_menu_collections_metabox' );

/**
 * Render collection links using the structure expected by WordPress nav-menu.js.
 */
function shop_co_render_nav_menu_collections_metabox(): void {
	$collections = array(
		'sale'         => esc_html__( 'On sale', 'shop-co' ),
		'new-arrivals' => esc_html__( 'New arrivals', 'shop-co' ),
	);
	?>
	<div id="posttype-shop-co-collections" class="posttypediv">
		<div id="tabs-panel-shop-co-collections" class="tabs-panel tabs-panel-active">
			<ul id="shop-co-collections-checklist" class="categorychecklist form-no-clear">
				<?php
				$item_id = -1000;

				foreach ( $collections as $collection => $title ) :
					$url = shop_co_get_catalog_collection_url( $collection );

					if ( ! $url ) {
						continue;
					}
					?>
					<li>
						<label class="menu-item-title">
							<input
								type="checkbox"
								class="menu-item-checkbox"
								name="menu-item[<?php echo esc_attr( $item_id ); ?>][menu-item-object-id]"
								value="<?php echo esc_attr( $item_id ); ?>"
							>
							<?php echo esc_html( $title ); ?>
						</label>
						<input type="hidden" class="menu-item-type" name="menu-item[<?php echo esc_attr( $item_id ); ?>][menu-item-type]" value="custom">
						<input type="hidden" class="menu-item-title" name="menu-item[<?php echo esc_attr( $item_id ); ?>][menu-item-title]" value="<?php echo esc_attr( $title ); ?>">
						<input type="hidden" class="menu-item-url" name="menu-item[<?php echo esc_attr( $item_id ); ?>][menu-item-url]" value="<?php echo esc_url( $url ); ?>">
						<input type="hidden" class="menu-item-classes" name="menu-item[<?php echo esc_attr( $item_id ); ?>][menu-item-classes]">
					</li>
					<?php
					--$item_id;
				endforeach;
				?>
			</ul>
		</div>

		<p class="button-controls wp-clearfix" data-items-type="posttype-shop-co-collections">
			<span class="list-controls">
				<label>
					<input type="checkbox" class="select-all">
					<?php esc_html_e( 'Select all', 'shop-co' ); ?>
				</label>
			</span>
			<span class="add-to-menu">
				<button
					type="submit"
					class="button-secondary submit-add-to-menu right"
					name="add-post-type-menu-item"
					id="submit-posttype-shop-co-collections"
				>
					<?php esc_html_e( 'Add to menu', 'shop-co' ); ?>
				</button>
				<span class="spinner"></span>
			</span>
		</p>
	</div>
	<?php
}
