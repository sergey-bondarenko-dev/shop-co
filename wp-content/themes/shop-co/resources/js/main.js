const NO_UI_SLIDER_SELECTOR = '.site-range';

const navigation = document.getElementById( 'site-navigation' );

if ( navigation ) {
	navigation.classList.add( 'is-ready' );
}

if ( document.querySelector( NO_UI_SLIDER_SELECTOR ) ) {
	import( './modules/noUiSlider' ).then( ( { NoUiSlider } ) => {
		NoUiSlider.init( NO_UI_SLIDER_SELECTOR );
	} );
}
