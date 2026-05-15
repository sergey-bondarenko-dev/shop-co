const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const RemoveEmptyScriptsPlugin = require( 'webpack-remove-empty-scripts' );
const path = require( 'path' );

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
