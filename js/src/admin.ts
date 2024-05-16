import {CONFIG} from './config';

if ( typeof window.wp.customize !== 'undefined' ) {
	window.wp.customize.bind( 'ready', () => {
		require( './gutenberg' ).default();
	} );
} else if ( '1' === CONFIG.isGutenberg ) {
	require( './gutenberg' ).default();
}
