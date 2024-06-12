<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Libs\Scripts\ScriptHandles;
use Lipe\Lib\Taxonomy\Meta_Box\Gutenberg_Box;

/**
 * @author Mat Lipe
 * @since  May 2024
 *
 */
class Meta_BoxTest extends \WP_UnitTestCase {

	public function test_use_term_ids(): void {
		$post_type = register_post_type( 't-post', [
			'show_in_rest' => false,
		] );
		$tax = new Taxonomy( 'test', [ $post_type->name ] );
		$tax->set_label( 'Tag', 'Tags' );
		$tax->capabilities()->assign_terms( 'exist' );
		$tax->add_initial_terms( [ 'one', 'two' ] );
		do_action( 'wp_loaded' );

		$post = $this->setup_check_default_meta_box( get_taxonomy( $tax->slug ), $post_type->name );

		new Meta_Box( 'test', Meta_Box::TYPE_RADIO, true );
		register_and_do_post_meta_boxes( $post );

		$html = get_echo( function() use ( $post ) {
			do_meta_boxes( $post->post_type, 'side', $post );
		} );
		$one = get_term_by( 'slug', 'one', 'test' );
		$two = get_term_by( 'slug', 'two', 'test' );

		$this->assertStringContainsString( '<label><input value="' . $one->term_id . '" type="radio" name="tax_input[test][]" id="in-test-' . $one->term_id . '" />one</label>', strip_ws_all( $html ) );
		$this->assertStringContainsString( '<label><input value="' . $two->term_id . '" type="radio" name="tax_input[test][]" id="in-test-' . $two->term_id . '" />two</label>', strip_ws_all( $html ) );
		$this->assertStringContainsString( '<label><input value="0" type="radio" name="tax_input[test][]" id="in-test-0" checked=\'checked\'/>No tags</label>', strip_ws_all( $html ) );
	}


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

		do_action( 'enqueue_block_assets' );
		$this->assertFalse( wp_scripts()->query( ScriptHandles::BLOCK_EDITOR->value ) );

		new Meta_Box( 'test', Meta_Box::TYPE_RADIO, true );
		register_and_do_post_meta_boxes( $post );
		$this->assertFalse( $wp_meta_boxes[ $post_type ]['side']['core'][ 'tagsdiv-' . $tax->name ] );
		$this->assertFalse( $wp_meta_boxes[ $post_type ]['side']['default']["{$tax->name}div"] ?? false );
		$this->assertSame( '[{"type":"radio","taxonomy":"test","checkedOnTop":true}]', wp_json_encode( get_private_property( Gutenberg_Box::class, 'boxes' ) ) );
		do_action( 'enqueue_block_assets' );
		$this->assertInstanceOf( \_WP_Dependency::class, wp_scripts()->query( ScriptHandles::BLOCK_EDITOR->value ) );

		new Meta_Box( 'test', Meta_Box::TYPE_DROPDOWN, false );
		register_and_do_post_meta_boxes( $post );
		$this->assertSame( '[{"type":"dropdown","taxonomy":"test","checkedOnTop":false}]', wp_json_encode( get_private_property( Gutenberg_Box::class, 'boxes' ) ) );
		$this->assertSame( 'var LIPE_LIBS_BLOCK_EDITOR_CONFIG = {"taxonomyMetaBoxes":[{"type":"radio","taxonomy":"test","checkedOnTop":true}]};', wp_scripts()->get_data( ScriptHandles::BLOCK_EDITOR->value, 'data' ) );

		register_taxonomy( 'again', $post->post_type, [
			'show_in_rest' => true,
			'capabilities' => [
				'assign_terms' => 'exist',
			],
		] );
		new Meta_Box( 'again', 'radio', false );
		register_and_do_post_meta_boxes( $post );
		do_action( 'enqueue_block_assets' );
		$this->assertSame( '[{"type":"dropdown","taxonomy":"test","checkedOnTop":false},{"type":"radio","taxonomy":"again","checkedOnTop":false}]', wp_json_encode( get_private_property( Gutenberg_Box::class, 'boxes' ) ) );
		$this->assertSame( 'var LIPE_LIBS_BLOCK_EDITOR_CONFIG = {"taxonomyMetaBoxes":[{"type":"radio","taxonomy":"test","checkedOnTop":true}]};', wp_scripts()->get_data( ScriptHandles::BLOCK_EDITOR->value, 'data' ) );

		wp_scripts()->registered[ ScriptHandles::BLOCK_EDITOR->value ]->extra['data'] = false;
		register_and_do_post_meta_boxes( $post );
		do_action( 'enqueue_block_assets' );
		$this->assertSame( 'var LIPE_LIBS_BLOCK_EDITOR_CONFIG = {"taxonomyMetaBoxes":[{"type":"dropdown","taxonomy":"test","checkedOnTop":false},{"type":"radio","taxonomy":"again","checkedOnTop":false}]};', wp_scripts()->get_data( ScriptHandles::BLOCK_EDITOR->value, 'data' ) );
	}


	private function has_classic_metabox( \WP_Taxonomy|\WP_Error $tax, string $post_type = 'post' ): void {
		global $wp_meta_boxes;
		$post = $this->setup_check_default_meta_box( $tax, $post_type );

		new Meta_Box( 'test', Meta_Box::TYPE_RADIO, true );
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
