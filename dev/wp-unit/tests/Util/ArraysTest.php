<?php
/**
 * @author Mat Lipe
 * @since  December, 2018
 *
 */

namespace Lipe\Lib\Util;

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


	public function test_clean() : void {
		$source = [
			0 => '',
			1 => false,
			2 => 'first ',
			3 => 'first ',
			4 => 'first',
			5 => null,
			6 => ' second ',
			7 => 'second',
			8 => 0,
		];
		$this->assertSame( [
			2 => 'first',
			6 => 'second',
		], Arrays::in()->clean( $source ) );
		$this->assertSame( [
			0 => 'first',
			1 => 'second',
		], Arrays::in()->clean( $source, false ) );

		$this->assertSame( [
			'f' => 'first',
			's' => 'second',
			'x' => 5,
		], Arrays::in()->clean( [
			0   => '',
			1   => false,
			'f' => 'first ',
			3   => 'first ',
			4   => 'first',
			5   => null,
			's' => ' second ',
			7   => 'second',
			'x' => 5,
			8   => 0,
		] ) );
	}


	public function test_find_index() : void {
		$this->assertEquals( 's', Arrays::in()->find_index( [
			'f' => 'first',
			's' => 'second',
			'x' => 5,
			'v' => 'second',
		], fn( $value ) => $value === 'second' ) );

		$this->assertNull( Arrays::in()->find_index( [
			'f' => 'first',
			's' => 'second',
			'x' => 5,
			'v' => 'second',
		], fn( $value ) => $value === 'not-exists' ) );

		$this->assertEquals( 'v', Arrays::in()->find_index( [
			'f' => 'first',
			's' => 'second',
			'x' => 5,
			'v' => 'second',
		], fn( $value, string $key ) => 's' !== $key && $value === 'second' ) );
	}


	public function test_find() : void {
		$this->assertEquals( [
			'some-key' => 'second',
		], Arrays::in()->find( [
			'f' => [
				'some-key' => 'first',
			],
			's' => [
				'some-key' => 'second',
			],
			'x' => [
				'some-key' => 5,
			],
			'v' => [
				'some-key' => 'second',
			],
		], fn( $value ) => $value['some-key'] === 'second' ) );

		$this->assertNull( Arrays::in()->find( [
			'f' => [
				'some-key' => 'first',
			],
			's' => [
				'some-key' => 'second',
			],
			'x' => [
				'some-key' => 5,
			],
			'v' => [
				'some-key' => 'second',
			],
		], fn( $value ) => $value['some-key'] === 'not-exists' ) );

		$this->assertEquals( [
			'some-key' => 'second',
		], Arrays::in()->find( [
			'f' => [
				'some-key' => 'first',
			],
			's' => [
				'some-key' => 'second',
			],
			'x' => [
				'some-key' => 5,
			],
			'v' => [
				'some-key' => 'second',
			],
		], fn( $value, string $key ) => 's' !== $key && $value['some-key'] === 'second' ) );
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
