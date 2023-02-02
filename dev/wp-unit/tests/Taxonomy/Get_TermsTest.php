<?php

namespace Lipe\Lib\Taxonomy;

/**
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Get_TermsTest extends \WP_UnitTestCase {

	public function test_get_args() : void {
		$args = new Get_Terms( [
			'order'  => 'ASC',
			'offset' => 4,
		] );

		$this->assertEquals( [
			'order'  => 'ASC',
			'offset' => 4,
		], $args->get_args(), 'Existing args are not being passed.' );

		$args->fields = 'all';
		$args->taxonomy = [ 'category', 'post_tag' ];
		$args->meta_query()
		     ->in( 'meta-key', [ 4, 5, 6 ], 'NUMERIC' );
		$args->order = 'DESC';

		$this->assertEquals( [
			'order'      => 'DESC',
			'offset'     => 4,
			'fields'     => 'all',
			'taxonomy'   => [ 'category', 'post_tag' ],
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
}
