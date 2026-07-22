import Swiper from 'swiper';
import { A11y, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

export class ProductSlider {
	static init( selector ) {
		const sliders = document.querySelectorAll( selector );

		if ( sliders.length <= 0 ) {
			return;
		}

		sliders.forEach( ( slider ) => {
			const swiper = slider.querySelector( '.products-slider__swiper' );

			if ( ! swiper ) {
				return;
			}

			const section = slider.closest( '.products-section' );
			const prevEl = section?.querySelector(
				'.products-slider__button--prev'
			);
			const nextEl = section?.querySelector(
				'.products-slider__button--next'
			);
			const navigation =
				prevEl && nextEl
					? {
							prevEl,
							nextEl,
					  }
					: false;

			new Swiper( swiper, {
				modules: [ A11y, Navigation ],
				a11y: {
					enabled: true,
					scrollOnFocus: true,
				},
				navigation,
				slidesPerView: 1.2,
				spaceBetween: 8,
				breakpoints: {
					360: {
						spaceBetween: 16,
					},
					391: {
						slidesPerView: 2,
					},
					768: {
						slidesPerView: 3,
						spaceBetween: 20,
					},
					1024: {
						slidesPerView: 4,
						spaceBetween: 20,
					},
				},
			} );
		} );
	}
}
