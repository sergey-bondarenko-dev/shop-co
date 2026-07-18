const globals = require( 'globals' );
const wordpressConfig = require( '@wordpress/scripts/config/eslint.config.cjs' );

module.exports = [
	...wordpressConfig,
	{
		languageOptions: {
			globals: {
				...globals.browser,
				...globals.node,
			},
		},
	},
];
