<?php

namespace Lipe\Lib\Util;

/**
 * @author Mat Lipe
 * @since  January 2023
 *
 */
class QueryTest extends \WP_UnitTestCase {

	public function test_get_light_query() : void {
		$expected = [
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'suppress_filters'       => false,
			'update_menu_item_cache' => false,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		];
		$query = Query::in()->get_light_query_args( [] );
		foreach ( $expected as $arg => $value ) {
			$this->assertEquals( $value, $query[ $arg ] );
		}

		$overrides = [
			'post_status'            => [ 'draft', 'private' ],
			'update_menu_item_cache' => true,
		];
		$query = Query::in()->get_light_query_args( $overrides );
		foreach ( $expected as $arg => $value ) {
			if ( isset( $overrides[ $arg ] ) ) {
				$this->assertEquals( $overrides[ $arg ], $query[ $arg ] );
			} else {
				$this->assertEquals( $value, $query[ $arg ] );
			}
		}
	}
}
