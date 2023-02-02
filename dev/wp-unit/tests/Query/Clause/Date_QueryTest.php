<?php

namespace Lipe\Lib\Query\Clause;

use Lipe\Lib\Query\Args;

/**
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Date_QueryTest extends \WP_UnitTestCase {

	public function test_after() : void {
		$args = new Args();
		$args->date_query()
		     ->after( '1200', '14', '0' )
		     ->column( 'fake-db-column' );

		$this->assertEquals( [
			'date_query' => [
				[
					'after'  => [
						'year'  => '1200',
						'month' => '14',
					],
					'column' => 'fake-db-column',
				],
			],
		], $args->get_args() );

		$args->date_query()
		     ->after_string( '2022-04-14' );
		$this->assertEquals( [
			'date_query' => [
				[
					'after'  => '2022-04-14',
				],
			],
		], $args->get_args() );
	}


	public function test_before() : void {
		$args = new Args();
		$args->date_query()
		     ->before( '1200', '01', '20' )
		     ->inclusive();

		$this->assertEquals( [
			'date_query' => [
				[
					'before'    => [
						'year'  => '1200',
						'month' => '01',
						'day'   => '20',
					],
					'inclusive' => true,
				],
			],
		], $args->get_args() );
	}


	public function test_next_clause() : void {
		$args = new Args();
		$args->date_query()
		     ->before( '1200', '01', '20' )
		     ->inclusive()
		     ->next_clause()
		     ->relation( 'OR' )
		     ->compare( 'BETWEEN' )
		     ->before_string( '2023-01-14' );

		$this->assertEquals( [
			'date_query' => [
				'relation' => 'OR',
				[
					'before'    => [
						'year'  => '1200',
						'month' => '01',
						'day'   => '20',
					],
					'inclusive' => true,
				],
				[
					'before'  => '2023-01-14',
					'compare' => 'BETWEEN',
				],
			],
		], $args->get_args() );
	}


	public function test_nested_clause_clause() : void {
		$args = new Args();
		$args->date_query()
		     ->before( '1200', '01', '20' )
		     ->inclusive()
		     ->nested_clause( 'OR' )
		     ->before_string( '2023-01-14' )
		     ->after_string( '2023-01-12' )
		     ->next_clause()
		     ->inclusive()
		     ->after( '2001' )
		     ->nested_clause()
		     ->before_string( '2023-02-14' )
		     ->parent_clause()
		     ->inclusive( false )
		     ->parent_clause()
		     ->second( '20' );

		$this->assertEquals( [
			'date_query' => [
				'relation' => 'AND',
				[
					'before'    => [
						'year'  => '1200',
						'month' => '01',
						'day'   => '20',
					],
					'inclusive' => true,
					'second'    => '20',
				],
				[
					'relation' => 'OR',
					[
						'before' => '2023-01-14',
						'after'  => '2023-01-12',
					],
					[
						'after'     => [
							'year' => '2001',
						],
						'inclusive' => false,
					],
					[
						'relation' => 'AND',
						[
							'before' => '2023-02-14',
						],
					],
				],

			],
		], $args->get_args() );
	}
}
