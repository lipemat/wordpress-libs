import {autoloadPlugins} from '@lipemat/js-boilerplate-gutenberg';

/**
 * Use our custom autoloader to automatically require,
 * register and add HMR support to Gutenberg related items.
 *
 * Will load from specified directory recursively.
 */

// Load all meta boxes.
if ( typeof window.wp?.editPost !== 'undefined' ) {
	autoloadPlugins( () => require.context( './gutenberg/meta-boxes', true, /index\.tsx$/ ), module );
}
