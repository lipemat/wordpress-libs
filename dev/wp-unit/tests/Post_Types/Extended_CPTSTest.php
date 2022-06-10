<?php


/**
 * Extended_CPTSTest.php
 *
 * @author  mat
 * @since   7/27/2017
 *
 * @package starting-point *
 */
class Extended_CPTSTest extends WP_UnitTestCase {

	public function test_correct_properties(){
		$cpt = new \Lipe\Lib\Post_Type\Custom_Post_Type_Extended( 'test' );
		$cpt->site_filters = [
			'my_foo' => [
				'meta_key' => 'foo',
			],
		];
		$args = call_private_method( $cpt, 'get_post_type_args' );
		$args = array_keys( $args );
		$this->assertNotContains( 'auto_admin_caps', $args, "Properties not correct on POST TYPES" );
		$this->assertNotContains( 'admin_cols', $args, "Properties not correct on POST TYPES" );
		$this->assertContains( 'site_filters', $args, "Properties not correct on POST TYPES" );
	}
}
