/**
 * Entry points to be loaded by Webpack.
 *
 * Checks for sources in the order they are defined and creates a
 * single entry per key if a source file exists.
 *
 * @see getEntries
 */

type EntriesConfig = {
	[ file: string ]: string[];
};

module.exports = function( config: EntriesConfig ): EntriesConfig {
	config[ 'block-editor' ] = [
		'block-editor.ts',
	];
	return config;
};
