import type {CssLoaderConfig} from '@lipemat/js-boilerplate/config/css-loader.config';

/**
 * - Use long class names for CSS Modules.
 */
module.exports = function( config: CssLoaderConfig ): CssLoaderConfig {
	if ( 'production' === process.env.NODE_ENV && 'object' === typeof config.modules && config.modules !== null ) {
		config.modules.localIdentName = 'wp-libs_[name]_[local]_[contenthash:base64:5]';
	}
	return config;
};
