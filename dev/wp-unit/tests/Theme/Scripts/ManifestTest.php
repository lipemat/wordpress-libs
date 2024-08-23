<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use mocks\Handles;

/**
 * @author   Mat Lipe
 * @since    February 2023
 *
 */
class ManifestTest extends \WP_UnitTestCase {
	protected function setUp(): void {
		parent::setUp();

		add_filter( 'stylesheet_directory', fn() => $this->getStylesheetDirectory() );
	}


	public function test_get_url(): void {
		$js = Enqueue::factory( Handles::MASTER_JS );
		if ( SCRIPT_DEBUG && Util::in()->is_webpack_running( Handles::MASTER_JS ) ) {
			$this->assertEquals( ( is_ssl() ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . ':3000/js-dist/' . 'master.js', $js->get_url() );
		} else {
			$this->assertEquals( trailingslashit( get_stylesheet_directory_uri() ) . 'js-dist/master.js', $js->get_url() );
		}

		$pcss = Enqueue::factory( Handles::FRONT_END_CSS );
		if ( SCRIPT_DEBUG ) {
			$this->assertEquals( trailingslashit( get_stylesheet_directory_uri() ) . 'css-dist/front-end.css', $pcss->get_url() );
		} else {
			$this->assertEquals( trailingslashit( get_stylesheet_directory_uri() ) . 'css-dist/front-end.min.css', $pcss->get_url() );
		}
	}


	public function test_get_dist_path(): void {
		$url = trailingslashit( get_stylesheet_directory_uri() );
		$this->assertSame( $url . 'js-dist/', Handles::JS_MANIFEST->dist_url() );
		$this->assertSame( $url . 'css-dist/', Handles::PCSS_MANIFEST->dist_url() );

		$path = trailingslashit( $this->getStylesheetDirectory() );
		$this->assertSame( $path . 'js-dist/', Handles::JS_MANIFEST->dist_path() );
		$this->assertSame( $path . 'css-dist/', Handles::PCSS_MANIFEST->dist_path() );

		$this->assertSame( 'js-manifest.json', Handles::JS_MANIFEST->file() );
		$this->assertSame( 'css-manifest.json', Handles::PCSS_MANIFEST->file() );
	}


	public function test_get_version(): void {
		$path = trailingslashit( get_stylesheet_directory() );
		$manifest = json_decode( file_get_contents( $path . 'js-dist/js-manifest.json' ), true );
		$js = Enqueue::factory( Handles::MASTER_JS );
		$this->assertEquals( $manifest['master.js']['hash'], $js->get_version() );

		$manifest = json_decode( file_get_contents( $path . 'css-dist/css-manifest.json' ), true );
		$pcss = Enqueue::factory( Handles::FRONT_END_CSS );
		if ( SCRIPT_DEBUG ) {
			$this->assertEquals( $manifest['front-end.css'], $pcss->get_version() );
		} else {
			$this->assertEquals( $manifest['front-end.min.css'], $pcss->get_version() );
		}
	}


	public function test_get_integrity(): void {
		$manifest = json_decode( file_get_contents( Handles::JS_MANIFEST->dist_path() . 'js-manifest.json' ), true );
		$js = Enqueue::factory( Handles::MASTER_JS );
		$this->assertEquals( $manifest['master.js']['integrity'], $js->get_integrity() );

		$js = Enqueue::factory( Handles::ADMIN_JS );
		$this->assertEquals( $manifest['admin.js']['integrity'], $js->get_integrity() );
	}


	public function test_get_file(): void {
		$js = Enqueue::factory( Handles::MASTER_JS );
		$path = \str_replace( trailingslashit( get_stylesheet_directory() ), '', Handles::MASTER_JS->dist_path() );
		$this->assertEquals( $path . 'master.js', $js->get_file() );
		$this->assertEquals( Handles::MASTER_JS->dist_path() . 'master.js', $js->get_file( true ) );

		$pcss = Enqueue::factory( Handles::ADMIN_CSS );
		$path = \str_replace( trailingslashit( get_stylesheet_directory() ), '', Handles::PCSS_MANIFEST->dist_path() );
		if ( SCRIPT_DEBUG ) {
			$this->assertEquals( $path . 'admin.css', $pcss->get_file() );
			$this->assertEquals( Handles::ADMIN_CSS->dist_path() . 'admin.css', $pcss->get_file( true ) );
		} else {
			$this->assertEquals( $path . 'admin.min.css', $pcss->get_file() );
			$this->assertEquals( Handles::ADMIN_CSS->dist_path() . 'admin.min.css', $pcss->get_file( true ) );
		}
	}


	public function test_is_async(): void {
		$this->assertTrue( Handles::MASTER_JS->is_async() );
		$this->assertFalse( Handles::ADMIN_JS->is_async() );

		$js = Enqueue::factory( Handles::MASTER_JS );
		$js->enqueue();
		$script = get_echo( fn() => wp_scripts()->do_item( Handles::MASTER_JS->handle() ) );
		$this->assertStringContainsString( 'async', $script );
	}


	private function getStylesheetDirectory(): string {
		return dirname( __DIR__, 3 ) . '/data/';
	}

}
