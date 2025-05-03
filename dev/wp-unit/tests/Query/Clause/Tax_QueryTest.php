<?php

namespace Lipe\Lib\Query\Clause;

use Lipe\Lib\Query\Query_Args;

/**
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Tax_QueryTest extends \WP_UnitTestCase {

	public function test_in(): void {
		$args = new Query_Args( [] );
		$args->tax_query()
		     ->relation( 'OR' )
		     ->in( [ 'one', 'two' ], 'post_tag', true, 'slug' );

		$this->assertSame( [
			'tax_query' => [
				'relation' => 'OR',
				[
					'taxonomy' => 'post_tag',
					'field'    => 'slug',
					'terms'    => [ 'one', 'two' ],
					'operator' => 'IN',
				],
			],
		], $args->get_args() );

		$args = new Query_Args( [] );
		$tax = $args->tax_query()
		            ->relation( 'OR' )
		            ->in( [ 'one', 'two' ], 'post_tag', true, 'slug' );

		$tax->nested_clause()
		    ->in( [ 4, 5 ], 'category' )
		    ->in( [ 6, 7 ], 'post_tag' );

		$this->assertSame( [
			'tax_query' => [
				'relation' => 'OR',
				[
					'taxonomy' => 'post_tag',
					'field'    => 'slug',
					'terms'    => [ 'one', 'two' ],
					'operator' => 'IN',
				],
				[
					'relation' => 'AND',
					[
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => [ 4, 5 ],
						'operator' => 'IN',
					],
					[
						'taxonomy' => 'post_tag',
						'field'    => 'term_id',
						'terms'    => [ 6, 7 ],
						'operator' => 'IN',
					],
				],
			],
		], $args->get_args() );
	}


	public function test_exists(): void {
		$args = new Query_Args( [] );
		$args->tax_query()
		     ->exists( 'post_tag' )
		     ->nested_clause()
		     ->relation( 'OR' )
		     ->not_exists( 'category' )
		     ->in( [ 6, 7 ], 'post_tag' );

		$this->assertEquals( [
			'tax_query' => [
				'relation' => 'AND',
				[
					'taxonomy' => 'post_tag',
					'operator' => 'EXISTS',
				],
				[
					'relation' => 'OR',
					[
						'taxonomy' => 'category',
						'operator' => 'NOT EXISTS',
					],
					[
						'taxonomy' => 'post_tag',
						'field'    => 'term_id',
						'terms'    => [ 6, 7 ],
						'operator' => 'IN',
					],
				],
			],
		], $args->get_args() );
	}


	public function test_and(): void {
		$args = new Query_Args( [] );
		$args->tax_query()
		     ->and( [ 4, 5 ], 'category', false )
		     ->nested_clause()
		     ->and( [ 4, 5 ], 'post_tag', false, 'slug' )
		     ->and( [ 4, 5 ], 'post_tag', true, 'slug' );

		$this->assertEquals( [
			'tax_query' => [
				'relation' => 'AND',
				[
					'taxonomy'         => 'category',
					'field'            => 'term_id',
					'terms'            => [ 4, 5 ],
					'operator'         => 'AND',
					'include_children' => false,
				],
				[
					'relation' => 'AND',
					[
						'taxonomy'         => 'post_tag',
						'field'            => 'slug',
						'terms'            => [ 4, 5 ],
						'operator'         => 'AND',
						'include_children' => false,
					],
					[
						'taxonomy' => 'post_tag',
						'field'    => 'slug',
						'terms'    => [ 4, 5 ],
						'operator' => 'AND',
					],
				],
			],
		], $args->get_args() );
	}


	public function test_nested_clauses(): void {
		$args = new Query_Args( [] );
		$args->tax_query()
		     ->and( [ 4, 5 ], 'category', false )
		     ->nested_clause( 'OR' )
		     ->relation( 'AND' )
		     ->exists( 'post_tag' )
		     ->not_exists( 'category' )
		     ->nested_clause( 'OR' )
		     ->not_in( [ 'first' ], 'post_tag', false, 'slug' )
		     ->parent_clause()
		     ->not_in( [ 2 ], 'category' )
		     ->parent_clause()
		     ->in( [ 1, 2 ], 'product' );

		$this->assertEquals( [
			'tax_query' => [
				'relation' => 'AND',
				[
					'taxonomy'         => 'category',
					'field'            => 'term_id',
					'terms'            => [ 4, 5 ],
					'operator'         => 'AND',
					'include_children' => false,
				],
				[
					'taxonomy' => 'product',
					'field'    => 'term_id',
					'terms'    => [ 1, 2 ],
					'operator' => 'IN',
				],
				[
					'relation' => 'AND',
					[
						'taxonomy' => 'post_tag',
						'operator' => 'EXISTS',
					],
					[
						'taxonomy' => 'category',
						'operator' => 'NOT EXISTS',
					],
					[
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => [ 2 ],
						'operator' => 'NOT IN',
					],
					[
						'relation' => 'OR',
						[
							'taxonomy'         => 'post_tag',
							'field'            => 'slug',
							'terms'            => [ 'first' ],
							'operator'         => 'NOT IN',
							'include_children' => false,
						],
					],
				],
			],
		], $args->get_args() );
	}


	public function test_existing_merge(): void {
		$args = new Query_Args( [
			'tax_query' => [
				'relation' => 'OR',
				[
					'taxonomy' => 'post_tag',
					'field'    => 'slug',
					'terms'    => [ 'one', 'two' ],
					'operator' => 'IN',
				],
			],
		] );
		$args->tax_query()
		     ->relation( 'AND' )
		     ->in( [ 'one', 'two' ], 'post_tag', true, 'slug' );

		$this->assertEquals( [
			'tax_query' => [
				'relation' => 'AND',
				[
					'taxonomy' => 'post_tag',
					'field'    => 'slug',
					'terms'    => [ 'one', 'two' ],
					'operator' => 'IN',
				],
				[
					'taxonomy' => 'post_tag',
					'field'    => 'slug',
					'terms'    => [ 'one', 'two' ],
					'operator' => 'IN',
				],
			],
		], $args->get_args() );

		$query = new \WP_Query( [
			'tax_query' => [
				'relation' => 'OR',
				[
					'taxonomy' => 'post_tag',
					'field'    => 'slug',
					'terms'    => [ 'one', 'two' ],
					'operator' => 'IN',
				],
			],
		] );
		$args = new Query_Args( [] );
		$args->tax_query()
		     ->relation( 'AND' )
		     ->in( [ 'one', 'two' ], 'post_tag', true, 'slug' );
		$args->merge_query( $query );
		$this->assertEquals( [
			'relation' => 'AND',
			[
				'taxonomy' => 'post_tag',
				'field'    => 'slug',
				'terms'    => [ 'one', 'two' ],
				'operator' => 'IN',
			],
			[
				'taxonomy' => 'post_tag',
				'field'    => 'slug',
				'terms'    => [ 'one', 'two' ],
				'operator' => 'IN',
			],
		], $query->query_vars['tax_query'] );
	}


	public function test_no_duplicate(): void {
		$args = new Query_Args( [] );
		$args->tax_query()
		     ->relation( 'OR' )
		     ->in( [ 'one', 'two' ], 'post_tag', true, 'slug' );

		$expected = [
			'tax_query' => [
				'relation' => 'OR',
				[
					'taxonomy' => 'post_tag',
					'field'    => 'slug',
					'terms'    => [ 'one', 'two' ],
					'operator' => 'IN',
				],
			],
		];

		$this->assertSame( $expected, $args->get_args() );

		// Call a second time to ensure no duplicates.
		$this->assertSame( $expected, $args->get_args() );
	}
}
