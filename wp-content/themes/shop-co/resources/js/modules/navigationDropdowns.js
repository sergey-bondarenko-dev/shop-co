import Dropdown from 'bootstrap/js/dist/dropdown';

const DROPDOWN_ITEM_SELECTOR = '.site-navigation__list-item.dropdown';
const DROPDOWN_TOGGLE_SELECTOR = '[data-bs-toggle="dropdown"]';
const HOVER_MEDIA_QUERY = '(any-hover: hover) and (pointer: fine)';
const HIDE_DELAY = 120;

export class NavigationDropdowns {
	static init( selector ) {
		const navigation = document.querySelector( selector );

		if ( ! navigation ) {
			return;
		}

		navigation.classList.add( 'is-ready' );
		this.initHoverDropdowns( navigation );
	}

	static initHoverDropdowns( navigation ) {
		const hoverMedia = window.matchMedia( HOVER_MEDIA_QUERY );
		const dropdownItems = navigation.querySelectorAll( DROPDOWN_ITEM_SELECTOR );

		dropdownItems.forEach( ( item ) => {
			const toggle = item.querySelector( DROPDOWN_TOGGLE_SELECTOR );

			if ( ! toggle ) {
				return;
			}

			this.initHoverDropdown( item, toggle, hoverMedia );
		} );
	}

	static initHoverDropdown( item, toggle, hoverMedia ) {
		const dropdown = Dropdown.getOrCreateInstance( toggle );
		let hideTimer = null;

		item.addEventListener( 'mouseenter', () => {
			if ( ! hoverMedia.matches ) {
				return;
			}

			window.clearTimeout( hideTimer );
			dropdown.show();

			if ( document.activeElement === toggle ) {
				toggle.blur();
			}
		} );

		item.addEventListener( 'mouseleave', () => {
			if ( ! hoverMedia.matches ) {
				return;
			}

			hideTimer = window.setTimeout( () => {
				dropdown.hide();
			}, HIDE_DELAY );
		} );

		hoverMedia.addEventListener( 'change', ( event ) => {
			if ( ! event.matches ) {
				dropdown.hide();
			}
		} );
	}
}
