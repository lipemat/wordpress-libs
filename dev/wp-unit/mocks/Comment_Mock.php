<?php
declare( strict_types=1 );

namespace mocks;

use Lipe\Lib\Comment\Comment_Trait;

/**
 * Mock Comment Object for interacting with the Comment_Trait
 *
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Comment_Mock implements \ArrayAccess {
	use Comment_Trait;
}
