import {autoloadPlugins} from '@lipemat/js-boilerplate-gutenberg';

/**
 * Use our custom autoloader to automatically require,
 * register and add HMR support to Gutenberg related items.
 *
 * Will load from specified directory recursively.
 */
export default () => {
	// Load all meta boxes.
	if ( typeof window.wp?.editPost !== 'undefined' ) {
		autoloadPlugins( () => require.context( './meta-boxes', true, /index\.tsx$/ ), module );
	}
}
