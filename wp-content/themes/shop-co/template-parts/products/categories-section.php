<?php

if ( ! shop_co_is_woocommerce_active() ) {
    shop_co_admin_notice_section( __( 'Activate WooCommerce to show product categories.', 'shop-co' ), 'activate_plugins' );
    return;
}

$slugs = ['casual', 'formal', 'party', 'gym'];

$categories = get_terms([
    'taxonomy'   => 'product_cat',
    'slug'       => $slugs,
    'hide_empty' => false,
]);

if (is_wp_error($categories) || empty($categories)) {
    return;
}

$categories_by_slug = [];

foreach ($categories as $category) {
    $categories_by_slug[$category->slug] = $category;
}

$ordered_categories = [];

foreach ($slugs as $slug) {
    if (isset($categories_by_slug[$slug])) {
        $ordered_categories[] = $categories_by_slug[$slug];
    }
}

?>

<div class="container">
    <section class="section section--box">
        <div class="section__header">
            <h2 class="section__title text-center">
                <?php esc_html_e( 'Browse by dress style', 'shop-co' ); ?>
            </h2>
        </div>
        <div class="section__body">
            <div class="categories-grid">
                <?php foreach ($ordered_categories as $category):
                    $link = get_term_link($category);
                    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                    $slug = $category->slug;
                ?>
                    <a 
                        class="categories-grid__link <?php echo esc_attr( $slug ); ?>"
                        href="<?php echo esc_url($link) ?>">
                        <?php echo wp_get_attachment_image(
                            $thumbnail_id,
                            'large',
                            false,
                            array( 'class' => 'categories-grid__image' )
                        ); ?>

                        <h3 class="categories-grid__title"><?php echo esc_html($category->name); ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>

        </div>
    </section>
</div>
