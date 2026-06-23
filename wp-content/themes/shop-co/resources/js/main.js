import "bootstrap/js/dist/offcanvas";
import "bootstrap/js/dist/collapse";

const NAVIGATION_SELECTOR = '#site-navigation';
const SITE_HEADER_SELECTOR = '.site-header';
const NO_UI_SLIDER_SELECTOR = '.site-range';
const TESTIMONIALS_SLIDER_SELECTOR = '.testimonials-slider';
const PRODUCTS_SLIDER_SELECTOR = '.products-slider';
const PRODUCT_GALLERY_SELECTOR = '.site-product-gallery';
const PRODUCT_VARIATIONS_SELECTOR = '.variations_form';
const ADS_BANNER_SELECTOR = '.ads-banner';

if ( document.querySelector( NAVIGATION_SELECTOR ) ) {
	import( './modules/navigationDropdowns' ).then( ( { NavigationDropdowns } ) => {
		NavigationDropdowns.init( NAVIGATION_SELECTOR );
	} );
}

if ( document.querySelector( SITE_HEADER_SELECTOR ) ) {
	import( './modules/stickyHeader' ).then( ( { StickyHeader } ) => {
		StickyHeader.init( SITE_HEADER_SELECTOR );
	} );
}

if ( document.querySelector( NO_UI_SLIDER_SELECTOR ) ) {
	import( './modules/noUiSlider' ).then( ( { NoUiSlider } ) => {
		NoUiSlider.init( NO_UI_SLIDER_SELECTOR );
	} );
}

if ( document.querySelector( TESTIMONIALS_SLIDER_SELECTOR ) ) {
	import( './modules/testimonialSlider' ).then( ( { TestimonialSlider } ) => {
		TestimonialSlider.init( TESTIMONIALS_SLIDER_SELECTOR );
	} );
}

if ( document.querySelector( PRODUCTS_SLIDER_SELECTOR ) ) {
	import( './modules/productSlider' ).then( ( { ProductSlider } ) => {
		ProductSlider.init( PRODUCTS_SLIDER_SELECTOR );
	} );
}

if ( document.querySelector( PRODUCT_GALLERY_SELECTOR ) ) {
	import( './modules/productGallery' ).then( ( { ProductGallery } ) => {
		ProductGallery.init( PRODUCT_GALLERY_SELECTOR );
	} );
}

if ( document.querySelector( PRODUCT_VARIATIONS_SELECTOR ) ) {
	import( './modules/productVariations' ).then( ( { ProductVariations } ) => {
		ProductVariations.init( PRODUCT_VARIATIONS_SELECTOR );
	} );
}

if ( document.querySelector( ADS_BANNER_SELECTOR ) ) {
	import( './modules/adsBanner' ).then( ( { AdsBanner } ) => {
		AdsBanner.init( ADS_BANNER_SELECTOR );
	} );
}

function initQuantity() {
	/** @type HTMLElement[] quantityElements */
	const quantityElements = document.querySelectorAll('.quantity');

	quantityElements.forEach((element) => {
		/** @type HTMLInputElement */
		const inputElement = element.querySelector('input.input-text');
		const maxValue = parseInt(inputElement.getAttribute('max'));
		const minValue = parseInt(inputElement.getAttribute('min'));

		element.addEventListener('click', (event) => {
			/** @type HTMLElement target */
			const target = event.target;
			/** @type HTMLButtonElement|null */
			const buttonElement = target.closest('.quantity__button');

			if (!buttonElement) {
				return;
			}

			if (buttonElement.classList.contains('quantity__button--minus')) {
				inputElement.value = Math.max(minValue, inputElement.valueAsNumber - 1);
			} else if (buttonElement.classList.contains('quantity__button--plus')) {
				inputElement.value = Math.min(maxValue, inputElement.valueAsNumber + 1);
			}
		});
	});
}

initQuantity();
