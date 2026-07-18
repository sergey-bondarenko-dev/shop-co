export const assertHtmlElement = ( element, key ) => {
	if ( ! element ) {
		throw new Error( `Element not found: ${ key }` );
	}

	if ( ! ( element instanceof HTMLElement ) ) {
		throw new Error( `Element must be HTMLElement: ${ key }` );
	}
};

export const fetchHtml = async ( uri, options = {} ) => {
	const response = await fetch( uri, options );

	if ( ! response.ok ) {
		throw new Error( `HTTP ${ response.status }` );
	}

	const text = await response.text();

	const parser = new DOMParser();

	return parser.parseFromString( text, 'text/html' );
};
