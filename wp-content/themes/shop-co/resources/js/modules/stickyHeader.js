const SCROLLED_CLASS = 'is-scrolled';

export class StickyHeader {
	static init( selector ) {
		const header = document.querySelector( selector );

		if ( ! header ) {
			return;
		}

		let ticking = false;

		const update = () => {
			header.classList.toggle( SCROLLED_CLASS, window.scrollY > 0 );
			ticking = false;
		};

		window.addEventListener(
			'scroll',
			() => {
				if ( ticking ) {
					return;
				}

				ticking = true;
				window.requestAnimationFrame( update );
			},
			{ passive: true }
		);

		update();
	}
}
