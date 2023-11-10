<?php

namespace Lipe\Lib\Comment;

/**
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Get_CommentsTest extends \WP_UnitTestCase {

	public function test_get_args() : void {
		$args = new Get_Comments( [
			'order'  => 'ASC',
			'offset' => 4,
		] );

		$this->assertEquals( [
			'order'  => 'ASC',
			'offset' => 4,
		], $args->get_args(), 'Existing args are not being passed.' );

		$args->fields = 'all';
		$args->comment__in = [ 4 ];
		$args->orderby( [ 'comment_agent', 'comment__in' ] );
		$args->meta_query()
		     ->in( 'meta-key', [ 4, 5, 6 ] )
		     ->advanced( 'NUMERIC' );
		$args->order = 'DESC';

		$args->date_query()
		     ->after( '1200', '14', '0' )
		     ->column( 'fake-db-column' );

		$this->assertEquals( [
			'order'      => 'DESC',
			'offset'     => 4,
			'fields'     => 'all',
			'orderby'    => [ 'comment_agent', 'comment__in' ],
			'date_query' => [
				[
					'after'  => [
						'year'  => '1200',
						'month' => '14',
					],
					'column' => 'fake-db-column',
				],
			],
			'meta_query' => [
				[
					'key'     => 'meta-key',
					'value'   => [ 4, 5, 6 ],
					'compare' => 'IN',
					'type'    => 'NUMERIC',
				],
			],
			'comment__in' => [ 4 ],
		], $args->get_args() );
	}


	public function test_merge_query() : void {
		$query = new \WP_Comment_Query( [
			'parent' => '4455',
		] );
		$previous = $query->query_vars;

		$args = new Get_Comments( [] );
		$args->karma = 4;
		$args->orderby( 'user_id' );
		$args->merge_query( $query );

		$previous['orderby'] = 'user_id';
		$previous['karma'] = 4;
		$previous['parent'] = 4455;
		$this->assertEquals( $previous, $query->query_vars );
	}
}
