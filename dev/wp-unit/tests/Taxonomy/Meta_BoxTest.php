<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Libs\Scripts;
use Lipe\Lib\Taxonomy\Meta_Box\Gutenberg_Box;

/**
 * @author Mat Lipe
 * @since  May 2024
 *
 */
class Meta_BoxTest extends \WP_UnitTestCase {

	public function test_no_rest_taxonomy(): void {
		$tax = register_taxonomy( 'test', 'post', [
			'show_in_rest' => false,
			'capabilities' => [
				'assign_terms' => 'exist',
			],
		] );
		$this->has_classic_metabox( $tax );
	}


	public function test_no_block_editor_post_type(): void {
		$post_type = register_post_type( 't-post', [
			'show_in_rest' => false,
		] );
		$tax = register_taxonomy( 'test', $post_type->name, [
			'show_in_rest' => true,
			'capabilities' => [
				'assign_terms' => 'exist',
			],
		] );

		$this->has_classic_metabox( $tax, $post_type->name );
	}


	public function test_replace_default_meta_box(): void {
		$tax = register_taxonomy( 'test', 'post', [
			'show_in_rest' => true,
			'capabilities' => [
				'assign_terms' => 'exist',
			],
		] );
		$this->has_gutenberg_metabox( $tax );
	}


	private function has_gutenberg_metabox( \WP_Taxonomy|\WP_Error $tax, string $post_type = 'post' ): void {
		global $wp_meta_boxes;
		$post = $this->setup_check_default_meta_box( $tax, $post_type );

		new Meta_Box( 'test', Gutenberg_Box::TYPE_RADIO, true );
		register_and_do_post_meta_boxes( $post );
		$this->assertFalse( $wp_meta_boxes[ $post_type ]['side']['core'][ 'tagsdiv-' . $tax->name ] );
		$this->assertFalse( $wp_meta_boxes[ $post_type ]['side']['default']["{$tax->name}div"] ?? false );
		$this->assertSame( '[{"type":"radio","taxonomy":"test","checkedOnTop":true}]', wp_json_encode( call_private_method( Scripts::instance(), 'js_config' )['taxonomyMetaBoxes'] ) );

		new Meta_Box( 'test', Gutenberg_Box::TYPE_DROPDOWN, false );
		register_and_do_post_meta_boxes( $post );
		$this->assertSame( '[{"type":"dropdown","taxonomy":"test","checkedOnTop":false}]', wp_json_encode( call_private_method( Scripts::instance(), 'js_config' )['taxonomyMetaBoxes'] ) );
	}


	private function has_classic_metabox( \WP_Taxonomy|\WP_Error $tax, string $post_type = 'post' ): void {
		global $wp_meta_boxes;
		$post = $this->setup_check_default_meta_box( $tax, $post_type );

		new Meta_Box( 'test', Gutenberg_Box::TYPE_RADIO, true );
		register_and_do_post_meta_boxes( $post );
		$this->assertFalse( $wp_meta_boxes[ $post_type ]['side']['core'][ 'tagsdiv-' . $tax->name ] );
		$this->assertSame( '{"id":"testdiv","title":"Tag","callback":[{"taxonomy":"test","type":"radio","checked_ontop":true},"do_meta_box"],"args":null}', wp_json_encode( $wp_meta_boxes[ $post_type ]['side']['default']["{$tax->name}div"] ) );
	}


	private function setup_check_default_meta_box( \WP_Taxonomy|\WP_Error $tax, string $post_type = 'post' ): \WP_Post {
		global $wp_meta_boxes;
		global $current_screen;
		$current_screen = convert_to_screen( $post_type );
		if ( \is_wp_error( $tax ) ) {
			$this->fail( $tax->get_error_message() );
		}
		$post = self::factory()->post->create_and_get( [
			'post_type' => $post_type,
		] );
		require_once ABSPATH . 'wp-admin/includes/meta-boxes.php';

		register_and_do_post_meta_boxes( $post );
		$this->assertSame( [
			'id'       => 'tagsdiv-test',
			'title'    => 'Tags',
			'callback' => 'post_tags_meta_box',
			'args'     =>
				[
					'taxonomy'               => 'test',
					'__back_compat_meta_box' => true,
				],
		], $wp_meta_boxes[ $post_type ]['side']['core'][ 'tagsdiv-' . $tax->name ] );

		return $post;
	}
}
