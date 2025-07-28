<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Util\Actions;

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
		$this->assertEquals( "<script src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );
		[ $url, $callback, $handle ] = $this->get_script_handler();
		wp_script_add_data( $handle, 'strategy', 'async' );
		$this->assertEquals( "<script src='" . $url . "' id='arbuitrary-js' async data-wp-strategy='async'></script>" . "\n", $callback() );
	}


	public function test_defer_javascript(): void {
		[ $url, $callback ] = $this->get_script_handler();
		$this->assertEquals( "<script src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );
		[ $url, $callback, $handle ] = $this->get_script_handler();
		wp_script_add_data( $handle, 'strategy', 'defer' );
		$this->assertEquals( "<script src='" . $url . "' id='arbuitrary-js' defer data-wp-strategy='defer'></script>" . "\n", $callback() );
	}


	public function test_integrity_javascript(): void {
		[ $url, $callback ] = $this->get_script_handler();
		$this->assertEquals( "<script src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );

		[ $url, $callback, $handle ] = $this->get_script_handler();
		Resources::in()->integrity_javascript( $handle, '' );
		$this->assertEquals( "<script src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );

		Resources::in()->integrity_javascript( $handle, 'sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7' );
		$this->assertEquals( "<script integrity='sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7' crossorigin='anonymous' src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );
	}


	public function test_crossorigin_javascript(): void {
		[ $url, $callback ] = $this->get_script_handler();
		$this->assertEquals( "<script src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );

		[ $url, $callback, $handle ] = $this->get_script_handler();
		Resources::in()->crossorigin_javascript( $handle );
		$this->assertEquals( "<script crossorigin src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );

		[ $url, $callback, $handle ] = $this->get_script_handler();
		Resources::in()->crossorigin_javascript( $handle, 'anonymous' );
		$this->assertEquals( "<script crossorigin='anonymous' src='" . $url . "' id='arbuitrary-js'></script>" . "\n", $callback() );
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
}
