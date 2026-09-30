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
	protected ?string $previous_host = null;


	protected function setUp(): void {
		parent::setUp();

		$this->previous_host = $_SERVER['HTTP_HOST'] ?? null;
	}


	protected function tearDown(): void {
		$running = ScriptHandles::MASTER_JS->dist_path() . '.running';
		if ( \file_exists( $running ) ) {
			\unlink( $running );
		}
		if ( \is_string( $this->previous_host ) ) {
			$_SERVER['HTTP_HOST'] = $this->previous_host;
		} else {
			unset( $_SERVER['HTTP_HOST'] );
		}
		unset( $_SERVER['HTTPS'] );
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


	#[DataProvider( 'provideHosts' )]
	public function test_get_host( string $request_host, ?string $host, string $expected, string $message ): void {
		$_SERVER['HTTP_HOST'] = $request_host;

		$actual = Util::in()->get_host( $host );

		$this->assertSame( $expected, $actual, $message );
	}


	public function test_get_host_missing_request_host(): void {
		unset( $_SERVER['HTTP_HOST'] );

		$actual = Util::in()->get_host();

		$this->assertSame( '', $actual, 'An absent `HTTP_HOST` resolves to an empty host.' );
	}


	public function test_get_node_process_url_ported_request_host(): void {
		$_SERVER['HTTP_HOST'] = 'localhost:9084';
		$this->writeRunningFile( '{"port":3001}' );

		$actual = Util::in()->get_node_process_url( ScriptHandles::MASTER_JS, 3000, '/js/dist/master.js' );

		$this->assertSame( 'http://localhost:3001/js/dist/master.js', $actual, 'The request port is replaced by the Node process port instead of appended to it.' );
	}


	public function test_get_node_process_url_unported_request_host(): void {
		$_SERVER['HTTP_HOST'] = 'wp-libs.loc';
		$this->writeRunningFile( '{"port":3001}' );

		$actual = Util::in()->get_node_process_url( ScriptHandles::MASTER_JS, 3000, '/js/dist/master.js' );

		$this->assertSame( 'http://wp-libs.loc:3001/js/dist/master.js', $actual, 'A host without a port receives the Node process port.' );
	}


	public function test_get_node_process_url_default_port(): void {
		$_SERVER['HTTP_HOST'] = 'localhost:9084';

		$actual = Util::in()->get_node_process_url( ScriptHandles::MASTER_JS, 3000, '/js/dist/master.js' );

		$this->assertSame( 'http://localhost:3000/js/dist/master.js', $actual, 'A missing `.running` file falls back to the default port.' );
	}


	public function test_get_node_process_url_ssl_request(): void {
		$_SERVER['HTTP_HOST'] = 'localhost:9084';
		$_SERVER['HTTPS'] = 'on';
		$this->writeRunningFile( '{"port":3001}' );

		$actual = Util::in()->get_node_process_url( ScriptHandles::MASTER_JS, 3000, '/js/dist/master.js' );

		$this->assertSame( 'https://localhost:3001/js/dist/master.js', $actual, 'The scheme follows the current request.' );
	}


	public function test_get_node_process_url_without_path(): void {
		$_SERVER['HTTP_HOST'] = 'localhost:9084';
		$this->writeRunningFile( '{"port":3001}' );

		$actual = Util::in()->get_node_process_url( ScriptHandles::MASTER_JS, 3000 );

		$this->assertSame( 'http://localhost:3001', $actual, 'The path is optional.' );
	}


	private function writeRunningFile( string $contents ): void {
		\file_put_contents( ScriptHandles::MASTER_JS->dist_path() . '.running', $contents );
	}


	/**
	 * @return array<string, array{request_host: string, host: string|null, expected: string, message: string}>
	 */
	public static function provideHosts(): array {
		return [
			'ported-request-host'        => [
				'request_host' => 'localhost:9084',
				'host'         => null,
				'expected'     => 'localhost',
				'message'      => 'A ported request host drops its port.',
			],
			'unported-request-host'      => [
				'request_host' => 'wp-libs.loc',
				'host'         => null,
				'expected'     => 'wp-libs.loc',
				'message'      => 'A request host without a port is returned as is.',
			],
			'empty-request-host'         => [
				'request_host' => '',
				'host'         => null,
				'expected'     => '',
				'message'      => 'An empty request host resolves to an empty host.',
			],
			'padded-request-host'        => [
				'request_host' => ' localhost:9084 ',
				'host'         => null,
				'expected'     => 'localhost',
				'message'      => 'Surrounding whitespace is trimmed from the request host.',
			],
			'ipv6-ported-request-host'   => [
				'request_host' => '[::1]:9084',
				'host'         => null,
				'expected'     => '[::1]',
				'message'      => 'An IPv6 literal keeps its brackets while dropping the port.',
			],
			'ipv6-unported-request-host' => [
				'request_host' => '[::1]',
				'host'         => null,
				'expected'     => '[::1]',
				'message'      => 'An unported IPv6 literal is returned as is.',
			],
			'ported-provided-host'       => [
				'request_host' => 'wp-libs.loc',
				'host'         => 'localhost:9084',
				'expected'     => 'localhost',
				'message'      => 'A provided host drops its port instead of using the request host.',
			],
			'unported-provided-host'     => [
				'request_host' => 'wp-libs.loc',
				'host'         => 'example.com',
				'expected'     => 'example.com',
				'message'      => 'A provided host without a port is returned as is.',
			],
			'empty-provided-host'        => [
				'request_host' => 'wp-libs.loc',
				'host'         => '',
				'expected'     => '',
				'message'      => 'An empty provided host does not fall back to the request host.',
			],
		];
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
