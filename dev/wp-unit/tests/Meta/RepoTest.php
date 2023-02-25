<?php
/**
 * @author Mat Lipe
 * @since  December, 2018
 *
 */

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Box;
use Lipe\Lib\CMB2\User_Box;
use Lipe\Project\Post_Types\Post;
use Lipe\Project\User\User;
use mocks\Post_Mock;
use mocks\User_Mock;

class RepoTest extends \WP_UnitTestCase {

	public function test_get_value() : void {
		$user_id = self::factory()->user->create();
		$cat_id = self::factory()->category->create();

		$box = new User_Box( 'g', null );
		$box->field( 'u', 'uu' )
		    ->true_false();
		$box->field( 'tt', 'ttt' )
		    ->taxonomy_multicheck( 'category' )
		    ->store_user_terms_in_meta();

		do_action( 'init' );
		do_action( 'cmb2_init' );

		update_user_meta( $user_id, 'u', 'on' );
		$this->assertTrue( User_Mock::factory( $user_id )->get_meta( 'u' ) );
		delete_user_meta( $user_id, 'u' );
		$this->assertFalse( User_Mock::factory( $user_id )->get_meta( 'u' ) );

		$o = User_Mock::factory( $user_id );
		$o->update_meta( 'tt', [ $cat_id ] );

		$this->assertEquals( $o->get_meta( 'tt' )[0]->term_id, $cat_id );
	}


	public function test_get_file_field_value() : void {
		$post = self::factory()->post->create_and_get();

		$box = new Box( 'f', [ 'post' ], null );
		$box->field( 't', 'tt' )
		    ->file();
		do_action( 'cmb2_init' );

		update_post_meta( $post->ID, 't', 'http://nowhere.com' );
		update_post_meta( $post->ID, 't_id', 5 );
		$this->assertSame( [ 'id' => '5', 'url' => 'http://nowhere.com' ], Post_Mock::factory( $post )->get_meta( 't' ) );
	}


	public function test_post_id_availability() : void {
		$box = new Box( 'f', [ 'post' ], null );
		$box->field( 't', 'tt' )
		    ->text()
		    ->sanitization_cb( function( $value, array $args, \CMB2_Field $field ) {
			    return $field->object_id();
		    } );
		do_action( 'cmb2_init' );
		$object = Post_Mock::factory( self::factory()->post->create_and_get() );
		$object['t'] = 'not teh post id';
		$this->assertEquals( $object->get_id(), $object['t'] );
	}
}
