<?php
/**
 * Query_VarTest.php
 *
 * @author  mat
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type\Custom_Post_Type_Extended *
 */

namespace Lipe\Lib\Post_Type\Extended_CPTS;

use Lipe\Lib\Post_Type\Custom_Post_Type_Extended;

class Query_VarTest extends \WP_UnitTestCase {

	function test_query_vars(){
		$cpt = new Custom_Post_Type_Extended( 'test' );
		$cpt->site_filters()
			->meta_search( 't_var', 't_key' )
			->capability( 'manage_nothing' );

		$this->assertEquals( 't_var', key( $cpt->site_filters ) );
		$filter = array_shift( $cpt->site_filters );

		$this->assertEquals( 't_key', $filter[ 'meta_search_key' ] );
		$this->assertEquals( 'manage_nothing', $filter[ 'cap' ] );

	}
}
