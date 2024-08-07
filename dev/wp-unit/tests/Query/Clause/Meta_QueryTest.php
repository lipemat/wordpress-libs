<?php

namespace Lipe\Lib\Query\Clause;

use Lipe\Lib\Query\Query_Args;

/**
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Meta_QueryTest extends \WP_UnitTestCase {

	public function test_in(): void {
		$args = new Query_Args( [] );
		$args->meta_query()
		     ->relation( 'OR' )
		     ->in( [ 'some-key', 'another-key' ], [ '0', 'two', false, 0 ] )
		     ->advanced( 'REGEX', 'LIKE', 'BINARY' );

		$this->assertEquals( [
			'meta_query' => [
				'relation' => 'OR',
				[
					'key'         => [ 'some-key', 'another-key' ],
					'value'       => [ '0', 'two', false, 0 ],
					'compare'     => 'IN',
					'type'        => 'REGEX',
					'compare_key' => 'LIKE',
					'type_key'    => 'BINARY',
				],
			],
		], $args->get_args() );
	}


	public function test_not_equals(): void {
		$args = new Query_Args( [] );
		$args->meta_query()
		     ->not_equals( 'some-key', 'one' )
		     ->advanced( 'CHAR' );

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


	public function test_exists(): void {
		$args = new Query_Args( [] );
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


	public function test_nested_clause(): void {
		$args = new Query_Args( [] );
		$args->meta_query()
		     ->in( 'some-key', [ 'one', 'two' ] )
		     ->nested_clause()
		     ->relation( 'OR' )
		     ->in( 'some-key', [ 'three', 'four' ] )
		     ->advanced( 'BINARY' )
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


	public function tested_nested_multiple(): void {
		$args = new Query_Args( [] );
		$args->meta_query()
		     ->exists( 'some-key' )
		     ->nested_clause( 'OR' )
		     ->not_exists( [ 'another-key' ] )
		     ->advanced( 'NUMERIC', 'LIKE' )
		     ->nested_clause()
		     ->between( 'between-key', [ 1, 2 ] )
		     ->advanced( 'NUMERIC' )
		     ->parent_clause()
		     ->exists( 'third-key' )
		     ->not_exists( 'fourth-key' )
		     ->parent_clause()
		     ->not_exists( 'fifth-key' );

		$this->assertEquals( [
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'some-key',
					'compare' => 'EXISTS',
				],
				[
					'key'     => 'fifth-key',
					'compare' => 'NOT EXISTS',
				],
				[
					'relation' => 'OR',
					[
						'key'         => [ 'another-key' ],
						'compare'     => 'NOT EXISTS',
						'type'        => 'NUMERIC',
						'compare_key' => 'LIKE',
					],
					[
						'key'     => 'third-key',
						'compare' => 'EXISTS',
					],
					[
						'key'     => 'fourth-key',
						'compare' => 'NOT EXISTS',
					],
					[
						'relation' => 'AND',
						[
							'key'     => 'between-key',
							'compare' => 'BETWEEN',
							'value'   => [ 1, 2 ],
							'type'    => 'NUMERIC',
						],
					],
				],
			],
		], $args->get_args() );
	}


	public function test_existing_merge(): void {
		$args = new Query_Args( [
			'meta_query' => [
				[
					'key'   => 'existing',
					'value' => true,
				],
				'relation' => 'AND',
			],
		] );

		$args->meta_query()->in( 'new', [ '1' ] )
		     ->relation( 'OR' );
		$this->assertEquals( [
			'meta_query' => [
				'relation' => 'OR',
				[
					'key'   => 'existing',
					'value' => true,
				],
				[
					'key'     => 'new',
					'compare' => 'IN',
					'value'   => [ '1' ],
				],
			],
		], $args->get_args() );

		$query = new \WP_Query( [
			'meta_query' => [
				[
					'key'   => 'previous',
					'value' => 'on',
				],
			],
		] );
		$args = new Query_Args( [] );
		$args->meta_query()->in( 'new', [ '1' ] )
		     ->relation( 'OR' );
		$args->merge_query( $query );
		$this->assertEquals( [
			'relation' => 'OR',
			[
				'key'   => 'previous',
				'value' => 'on',
			],
			[
				'key'     => 'new',
				'compare' => 'IN',
				'value'   => [ '1' ],
			],
		], $query->query_vars['meta_query'] );
	}
}
