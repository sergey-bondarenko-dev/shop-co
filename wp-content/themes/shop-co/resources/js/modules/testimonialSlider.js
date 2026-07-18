import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

export class TestimonialSlider {
	static init( selector ) {
		const sliders = document.querySelectorAll( selector );

		if ( sliders.length <= 0 ) {
			return;
		}

		sliders.forEach( ( slider ) => {
			const swiper = slider.querySelector(
				'.testimonials-slider__swiper'
			);

			if ( ! swiper ) {
				return;
			}

			const section = slider.closest( '.section' );
			const prevEl = section?.querySelector(
				'.testimonials-slider__button--prev'
			);
			const nextEl = section?.querySelector(
				'.testimonials-slider__button--next'
			);
			const navigation =
				prevEl && nextEl
					? {
							prevEl,
							nextEl,
					  }
					: false;

			new Swiper( swiper, {
				modules: [ Navigation ],
				slidesPerView: 1,
				spaceBetween: 15,
				navigation,
				breakpoints: {
					768: {
						slidesPerView: 2,
					},
					1024: {
						slidesPerView: 3,
					},
				},
			} );
		} );
	}
}
