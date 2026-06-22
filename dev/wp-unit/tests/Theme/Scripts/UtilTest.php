<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme\Scripts;

use mocks\ScriptHandles;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @author Mat Lipe
 * @since  March 2026
 *
 */
class UtilTest extends \WP_UnitTestCase {
	protected function tearDown(): void {
		$running = ScriptHandles::MASTER_JS->dist_path() . '.running';
		if ( \file_exists( $running ) ) {
			\unlink( $running );
		}
		parent::tearDown();
	}


	#[DataProvider( 'provideHandles' )]
	public function test_is_javascript_resource( ResourceHandles $handle, bool $is_js ): void {
		$this->assertSame( $is_js, Util::in()->is_javascript_resource( $handle ) );
	}


	public function test_get_node_process_port_reads_port_from_running_file(): void {
		$this->writeRunningFile( '{"port":4400}' );
		$this->assertSame( 4400, Util::in()->get_node_process_port( ScriptHandles::MASTER_JS, 3000 ) );
	}


	public function test_get_node_process_port_casts_numeric_string_port(): void {
		$this->writeRunningFile( '{"port":"8080"}' );
		$this->assertSame( 8080, Util::in()->get_node_process_port( ScriptHandles::MASTER_JS, 3000 ) );
	}


	public function test_get_node_process_port_defaults_when_port_key_missing(): void {
		$this->writeRunningFile( '{"host":"localhost"}' );
		$this->assertSame( 3000, Util::in()->get_node_process_port( ScriptHandles::MASTER_JS, 3000 ) );
	}


	public function test_get_node_process_port_defaults_when_port_not_numeric(): void {
		$this->writeRunningFile( '{"port":"not-a-port"}' );
		$this->assertSame( 3000, Util::in()->get_node_process_port( ScriptHandles::MASTER_JS, 3000 ) );
	}


	public function test_get_node_process_port_defaults_on_invalid_json(): void {
		$this->writeRunningFile( 'this is not json' );
		$this->assertSame( 3000, Util::in()->get_node_process_port( ScriptHandles::MASTER_JS, 3000 ) );
	}


	public function test_get_node_process_port_defaults_when_file_missing(): void {
		$this->assertFalse( \file_exists( ScriptHandles::MASTER_JS->dist_path() . '.running' ) );
		$this->assertSame( 3000, Util::in()->get_node_process_port( ScriptHandles::MASTER_JS, 3000 ) );
	}


	public function test_get_node_process_port_defaults_on_empty_file(): void {
		$this->writeRunningFile( '' );
		$this->assertSame( 3000, Util::in()->get_node_process_port( ScriptHandles::MASTER_JS, 3000 ) );
	}


	public function test_get_node_process_port_uses_custom_default(): void {
		$this->assertSame( 35729, Util::in()->get_node_process_port( null, 35729 ) );
		$this->assertSame( 35729, Util::in()->get_node_process_port( ScriptHandles::MASTER_JS, 35729 ) );
	}


	public function test_get_node_process_port_caches_first_read(): void {
		$this->writeRunningFile( '{"port":4400}' );
		$this->assertSame( 4400, Util::in()->get_node_process_port( ScriptHandles::MASTER_JS, 3000 ) );

		$this->writeRunningFile( '{"port":9999}' );
		$this->assertSame( 4400, Util::in()->get_node_process_port( ScriptHandles::MASTER_JS, 3000 ) );
	}


	private function writeRunningFile( string $contents ): void {
		\file_put_contents( ScriptHandles::MASTER_JS->dist_path() . '.running', $contents );
	}


	public static function provideHandles(): array {
		return [
			'admin-js'      => [ 'handle' => ScriptHandles::ADMIN_JS, 'is_js' => true, ],
			'admin-js-css'  => [ 'handle' => ScriptHandles::ADMIN_JS_CSS, 'is_js' => false ],
			'admin-css'     => [ 'handle' => ScriptHandles::ADMIN_CSS, 'is_js' => false ],
			'master-js'     => [ 'handle' => ScriptHandles::MASTER_JS, 'is_js' => true ],
			'master-css'    => [ 'handle' => ScriptHandles::MASTER_CSS, 'is_js' => false ],
			'block-css'     => [ 'handle' => ScriptHandles::BLOCKS_CSS, 'is_js' => false ],
			'front-end-css' => [ 'handle' => ScriptHandles::FRONT_END_CSS, 'is_js' => false ],
			'font-awesome'  => [ 'handle' => ScriptHandles::FONT_AWESOME, 'is_js' => true ],
			'versioned-js'  => [ 'handle' => ScriptHandles::VERSIONED_JS, 'is_js' => true ],
			'versioned-css' => [ 'handle' => ScriptHandles::VERSIONED_CSS, 'is_js' => false ],
		];
	}
}
