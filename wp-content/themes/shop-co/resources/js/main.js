import Offcanvas from 'bootstrap/js/dist/offcanvas';
import 'bootstrap/js/dist/collapse';
import 'bootstrap/js/dist/modal';
import { ReviewManager } from './modules/ReviewManager';

const NAVIGATION_SELECTOR = '#site-navigation';
const SITE_HEADER_SELECTOR = '.site-header';
const NO_UI_SLIDER_SELECTOR = '.site-range';
const TESTIMONIALS_SLIDER_SELECTOR = '.testimonials-slider';
const PRODUCTS_SLIDER_SELECTOR = '.products-slider';
const PRODUCT_GALLERY_SELECTOR = '.site-product-gallery';
const PRODUCT_VARIATIONS_SELECTOR = '.variations_form';
const ADS_BANNER_SELECTOR = '.ads-banner';
const CART_UPDATE_DELAY = 400;

let cartUpdateTimeoutId;

const isSingleProductPage =
	document.body.classList.contains( 'single-product' );
const hasReviewList = document.getElementById( 'comment-list' );

if ( isSingleProductPage && hasReviewList ) {
	new ReviewManager().init();
}

if ( document.querySelector( NAVIGATION_SELECTOR ) ) {
	import( './modules/navigationDropdowns' ).then(
		( { NavigationDropdowns } ) => {
			NavigationDropdowns.init( NAVIGATION_SELECTOR );
		}
	);
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

document.addEventListener( 'click', ( event ) => {
	const buttonElement = event.target.closest?.( '.quantity__button' );

	if ( ! buttonElement ) {
		return;
	}

	const quantityElement = buttonElement.closest( '.quantity' );
	/** @type {HTMLInputElement|null} */
	const inputElement = quantityElement?.querySelector( 'input.qty' );

	if ( ! inputElement ) {
		return;
	}

	const step =
		inputElement.step === 'any' ? 1 : Number( inputElement.step ) || 1;
	const minValue = inputElement.min === '' ? 0 : Number( inputElement.min );
	const maxValue =
		inputElement.max === '' ? Infinity : Number( inputElement.max );
	const currentValue = Number.isNaN( inputElement.valueAsNumber )
		? minValue
		: inputElement.valueAsNumber;
	const previousValue = inputElement.value;

	if ( buttonElement.classList.contains( 'quantity__button--minus' ) ) {
		inputElement.value = String(
			Math.max( minValue, currentValue - step )
		);
	} else if ( buttonElement.classList.contains( 'quantity__button--plus' ) ) {
		inputElement.value = String(
			Math.min( maxValue, currentValue + step )
		);
	}

	if ( inputElement.value !== previousValue ) {
		inputElement.dispatchEvent( new Event( 'change', { bubbles: true } ) );
	}
} );

document.addEventListener( 'change', ( event ) => {
	const inputElement = event.target.closest?.(
		'.woocommerce-cart-form input.qty'
	);

	if ( ! inputElement ) {
		return;
	}

	const cartForm = inputElement.closest( '.woocommerce-cart-form' );
	const updateButton = cartForm?.querySelector( '[name="update_cart"]' );

	if ( ! updateButton ) {
		return;
	}

	clearTimeout( cartUpdateTimeoutId );
	cartUpdateTimeoutId = setTimeout( () => {
		updateButton.disabled = false;
		updateButton.click();
	}, CART_UPDATE_DELAY );
} );

document.addEventListener( 'submit', async ( event ) => {
	const productForm = event.target.closest?.(
		'.site-single-product form.cart'
	);

	if ( ! productForm ) {
		return;
	}

	const submitButton = productForm.querySelector(
		'.single_add_to_cart_button'
	);
	const cartFragmentsParams = window.wc_cart_fragments_params;
	const supportsAjax =
		productForm.classList.contains( 'variations_form' ) ||
		Number( submitButton?.value ) > 0;

	if (
		! submitButton ||
		! supportsAjax ||
		! cartFragmentsParams ||
		! window.jQuery
	) {
		return;
	}

	event.preventDefault();

	if (
		submitButton.disabled ||
		submitButton.classList.contains( 'disabled' ) ||
		productForm.dataset.shopcoAddingToCart === 'true'
	) {
		return;
	}

	const formData = new FormData( productForm );
	const variationId = Number( formData.get( 'variation_id' ) ) || 0;
	const productId =
		variationId ||
		Number( formData.get( 'product_id' ) ) ||
		Number( submitButton.value );

	if ( ! productId ) {
		return;
	}

	formData.set( 'product_id', String( productId ) );
	productForm.dataset.shopcoAddingToCart = 'true';
	submitButton.disabled = true;
	submitButton.classList.add( 'loading' );
	submitButton.setAttribute( 'aria-busy', 'true' );

	try {
		const response = await fetch(
			cartFragmentsParams.wc_ajax_url.replace(
				'%%endpoint%%',
				'add_to_cart'
			),
			{
				method: 'POST',
				body: formData,
			}
		);

		if ( ! response.ok ) {
			throw new Error( 'Unable to add the product to the cart.' );
		}

		const responseData = await response.json();

		if ( responseData.error && responseData.product_url ) {
			window.location.href = responseData.product_url;
			return;
		}

		if ( ! responseData.fragments ) {
			throw new Error( 'Cart fragments are missing.' );
		}

		window
			.jQuery( document.body )
			.trigger( 'added_to_cart', [
				responseData.fragments,
				responseData.cart_hash,
				false,
			] );

		const miniCartElement = document.getElementById( 'site-mini-cart' );

		if ( miniCartElement ) {
			Offcanvas.getOrCreateInstance( miniCartElement ).show();
		}
	} catch {
		window.location.reload();
	} finally {
		delete productForm.dataset.shopcoAddingToCart;
		submitButton.disabled = false;
		submitButton.classList.remove( 'loading' );
		submitButton.removeAttribute( 'aria-busy' );
	}
} );

document.addEventListener( 'submit', async ( event ) => {
	const couponForm = event.target.closest?.( '.shopco-cart-coupon' );

	if ( ! couponForm ) {
		return;
	}

	if ( couponForm.dataset.shopcoNativeSubmit === 'true' ) {
		delete couponForm.dataset.shopcoNativeSubmit;
		return;
	}

	const couponInput = couponForm.querySelector( '#coupon_code' );
	const submitButton = couponForm.querySelector( '[name="apply_coupon"]' );
	const cartParams = window.wc_cart_params;

	if ( ! couponInput || ! submitButton || ! cartParams || ! window.jQuery ) {
		return;
	}

	event.preventDefault();

	const couponCode = couponInput.value.trim();
	const endpoint = cartParams.wc_ajax_url.replace(
		'%%endpoint%%',
		'apply_coupon'
	);

	couponForm.querySelector( '.coupon-error-notice' )?.remove();
	couponInput.classList.remove( 'has-error' );
	couponInput.removeAttribute( 'aria-invalid' );
	couponInput.removeAttribute( 'aria-describedby' );
	submitButton.disabled = true;

	try {
		const response = await fetch( endpoint, {
			method: 'POST',
			headers: {
				'Content-Type':
					'application/x-www-form-urlencoded; charset=UTF-8',
			},
			body: new URLSearchParams( {
				security: cartParams.apply_coupon_nonce,
				coupon_code: couponCode,
			} ),
		} );
		const responseHtml = await response.text();
		const responseTemplate = document.createElement( 'template' );

		responseTemplate.innerHTML = responseHtml.trim();

		const errorNotice = responseTemplate.content.querySelector(
			'.woocommerce-error, .is-error'
		);

		if ( errorNotice ) {
			const errorElement = document.createElement( 'p' );

			errorElement.className = 'coupon-error-notice';
			errorElement.id = 'coupon-error-notice';
			errorElement.setAttribute( 'role', 'alert' );
			errorElement.textContent = errorNotice.textContent.trim();
			couponInput.classList.add( 'has-error' );
			couponInput.setAttribute( 'aria-invalid', 'true' );
			couponInput.setAttribute( 'aria-describedby', errorElement.id );
			couponForm.append( errorElement );
			return;
		}

		document
			.querySelectorAll(
				'.woocommerce-error, .woocommerce-message, .woocommerce-info, .is-error, .is-info, .is-success'
			)
			.forEach( ( notice ) => notice.remove() );

		document
			.querySelector( '.woocommerce-notices-wrapper' )
			?.prepend( responseTemplate.content.cloneNode( true ) );

		window
			.jQuery( document.body )
			.trigger( 'applied_coupon', [ couponCode ] );
		window.jQuery( document ).trigger( 'wc_update_cart', [ true ] );
	} catch {
		submitButton.disabled = false;
		couponForm.dataset.shopcoNativeSubmit = 'true';
		couponForm.requestSubmit( submitButton );
	} finally {
		submitButton.disabled = false;
	}
} );
