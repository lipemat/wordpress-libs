<?php
/**
 * SortableTest.php
 *
 * @author  mat
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type *
 */

namespace Lipe\Lib\Post_Type\Extended_CPTS;

use Lipe\Lib\Post_Type\Custom_Post_Type_Extended;

class SortableTest extends \WP_UnitTestCase {

	function test_meta_sort(){
		$cpt = new Custom_Post_Type_Extended( 'test' );
		$cpt->site_sortables()
		    ->meta( 'sort_key_t', 'meta_key_t' )
			->set_as_default_sort_sortable( 'DESC' );


		$this->assertEquals( 'sort_key_t', key( $cpt->site_sortables ) );
		$sort = array_shift( $cpt->site_sortables );

		$this->assertEquals( 'meta_key_t', $sort[ 'meta_key' ] );
		$this->assertEquals( 'DESC', $sort[ 'default' ] );


	}
}
