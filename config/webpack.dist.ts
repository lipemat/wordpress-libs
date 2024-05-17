import {Configuration} from 'webpack';

/**
 * Enable source maps for dist builds because we're not supporting start.
 */
module.exports = ( config: Configuration ) => {
	config.devtool = 'source-map';
	return config;
};
