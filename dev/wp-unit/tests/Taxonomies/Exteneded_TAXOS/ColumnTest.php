<?php

namespace Lipe\Lib\Taxonomy\Extended_TAXOS;

use Lipe\Lib\Taxonomy\Taxonomy_Extended;

/**
 * ColumnTest.php
 *
 * @author  mat
 * @since   7/29/2017
 *
 * @package starting-point *
 */
class ColumnTest extends \WP_UnitTestCase {

	function test_custom(){
		$cpt = new Taxonomy_Extended( 'test' );
		$cpt->admin_cols()->custom( 'testing', function(){
			return 'nothing';
		} );

		$col = array_shift( $cpt->admin_cols );

		$this->assertEquals( 'testing', $col[ 'title' ] );
		$this->assertTrue( is_callable( $col[ 'function' ] ) );
	}

}
