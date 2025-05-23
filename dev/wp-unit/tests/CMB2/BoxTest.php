<?php

declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Field\Type;
use Lipe\Lib\Meta\Registered;
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


	public function setUp(): void {
		parent::setUp();

		$this->attachment_id = self::factory()->attachment->create();

		do_action( 'cmb2_init' );
	}


	public function tearDown(): void {
		switch_to_blog( 1 );
		wp_delete_attachment( $this->attachment_id, true );

		parent::tearDown();
	}


	public function test_escape_and_sanitize(): void {
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


	public function test_shorthand_registering(): void {
		$box = new Box( 'shorthand-registering', [ 'post' ], 'Test Box' );
		$box->field( 't1', 'TEST 1' )
		    ->multicheck( [
			    'o' => 'one',
			    't' => 'two',
		    ] )
		    ->column( 3 )
		    ->position( 14 );
		/** @var Field $field */
		$field = get_private_property( $box, 'fields' )['t1'];
		$this->assertEquals( 3, get_private_property( $field, 'column' )['position'] ?? false );
		$this->assertEquals( 14, get_private_property( $field, 'position' ) );
		$this->assertEquals( [ 'o' => 'one', 't' => 'two' ], get_private_property( $field, 'options' ) );

		$this->expectDoingItWrong( 'Lipe\Lib\CMB2\Field::default', 'Callbacks should use `default_cb` instead of `default` (This message was added in version 3.2.1.)' );
		$group = $box->group( 'g1', 'Group 1' );
		$group->field( 't2', 'TEST 2' )
		      ->checkbox()
		      ->column( 4 )
		      ->position( 9 )
		      ->default( fn() => 'on' );
		$group->field( 't3', 'TEST 3' )
		      ->text()
		      ->default( 'some other' );
		$group->field( 't4', 'TEST 4' )
		      ->text()
		      ->default_cb( fn() => 'some value' );
		do_action( 'cmb2_init' );

		/** @var Group $group */
		$group = get_private_property( $box, 'fields' )['g1'];
		/** @var Field $field */
		$field = get_private_property( $group, 'fields' )['t2'];
		/** @var Field $t4 */
		$t4 = get_private_property( $group, 'fields' )['t4'];

		$this->assertEquals( 4, get_private_property( $field, 'column' )['position'] );
		$this->assertEquals( 9, get_private_property( $field, 'position' ) );
		$this->assertEquals( Type::CHECKBOX, get_private_property( $field, 'type' ) );
		$this->assertEquals( 'on', Registered::factory( $field )->get_default( 10 ) );
		$this->assertEquals( 'some value', Registered::factory( $t4 )->get_default( 10 ) );
		$this->assertEquals( 'some other', Registered::factory( get_private_property( $group, 'fields' )['t3'] )->get_default() );

		$post = Post_Mock::factory( self::factory()->post->create_and_get() );
		$this->assertTrue( $post->get_meta( 't2' ) );
		$this->assertEquals( 'some other', $post->get_meta( 't3' ) );
		$this->assertEquals( 'some value', $post->get_meta( 't4' ) );
	}


	public function test_comment(): void {
		global $wp_meta_boxes;
		$comment = self::factory()->comment->create_and_get();
		update_comment_meta( $comment->comment_ID, 'priv', 'testing u' );
		$comment = Comment_Mock::factory( $comment );
		$this->assertEquals( 'testing u', $comment->get_meta( 'priv' ) );

		$box = new Comment_Box( 'comment-only', 'Comment Only Box' );
		$box->field( 'trigger', 'Trigger the hookup' )
		    ->text();
		$this->assertSame( 'normal', get_private_property( $box, 'context' ) );
		$this->assertSame( 'normal', call_private_method( $box, 'get_args' )['context'] );
	}


	public function test_terms(): void {
		$term = self::factory()->category->create_and_get();
		update_term_meta( $term->term_id, 'labe', 'testing' );
		$cat = Term_Mock::factory( $term );
		$this->assertEquals( 'testing', $cat->get_meta( 'labe' ) );
	}


	public function test_user(): void {
		$user = self::factory()->user->create_and_get();
		update_user_meta( $user->ID, 'surr', 'testing u' );
		$object = User_Mock::factory( $user );
		$this->assertEquals( 'testing u', $object->get_meta( 'surr' ) );
		$object = User_Mock::factory( $user );
		$this->assertEquals( $user->ID, $object->get_id() );
	}


	public function test_settings(): void {
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
		$this->assertEquals( $term->term_id, get_option( 'op' )['t'] );
		$this->assertEquals( [
			'id'  => $this->attachment_id,
			'url' => wp_get_attachment_url( $this->attachment_id ),
		], $object->get_option( 'f' ) );

		$object->delete_meta( 't' );
		$this->assertEmpty( $object->get_option( 't' ) );
		$this->assertArrayNotHasKey( 't', get_option( 'op' ) );

		$object->update_option( 't', [ \WP_Term::get_instance( '1' )->term_id ] );
		$this->assertEquals( get_term( 1, 'category' ), $object->get_option( 't' ) );
		$this->assertEquals( get_term( 1, 'category' )->term_id, get_option( 'op' )['t'] );
	}


	public function test_post(): void {
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


	public function test_network_options(): void {
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
		$this->assertEquals( $term->term_id, get_network_option( 1, 'nop' )['nt'] );
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

		$attachment_id = self::factory()->attachment->create_upload_object( DIR_TEST_IMAGES . '/test-image.png' );
		$object->update_option( 'nf', $attachment_id );
		$this->assertEquals( [
			'id'  => $attachment_id,
			'url' => wp_get_attachment_url( $attachment_id ),
		], $object->get_option( 'nf' ) );

		\wp_delete_attachment( $attachment_id, true );
	}


	public function test_multiple_vs_singular_terms(): void {
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


	public function test_no_title(): void {
		$box = new Box( 'no-title', [ 'post' ], null );
		$this->assertArrayNotHasKey( 'title', call_private_method( $box, 'get_args' ) );

		$box = new Box( 'no-title', [ 'post' ], '' );
		$this->assertArrayHasKey( 'title', call_private_method( $box, 'get_args' ) );

		$box->remove_box_wrap();
		$this->assertArrayHasKey( 'remove_box_wrap', call_private_method( $box, 'get_args' ) );
	}


	public function test_register_meta_label(): void {
		$box = new Box( 'no-title', [ 'post' ], null );
		$box->field( 'with-description', 'With Description' )
		    ->text()
		    ->description( 'A longer description' );
		$box->field( 'no-descrption', 'No Description' )
		    ->text();

		do_action( 'cmb2_init' );
		$meta = get_registered_meta_keys( 'post', 'post' );

		if ( version_compare( $GLOBALS['wp_version'], '6.7', '>=' ) ) {
			$this->assertSame( 'With Description', $meta['with-description']['label'] );
		} else {
			$this->assertArrayNotHasKey( 'label', $meta['with-description'] );
		}
		$this->assertSame( 'A longer description', $meta['with-description']['description'] );
	}
}
