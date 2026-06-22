<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Theme\Scripts\PCSS_Manifest;
use Lipe\Lib\Theme\Scripts\ResourceHandles;
use Lipe\Lib\Util\Actions;
use mocks\Class_Names_Enum_Mock;
use mocks\ScriptHandles;

class ResourcesTest extends \WP_UnitTestCase {
	private $requests = [];


	public function setUp(): void {
		parent::setUp();
		$this->requests = [];

		Actions::in()->add_filter_as_action( 'pre_http_request', function( ...$r ) {
			$this->requests[] = $r[2];
		} );
		Resources::in()->clear_memoize_cache();
		add_theme_support( 'html5', [ 'script', 'style' ] );

		global $wp_scripts;
		$wp_scripts = new \WP_Scripts();

		do_action( 'wp_default_scripts', $wp_scripts );
	}


	protected function tearDown(): void {
		$running = ScriptHandles::MASTER_CSS->dist_path() . '.running';
		if ( \file_exists( $running ) ) {
			\unlink( $running );
		}
		parent::tearDown();
	}


	public function test_get_revision(): void {
		file_put_contents( Resources::in()->get_site_root() . '.revision', 'XX' );
		$this->assertEquals( 'XX', Resources::in()->get_revision() );

		file_put_contents( trailingslashit( WP_CONTENT_DIR ) . '.revision', 'VV' );
		$this->assertEquals( 'XX', Resources::in()->get_revision() );

		unlink( Resources::in()->get_site_root() . '.revision' );
		$this->assertEquals( 'XX', Resources::in()->get_revision() );
		Resources::in()->clear_memoize_cache();
		$this->assertEquals( 'VV', Resources::in()->get_revision() );

		unlink( trailingslashit( WP_CONTENT_DIR ) . '.revision' );
		$this->assertEquals( 'VV', Resources::in()->get_revision() );
		Resources::in()->clear_memoize_cache();
		$this->assertNull( Resources::in()->get_revision() );

		add_filter( 'lipe/lib/theme/resources/revision-path', function() {
			return Resources::in()->get_site_root() . 'other';
		} );
		Resources::in()->clear_memoize_cache();
		file_put_contents( Resources::in()->get_site_root() . 'other', 'YY' );
		$this->assertEquals( 'YY', Resources::in()->get_revision() );
		unlink( Resources::in()->get_site_root() . 'other' );
	}


	public function test_get_content_hash(): void {
		$this->assertEquals( hash_file( 'fnv1a64', __FILE__ ), Resources::in()->get_content_hash( plugins_url( 'ResourcesTest.php', __FILE__ ) ) );
		$this->assertEquals( hash_file( 'fnv1a64', __FILE__ ), Resources::in()->get_content_hash( plugins_url( 'ResourcesTest.php', __FILE__ ) ) );
		$this->assertNull( Resources::in()->get_content_hash( 'http://i-dont-exist/anywhere' ) );
	}


	public function test_get_file_modified_time(): void {
		$this->assertEquals( filemtime( __FILE__ ), Resources::in()->get_file_modified_time( plugins_url( 'ResourcesTest.php', __FILE__ ) ) );
		$this->assertNull( Resources::in()->get_content_hash( 'http://i-dont-exist/anywhere' ) );

		$time = time();
		touch( __FILE__, $time );
		filemtime( __FILE__ ); //prime the time.
		$this->assertEquals( $time, Resources::in()->get_file_modified_time( plugins_url( 'ResourcesTest.php', __FILE__ ) ) );
	}


	public function test_async_javascript(): void {
		[ $url, $callback ] = $this->get_script_handler();
		$this->assertEqualHTML( "<script src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );
		[ $url, $callback, $handle ] = $this->get_script_handler();
		wp_script_add_data( $handle, 'strategy', 'async' );
		$this->assertEqualHTML( "<script src='" . $url . "' id='arbuitrary-js' async data-wp-strategy='async'></script>" . "\n", $callback() );
	}


	public function test_defer_javascript(): void {
		[ $url, $callback ] = $this->get_script_handler();
		$this->assertEqualHTML( "<script src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );
		[ $url, $callback, $handle ] = $this->get_script_handler();
		wp_script_add_data( $handle, 'strategy', 'defer' );
		$this->assertEqualHTML( "<script src='" . $url . "' id='arbuitrary-js' defer data-wp-strategy='defer'></script>" . "\n", $callback() );
	}


	public function test_integrity_javascript(): void {
		[ $url, $callback ] = $this->get_script_handler();
		$this->assertEqualHTML( "<script src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );

		[ $url, $callback, $handle ] = $this->get_script_handler();
		Resources::in()->integrity_javascript( $handle, '' );
		$this->assertEqualHTML( "<script src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );

		Resources::in()->integrity_javascript( $handle, 'sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7' );
		$this->assertEqualHTML( "<script integrity='sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7' crossorigin='anonymous' src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );
	}


	public function test_crossorigin_javascript(): void {
		[ $url, $callback ] = $this->get_script_handler();
		$this->assertEqualHTML( "<script src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );

		[ $url, $callback, $handle ] = $this->get_script_handler();
		Resources::in()->crossorigin_javascript( $handle );
		$this->assertEqualHTML( "<script crossorigin src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );

		[ $url, $callback, $handle ] = $this->get_script_handler();
		Resources::in()->crossorigin_javascript( $handle, 'anonymous' );
		$this->assertEqualHTML( "<script crossorigin='anonymous' src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );
	}


	public function test_add_body_class(): void {
		Resources::in()->add_body_class( 'test-class-one' );
		Resources::in()->add_body_class( 'test-class-two' );
		Resources::in()->add_body_class( 'test-class-two' );
		Resources::in()->add_body_class( 'test-class-two' );
		Resources::in()->add_body_class( Class_Names_Enum_Mock::L );

		$classes = get_body_class();
		// Remove unreliable classes cross different projects.
		$classes = \array_values( \array_filter( $classes, function( $class ) {
			return 'wp-embed-responsive' !== $class;
		} ) );

		$this->assertSame( [ 'wp-theme-twentytwentyfour', 'test-class-one', 'test-class-two', 'last' ], $classes );
	}


	public function test_live_reload_uses_default_port_without_handle(): void {
		// Arrange
		// Act
		Resources::in()->live_reload();
		do_action( 'wp_enqueue_scripts' );

		// Assert
		if ( SCRIPT_DEBUG ) {
			$this->assertSame( 'http://localhost:' . PCSS_Manifest::LIVE_RELOAD_PORT . '/livereload.js', $this->get_livereload_src(), 'Falls back to the default LiveReload port when no handle is provided.' );
		} else {
			$this->assertArrayNotHasKey( 'livereload', wp_scripts()->registered, 'LiveReload is only enqueued when SCRIPT_DEBUG is enabled.' );
		}
	}


	public function test_live_reload_uses_https_with_domain(): void {
		// Arrange
		// Act
		Resources::in()->live_reload( 'example.com' );
		do_action( 'wp_enqueue_scripts' );

		// Assert
		if ( SCRIPT_DEBUG ) {
			$this->assertSame( 'https://example.com:' . PCSS_Manifest::LIVE_RELOAD_PORT . '/livereload.js', $this->get_livereload_src(), 'A provided domain loads LiveReload over https using the default port.' );
		} else {
			$this->assertArrayNotHasKey( 'livereload', wp_scripts()->registered, 'LiveReload is only enqueued when SCRIPT_DEBUG is enabled.' );
		}
	}


	public function test_live_reload_reads_port_from_handle_running_file(): void {
		// Arrange
		$this->write_running_file( ScriptHandles::MASTER_CSS, '{"port":4400}' );

		// Act
		Resources::in()->live_reload( null, false, ScriptHandles::MASTER_CSS );
		do_action( 'wp_enqueue_scripts' );

		// Assert
		if ( SCRIPT_DEBUG ) {
			$this->assertSame( 'http://localhost:4400/livereload.js', $this->get_livereload_src(), 'The per-worktree port is read from the handle `.running` file.' );
		} else {
			$this->assertArrayNotHasKey( 'livereload', wp_scripts()->registered, 'LiveReload is only enqueued when SCRIPT_DEBUG is enabled.' );
		}
	}


	public function test_live_reload_falls_back_to_default_port_when_running_file_missing(): void {
		// Arrange
		$this->assertFileDoesNotExist( ScriptHandles::MASTER_CSS->dist_path() . '.running', 'No `.running` file should exist for this handle.' );

		// Act
		Resources::in()->live_reload( null, false, ScriptHandles::MASTER_CSS );
		do_action( 'wp_enqueue_scripts' );

		// Assert
		if ( SCRIPT_DEBUG ) {
			$this->assertSame( 'http://localhost:' . PCSS_Manifest::LIVE_RELOAD_PORT . '/livereload.js', $this->get_livereload_src(), 'Falls back to the default port when the handle `.running` file is missing.' );
		} else {
			$this->assertArrayNotHasKey( 'livereload', wp_scripts()->registered, 'LiveReload is only enqueued when SCRIPT_DEBUG is enabled.' );
		}
	}


	public function test_live_reload_enqueues_in_admin_when_requested(): void {
		// Arrange
		set_current_screen( 'dashboard' );

		// Act
		Resources::in()->live_reload( null, true );
		do_action( 'admin_enqueue_scripts' );

		// Assert
		if ( SCRIPT_DEBUG ) {
			$this->assertSame( 'http://localhost:' . PCSS_Manifest::LIVE_RELOAD_PORT . '/livereload.js', $this->get_livereload_src(), 'LiveReload is enqueued on the admin hook when `$admin_also` is true.' );
		} else {
			$this->assertArrayNotHasKey( 'livereload', wp_scripts()->registered, 'LiveReload is only enqueued when SCRIPT_DEBUG is enabled.' );
		}
	}


	/**
	 * @return array<string,callable()>
	 */
	private function get_script_handler(): array {
		$url = plugins_url( 'ResourcesTest.php', __FILE__ );
		wp_register_script( 'arbuitrary', $url, [], null );

		$callback = function() {
			ob_start();
			wp_scripts()->do_item( 'arbuitrary' );
			return \str_replace( '"', "'", ob_get_clean() );
		};
		return [ $url, $callback, 'arbuitrary' ];
	}


	private function get_livereload_src(): string {
		$this->assertArrayHasKey( 'livereload', wp_scripts()->registered, 'The `livereload` script should be registered.' );
		return wp_scripts()->registered['livereload']->src;
	}


	private function write_running_file( ResourceHandles $handle, string $contents ): void {
		\file_put_contents( $handle->dist_path() . '.running', $contents );
	}
}
