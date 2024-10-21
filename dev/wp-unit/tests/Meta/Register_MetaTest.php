<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\Rest_Api\Resource_Schema;

/**
 * @author Mat Lipe
 * @since  October 2024
 *
 */
class Register_MetaTest extends \WP_Test_REST_TestCase {

	public function test_default(): void {
		$args = new Register_Meta( [] );
		register_meta( 'post', 'testing', $args->get_args() );
		$meta = get_registered_meta_keys( 'post' )['testing'];

		$this->assertSame( [
			'type'              => 'string',
			'label'             => '',
			'description'       => '',
			'single'            => true,
			'sanitize_callback' => null,
			'auth_callback'     => '__return_true',
			'show_in_rest'      => false,
			'revisions_enabled' => false,
		], $meta );
	}


	public function test_get_args(): void {
		$schema = new Resource_Schema( [] );
		$schema->type()->number()->minimum( 4 )->maximum( 10 );

		$args = new Register_Meta( [ 'revisions_enabled' => true ] );
		$args->label = 'Test Label';
		$args->description = 'Test Description';
		$args->single = false;
		$args->sanitize_callback = 'sanitize_text_field';
		$args->auth_callback = '__return_false';
		$args->show_in_rest = [
			'schema'           => $schema->get_args(),
			'prepare_callback' => '__return_null',
		];

		$this->assertSame( [
			'description'       => 'Test Description',
			'label'             => 'Test Label',
			'single'            => false,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => '__return_false',
			'show_in_rest'      => [
				'schema'           => [
					'$schema' => 'http://json-schema.org/draft-04/schema#',
					'type'    => 'number',
					'minimum' => 4,
					'maximum' => 10,
				],
				'prepare_callback' => '__return_null',
			],
			'revisions_enabled' => true,
		], $args->get_args() );
	}


	public function test_auth_callback(): void {
		$post = self::factory()->post->create_and_get();
		$id = update_post_meta( $post->ID, 'testing', 'test' );
		wp_set_current_user( self::factory()->user->create( [ 'role' => 'editor' ] ) );

		$args = new Register_Meta( [] );
		$args->auth_callback = fn() => current_user_can( 'manage_options' );
		register_meta( 'post', 'testing', $args->get_args() );

		edit_post( [
			'post_ID' => $post->ID,
			'meta'    => [
				$id => [
					'key'   => 'testing',
					'value' => 'changed',
				],
			],
		] );
		$this->assertSame( 'test', get_post_meta( $post->ID, 'testing', true ) );

		wp_set_current_user( self::factory()->user->create( [ 'role' => 'administrator' ] ) );
		edit_post( [
			'post_ID' => $post->ID,
			'meta'    => [
				$id => [
					'key'   => 'testing',
					'value' => 'changed',
				],
			],
		] );
		$this->assertSame( 'changed', get_post_meta( $post->ID, 'testing', true ) );
	}


	public function test_rest_schema(): void {
		$post = self::factory()->post->create_and_get();
		$schema = new Resource_Schema( [] );
		$schema->type()->number()->minimum( 4 )->maximum( 10 );

		$args = new Register_Meta( [] );
		$args->show_in_rest = [
			'schema'           => $schema->get_args(),
			'prepare_callback' => '\Lipe\Lib\Meta\plus_ten',
		];
		register_meta( 'post', 'testing', $args->get_args() );

		$meta = get_registered_meta_keys( 'post' )['testing'];
		$this->assertSame( [
			'type'              => 'string',
			'label'             => '',
			'description'       => '',
			'single'            => true,
			'sanitize_callback' => null,
			'auth_callback'     => '__return_true',
			'show_in_rest'      => [
				'schema'           => [
					'$schema' => 'http://json-schema.org/draft-04/schema#',
					'type'    => 'number',
					'minimum' => 4,
					'maximum' => 10,
				],
				'prepare_callback' => '\Lipe\Lib\Meta\plus_ten',
			],
			'revisions_enabled' => false,
		], $meta );

		$this->assertSame( 10, $this->get_response( '/wp/v2/posts/' . $post->ID, [], 'GET' )->get_data()['meta']['testing'] );

		wp_set_current_user( self::factory()->user->create( [ 'role' => 'editor' ] ) );
		$this->assertSame( 15, $this->get_response( '/wp/v2/posts/' . $post->ID, [
			'meta' => [
				'testing' => 5,
			],
		] )->get_data()['meta']['testing'] );

		update_post_meta( $post->ID, 'testing', 11 );
		$this->assertSame( 21, $this->get_response( '/wp/v2/posts/' . $post->ID, [], 'GET' )->get_data()['meta']['testing'] );

		$above_maximum = $this->get_response( '/wp/v2/posts/' . $post->ID, [
			'meta' => [
				'testing' => 11,
			],
		] );
		$this->assertErrorResponse( 'rest_out_of_bounds', $above_maximum );
	}
}

function plus_ten( $value ): int {
	return ( (int) $value ) + 10;
}
