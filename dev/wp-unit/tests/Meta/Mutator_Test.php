<?php
declare( strict_types=1 );

/**
 * @author Mat Lipe
 * @since  February, 2019
 *
 */

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Box;
use Lipe\Lib\CMB2\Options_Page;
use Lipe\Lib\Settings\Settings_Trait;
use Lipe\Project\Comments\Comment;
use Lipe\Project\Post_Types\Post;
use Lipe\Project\Settings\Theme;
use Lipe\Project\Taxonomies\Category;
use Lipe\Project\User\User;
use mocks\Comment_Mock;
use mocks\Post_Mock;
use mocks\Settings_Mock;
use mocks\Term_Mock;
use mocks\User_Mock;

class Mutator_Test extends \WP_UnitTestCase {
	protected array $deleted_args;

	protected array $changed_args;

	private array $tags;

	private $attachment_id;

	private array $deleted = [];

	private array $changed = [];


	public function setUp() : void {
		parent::setUp();
		$this->attachment_id = self::factory()->attachment->create_upload_object( DIR_TESTDATA . '/images/test-image.png' );
		$this->deleted = [];

		$this->register_box();
	}


	public function tearDown() : void {
		wp_delete_attachment( $this->attachment_id, true );

		parent::tearDown();
	}


	private function register_box( $object_types = [ 'post' ], $id = 'mu-test' ) : void {
		$changed = function( $object_id, $value, $key, $previous, $type ) {
			$this->changed[] = $object_id;
			$this->changed_args = \func_get_args();
		};

		$deleted = function( $object_id, $key, $previous, $type ) {
			$this->deleted[] = $object_id;
			$this->deleted_args = \func_get_args();
		};

		$box = new Box( $id, $object_types, 'Mutator Box' );
		$box->field( 'categories', 'Categories Test' )
		    ->taxonomy_select( 'category' )
		    ->delete_cb( $deleted )
		    ->change_cb( $changed );
		$box->field( 'tags', ' Post Tag Test' )
		    ->taxonomy_multicheck( 'post_tag' )
		    ->delete_cb( $deleted )
		    ->change_cb( $changed );
		$box->field( 'file', 'File Test' )
		    ->file()
		    ->delete_cb( $deleted )
		    ->change_cb( $changed );
		$box->field( 'checkbox', 'Checkbox Test' )
		    ->checkbox()
		    ->delete_cb( $deleted )
		    ->change_cb( $changed );
		$box->field( 'text', 'Text Test' )
		    ->text()
		    ->delete_cb( $deleted )
		    ->change_cb( $changed );

		$this->tags = self::factory()->term->create_many( 2 );

		do_action( 'init' );
		do_action( 'cmb2_init' );
	}


	private function get_options_box() : Options_Page {
		return new class() {
			use Settings_Trait;
		};
	}


	private function get_tags() : array {
		return get_terms( [
			'include'    => $this->tags,
			'taxonomy'   => 'post_tag',
			'hide_empty' => false,
		] );
	}


	private function get_tags_from_meta( array $ids ) : array {
		return get_terms( [
			'include'    => $ids,
			'taxonomy'   => 'post_tag',
			'hide_empty' => false,
		] );
	}


	public function test_update_meta_callabale() : void {
		$o = Post_Mock::factory( 1 );
		$o->update_meta( 'text', 'normal' );
		$o['text'] = function( $p ) {
			$this->assertEquals( 'normal', $p );

			return 'r';
		};
		$this->assertEquals( 'r', $o['text'] );
		$o->update_meta( 'file', function( $p ) {
			$this->assertEquals( 'B', $p );
		}, 'B' );
		$o->update_meta( 'text', 'vvv' );
		$this->assertEquals( 'vvv', $o['text'] );
	}


	public function test_delete_callbacks() : void {
		$id = self::factory()->post->create();
		$o = Post_Mock::factory( $id );
		$this->changed = [];
		$o['tags'] = $this->tags;
		$this->assertEquals( [ $id ], $this->changed );
		$this->assertEmpty( $this->deleted );
		$this->assertEquals( [
			$id,
			$this->tags,
			'tags',
			[],
			'post',
		], $this->changed_args );

		// Via meta repo.
		unset( $o['categories'] );
		$this->assertEquals( [ $id ], $this->deleted );
		$this->assertEquals( [ $id, $id ], $this->changed );
		unset( $o['tags'] );
		$this->assertEquals( [ $id, $id ], $this->deleted );
		$this->assertEquals( [
			$id,
			'tags',
			$this->tags,
			'post',
		], $this->deleted_args );
		$this->assertEquals( [ $id, $id, $id ], $this->changed );
		$o['file'] = $this->attachment_id;
		unset( $o['file'] );
		$this->assertEquals( [ $id, $id, $id ], $this->deleted );
		$this->assertEquals( [ $id, $id, $id, $id, $id ], $this->changed );
		$this->assertEquals( [
			$id,
			'',
			'file',
			wp_get_attachment_image_url( $this->attachment_id ),
			'post',
		], $this->changed_args );
		$this->assertEquals( [
			$id,
			'file',
			wp_get_attachment_image_url( $this->attachment_id ),
			'post',
		], $this->deleted_args );
		unset( $o['file'] );
		$this->assertEquals( [ $id, $id, $id ], $this->deleted );
		$this->assertEquals( [ $id, $id, $id, $id, $id ], $this->changed );
		unset( $o['checkbox'] );
		$this->assertEquals( [ $id, $id, $id ], $this->deleted );
		$o['checkbox'] = true;
		unset( $o['checkbox'] );
		$this->assertEquals( [ $id, $id, $id, $id ], $this->deleted );
		$o['text'] = 'test';
		unset( $o['text'] );
		$this->assertEquals( [ $id, $id, $id, $id, $id ], $this->deleted );

		// WP callbacks.
		delete_post_meta( $id, 'checkbox' );
		$this->assertEquals( [ $id, $id, $id, $id, $id ], $this->deleted );
		update_post_meta( $o->get_id(), 'checkbox', true );
		delete_post_meta( $id, 'checkbox' );
		$this->assertEquals( [
			$id,
			'',
			'checkbox',
			true,
			'post',
		], $this->changed_args );
		$this->assertEquals( [
			$id,
			'checkbox',
			true,
			'post',
		], $this->deleted_args );

		$this->assertEquals( [ $id, $id, $id, $id, $id, $id ], $this->deleted );

		// CMB2 direct (eg. saving a post).
		$this->changed = [];
		$this->deleted = [];
		$field = call_private_method( Repo::in(), 'get_field', [ 'tags' ] )->get_cmb2_field();
		$field->object_id( $id );
		$field->save_field( $this->tags );
		$this->assertEquals( [
			$id,
			$this->tags,
			'tags',
			[],
			'post',
		], $this->changed_args );
		$field->save_field( null );
		$this->assertEquals( [
			$id,
			[],
			'tags',
			$this->tags,
			'post',
		], $this->changed_args );
		$this->assertEquals( [
			$id,
			'tags',
			$this->tags,
			'post',
		], $this->deleted_args );

		$this->assertEquals( [ $id ], $this->deleted );
		$this->assertEquals( [ $id, $id ], $this->changed );

		$field = call_private_method( Repo::in(), 'get_field', [ 'file' ] )->get_cmb2_field();
		$field->object_id( $id );
		$field->remove_data();
		$this->assertEquals( [ $id ], $this->deleted );
		$field->save_field( $this->attachment_id );
		$field->remove_data();
		$this->assertEquals( [ $id, $id ], $this->deleted );
		$this->assertEquals( [ $id, $id, $id, $id ], $this->changed );

		$field = call_private_method( Repo::in(), 'get_field', [ 'checkbox' ] )->get_cmb2_field();
		$field->object_id( $id );
		$field->save_field( 'on' );
		$field->remove_data();
		$this->assertEquals( [ $id, $id, $id ], $this->deleted );
		$this->assertCount( 6, $this->changed );

		$field = call_private_method( Repo::in(), 'get_field', [ 'text' ] )->get_cmb2_field();
		$field->object_id( $id );
		$field->remove_data();
		$field->save_field( 'test' );
		$field->remove_data();
		$this->assertEquals( [ $id, $id, $id, $id ], $this->deleted );
		$this->assertCount( 8, $this->changed );
	}


	public function test_delete_callback_options() : void {
		$cat_id = self::factory()->category->create();
		$post_id = self::factory()->post->create();

		// Options.
		$this->deleted = [];
		$this->changed = [];
		$id = Settings_Mock::NAME;
		$this->register_box( [ 'options-page' ], $id );
		$o = new Settings_Mock();
		$this->assertEmpty( $this->deleted );
		$o['tags'] = $this->tags;
		$o['categories'] = [ $cat_id ];
		$this->assertEquals( [
			Settings_Mock::NAME,
			[ $cat_id ],
			'categories',
			null,
			'options-page',
		], $this->changed_args );

		$this->assertEquals( [ $id, $id ], $this->changed );
		unset( $o['categories'] );
		$this->assertEquals( [ $id ], $this->deleted );
		$this->assertEquals( [ $id, $id, $id ], $this->changed );
		$this->assertEquals( [
			Settings_Mock::NAME,
			null,
			'categories',
			[ $cat_id ],
			'options-page',
		], $this->changed_args );
		$this->assertEquals( [
			$id,
			'categories',
			[ $cat_id ],
			'options-page',
		], $this->deleted_args );

		unset( $o['tags'] );
		$this->assertEquals( [ $id, $id ], $this->deleted );
		$this->assertEquals( [ $id, $id, $id, $id ], $this->changed );
		$o['file'] = $this->attachment_id;
		unset( $o['file'] );
		$this->assertEquals( [ $id, $id, $id ], $this->deleted );
		$this->assertEquals( [ $id, $id, $id, $id, $id, $id ], $this->changed );
		$o['checkbox'] = true;
		$this->assertCount( 7, $this->changed );
		unset( $o['checkbox'] );
		$this->assertEquals( [ $id, $id, $id, $id ], $this->deleted );
		$this->assertCount( 8, $this->changed );
		unset( $o['text'] );
		$this->assertEquals( [ $id, $id, $id, $id ], $this->deleted );
		$this->assertCount( 8, $this->changed );
		$o['text'] = 'ttt';
		$this->assertCount( 9, $this->changed );
		unset( $o['text'] );
		$this->assertEquals( [ $id, $id, $id, $id, $id ], $this->deleted );
		$this->assertCount( 10, $this->changed );

		// CMB2 direct (eg. saving a post).
		$this->changed = [];
		$this->deleted = [];
		/** @var \CMB2_Field $field */
		$field = call_private_method( Repo::in(), 'get_field', [ 'categories' ] )->get_cmb2_field();
		$field->object_id( $post_id );
		$field->remove_data();
		$this->assertEquals( [], $this->deleted );
		$this->assertEquals( [], $this->changed );
		$o['categories'] = [ $cat_id ];
		cmb2_options( $id )->set( $field->remove_data() );
		$this->assertEquals( [
			$id,
			null,
			'categories',
			[ $cat_id ],
			'options-page',
		], $this->changed_args );
		$this->assertEquals( [
			$id,
			'categories',
			[ $cat_id ],
			'options-page',
		], $this->deleted_args );
		$this->assertEquals( [ $id, ], $this->deleted );
		$this->assertEquals( [ $id, $id ], $this->changed );
	}


	public function test_update_callback() : void {
		$cat_id = self::factory()->category->create();
		$id = self::factory()->post->create();
		$o = Post_Mock::factory( $id );
		$this->changed = [];
		$this->assertEmpty( $this->changed );

		// Via meta repo.
		$o['categories'] = [ $cat_id ];
		$this->assertEquals( [ $id ], $this->changed );
		$this->assertEquals( [ $id ], $this->deleted );
		$o['tags'] = $this->tags;
		$this->assertEquals( [ $id, $id ], $this->changed );
		$o['file'] = $this->attachment_id;
		$this->assertEquals( [ $id, $id, $id ], $this->changed );
		$o['checkbox'] = 'x';
		$this->assertEquals( [ $id, $id, $id, $id ], $this->changed );
		$o['checkbox'] = 'x';
		$this->assertEquals( [ $id, $id, $id, $id ], $this->changed );
		$o['checkbox'] = false;
		$this->assertEquals( [ $id, $id, $id, $id, $id ], $this->changed );
		$o['text'] = 'test';
		$this->assertEquals( [ $id, $id, $id, $id, $id, $id ], $this->changed );

		// WP callbacks.
		update_post_meta( $id, 'checkbox', 'x' );
		$this->assertEquals( [ $id, $id, $id, $id, $id, $id, $id ], $this->changed );
		update_post_meta( $o->get_id(), 'checkbox', 'x' );
		update_post_meta( $id, 'checkbox', 'x' );
		$this->assertEquals( [ $id, $id, $id, $id, $id, $id, $id ], $this->changed );

		$this->changed = [];
		$this->deleted = [];
		// CMB2 direct (eg. saving a post).
		$field = call_private_method( Repo::in(), 'get_field', [ 'tags' ] )->get_cmb2_field();
		$field->object_id( $id );
		$field->save_field( $this->tags );
		$this->assertEquals( [ $id ], $this->changed );
		$this->assertEmpty( $this->deleted );

		$field = call_private_method( Repo::in(), 'get_field', [ 'file' ] )->get_cmb2_field();
		$field->object_id( $id );
		$field->save_field( 'x' );
		$this->assertEquals( [ $id, $id ], $this->changed );
		$field->save_field( $this->attachment_id );
		$field->save_field( false );
		$this->assertEquals( [ $id, $id, $id, $id ], $this->changed );
		$this->assertEquals( [ $id ], $this->deleted );

		$field = call_private_method( Repo::in(), 'get_field', [ 'checkbox' ] )->get_cmb2_field();
		$field->object_id( $id );
		$field->save_field( 'on' );
		$this->assertCount( 5, $this->changed );
		$field->save_field( 'on' );
		$this->assertCount( 5, $this->changed );
		$this->assertEquals( [ $id ], $this->deleted );

		$field = call_private_method( Repo::in(), 'get_field', [ 'text' ] )->get_cmb2_field();
		$field->object_id( $id );
		$field->save_field( 'V' );
		$this->assertCount( 6, $this->changed );
		$this->assertEquals( [ $id ], $this->deleted );
	}


	public function test_update_callback_options() : void {
		$cat_id = self::factory()->category->create();
		$post_id = self::factory()->post->create();
		// Options.
		$this->deleted = [];
		$this->changed = [];
		$this->register_box( [ 'options-page' ], Settings_Mock::NAME );
		$i = Settings_Mock::NAME;
		$o = new Settings_Mock();
		$this->assertEmpty( $this->changed );
		$o['categories'] = [ 2 ];
		$this->assertEquals( [ $i ], $this->changed );
		$o['tags'] = $this->tags;
		$this->assertEquals( [ $i, $i ], $this->changed );
		$o['file'] = $this->attachment_id;
		$this->assertEquals( [ $i, $i, $i ], $this->changed );
		$o['checkbox'] = true;
		$this->assertEquals( [ $i, $i, $i, $i ], $this->changed );
		$o['text'] = 'test';
		$this->assertEquals( [ $i, $i, $i, $i, $i ], $this->changed );

		// CMB2 direct (eg. saving a post).
		$this->changed = [];
		/** @var \CMB2_Field $field */
		$field = call_private_method( Repo::in(), 'get_field', [ 'categories' ] )->get_cmb2_field();
		$field->object_id( $post_id );
		cmb2_options( $i )->update( 'categories', [ $cat_id ], true );
		$this->assertEquals( [ $i ], $this->changed );
		$this->assertEmpty( $this->deleted );
	}


	public function test_post_object() : void {
		$cat_id = self::factory()->category->create();
		$post_id = self::factory()->post->create();
		$o = Post_Mock::factory( $post_id );
		$o['categories'] = [ $cat_id ];
		$this->assertEquals( get_term( $cat_id ), $o['categories'] );
		$this->assertEquals( get_term( $cat_id ), get_the_terms( $post_id, 'category' )[0] );

		$o['tags'] = $this->tags;
		$this->assertEquals( $this->get_tags(), $o['tags'] );
		$this->assertEquals( $this->get_tags(), get_the_terms( $post_id, 'post_tag' ) );

		unset( $o['tags'] );
		$this->assertEquals( [], $o['tags'] );
		$this->assertEmpty( get_the_terms( $post_id, 'post_tag' ) );

		$o['file'] = $this->attachment_id;
		$this->assertEquals( \wp_get_attachment_url( $this->attachment_id ), get_post_meta( $post_id, 'file', true ) );
		$this->assertEquals( $this->attachment_id, $o['file']['id'] );
		$this->assertEquals( \wp_get_attachment_url( $this->attachment_id ), $o['file']['url'] );

		unset( $o['file'] );
		$this->assertEquals( '', $o['file'] );
		$this->assertEquals( '', get_post_meta( $post_id, 'file', true ) );

		$o['checkbox'] = true;
		$this->assertEquals( 'on', get_post_meta( $post_id, 'checkbox', true ) );
		$this->assertEquals( true, $o['checkbox'] );

		unset( $o['checkbox'] );
		$this->assertEquals( '', get_post_meta( $post_id, 'checkbox', true ) );
		$this->assertEquals( false, $o['checkbox'] );

		$o['text'] = 'nothing';
		$this->assertEquals( 'nothing', get_post_meta( $post_id, 'text', true ) );
		$this->assertEquals( 'nothing', $o['text'] );
	}


	public function test_user_object() : void {
		$o = User_Mock::factory( 1 );

		$o['categories'] = [ 1 ];
		$this->assertEquals( get_term( 1 ), $o['categories'] );
		$this->assertEquals( get_term( 1 )->term_id, get_user_meta( 1, 'categories', true )[0] );

		$o['tags'] = $this->tags;
		$this->assertEquals( $this->get_tags(), $o['tags'] );
		$this->assertEquals( $this->get_tags(), $this->get_tags_from_meta( get_user_meta( 1, 'tags', true ) ) );

		unset( $o['tags'] );
		$this->assertEquals( [], $o['tags'] );
		$this->assertEquals( '', get_user_meta( 1, 'tags', true ) );

		$o['file'] = $this->attachment_id;
		$this->assertEquals( \wp_get_attachment_url( $this->attachment_id ), get_user_meta( 1, 'file', true ) );
		$this->assertEquals( $this->attachment_id, $o['file']['id'] );
		$this->assertEquals( \wp_get_attachment_url( $this->attachment_id ), $o['file']['url'] );

		$o['checkbox'] = true;
		$this->assertEquals( 'on', get_user_meta( 1, 'checkbox', true ) );
		$this->assertEquals( true, $o['checkbox'] );

		$o['text'] = 'nothing';
		$this->assertEquals( 'nothing', get_user_meta( 1, 'text', true ) );
		$this->assertEquals( 'nothing', $o['text'] );
	}


	public function test_comments_object() : void {
		$o = Comment_Mock::factory( 1 );
		$o['categories'] = [ 1 ];
		$this->assertEquals( get_term( 1 ), $o['categories'] );
		$this->assertEquals( get_term( 1 )->term_id, \get_comment_meta( 1, 'categories', true )[0] );

		$o['tags'] = $this->tags;
		$this->assertEquals( $this->get_tags(), $o['tags'] );
		$this->assertEquals( $this->get_tags(), $this->get_tags_from_meta( \get_comment_meta( 1, 'tags', true ) ) );

		$o['file'] = $this->attachment_id;
		$this->assertEquals( \wp_get_attachment_url( $this->attachment_id ), \get_comment_meta( 1, 'file', true ) );
		$this->assertEquals( $this->attachment_id, $o['file']['id'] );
		$this->assertEquals( \wp_get_attachment_url( $this->attachment_id ), $o['file']['url'] );

		$o['checkbox'] = true;
		$this->assertEquals( 'on', \get_comment_meta( 1, 'checkbox', true ) );
		$this->assertEquals( true, $o['checkbox'] );

		$o['text'] = 'nothing';
		$this->assertEquals( 'nothing', \get_comment_meta( 1, 'text', true ) );
		$this->assertEquals( 'nothing', $o['text'] );
	}


	public function test_terms_object() : void {
		$cat_id = self::factory()->category->create();
		$assigned = self::factory()->category->create();
		$o = Term_Mock::factory( $cat_id );
		$o['categories'] = [ $assigned ];
		$this->assertEquals( get_term( $assigned ), $o['categories'] );
		$this->assertEquals( get_term( $assigned )->term_id, \get_term_meta( $cat_id, 'categories', true )[0] );

		$o['tags'] = $this->tags;
		$this->assertEquals( $this->get_tags(), $o['tags'] );
		$this->assertEquals( $this->get_tags(), $this->get_tags_from_meta( \get_term_meta( $cat_id, 'tags', true ) ) );

		$o['file'] = $this->attachment_id;
		$this->assertEquals( \wp_get_attachment_url( $this->attachment_id ), \get_term_meta( $cat_id, 'file', true ) );
		$this->assertEquals( $this->attachment_id, $o['file']['id'] );
		$this->assertEquals( \wp_get_attachment_url( $this->attachment_id ), $o['file']['url'] );

		$o['checkbox'] = true;
		$this->assertEquals( 'on', \get_term_meta( $cat_id, 'checkbox', true ) );
		$this->assertEquals( true, $o['checkbox'] );

		$o['checkbox'] = false;
		$this->assertEquals( '', \get_term_meta( $cat_id, 'checkbox', true ) );
		$this->assertEquals( false, $o['checkbox'] );

		$o['text'] = 'nothing';
		$this->assertEquals( 'nothing', \get_term_meta( $cat_id, 'text', true ) );
		$this->assertEquals( 'nothing', $o['text'] );
	}


	public function test_settings_object() : void {
		$cat_id = self::factory()->category->create();
		$o = new Settings_Mock();
		$o['categories'] = [ $cat_id ];
		$this->assertEquals( get_term( $cat_id ), $o['categories'] );
		$this->assertEquals( get_term( $cat_id ), $o->get_option( 'categories' ) );

		$o['tags'] = $this->tags;
		$this->assertEquals( $this->get_tags(), $o['tags'] );
		$this->assertEquals( $this->get_tags(), $o->get_option( 'tags' ) );

		$o['tags'] = [];
		$this->assertEquals( [], $o['tags'] );
		$this->assertEquals( [], $o->get_option( 'tags' ) );

		$o['file'] = $this->attachment_id;
		$this->assertEquals( $this->attachment_id, $o['file']['id'] );
		$this->assertEquals( \wp_get_attachment_url( $this->attachment_id ), $o['file']['url'] );

		$o['checkbox'] = true;
		$this->assertEquals( true, $o->get_option( 'checkbox' ) );
		$this->assertEquals( true, $o['checkbox'] );

		$o['checkbox'] = false;
		$this->assertEquals( false, $o->get_option( 'checkbox' ) );
		$this->assertEquals( false, $o['checkbox'] );

		$o['text'] = 'nothing';
		$this->assertEquals( 'nothing', $o->get_option( 'text' ) );
		$this->assertEquals( 'nothing', $o['text'] );
	}

}
