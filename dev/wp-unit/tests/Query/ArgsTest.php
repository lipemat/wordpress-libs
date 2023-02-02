<?php

namespace Lipe\Lib\Query;

/**
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class ArgsTest extends \WP_UnitTestCase {

	public function test_get_args() : void {
		$args = new Args();
		$args->lazy_load_term_meta = false;
		$args->update_post_meta_cache = false;

		$this->assertEquals( [
			'lazy_load_term_meta'    => false,
			'update_post_meta_cache' => false,
		], $args->get_args(), 'False values are not be returned.' );
	}
}
