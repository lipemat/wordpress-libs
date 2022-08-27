<?php

namespace Lipe\Lib\Theme;
/**
 * @author Mat Lipe
 * @since  September, 2018
 *
 */

use Lipe\Lib\Theme\Styles;
use Lipe\Lib\Util\Actions;

class ResourcesTest extends \WP_UnitTestCase {
	private $requests = [];


	public function setUp() : void {
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


	/**
	 * Verify functionality of switching WP Core resources to
	 * unpkg CDN.
	 */
	public function test_use_cdn_for_resources() : void {
		$react_version = wp_scripts()->query( 'react' )->ver;
		$lodash_version = wp_scripts()->query( 'lodash' )->ver;
		$this->assertNotEmpty( $react_version );
		$this->assertNotEmpty( $lodash_version );

		Resources::in()->use_cdn_for_resources( [ 'react', 'lodash' ] );
		$this->assertEquals( 'https://unpkg.com/react@' . $react_version . '/umd/react.production.min.js', wp_scripts()->query( 'react' )->src );
		$this->assertEquals( 'https://unpkg.com/lodash@' . $lodash_version . '/lodash.min.js', wp_scripts()->query( 'lodash' )->src );

		ob_start();
		wp_scripts()->do_item( 'react' );
		$script = ob_get_clean();
		$this->assertStringContainsString( "src='https://unpkg.com/react@" . $react_version . "/umd/react.production.min.js'", $script );
		$this->assertStringContainsString( 'integrity="', $script );
		$this->assertStringContainsString( 'crossorigin="anonymous"', $script );

		// Simulate admin screens.
		set_current_screen( 'widgets.php' );
		$jquery_version = wp_scripts()->query( 'jquery-core' )->ver;
		Resources::in()->use_cdn_for_resources( [ 'jquery-core' ] );
		// Not replace on non admin_enqueue_scripts calls.
		$this->assertEquals( '/wp-includes/js/jquery/jquery.min.js', wp_scripts()->query( 'jquery-core' )->src );
		$GLOBALS['wp_current_filter'][] = 'admin_enqueue_scripts';
		Resources::in()->use_cdn_for_resources( [ 'jquery-core' ] );
		$this->assertEquals( 'https://unpkg.com/jquery@' . $jquery_version . '/dist/jquery.min.js', wp_scripts()->query( 'jquery-core' )->src );
		unset( $GLOBALS['current_screen'] );
	}


	/**
	 * Make sure the appropriate integrity and crossorigin are added when
	 * using the unpkg integrity.
	 */
	public function test_unpkg_integrity() : void {
		$this->assertArrayNotHasKey( 'https://unpkg.com/jquery@3.1.1/dist/jquery.min.js', get_network_option( null, Resources::INTEGRITY, [] ) );
		$this->assertEmpty( $this->requests );

		wp_register_script( __METHOD__, 'https://unpkg.com/jquery@3.1.1/dist/jquery.min.js', [], null );
		Resources::in()->unpkg_integrity( __METHOD__, 'https://unpkg.com/jquery@3.1.1/dist/jquery.min.js' );
		$this->assertCount( 1, $this->requests );
		$this->assertContains( 'https://unpkg.com/jquery@3.1.1/dist/jquery.min.js?meta', $this->requests );

		ob_start();
		wp_scripts()->do_item( __METHOD__ );
		$this->assertEquals( '<script integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous" src=\'https://unpkg.com/jquery@3.1.1/dist/jquery.min.js\' id=\'Lipe\Lib\Theme\ResourcesTest::test_unpkg_integrity-js\'></script>' . "\n", ob_get_clean() );
		$cache = get_network_option( null, Resources::INTEGRITY, [] );
		$this->assertEquals( 'sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7', $cache['https://unpkg.com/jquery@3.1.1/dist/jquery.min.js'] );
		$this->assertCount( 1, $this->requests );
	}
}
