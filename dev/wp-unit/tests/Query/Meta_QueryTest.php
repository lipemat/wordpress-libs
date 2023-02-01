<?php

namespace Lipe\Lib\Query;

/**
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Meta_QueryTest extends \WP_UnitTestCase {

	public function test_in() : void {
		$args = new Args();
		$args->meta_query()
		     ->relation( 'OR' )
		     ->in( [ '0', 'two', false, 0 ], 'some-key', 'BINARY' );

		$this->assertEquals( [
			'meta_query' => [
				'relation' => 'OR',
				[
					'key'     => 'some-key',
					'value'   => [ '0', 'two', false, 0 ],
					'compare' => 'IN',
					'type'    => 'BINARY',
				],
			],
		], $args->get_args() );
	}


	public function test_not_equals() : void {
		$args = new Args();
		$args->meta_query()
		     ->not_equals( 'one', 'some-key', 'CHAR' );

		$this->assertEquals( [
			'meta_query' => [
				[
					'key'     => 'some-key',
					'value'   => 'one',
					'compare' => '!=',
					'type'    => 'CHAR',
				],
			],
		], $args->get_args() );
	}


	public function test_exists() : void {
		$args = new Args();
		$args->meta_query()
		     ->exists( 'some-key' );

		$this->assertEquals( [
			'meta_query' => [
				[
					'key'     => 'some-key',
					'compare' => 'EXISTS',
				],
			],
		], $args->get_args() );
	}


	public function test_sub_query() : void {
		$args = new Args();
		$args->meta_query()
		     ->in( [ 'one', 'two' ], 'some-key' )
		     ->sub_query()
		     ->relation( 'OR' )
		     ->in( [ 'three', 'four' ], 'some-key', 'BINARY' )
		     ->not_exists( 'another-key' );

		$this->assertEquals( [
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'some-key',
					'value'   => [ 'one', 'two' ],
					'compare' => 'IN',
				],
				[
					'relation' => 'OR',
					[
						'key'     => 'some-key',
						'value'   => [ 'three', 'four' ],
						'compare' => 'IN',
						'type'    => 'BINARY',
					],
					[
						'key'     => 'another-key',
						'compare' => 'NOT EXISTS',
					],
				],
			],
		], $args->get_args() );
	}
}
