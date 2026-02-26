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

use Lipe\Lib\CMB2\Box\BoxType;
use Lipe\Lib\CMB2\Field\Default_Callback;
use Lipe\Lib\CMB2\Field\Display;
use Lipe\Lib\CMB2\Field\Event_Callbacks;
use Lipe\Lib\CMB2\Field\Field_Type;
use Lipe\Lib\Container\Container;

// @todo Log to Wiki and remove in version 6.
\class_alias( BoxType::class, 'Lipe\Lib\CMB2\BoxType' );
\class_alias( Default_Callback::class, 'Lipe\Lib\CMB2\Default_Callback' );
\class_alias( Display::class, 'Lipe\Lib\CMB2\Display' );
\class_alias( Event_Callbacks::class, 'Lipe\Lib\CMB2\Event_Callbacks' );
\class_alias( Field_Type::class, 'Lipe\Lib\CMB2\Field_Type' );

// Reset the DI container between tests.
if ( \defined( 'WP_UNIT_DIR' ) ) {
	add_action( 'wp-unit/reset-container', Container::reset( ... ) );
}
