<?php

namespace Lipe\Lib\Query\Clause;

use Lipe\Lib\Query\Args;

/**
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Tax_QueryTest extends \WP_UnitTestCase {

	public function test_in() : void {
		$args = new Args();
		$tax = $args->tax_query()
		            ->relation( 'OR' )
		            ->in( [ 'one', 'two' ], 'post_tag', true, 'slug' );

		$this->assertEquals( [
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

		$tax->sub_query()
		    ->in( [ 4, 5 ], 'category' )
		    ->in( [ 6, 7 ], 'post_tag' );

		$this->assertEquals( [
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


	public function test_exists() : void {
		$args = new Args();
		$args->tax_query()
		     ->exists( 'post_tag' )
		     ->sub_query()
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


	public function test_and() : void {
		$args = new Args();
		$args->tax_query()
		     ->and( [ 4, 5 ], 'category', false )
		     ->sub_query()
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
}
