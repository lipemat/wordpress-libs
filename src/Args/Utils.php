<?php
declare( strict_types=1 );

namespace Lipe\Lib\Args;

use Lipe\Lib\Traits\Singleton;

/**
 * Utility functions for Args classes.
 *
 * @author Mat Lipe
 * @since  5.0.0
 */
class Utils {
	use Singleton;

	/**
	 * Get the names and values of all public properties of a passed
	 * class or object.
	 *
	 * @param object $this_object - Object to get properties from.
	 *
	 * @return array<string, mixed>
	 */
	public function get_public_object_vars( object $this_object ): array {
		return \get_object_vars( $this_object );
	}
}
