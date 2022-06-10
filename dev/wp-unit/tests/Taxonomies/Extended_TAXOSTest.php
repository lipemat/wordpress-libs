<?php


/**
 * Extended_TAXOSTest.php
 *
 * @author  mat
 * @since   7/27/2017
 *
 * @package starting-point *
 */
class Extended_TAXOSTest extends WP_UnitTestCase {
	public function test_correct_properties(){
		$tax = new \Lipe\Lib\Taxonomy\Taxonomy_Extended( 'test', [ 'post' ] );
		$tax->admin_cols()
		    ->meta( 'foo', 'meta_key' )
			->set_as_default_sort_column( 'ASC' );

		$args = call_private_method( $tax, 'get_taxonomy_args' );
		$args = array_keys( $args );
		$this->assertNotContains( 'default_terms', $args , "Properties not correct on tax" );
		$this->assertNotContains( 'checked_ontop', $args, "Properties not correct on POST TYPES" );
		$this->assertContains( 'admin_cols', $args, "Properties not correct on tax" );
		$col = array_shift( $tax->admin_cols );

		$this->assertEquals( 'ASC', $col[ 'default' ] );
	}
}
