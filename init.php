<?php
declare( strict_types=1 );

/**
 * Intialize the library.
 *
 * Minimal intitilization is required as classes are loades as/if they
 * are used.
 *
 * @author Mat Lipe
 * @since  5.6.1
 */

use Lipe\Lib\Libs\Container;

// Reset the DI container between tests.
if ( \defined( 'WP_UNIT_DIR' ) ) {
	add_action( 'wp-unit/reset-container', Container::reset( ... ) );
}
