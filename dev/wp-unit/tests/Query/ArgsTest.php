<?php

namespace Lipe\Lib\Query;

/**
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class ArgsTest extends \WP_UnitTestCase {

	public function test_get_args(): void {
		$args = new Query_Args( [] );
		$args->lazy_load_term_meta = false;
		$args->update_post_meta_cache = false;

		$this->assertEquals( [
			'lazy_load_term_meta'    => false,
			'update_post_meta_cache' => false,
		], $args->get_args(), 'False values are not be returned.' );
	}


	public function test_get_preload(): void {
		$args = new Query_Args( [
			'lazy_load_term_meta'    => false,
			'update_post_meta_cache' => false,
		] );
		$this->assertEquals( [
			'lazy_load_term_meta'    => false,
			'update_post_meta_cache' => false,
		], $args->get_args(), 'Preloading is not working.' );
	}


	public function test_merge_query(): void {
		$query = new \WP_Query( [
			'orderby' => 'post_title',
		] );

		$previous = $query->query_vars;

		$args = new Query_Args( [] );
		$args->orderby( 'date' );
		$args->merge_query( $query );
		$previous['orderby'] = 'date';

		$this->assertEquals( $previous, $query->query_vars );
	}


	public function test_string_paged(): void {
		$query = new \WP_Query();
		$query->parse_query( [
			'paged' => '2',
			'page' => '4',
		] );
		$args = new Query_Args( [] );
		$args->merge_query( $query );
		$this->assertEquals( 2, $args->get_args()['paged'] );
		$this->assertEquals( 4, $args->get_args()['page'] );
	}
}
