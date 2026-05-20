<?php

function shop_co_template_loop_product_link_open() {
    global $product;

    if ( ! ( $product instanceof WC_Product ) ) {
        return;
    }

    $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

    echo '<a href="' . esc_url( $link ) . '" class="site-product-card__link woocommerce-LoopProduct-link">';
}

function shop_co_template_loop_product_thumbnail() {
    $img = woocommerce_get_product_thumbnail(
        'woocommerce_thumbnail',
        array(
            'class' => 'site-product-card__thumbnail',
        ),
    );
    echo "<span class='site-product-card__thumbnail-wrapper'>$img</span>";
}

function shop_co_template_loop_product_title() {
    $classes = 'site-product-card__title woocommerce-loop-product__title h5';

    echo '<h2 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', $classes ) ) . '">' . get_the_title() . '</h2>';
}

/**
 * @param WC_Product&WC_Product_Variable $product
 */
function shop_co_template_price( WC_Product $product, bool $show_discount = true, string $wrapper_class = '' ): void {
    if ( ! ( $product instanceof WC_Product ) ) {
        return;
    }

    if ( $product->is_type( 'variable' ) ) {
        $variation_prices = $product->get_variation_prices( true );
        $variation_id     = 0;
        $current_price    = 0.0;

        foreach ( $variation_prices['price'] ?? array() as $id => $price ) {
            $price = (float) $price;

            if ( $price <= 0 ) {
                continue;
            }

            if ( 0.0 === $current_price || $price < $current_price ) {
                $variation_id  = (int) $id;
                $current_price = $price;
            }
        }

        $regular_price = (float) ( $variation_prices['regular_price'][ $variation_id ] ?? $current_price );
    } else {
        $regular_price = (float) $product->get_regular_price();
        $current_price = (float) $product->get_price();
    }

    if ( $current_price <= 0 ) {
        return;
    }

    $discount_percent = 0;

    if ( $product->is_on_sale() && $regular_price > 0 && $current_price < $regular_price ) {
        $discount_percent = (int) round( ( ( $regular_price - $current_price ) / $regular_price ) * 100 );
    }

    $classes = array_filter(
        array(
            'site-price',
            'price',
            $wrapper_class,
        )
    );
    ?>
    <span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <span class="site-price__current">
            <?php echo wp_kses_post( wc_price( $current_price ) ); ?>
        </span>

        <?php if ( $show_discount && $discount_percent > 0 ) : ?>
            <del class="site-price__regular opacity-40">
                <?php echo wp_kses_post( wc_price( $regular_price ) ); ?>
            </del>

            <span class="site-price__discount">
                -<?php echo esc_html( (string) $discount_percent ); ?>%
            </span>
        <?php endif; ?>
    </span>
    <?php
}
