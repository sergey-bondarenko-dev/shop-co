const NO_UI_SLIDER_SELECTOR = '.site-range';
const TESTIMONIALS_SLIDER_SELECTOR = '.testimonials-slider';
const PRODUCTS_SLIDER_SELECTOR = '.products-slider';

const navigation = document.getElementById( 'site-navigation' );

if ( navigation ) {
	navigation.classList.add( 'is-ready' );
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
