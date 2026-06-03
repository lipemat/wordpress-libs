import type {Configuration} from 'webpack';

/**
 * - Allow running multiple entry points in the same runtime.
 */
export default ( config: Configuration ) => {
	if ( typeof config.optimization === 'object' ) {
		config.optimization.runtimeChunk = 'single';
	}
	return config;
};
