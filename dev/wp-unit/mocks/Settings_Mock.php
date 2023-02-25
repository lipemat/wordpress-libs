<?php
declare( strict_types=1 );

namespace mocks;

use Lipe\Lib\Settings\Settings_Trait;

/**
 * Mock Comment Object for interacting with the Settings_Trait.
 *
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Settings_Mock implements \ArrayAccess {
	use Settings_Trait;

	public const NAME = 'op';
}
