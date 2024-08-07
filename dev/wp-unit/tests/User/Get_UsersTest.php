<?php

namespace Lipe\Lib\User;

/**
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Get_UsersTest extends \WP_UnitTestCase {

	public function test_get_args(): void {
		$args = new Get_Users( [
			'order'  => 'ASC',
			'offset' => 4,
		] );

		$this->assertEquals( [
			'order'  => 'ASC',
			'offset' => 4,
		], $args->get_args(), 'Existing args are not being passed.' );

		$args->fields = [ 'ID', 'display_name' ];
		$args->login__in = [ 'username-test', 'username-test-2' ];
		$args->meta_query()
		     ->in( 'meta-key', [ 4, 5, 6 ] )
		     ->advanced( 'NUMERIC' );
		$args->order = 'DESC';

		$this->assertEquals( [
			'order'      => 'DESC',
			'offset'     => 4,
			'fields'     => [ 'ID', 'display_name' ],
			'login__in'  => [ 'username-test', 'username-test-2' ],
			'meta_query' => [
				[
					'key'     => 'meta-key',
					'value'   => [ 4, 5, 6 ],
					'compare' => 'IN',
					'type'    => 'NUMERIC',
				],
			],
		], $args->get_args() );
	}


	public function test_merge_existing(): void {
		$query = new \WP_User_Query( [
			'order' => 'ASC',
		] );
		$previous = $query->query_vars;

		$args = new Get_Users( [] );
		$args->orderby( 'include' );
		$args->merge_query( $query );

		$previous['orderby'] = 'include';
		$this->assertEquals( $previous, $query->query_vars );
	}
}
