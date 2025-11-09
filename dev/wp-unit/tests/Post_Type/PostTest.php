<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Libs\Container;

/**
 * @author Mat Lipe
 * @since  November 2025
 *
 */
class PostTest extends \WP_UnitTestCase {
	public function test_container_change(): void {
		$this->assertInstanceOf( Post::class, Post::factory( 1 ) );
		$this->assertSame( 1, Post::factory( 1 )->get_id() );

		Container::instance()->set_factory( Post::class, fn() => new class( 1 ) extends Post {
			public function get_id(): int {
				return 999;
			}
		} );
		$this->assertSame( 999, Post::factory( 1 )->get_id() );
	}
}

class Post {
	use Post_Object_Trait;
}
