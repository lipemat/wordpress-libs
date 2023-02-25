<?php
declare( strict_types=1 );

namespace mocks;

use Lipe\Lib\User\User_Trait;

/**
 * Mock Term Object for interacting with the User_Trait
 *
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class User_Mock implements \ArrayAccess {
	use User_Trait;
}
