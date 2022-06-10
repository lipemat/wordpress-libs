<?php

namespace Lipe\Project\Api\Rest;

use Lipe\Lib\Rest_Api\Initial_Data;

/**
 * @author Mat Lipe
 * @since  August 2020
 *
 */
class Initial_DataTest extends \WP_UnitTestCase {

	public function test_no_links() : void {
		$post = self::factory()->post->create_and_get();
		$data = Initial_Data::in()->get_post_data( [ $post ] )[0];
		$this->assertEquals( $post->post_title, $data['title']['rendered'] );
		$this->assertArrayNotHasKey( '_links', $data );
	}


	public function test_with_links() : void {
		$post = self::factory()->post->create_and_get();
		$data = Initial_Data::in()->get_post_data( [ $post ], true )[0];
		$this->assertEquals( $post->post_title, $data['title']['rendered'] );
		$this->assertArrayHasKey( '_links', $data );
		$this->assertArrayNotHasKey( '_embedded', $data );
	}


	public function test_embedded_links() : void {
		$post = self::factory()->post->create_and_get();
		$data = Initial_Data::in()->get_post_data( [ $post ], true, true )[0];
		$this->assertEquals( $post->post_title, $data['title']['rendered'] );
		$this->assertArrayHasKey( '_links', $data );
		$this->assertNotEmpty( $data['_embedded'] );
	}


	public function test_initial_data_from_query() : void {
		$posts = query_posts( [] );
		$data = Initial_Data::in()->get_post_data();
		$this->assertSameSize( $posts, $data, 'Not defaulting to global query!' );

		foreach ( $posts as $k => $post ) {
			$this->assertEquals( $post->ID, $data[ $k ]['id'] );
		}
	}
}
