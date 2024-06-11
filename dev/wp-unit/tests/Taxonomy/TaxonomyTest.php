<?php

namespace Lipe\Lib\Taxonomy;

/**
 * @author Mat Lipe
 * @since  August 2020
 *
 */
class TaxonomyTest extends \WP_UnitTestCase {

	public function test_set_default_term(): void {
		wp_set_current_user( 1 );
		$tax = new Taxonomy( 'unit-testing', [ 'post' ] );
		$tax->set_default_term( 'tsdt', 'test set default term', 'optional description' );
		do_action( 'wp_loaded' );
		$term = \get_term_by( 'slug', 'tsdt', 'unit-testing' );
		$this->assertTrue( is_a( $term, \WP_Term::class ) );
		$this->assertEquals( 'optional description', $term->description );

		$post = self::factory()->post->create_and_get( [ 'post_status' => 'publish' ] );
		$this->assertEquals( $term->term_id, \wp_get_post_terms( $post->ID, 'unit-testing' )[0]->term_id );
	}


	public function test_add_initial_terms(): void {
		$tax = new Taxonomy( 'unit-testing', [ 'post' ] );
		$tax->add_initial_terms( [
			'one' => 'mississippi',
			'two' => 'one thousand',
		] );
		do_action( 'wp_loaded' );
		$terms = get_terms( 'taxonomy=unit-testing&hide_empty=0' );
		$this->assertEquals( [ 'one', 'two' ], wp_list_pluck( $terms, 'slug' ) );
		$this->assertEquals( [ 'mississippi', 'one thousand' ], wp_list_pluck( $terms, 'name' ) );
	}


	public function test_object_properties(): void {
		$tax = new Taxonomy( 'unit-testing', [ 'post' ] );
		$tax->labels->no_terms( 'no terms for you' );
		$this->assertEquals( 'no terms for you', $tax->labels()->get_label( 'no_terms' ) );
		$tax->labels()->no_item( 'no item for you' );
		$this->assertEquals( 'no item for you', $tax->labels->get_label( 'no_item' ) );

		$tax->capabilities->assign_terms( 'exist' );
		$this->assertEquals( 'exist', $tax->capabilities()->get_cap( 'assign_terms' ) );
		$tax->capabilities()->assign_terms( 'not-exists' );
		$this->assertEquals( 'not-exists', $tax->capabilities->get_cap( 'assign_terms' ) );
	}
}
