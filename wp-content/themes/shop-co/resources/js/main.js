import "bootstrap/js/dist/offcanvas";
import "bootstrap/js/dist/collapse";

const NAVIGATION_SELECTOR = '#site-navigation';
const SITE_HEADER_SELECTOR = '.site-header';
const NO_UI_SLIDER_SELECTOR = '.site-range';
const TESTIMONIALS_SLIDER_SELECTOR = '.testimonials-slider';
const PRODUCTS_SLIDER_SELECTOR = '.products-slider';
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

if ( document.querySelector( ADS_BANNER_SELECTOR ) ) {
	import( './modules/adsBanner' ).then( ( { AdsBanner } ) => {
		AdsBanner.init( ADS_BANNER_SELECTOR );
	} );
}
