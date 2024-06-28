<?php

declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\Meta\Repo;
use Lipe\Lib\Settings\Settings_Trait;
use mocks\Post_Mock;

/**
 * @requires function \CMB2_Bootstrap_2101::initiate
 *
 * @link     https://docs.phpunit.de/en/9.5/incomplete-and-skipped-tests.html#skipping-tests-using-requires
 */
class FieldTest extends \WP_Test_REST_TestCase {
	public function setUp(): void {
		parent::setUp();

		Repo::in()->clear_memoize_cache();

		$box = new Box( 'test-term-select', [ 'post' ], 'Term Select Test' );
		$box->field( 'ta', 'Tag' )
		    ->taxonomy_select( 'post_tag' );
		$box->field( 'tc', 'Category' )
		    ->taxonomy_multicheck( 'category' );

		do_action( 'cmb2_init' );
	}


	public function test_field_type_array(): void {
		$box = new Box( 'test-term-select', [ 'post' ], 'Term Select Test' );
		$field = $box->field( 't', 'test' )
		             ->text_date( 'M', 'time_key', [ 'passive' => 1 ] );
		$field->attributes( [ 'directly' => 1 ] );

		$args = $field->get_field_args();
		$this->assertEquals( [ 'directly' => 1, 'data-datepicker' => '{"passive":1}' ], $args['attributes'] );
		$this->assertEquals( 'time_key', $args['timezone_meta_key'] );
		$this->assertEquals( 'text_date', $args['type'] );
	}


	public function test_taxonomy_retrieval(): void {
		$term = self::factory()->category->create_and_get();
		update_term_meta( $term->term_id, 'tc', [ $term->slug ] );
		$terms = Repo::in()->get_value( $term->term_id, 'tc', 'term' );
		$this->assertEquals( $term->term_id, $terms[0]->term_id );
	}


	public function test_term_select(): void {
		$term = self::factory()->tag->create_and_get();

		$object = Post_Mock::factory( self::factory()->post->create_and_get() );
		$object['ta'] = $term->slug;
		$this->assertEquals( $term->term_id, $object['ta']->term_id );
		$this->assertEquals( [ $term->term_id ], wp_get_post_tags( $object->get_id(), [ 'fields' => 'ids' ] ) );

		unset( $object['ta'] );
		$this->assertEmpty( $object['ta'] );
		$this->assertEquals( [], wp_get_post_tags( $object->get_id(), [ 'fields' => 'ids' ] ) );

		$object['ta'] = (string) $term->term_id;
		$this->assertEquals( $term->term_id, $object['ta']->term_id );
		$this->assertEquals( [ $term->term_id ], wp_get_post_tags( $object->get_id(), [ 'fields' => 'ids' ] ) );

		unset( $object['ta'] );
		$object['ta'] = $term->term_id;
		$this->assertEquals( $term->term_id, $object['ta']->term_id );
		$this->assertEquals( [ $term->term_id ], wp_get_post_tags( $object->get_id(), [ 'fields' => 'ids' ] ) );
	}


	public function test_show_in_rest(): void {
		$box = new Box( 'rested', [ 'post' ], 'Sanitize Box' );
		$box->field( 'unit-testing/t1', 'TEST 1' )
		    ->text()
		    ->show_in_rest( \WP_REST_Server::ALLMETHODS );
		$box->field( 't2', 'Test 2' )
		    ->text();
		$group = $box->group( 't3', 'Test 3' );
		$group->show_in_rest();
		$group
			->field( 'first', '' )
			->text();
		$group
			->field( 'second', '' )
			->text();
		do_action( 'cmb2_init' );
		( new \CMB2_REST( $box->get_cmb2_box() ) )->universal_hooks()::register_cmb2_fields();

		$post = Post_Mock::factory( self::factory()->post->create_and_get() );
		$post['unit-testing/t1'] = 'returnee';
		$post['t3'] = [ [ 'first' => 'omg', 'second' => 'foo' ] ];

		$request = new \WP_REST_Request( 'GET', '/wp/v2/posts/' . $post->get_id() );
		$request->set_query_params( [ 'domain' => 'unit-test.com', 'site_name' => 'Unit Test' ] );
		$response = rest_get_server()->dispatch( $request )->data;
		$this->assertEquals( 'returnee', $response['cmb2']['rested']['unit-testing/t1'] );
		// Important this remains intact, or we'll break sites!!
		$this->assertArrayHasKey( 't1', $response['meta'], 'Keys are not being shortened in rest!' );
		$this->assertEquals( 'returnee', $response['meta']['t1'] );
		$this->assertArrayNotHasKey( 't2', $response['meta'] );
		$this->assertEquals( [ [ 'first' => 'omg', 'second' => 'foo' ] ], $response['meta']['t3'] );
	}


	public function test_defaults(): void {
		$post = self::factory()->post->create_and_get();
		$box = new Box( 'defaulted', [ 'post' ], 'Default Box' );
		$box->field( 'd1', 'Default 1' )
		    ->text()
		    ->default( 'secret' );
		$group = $box->group( 'd1-alot', '' )
		             ->default( [ [ 'first' => 'omg', 'second' => 'foo' ] ] );
		$group
			->field( 'first', '' )
			->text();
		$group
			->field( 'second', '' )
			->text();

		\CMB2_Bootstrap_2101::initiate()->include_cmb();
		do_action( 'cmb2_init' );

		$this->assertEquals( 'secret', get_post_meta( $post->ID, 'd1', true ) );
		$this->assertEquals( 'secret', Post_Mock::factory( $post->ID )['d1'] );
		$this->assertEquals( [ [ 'first' => 'omg', 'second' => 'foo' ] ], get_post_meta( $post->ID, 'd1-alot', true ) );
	}


	public function test_default_callback(): void {
		$box = new Box( __FUNCTION__, [ 'post' ], __METHOD__ );
		$box->field( 'd1', __METHOD__ . '-d1' )
		    ->text();
		$box->field( __FUNCTION__ . '-d2', __METHOD__ . '-d2' )
		    ->text()
		    ->default( function( array $config, \CMB2_Field $field ) {
			    $object = Post_Mock::factory( $field->object_id() );
			    return $object->get_meta( 'd1' ) . '-cb';
		    } );
		do_action( 'cmb2_init' );

		$object = Post_Mock::factory( 1 );
		$object['d1'] = __FUNCTION__ . '-default';
		$this->assertEquals( __FUNCTION__ . '-default-cb', $object[ __FUNCTION__ . '-d2' ] );
		$this->assertEquals( __FUNCTION__ . '-default-cb', get_post_meta( 1, __FUNCTION__ . '-d2', true ) );
	}


	public function test_options_defaults(): void {
		$c = new class implements \ArrayAccess {
			use Settings_Trait;

			public const NAME = 'options-defaulted';
		};
		$box = new Options_Page( 'options-defaulted', 'Default Box' );
		$box->field( 'o1', 'Options Default 1' )
		    ->text()
		    ->default( 'secret' );
		$box->field( __FUNCTION__ . '-o2', 'Options Default Callback' )
		    ->text()
		    ->default( function( array $config, \CMB2_Field $field ) use ( $c ) {
			    return $c->get_option( 'o1' ) . '-cb';
		    } );
		do_action( 'cmb2_init' );

		$this->assertEquals( 'secret', \cmb2_options( 'options-defaulted' )->get( 'o1' ) );
		$this->assertEquals( 'secret', $c->get_option( 'o1' ) );
		$this->assertEquals( 'secret-cb', \cmb2_options( 'options-defaulted' )->get( __FUNCTION__ . '-o2' ) );
		$this->assertEquals( 'secret-cb', $c->get_option( __FUNCTION__ . '-o2' ) );
	}


	public function test_object_subtypes(): void {
		$box = new Box( 'object_subtypes', [ 'page' ], 'Sanitize Box' );
		$box->field( 'tos', 'TEST 1' )
		    ->text()
		    ->show_in_rest( \WP_REST_Server::ALLMETHODS );
		$group = $box->group( 'tos2', 'Test 3' );
		$group->show_in_rest();
		$group
			->field( 'first-tos', '' )
			->text();
		do_action( 'cmb2_init' );
		( new \CMB2_REST( $box->get_cmb2_box() ) )->universal_hooks()::register_cmb2_fields();

		$post = Post_Mock::factory( self::factory()->post->create_and_get( [
			'post_type' => 'page',
		] ) );
		$post['tos'] = 'returnee';
		$post['tos2'] = [ [ 'first-tos' => 'omg' ] ];
		$request = new \WP_REST_Request( 'GET', '/wp/v2/pages/' . $post->get_id() );
		$request->set_query_params( [ 'domain' => 'unit-testx.com', 'site_name' => 'Unit Testx' ] );
		$response = rest_get_server()->dispatch( $request );
		$this->assertEquals( 'returnee', $response->data['meta']['tos'] );
		$this->assertEquals( [ [ 'first-tos' => 'omg' ] ], $response->data['meta']['tos2'] );

		$post = Post_Mock::factory( self::factory()->post->create_and_get() );
		$post['tos'] = 'returnee';
		$request = new \WP_REST_Request( 'GET', '/wp/v2/posts/' . $post->get_id() );
		$request->set_query_params( [ 'domain' => 'unit-testx2.com', 'site_name' => 'Unit Testx' ] );
		$response = rest_get_server()->dispatch( $request );
		$this->assertArrayNotHasKey( 'tos', $response->data['meta'] );
	}


	/**
	 * @requires function wp_post_revision_meta_keys
	 */
	public function test_revision_support(): void {
		$this->assertNotContains( 'tos', wp_post_revision_meta_keys( 'page' ) );

		$box = new Box( 'object_subtypes', [ 'page' ], 'Sanitize Box' );
		$box->field( 'tos', 'TEST 1' )
		    ->text()
		    ->revisions_enabled( true );
		call_private_method( $box, 'register_fields' );
		$this->assertContains( 'tos', wp_post_revision_meta_keys( 'page' ) );

		$box->field( 'tos', 'TEST 1' )
		    ->text()
		    ->revisions_enabled( false );
		call_private_method( $box, 'register_fields' );
		$this->assertNotContains( 'tos', wp_post_revision_meta_keys( 'page' ) );

		$box = new Options_Page( 'options', 'Sanitize Box' );
		$box->field( 'tos', 'TEST 1' )
		    ->text()
		    ->revisions_enabled( false );
		call_private_method( $box, 'register_fields' );
		// So we can reuse the same method saying "doing it wrong".
		$this->assertCount( 1, $this->caught_doing_it_wrong );
		$this->caught_doing_it_wrong = [];

		$box = new Term_Box( 'options', [ 'category' ], 'Sanitize Box' );
		$box->field( 'tos', 'TEST 1' )
		    ->text()
		    ->revisions_enabled( false );
		$this->setExpectedIncorrectUsage( 'Lipe\Lib\CMB2\Field::revisions_enabled' );
		call_private_method( $box, 'register_fields' );
	}
}
