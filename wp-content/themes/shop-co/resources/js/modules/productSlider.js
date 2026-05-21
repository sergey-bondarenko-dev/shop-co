import Swiper from 'swiper';
import 'swiper/css';

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

			new Swiper( swiper, {
				slidesPerView: 1,
				spaceBetween: 8,
				breakpoints: {
					360: {
						slidesPerView: 1.7,
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
