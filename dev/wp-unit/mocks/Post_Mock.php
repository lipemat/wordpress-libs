<?php
declare( strict_types=1 );

namespace mocks;

use Lipe\Lib\Post_Type\Post_Object_Trait;

/**
 * Mock Post Object for interacting with the Post_Object_Trait
 *
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Post_Mock implements \ArrayAccess {
	use Post_Object_Trait;

	public const NAME = 'post';


	public static function factory( int|\WP_Post|null $post = null ): Post_Mock {
		return new self( $post );
	}
}
