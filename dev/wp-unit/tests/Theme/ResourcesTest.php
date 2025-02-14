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


	/**
	 * Verify functionality of switching WP Core resources to
	 * unpkg CDN.
	 */
	public function test_use_cdn_for_resources(): void {
		$react_version = wp_scripts()->query( 'react' )->ver;
		// Fix for non-existent react version introduced in WP 6.7.1.
		// @todo Remove when WP core updates React to version 19.
		if ( '18.3.1.1' === $react_version ) {
			$react_version = '18.3.1';
		}

		$lodash_version = wp_scripts()->query( 'lodash' )->ver;
		$jquery_version = wp_scripts()->query( 'jquery' )->ver;
		$jquery_migrate_version = wp_scripts()->query( 'jquery-migrate' )->ver;
		$this->assertNotEmpty( $react_version );
		$this->assertNotEmpty( $lodash_version );
		$this->assertNotEmpty( $jquery_version );
		$this->assertNotEmpty( $jquery_migrate_version );

		Resources::in()->use_cdn_for_resources( [ 'react', 'lodash' ] );
		$this->assertEquals( 'https://unpkg.com/react@' . $react_version . '/umd/react.production.min.js', wp_scripts()->query( 'react' )->src );
		$this->assertEquals( 'https://unpkg.com/lodash@' . $lodash_version . '/lodash.min.js', wp_scripts()->query( 'lodash' )->src );

		ob_start();
		wp_scripts()->do_item( 'react' );
		$script = \str_replace( '"', "'", ob_get_clean() );
		self::assertStringContainsString( "src='https://unpkg.com/react@" . $react_version . "/umd/react.production.min.js'", $script );
		self::assertStringContainsString( "integrity='", $script );
		self::assertStringContainsString( "crossorigin='anonymous'", $script );

		// Simulate admin screens.
		set_current_screen( 'widgets.php' );
		Resources::in()->use_cdn_for_resources( [ 'jquery' ] );
		// Not replace on non admin_enqueue_scripts calls.
		$this->assertEquals( '/wp-includes/js/jquery/jquery.min.js', wp_scripts()->query( 'jquery-core' )->src );
		$this->assertEquals( '/wp-includes/js/jquery/jquery-migrate.min.js', wp_scripts()->query( 'jquery-migrate' )->src );
		$GLOBALS['wp_current_filter'][] = 'admin_enqueue_scripts';
		Resources::in()->use_cdn_for_resources( [ 'jquery' ] );
		$this->assertEquals( 'https://unpkg.com/jquery@' . $jquery_version . '/dist/jquery.min.js', wp_scripts()->query( 'jquery-core' )->src );
		$this->assertEquals( 'https://unpkg.com/jquery-migrate@' . $jquery_migrate_version . '/dist/jquery-migrate.min.js', wp_scripts()->query( 'jquery-migrate' )->src );
		unset( $GLOBALS['current_screen'] );
	}


	public function test_failed_use_cdn_for_resources(): void {
		$this->assertEmpty( $this->requests );
		wp_scripts()->query( 'react-dom' )->ver = '18.1.1.A';
		Resources::in()->use_cdn_for_resources( [ 'react-dom' ] );

		$this->assertSame( [ 'https://unpkg.com/react-dom@18.1.1.A/umd/react-dom.production.min.js?meta' ], $this->requests );

		$this->assertSame( '/wp-includes/js/dist/vendor/react-dom.min.js', wp_scripts()->query( 'react-dom' )->src );
	}


	/**
	 * Make sure the appropriate integrity and crossorigin are added when
	 * using the unpkg integrity.
	 */
	public function test_unpkg_integrity(): void {
		$this->assertArrayNotHasKey( 'https://unpkg.com/jquery@3.1.1/dist/jquery.min.js', get_network_option( 0, Resources::INTEGRITY, [] ) );
		$this->assertEmpty( $this->requests );

		wp_register_script( __METHOD__, 'https://unpkg.com/jquery@3.1.1/dist/jquery.min.js', [], null );
		Resources::in()->unpkg_integrity( __METHOD__, 'https://unpkg.com/jquery@3.1.1/dist/jquery.min.js' );
		$this->assertCount( 1, $this->requests );
		$this->assertContains( 'https://unpkg.com/jquery@3.1.1/dist/jquery.min.js?meta', $this->requests );

		ob_start();
		wp_scripts()->do_item( __METHOD__ );
		$this->assertEquals( "<script integrity='sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7' crossorigin='anonymous' src='https://unpkg.com/jquery@3.1.1/dist/jquery.min.js' id='Lipe\Lib\Theme\ResourcesTest::test_unpkg_integrity-js'></script>" . "\n", str_replace( '"', "'", ob_get_clean() ) );
		$cache = get_network_option( 0, Resources::INTEGRITY, [] );
		$this->assertEquals( 'sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7', $cache['https://unpkg.com/jquery@3.1.1/dist/jquery.min.js'] );
		$this->assertCount( 1, $this->requests );
	}


	public function test_unpkg_integrity_failed(): void {
		$this->assertCount( 0, $this->requests );
		wp_register_script( __METHOD__, 'https://unpkg.com/react@18.3.1.1/umd/react.development.js', [], null );
		$this->assertFalse( Resources::in()->unpkg_integrity( __METHOD__, 'https://unpkg.com/react@18.3.1.1/umd/react.development.js' ) );
		$this->assertSame( [ 'https://unpkg.com/react@18.3.1.1/umd/react.development.js?meta' ], $this->requests );

		$this->assertSame( [], get_network_option( 0, Resources::INTEGRITY, [] ) );
		$this->assertSame( 'failed', wp_cache_get( Resources::INTEGRITY . __METHOD__ ) );

		$this->assertFalse( Resources::in()->unpkg_integrity( __METHOD__, 'https://unpkg.com/react@18.3.1.1/umd/react.development.js' ) );
		$this->assertSame( [ 'https://unpkg.com/react@18.3.1.1/umd/react.development.js?meta' ], $this->requests );
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
