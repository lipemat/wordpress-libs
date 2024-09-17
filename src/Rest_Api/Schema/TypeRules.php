<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

/**
 * Rules a `type` must follow.
 *
 * Mostly here to make sure all types have a common interface.
 *
 * @author Mat Lipe
 * @since  5.2.0
 */
interface TypeRules {
	/**
	 * @return array<string, mixed>
	 */
	public function get_args(): array;
}
