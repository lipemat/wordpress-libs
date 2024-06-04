<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

/**
 * @author Mat Lipe
 * @since  June 2024
 *
 */
class Meta_BoxTest extends \WP_UnitTestCase {
	public const BOX = 'lipe/lib/meta/meta-box/test';


	protected function setUp(): void {
		parent::setUp();
		\WP_Screen::get( 'post' )->set_current_screen();
	}


	public function test__construct(): void {
		$mock = $this->mock_box();
		$box = new Meta_Box( $mock );
		$this->assertSame( $mock, get_private_property( $box, 'box' ) );

		$this->assertSame( 10, has_action( 'add_meta_boxes_post', [ $box, 'register' ] ) );
		$this->assertSame( 10, has_action( 'save_post_post', [ $box, 'save' ] ) );
		$this->assertSame( 10, has_action( 'add_meta_boxes_page', [ $box, 'register' ] ) );
		$this->assertSame( 10, has_action( 'save_post_page', [ $box, 'save' ] ) );
		$this->assertSame( 10, has_action( 'post_submitbox_misc_actions', [ $box, 'render_nonce' ] ) );
	}


	public function test_register(): void {
		global $wp_meta_boxes;
		$mock = $this->mock_box();
		new Meta_Box( $mock );
		$post = self::factory()->post->create_and_get();
		$page = self::factory()->post->create_and_get( [
			'post_type' => 'page',
		] );
		$this->assertNull( $wp_meta_boxes[ $post->post_type ][ Meta_Box::CONTEXT_SIDE ][ Meta_Box::PRIORITY_HIGH ][ self::BOX ] ?? null );

		do_action( 'add_meta_boxes_' . $post->post_type, $post );
		$registered = $wp_meta_boxes[ $post->post_type ][ Meta_Box::CONTEXT_SIDE ][ Meta_Box::PRIORITY_HIGH ][ self::BOX ];
		$this->assertSame( $mock->get_title(), $registered['title'] );
		$this->assertSame( $mock->get_id(), $registered['id'] );

		$this->assertEmpty( $wp_meta_boxes[ $page->post_type ] ?? null );

		do_action( 'add_meta_boxes_page', $page );
		$registered = $wp_meta_boxes[ $page->post_type ][ Meta_Box::CONTEXT_SIDE ][ Meta_Box::PRIORITY_HIGH ][ self::BOX ];
		$this->assertSame( $mock->get_title(), $registered['title'] );
		$this->assertSame( $mock->get_id(), $registered['id'] );
	}


	/**
	 * @dataProvider provideSave
	 */
	public function test_save( \WP_Post $post, bool $valid, \WP_Post $saving ): void {
		$box = $this->mock_box();
		new Meta_Box( $box );
		do_action( 'save_post_' . $saving->post_type, $post->ID, $post );

		// No nonce provided.
		$this->assertEmpty( get_post_meta( $post->ID, 'test_meta', true ) );
		$_POST[ self::BOX ] = wp_create_nonce( self::BOX );

		// Bulk edit happening
		$_GET['bulk_edit'] = true;
		do_action( 'save_post_' . $saving->post_type, $post->ID, $post );
		$this->assertEmpty( get_post_meta( $post->ID, 'test_meta', true ) );
		unset( $_GET['bulk_edit'] );

		// Doing AJAX
		add_filter( 'wp_doing_ajax', '__return_true' );
		do_action( 'save_post_' . $saving->post_type, $post->ID, $post );
		$this->assertEmpty( get_post_meta( $post->ID, 'test_meta', true ) );
		remove_filter( 'wp_doing_ajax', '__return_true' );

		do_action( 'save_post_' . $saving->post_type, $post->ID, $post );
		if ( $valid ) {
			$this->assertSame( 'test', get_post_meta( $post->ID, 'test_meta', true ) );
		} else {
			$this->assertEmpty( get_post_meta( $post->ID, 'test_meta', true ) );
		}
	}


	public function test_render_nonce(): void {
		$page = self::factory()->post->create_and_get( [
			'post_type' => 'page',
		] );
		$post = self::factory()->post->create_and_get();
		$css = self::factory()->post->create_and_get( [
			'post_type' => 'custom_css',
		] );
		new Meta_Box( $this->mock_box() );

		$this->assertEmpty( get_echo( function() use ( $css ) {
			do_action( 'post_submitbox_misc_actions', $css );
		} ) );

		$html = '<input type="hidden" id="' . self::BOX . '" name="' . self::BOX . '" value="' . wp_create_nonce( self::BOX ) . '" /><input type="hidden" name="_wp_http_referer" value="" />';

		$this->assertSame( $html, get_echo( function() use ( $page ) {
			do_action( 'post_submitbox_misc_actions', $page );
		} ) );
		$this->assertSame( $html, get_echo( function() use ( $post ) {
			do_action( 'post_submitbox_misc_actions', $post );
		} ) );
	}


	public function test_get_callback_args(): void {
		$mock = $this->mock_box();
		$box = new Meta_Box( $mock );
		$post = self::factory()->post->create_and_get();
		$callback_args = call_private_method( $box, 'get_callback_args', [ $post ] );

		$this->assertSame( [
			'__block_editor_compatible_meta_box' => true,
			'__back_compat_meta_box'             => false,
		], $callback_args );

		$mocked = $this->createMock( Box::class );
		$mocked->method( 'is_classic_editor_fallback' )->willReturn( true );

		$box = new Meta_Box( $mocked );
		$callback_args = call_private_method( $box, 'get_callback_args', [ $post ] );

		$this->assertSame( [
			'__block_editor_compatible_meta_box' => true,
			'__back_compat_meta_box'             => true,
		], $callback_args );
	}


	public static function provideSave(): array {
		$post = self::factory()->post->create_and_get();
		$page = self::factory()->post->create_and_get( [
			'post_type' => 'page',
		] );
		$auto_draft = self::factory()->post->create_and_get( [
			'post_status' => 'auto-draft',
		] );
		$revision = self::factory()->post->create_and_get( [
			'post_type' => 'revision',
		] );

		return [
			'post'            => [ 'post' => $post, 'valid' => true, 'saving' => $post ],
			'page'            => [ 'post' => $page, 'valid' => true, 'saving' => $page ],
			'auto_draft'      => [ 'post' => $auto_draft, 'valid' => false, 'saving' => $auto_draft ],
			'revision'        => [ 'post' => $revision, 'valid' => false, 'saving' => $revision ],
			'auto_draft page' => [ 'post' => $auto_draft, 'valid' => false, 'saving' => $page ],
			'revision page'   => [ 'post' => $revision, 'valid' => false, 'saving' => $page ],
			'auto_draft post' => [ 'post' => $auto_draft, 'valid' => false, 'saving' => $post ],
			'revision post'   => [ 'post' => $revision, 'valid' => false, 'saving' => $post ],

		];
	}


	private function mock_box(): Box {
		return new class() implements Box {
			public function get_title(): string {
				return 'Test Meta Box';
			}


			public function get_id(): string {
				return Meta_BoxTest::BOX;
			}


			public function get_priority(): string {
				return Meta_Box::PRIORITY_HIGH;
			}


			public function get_context(): string {
				return Meta_Box::CONTEXT_SIDE;
			}


			public function get_post_types(): array {
				return [ 'post', 'page' ];
			}


			public function is_classic_editor_fallback(): bool {
				return false;
			}


			public function save( \WP_Post $post ): void {
				update_post_meta( $post->ID, 'test_meta', 'test' );
			}


			public function render( \WP_Post $post ): void {
				echo '<input type="text" name="test_meta" value="' . esc_attr( get_post_meta( $post->ID, 'test_meta', true ) ) . '">';
			}
		};
	}
}
