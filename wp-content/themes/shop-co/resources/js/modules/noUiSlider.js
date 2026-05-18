import noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css';

export class NoUiSlider {
	static defaults = {
		min: 0,
		max: 250,
		start: [ 50, 200 ],
		step: 1,
		connect: true,
		tooltips: true,
		prefix: '$',
		suffix: '',
	};

	static init( selector ) {
		const sliders = document.querySelectorAll( selector );
		if ( sliders.length <= 0 ) {
			return;
		}

		sliders.forEach( ( slider ) => {
			noUiSlider.create( slider, this.getOptions( slider ) );
		} );
	}

	static getOptions( slider ) {
		const options = {
			min: this.getNumber( slider.dataset.min, this.defaults.min ),
			max: this.getNumber( slider.dataset.max, this.defaults.max ),
			start: this.getStart( slider.dataset.start ),
			step: this.getNumber( slider.dataset.step, this.defaults.step ),
			connect: this.getBoolean(
				slider.dataset.connect,
				this.defaults.connect
			),
			tooltips: this.getBoolean(
				slider.dataset.tooltips,
				this.defaults.tooltips
			),
			prefix: slider.dataset.prefix ?? this.defaults.prefix,
			suffix: slider.dataset.suffix ?? this.defaults.suffix,
		};

		return {
			start: options.start,
			connect: options.connect,
			step: options.step,
			tooltips: options.tooltips
				? this.getTooltips( options, options.start.length )
				: false,
			range: {
				min: options.min,
				max: options.max,
			},
		};
	}

	static getStart( value ) {
		if ( ! value ) {
			return this.defaults.start;
		}

		const values = value
			.split( ',' )
			.map( ( item ) => Number( item.trim() ) );

		if ( values.some( Number.isNaN ) ) {
			return this.defaults.start;
		}

		return values;
	}

	static getNumber( value, fallback ) {
		const number = Number( value );

		return Number.isNaN( number ) ? fallback : number;
	}

	static getBoolean( value, fallback ) {
		if ( value === undefined ) {
			return fallback;
		}

		return value !== 'false';
	}

	static getTooltips( { prefix, suffix }, count ) {
		const format = {
			to: ( value ) => `${ prefix }${ Math.round( value ) }${ suffix }`,
		};

		return Array( count ).fill( format );
	}
}
