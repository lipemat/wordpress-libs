<?php
/**
 * @author Mat Lipe
 * @since  December, 2018
 *
 */

namespace Lipe\Project\Util;

use Lipe\Lib\Util\Arrays;

class ArraysTest extends \WP_UnitTestCase {
	public function test_array_chunk_to_associative() : void {
		$this->assertSame( [
			'page'     => 3,
			'category' => 6,
		], Arrays::in()->chunk_to_associative( [ 'page', 3, 'category', 6 ] ) );

		$this->assertSame( [
			3 => 6,
		], Arrays::in()->chunk_to_associative( [
			'page'     => 3,
			'category' => 6,
		] ) );

		$this->assertSame( [
			'page'     => 3,
			'category' => 6,
			0          => 'extra',
		], Arrays::in()->chunk_to_associative( [ 'page', 3, 'category', 6, 'extra' ] ) );
	}


	public function testArray_merge_recursive() : void {
		$default = [
			'h' => 'x',
			'y' => 'b',
			'p' => [
				'l' => 'm',
				'x' => 'i',
			],
		];

		$new = [
			'y' => 'c',
			'p' => 'one',
		];

		$this->assertSame( [
			'h' => 'x',
			'y' => 'c',
			'p' => 'one',
		], Arrays::in()->merge_recursive( $new, $default ) );

		$new = [
			'y' => 'c',
			'p' => [
				'l' => 'o',
				'k' => 'p',
			],
		];

		$this->assertSame( [
			'h' => 'x',
			'y' => 'c',
			'p' => [
				'l' => 'o',
				'x' => 'i',
				'k' => 'p',
			],
		], Arrays::in()->merge_recursive( $new, $default ) );
	}


	public function test_array_flatten_assoc() : void {
		$posts = get_posts();
		$result = Arrays::in()->flatten_assoc( function ( \WP_Post $post ) {
			return [ $post->ID => $post->post_name ];
		}, $posts );
		$expected = [];
		foreach ( $posts as $post ) {
			$expected[ $post->ID ] = $post->post_name;
		}
		$this->assertEquals( $expected, $result );

		$result = Arrays::in()->flatten_assoc( function ( \WP_Post $post ) {
			return [ $post->post_title => $post->post_name ];
		}, $posts );
		$expected = [];
		foreach ( $posts as $post ) {
			$expected[ $post->post_title ] = $post->post_name;
		}
		$this->assertEquals( $expected, $result );
	}


	public function test_list_pluck() : void {
		$data = [
			(object) [
				'one'   => 'uno',
				'two'   => 'does',
				'three' => 'tries',
			],
			[
				'one'   => 'ut',
				'two'   => 'twice',
				'three' => 'out',
			],
			(object) [
				'one'   => 'etch',
				'two'   => 'both',
				'three' => 'all',
			],
		];

		$this->assertEquals( [
			[ 'one' => 'uno', 'three' => 'tries' ],
			[ 'one' => 'ut', 'three' => 'out' ],
			[ 'one' => 'etch', 'three' => 'all' ],
		], Arrays::in()->list_pluck( $data, [ 'one', 'three' ] ) );
	}
}