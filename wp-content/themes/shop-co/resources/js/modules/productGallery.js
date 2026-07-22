import Swiper from 'swiper';
import { A11y, Navigation, Thumbs, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import 'swiper/css/effect-fade';
import 'fslightbox';

export class ProductGallery {
	static init( selector ) {
		const galleries = document.querySelectorAll( selector );

		if ( galleries.length <= 0 ) {
			return;
		}

		galleries.forEach( ( gallery ) => {
			const thumbsElement = gallery.querySelector(
				'.site-product-gallery__thumbs-swiper'
			);
			const mainElement = gallery.querySelector(
				'.site-product-gallery__main'
			);

			if ( ! thumbsElement || ! mainElement ) {
				return;
			}

			const thumbsSwiper = new Swiper( thumbsElement, {
				modules: [ A11y, Navigation ],
				a11y: {
					enabled: true,
					scrollOnFocus: true,
				},
				direction: 'horizontal',
				slidesPerView: 3,
				spaceBetween: 14,
				watchSlidesProgress: true,
				breakpoints: {
					768: {
						direction: 'vertical',
					},
				},
				navigation: {
					prevEl: gallery.querySelector(
						'.site-product-gallery__button--prev'
					),
					nextEl: gallery.querySelector(
						'.site-product-gallery__button--next'
					),
				},
			} );

			const mainSwiper = new Swiper( mainElement, {
				modules: [ A11y, Navigation, Thumbs, EffectFade ],
				a11y: {
					enabled: true,
					scrollOnFocus: true,
				},
				slidesPerView: 1,
				spaceBetween: 0,
				allowTouchMove: true,
				autoHeight: false,
				effect: 'fade',
				fadeEffect: {
					crossFade: true,
				},
				navigation: {
					prevEl: gallery.querySelector(
						'.site-product-gallery__main-button--prev'
					),
					nextEl: gallery.querySelector(
						'.site-product-gallery__main-button--next'
					),
				},
				speed: 300,
				thumbs: {
					swiper: thumbsSwiper,
				},
			} );

			if (
				window.matchMedia( '(hover: hover) and (pointer: fine)' )
					.matches
			) {
				thumbsSwiper.slides.forEach( ( slide, index ) => {
					slide.addEventListener( 'mouseenter', () => {
						mainSwiper.slideTo( index );
					} );
				} );
			}

			ProductGallery.initVariationImageSync( gallery, mainSwiper );
		} );
	}

	static initVariationImageSync( gallery, mainSwiper ) {
		const product = gallery.closest( '.product' );
		const variationForm = product?.querySelector( '.variations_form' );
		const jquery = window.jQuery;

		if ( ! variationForm || ! jquery ) {
			return;
		}

		const mainImage = gallery.querySelector(
			'.site-product-gallery__main .swiper-slide:first-child img'
		);
		const thumbImage = gallery.querySelector(
			'.site-product-gallery__thumbs-swiper .swiper-slide:first-child img'
		);

		if ( ! mainImage || ! thumbImage ) {
			return;
		}

		const lightboxLink = gallery.querySelector(
			'.site-product-gallery__main .swiper-slide:first-child a'
		);
		const original = {
			mainSrc: mainImage.getAttribute( 'src' ),
			mainSrcset: mainImage.getAttribute( 'srcset' ),
			mainSizes: mainImage.getAttribute( 'sizes' ),
			mainAlt: mainImage.getAttribute( 'alt' ),
			thumbSrc: thumbImage.getAttribute( 'src' ),
			thumbSrcset: thumbImage.getAttribute( 'srcset' ),
			thumbSizes: thumbImage.getAttribute( 'sizes' ),
			thumbAlt: thumbImage.getAttribute( 'alt' ),
			fullSrc: lightboxLink?.getAttribute( 'href' ),
		};

		jquery( variationForm )
			.on( 'found_variation', ( event, variation ) => {
				if ( ! variation?.image?.src ) {
					return;
				}

				ProductGallery.updateVariationImage(
					mainImage,
					thumbImage,
					lightboxLink,
					variation.image
				);
				ProductGallery.refreshGallery( mainSwiper );
			} )
			.on( 'reset_data', () => {
				ProductGallery.restoreVariationImage(
					mainImage,
					thumbImage,
					lightboxLink,
					original
				);
				ProductGallery.refreshGallery( mainSwiper );
			} );
	}

	static updateVariationImage( mainImage, thumbImage, lightboxLink, image ) {
		mainImage.setAttribute( 'src', image.src );
		ProductGallery.setOptionalAttribute(
			mainImage,
			'srcset',
			image.srcset
		);
		ProductGallery.setOptionalAttribute( mainImage, 'sizes', image.sizes );
		ProductGallery.setOptionalAttribute( mainImage, 'alt', image.alt );

		thumbImage.setAttribute(
			'src',
			image.gallery_thumbnail_src || image.thumb_src || image.src
		);
		ProductGallery.setOptionalAttribute( thumbImage, 'srcset', '' );
		ProductGallery.setOptionalAttribute( thumbImage, 'sizes', '' );
		ProductGallery.setOptionalAttribute( thumbImage, 'alt', image.alt );

		if ( lightboxLink && image.full_src ) {
			lightboxLink.setAttribute( 'href', image.full_src );
		}
	}

	static restoreVariationImage(
		mainImage,
		thumbImage,
		lightboxLink,
		original
	) {
		ProductGallery.setOptionalAttribute(
			mainImage,
			'src',
			original.mainSrc
		);
		ProductGallery.setOptionalAttribute(
			mainImage,
			'srcset',
			original.mainSrcset
		);
		ProductGallery.setOptionalAttribute(
			mainImage,
			'sizes',
			original.mainSizes
		);
		ProductGallery.setOptionalAttribute(
			mainImage,
			'alt',
			original.mainAlt
		);

		ProductGallery.setOptionalAttribute(
			thumbImage,
			'src',
			original.thumbSrc
		);
		ProductGallery.setOptionalAttribute(
			thumbImage,
			'srcset',
			original.thumbSrcset
		);
		ProductGallery.setOptionalAttribute(
			thumbImage,
			'sizes',
			original.thumbSizes
		);
		ProductGallery.setOptionalAttribute(
			thumbImage,
			'alt',
			original.thumbAlt
		);

		if ( lightboxLink ) {
			ProductGallery.setOptionalAttribute(
				lightboxLink,
				'href',
				original.fullSrc
			);
		}
	}

	static refreshGallery( mainSwiper ) {
		mainSwiper.slideTo( 0 );
		mainSwiper.update();

		if ( typeof window.refreshFsLightbox === 'function' ) {
			window.refreshFsLightbox();
		}
	}

	static setOptionalAttribute( element, attribute, value ) {
		if ( value ) {
			element.setAttribute( attribute, value );
			return;
		}

		element.removeAttribute( attribute );
	}
}
