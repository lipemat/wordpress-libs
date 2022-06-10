<?php
namespace Lipe\Lib\Post_Type;

/**
 * ColumnTest.php
 *
 * @author  mat
 * @since   7/29/2017
 *
 * @package starting-point *
 */
class ColumnTest extends \WP_UnitTestCase {

	function test_custom_column() {
		$cpt = new Custom_Post_Type_Extended( 'test' );
		$cpt->admin_cols()->custom( 'testing', function(){
			return 'nothing';
		} )->column_capability( 'edit_post' );

		$col = array_shift( $cpt->admin_cols );

		$this->assertEquals( 'testing', $col[ 'title' ] );
		$this->assertTrue( is_callable( $col[ 'function' ] ) );
		$this->assertEquals( 'edit_post', $col[ 'cap' ] );

		$cpt->admin_cols()->p2p( 'p2p title', 'p_to_o', 'view' )->set_as_default_sort_column( 'DESC' );


		$col = array_shift( $cpt->admin_cols );

		$this->assertEquals( 'p_to_o', $col[ 'connection' ] );
		$this->assertEquals( 'DESC', $col[ 'default' ] );

	}

	function test_stringed_properties(){
		$cpt = Custom_Post_Type_Extended::factory( 'post' );
		$cpt->admin_cols()
		    ->featured_image( "Mat Loves Star", 'full' )
		    ->column_capability( 'manage_options' )
		    ->set_as_default_sort_column( 'DESC' )
			->sortable( false );

		$col = array_shift( $cpt->admin_cols );

		$this->assertEquals( 'DESC', $col[ 'default' ] );
		$this->assertEquals( 'manage_options', $col[ 'cap' ] );
		$this->assertEquals( false, $col[ 'sortable' ] );
	}
}
