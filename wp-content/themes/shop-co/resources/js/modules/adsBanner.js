export class AdsBanner {
	static cookieName = 'shop_co_ads_banner_closed';

	static init( selector ) {
		const banner = document.querySelector( selector );

		if ( ! banner ) {
			return;
		}

		const closeButton = banner.querySelector( '.ads-banner__close' );

		if ( ! closeButton ) {
			return;
		}

		closeButton.addEventListener( 'click', () => {
			this.setClosedCookie();
			banner.remove();
		} );
	}

	static setClosedCookie() {
		const maxAge = 60 * 60 * 24 * 30;

		document.cookie = `${ this.cookieName }=yes; path=/; max-age=${ maxAge }; SameSite=Lax`;
	}
}
