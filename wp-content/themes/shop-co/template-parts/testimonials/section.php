<?php

if ( ! shop_co_is_core_plugin_active() ) {
	shop_co_admin_notice_section( __( 'Activate the Shop Co Core plugin to manage testimonials.', 'shop-co' ), 'activate_plugins' );
	return;
}

$testimonials = shop_co_get_testimonials();

if ( ! $testimonials->have_posts() ) {
	shop_co_admin_notice_section( __( 'No testimonials have been added yet.', 'shop-co' ) );
	return;
}

?>

<section class="section overflow-hidden">
    <div class="section__header container">
        <h2 class="section__title">OUR HAPPY CUSTOMERS</h2>
        <div class="section__extra">
            <div class="slider-arrows">
                <button class="slider-arrows__button testimonials-slider__button--prev" type="button">
                    <?php echo ShopCo_Icons::arrow_left(); ?>
                    <span class="screen-reader-text"><?php esc_html_e( 'Previous testimonial', 'shop-co' ); ?></span>
                </button>

                <button class="slider-arrows__button testimonials-slider__button--next" type="button">
                    <?php echo ShopCo_Icons::arrow_right(); ?>
                    <span class="screen-reader-text"><?php esc_html_e( 'Next testimonial', 'shop-co' ); ?></span>
                </button>
            </div>
            
        </div>
    </div>
    <div class="section__body container">
        <div class="testimonials-slider">
            <div class="testimonials-slider__swiper swiper">
                <div class="testimonials-slider__wrapper swiper-wrapper">
                    <?php
                    foreach ( $testimonials->posts as $testimonial ) {
                        ?>
                        <div class="testimonials-slider__slide swiper-slide">
                            <?php
                            shop_co_get_template_part(
                                'testimonials/card',
                                array(
                                    'testimonial' => $testimonial,
                                )
                            );
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
