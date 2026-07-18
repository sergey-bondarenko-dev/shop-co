export class ProductVariations {
	static init( selector ) {
		document.querySelectorAll( selector ).forEach( ( form ) => {
			ProductVariations.initForm( form );
		} );
	}

	static initForm( form ) {
		const radios = form.querySelectorAll(
			'.site-variations input[type="radio"][data-attribute-name]'
		);
		const selects = form.querySelectorAll( '.variations select' );

		if ( radios.length <= 0 || selects.length <= 0 ) {
			return;
		}

		radios.forEach( ( radio ) => {
			radio.addEventListener( 'change', () => {
				if ( ! radio.checked ) {
					return;
				}

				const select = ProductVariations.getSelectForRadio(
					form,
					radio
				);

				if ( ! select ) {
					return;
				}

				select.value = radio.value;
				select.dispatchEvent(
					new Event( 'change', { bubbles: true } )
				);
			} );
		} );

		selects.forEach( ( select ) => {
			select.addEventListener( 'change', () => {
				ProductVariations.syncRadiosFromSelect( form, select );
			} );

			ProductVariations.syncRadiosFromSelect( form, select );
		} );

		if ( window.jQuery ) {
			window
				.jQuery( form )
				.on( 'woocommerce_update_variation_values', () => {
					selects.forEach( ( select ) => {
						ProductVariations.syncRadiosFromSelect( form, select );
					} );
				} );
		}
	}

	static getSelectForRadio( form, radio ) {
		return form.querySelector(
			`.variations select[name="${ radio.dataset.attributeName }"]`
		);
	}

	static syncRadiosFromSelect( form, select ) {
		const radios = form.querySelectorAll(
			`.site-variations input[type="radio"][data-attribute-name="${ select.name }"]`
		);

		radios.forEach( ( radio ) => {
			const option = Array.from( select.options ).find(
				( item ) => item.value === radio.value
			);

			radio.checked = radio.value === select.value;
			radio.disabled = option ? option.disabled : true;
			radio
				.closest( 'label' )
				?.classList.toggle( 'is-disabled', radio.disabled );
		} );
	}
}
