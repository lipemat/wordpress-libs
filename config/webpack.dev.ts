import type {Configuration, RuleSetRule} from 'webpack';

/**
 * - Allow running multiple entry points in the same runtime.
 */
module.exports = ( config: Configuration ) => {
	if ( typeof config.optimization === 'object' ) {
		config.optimization.runtimeChunk = 'single';
	}
	return config;
};
