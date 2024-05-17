/**
 * Entry points to be loaded by Webpack.
 *
 * Checks for sources in the order they are defined and creates a
 * single entry per key if a source file exists.
 *
 * @see getEntries
 */

export type EntriesConfig = {
	[ file: string ]: string[];
};

const entries: EntriesConfig = {
	'meta-boxes': [
		'meta-boxes.ts',
	],
};

module.exports = entries;
