<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

use Lipe\Lib\Post_Type\Custom_Post_Type_Extended;

/**
 * FilterTest.php
 *
 * @author  mat
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type *
 */

class FilterTest extends \WP_UnitTestCase {

	function test_filters(){
		$post = new Custom_Post_Type_Extended( 'test' );
		$post->admin_filters()
			->meta_exists( 't title', [ 't_key' => 'TEST KEY' ] )
			->capability( 'manage_options' );

		$filter = array_shift( $post->admin_filters );
		$this->assertEquals( 'manage_options', $filter[ 'cap' ] );
		$this->assertEquals( [ 't_key' => 'TEST KEY' ], $filter[ 'meta_exists' ] );

		$post->admin_filters()
		     ->meta_search( 't title', 'featured_image' )
			 ->capability( 'manage_options' );


		$filter = array_shift( $post->admin_filters );
		$this->assertEquals( 'featured_image', $filter[ 'meta_search_key' ] );
		$this->assertEquals( 'manage_options', $filter[ 'cap' ] );

	}
}
