<?php

declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\Settings\Settings_Trait;
use mocks\Comment_Mock;
use mocks\Post_Mock;
use mocks\Term_Mock;
use mocks\User_Mock;

/**
 * @requires function \CMB2_Bootstrap_2101::initiate
 *
 * @link     https://docs.phpunit.de/en/9.5/incomplete-and-skipped-tests.html#skipping-tests-using-requires
 */
class BoxTest extends \WP_UnitTestCase {
	private $attachment_id;


	public function setUp() : void {
		parent::setUp();

		$this->attachment_id =
			self::factory()->attachment->create_upload_object( DIR_TESTDATA . '/images/test-image.png' );

		\CMB2_Bootstrap_2101::initiate()->include_cmb();
		do_action( 'cmb2_init' );
	}


	public function tearDown() : void {
		switch_to_blog( 1 );
		wp_delete_attachment( $this->attachment_id, true );

		parent::tearDown();
	}


	public function test_escape_and_sanitize() : void {
		$post = self::factory()->post->create_and_get();
		$sanitize = function( $value ) {
			return str_replace( [ '-', 'x' ], [ 'F', '-' ], $value );
		};
		$escape = function( $value ) {
			return str_replace( '_--_', '_x_', $value );
		};
		$box = new Box( 'sanitize', [ Post_Mock::NAME ], 'Sanitize Box' );
		$box->field( 't1', 'TEST 1' )
		    ->text()
		    ->sanitization_cb( $sanitize )
		    ->escape_cb( $escape );

		do_action( 'cmb2_init' );

		Post_Mock::factory( $post )['t1'] = 'yy_xx_yy_xx_yy';
		$this->assertEquals( 'yy_--_yy_--_yy', get_post_meta( $post->ID, 't1', true ) );
		$this->assertEquals( 'yy_x_yy_x_yy', Post_Mock::factory( $post )['t1'] );

		cmb2_get_field( 'sanitize', 't1', $post->ID )
			->save_field( 'yy_xx_yy_xx_yy' );
		$this->assertEquals( 'yy_--_yy_--_yy', get_post_meta( $post->ID, 't1', true ) );
		$this->assertEquals( 'yy_x_yy_x_yy', Post_Mock::factory( $post )['t1'] );
	}


	public function test_shorthand_registering() : void {
		$box = new Box( 'ids', [ 'post' ], 'Test Box' );
		$box->field( 't1', 'TEST 1' )
		    ->multicheck( [
			    'o' => 'one',
			    't' => 'two',
		    ] )
		    ->column( 3 )
		    ->position( 14 );
		/** @var Field $field */
		$field = call_private_method( $box, 'get_fields' )['t1'];
		$this->assertEquals( 3, $field->column['position'] ?? false );
		$this->assertEquals( 14, $field->position );
		$this->assertEquals( [ 'o' => 'one', 't' => 'two' ], $field->options );

		$group = $box->group( 'g1', 'Group 1' );
		$group->field( 't2', 'TEST 2' )
		      ->checkbox()
		      ->column( 4 )
		      ->position( 9 );

		$group = call_private_method( $box, 'get_fields' )['g1'];
		$field = call_private_method( $group, 'get_fields' )['t2'];

		$this->assertEquals( 4, $field->column['position'] );
		$this->assertEquals( 9, $field->position );
		$this->assertEquals( 'checkbox', $field->get_type() );
	}


	public function test_comment() : void {
		$comment = self::factory()->comment->create_and_get();
		update_comment_meta( $comment->comment_ID, 'priv', 'testing u' );
		$comment = Comment_Mock::factory( $comment );
		$this->assertEquals( 'testing u', $comment->get_meta( 'priv' ) );
	}


	public function test_terms() : void {
		$term = self::factory()->category->create_and_get();
		update_term_meta( $term->term_id, 'labe', 'testing' );
		$cat = Term_Mock::factory( $term );
		$this->assertEquals( 'testing', $cat->get_meta( 'labe' ) );
	}


	public function test_user() : void {
		$user = self::factory()->user->create_and_get();
		update_user_meta( $user->ID, 'surr', 'testing u' );
		$object = User_Mock::factory( $user );
		$this->assertEquals( 'testing u', $object->get_meta( 'surr' ) );
		$object = User_Mock::factory( $user );
		$this->assertEquals( $user->ID, $object->get_id() );
	}


	public function test_settings() : void {
		$term = get_term( 1, 'category' );
		$box = new Options_Page( 'op', null );
		$box->field( 'f', '' )
		    ->file();
		$box->field( 't', '' )
		    ->taxonomy_select( 'category' );

		do_action( 'cmb2_init' );

		$object = new class {
			public const NAME = 'op';
			use Settings_Trait;
		};

		$object->update_option( 't', [ \WP_Term::get_instance( '1' )->slug ] );
		$object->update_option( 'f', $this->attachment_id );
		$this->assertEquals( $term, $object->get_option( 't' ) );
		$this->assertEquals( [ $term->term_id ], get_option( 'op' )['t'] );
		$this->assertEquals( [
			'id'  => $this->attachment_id,
			'url' => wp_get_attachment_url( $this->attachment_id ),
		], $object->get_option( 'f' ) );

		$object->delete_meta( 't' );
		$this->assertEmpty( $object->get_option( 't' ) );
		$this->assertArrayNotHasKey( 't', get_option( 'op' ) );

		$object->update_option( 't', [ \WP_Term::get_instance( '1' )->term_id ] );
		$this->assertEquals( get_term( 1, 'category' ), $object->get_option( 't' ) );
		$this->assertEquals( [ get_term( 1, 'category' )->term_id ], get_option( 'op' )['t'] );
	}


	public function test_post() : void {
		$post = self::factory()->post->create_and_get();
		$box = new Box( 'post-only', [ Post_Mock::NAME ], 'Post Only Box' );
		$box->field( 'fe', 'TEST 1' )
		    ->checkbox();

		do_action( 'cmb2_init' );

		update_post_meta( $post->ID, 'fe', 'on' );
		$object = new Post_Mock( $post );
		$this->assertTrue( $object->get_meta( 'fe' ) );
		update_post_meta( $post->ID, 'fe', '' );
		$this->assertFalse( $object->get_meta( 'fe' ) );
	}


	public function test_network_options() : void {
		switch_to_blog( 1 );
		$box = new Options_Page( 'nop', null );
		$box->field( 'nf', '' )
		    ->file();
		$box->field( 'nt', '' )
		    ->taxonomy_select( 'category' );
		$box->network();

		cmb2_bootstrap();

		$object = new class {
			public const NAME = 'nop';
			use Settings_Trait;
		};

		$term = self::factory()->category->create_and_get();
		$object->update_option( 'nt', [ $term->slug ] );
		$object->update_option( 'nf', $this->attachment_id );
		$this->assertEquals( $term, $object->get_option( 'nt' ) );
		$this->assertEquals( [ $term->term_id ], get_network_option( 1, 'nop' )['nt'] );
		$this->assertEquals( [
			'id'  => $this->attachment_id,
			'url' => wp_get_attachment_url( $this->attachment_id ),
		], $object->get_option( 'nf' ) );

		$url = wp_get_attachment_url( $this->attachment_id );
		switch_to_blog( 2 );
		$this->assertEquals( $term, $object->get_option( 'nt' ) );
		$this->assertEquals( [
			'id'  => $this->attachment_id,
			'url' => $url,
		], $object->get_option( 'nf' ) );

		$attachment_id = self::factory()->attachment->create_upload_object( DIR_TESTDATA . '/images/test-image.png' );
		$object->update_option( 'nf', $attachment_id );
		$this->assertEquals( [
			'id'  => $attachment_id,
			'url' => wp_get_attachment_url( $attachment_id ),
		], $object->get_option( 'nf' ) );

		\wp_delete_attachment( $attachment_id, true );
	}


	public function test_multiple_vs_singular_terms() : void {
		$box = new Options_Page( 'mup', null );
		$box->field( 'singc', '' )
		    ->taxonomy_radio( 'category' );
		$box->field( 'muc', '' )
		    ->taxonomy_multicheck( 'category' );

		do_action( 'cmb2_init' );

		$object = new class {
			public const NAME = 'mup';
			use Settings_Trait;
		};

		$object->update_option( 'singc', [ get_term( 1, 'category' )->slug ] );
		$object->update_option( 'muc', wp_list_pluck( get_terms( 'taxonomy=category&hide_empty=0' ), 'slug' ) );

		$this->assertEquals( get_term( 1, 'category' ), $object->get_option( 'singc' ) );

		$this->assertEquals( get_terms( 'taxonomy=category&hide_empty=0' ), $object->get_option( 'muc' ) );
	}
}
