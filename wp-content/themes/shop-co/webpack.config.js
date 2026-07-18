const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const RemoveEmptyScriptsPlugin = require( 'webpack-remove-empty-scripts' );
const path = require( 'path' );

const sassRule = defaultConfig.module.rules.find( ( rule ) =>
	rule.test?.test( 'styles.scss' )
);
const sassLoader = sassRule.use.find(
	( loader ) =>
		typeof loader === 'object' && loader.loader?.includes( 'sass-loader' )
);

sassLoader.options = {
	...sassLoader.options,
	sassOptions: {
		quietDeps: true,
		silenceDeprecations: [ 'import' ],
	},
};

module.exports = {
	...defaultConfig,
	output: {
		...defaultConfig.output,
		assetModuleFilename: 'fonts/[name][ext]',
	},
	entry: {
		'js/main': path.resolve( process.cwd(), 'resources/js', 'main.js' ),
		'js/editor': path.resolve( process.cwd(), 'resources/js', 'editor.js' ),
		'css/screen': path.resolve(
			process.cwd(),
			'resources/scss',
			'screen.scss'
		),
		'css/catalog': path.resolve(
			process.cwd(),
			'resources/scss',
			'catalog.scss'
		),
		'css/product': path.resolve(
			process.cwd(),
			'resources/scss',
			'product.scss'
		),
		'css/cart': path.resolve(
			process.cwd(),
			'resources/scss',
			'cart.scss'
		),
		'css/checkout': path.resolve(
			process.cwd(),
			'resources/scss',
			'checkout.scss'
		),
		'css/account': path.resolve(
			process.cwd(),
			'resources/scss',
			'account.scss'
		),
		'css/editor': path.resolve(
			process.cwd(),
			'resources/scss',
			'editor.scss'
		),
	},
	plugins: [
		...defaultConfig.plugins,
		new RemoveEmptyScriptsPlugin( {
			stage: RemoveEmptyScriptsPlugin.STAGE_AFTER_PROCESS_PLUGINS,
		} ),
	],
};
