<?php
/** @noinspection PhpUnhandledExceptionInspection */
declare( strict_types=1 );

namespace Lipe\Lib\Api;

/**
 * @author Mat Lipe
 * @since  June 2024
 *
 */
class ZipTest extends \WP_UnitTestCase {
	public function test_get_url_for_endpoint(): void {
		$url = Zip::in()->get_url_for_endpoint();
		$this->assertSame( 'http://wp-libs.loc/api/zip/', $url );
	}


	public function test_get_post_data_to_send(): void {
		$data = Zip::in()->get_post_data_to_send( [
			'https://onpointplugins.com/wp/readme.html',
			'https://onpointplugins.com/wp/license.txt',
		] );
		$this->assertSame( [
			'lipe/lib/util/zip/key'  => 'fabcc6d946bd7f6d6919d493f04e069b',
			'lipe/lib/util/zip/name' => null,
			'lipe/lib/util/zip/urls' => [
				'https://onpointplugins.com/wp/readme.html',
				'https://onpointplugins.com/wp/license.txt',
			],
		], $data );

		$data = Zip::in()->get_post_data_to_send( [
			'https://onpointplugins.com/irrelevant',
			'https://onpointplugins.com/wp/license.txt',
		], 'fred' );
		$this->assertSame( [
			'lipe/lib/util/zip/key'  => '8ced05dbd5b8ab7f1ef0c5811bb5ae2e',
			'lipe/lib/util/zip/name' => 'fred',
			'lipe/lib/util/zip/urls' => [
				'https://onpointplugins.com/irrelevant',
				'https://onpointplugins.com/wp/license.txt',
			],
		], $data );
	}


	public function test_build_zip(): void {
		unlink( 'C:\Users\mat\AppData\Local\Temp/d7d4671eed44043cd98b9f2498db9711' );
		$this->assertFalse( file_exists( 'C:\Users\mat\AppData\Local\Temp/d7d4671eed44043cd98b9f2498db9711' ) );
		$temp_count = \count( glob( get_temp_dir() . '*' ) );

		get_echo( function() {
			try {
				Zip::in()->build_zip( [
					'https://onpointplugins.com/wp/readme.html',
					'https://onpointplugins.com/wp/license.txt',
				] );
			} catch ( \OutOfBoundsException $e ) {
				$this->assertSame( 'Exit called in test context.', $e->getMessage() );
			}
		} );

		$this->assertTrue( file_exists( 'C:\Users\mat\AppData\Local\Temp/d7d4671eed44043cd98b9f2498db9711' ) );

		$zip = new \ZipArchive;
		$zip->open( 'C:\Users\mat\AppData\Local\Temp/d7d4671eed44043cd98b9f2498db9711' );
		$files = [];
		for ( $i = 0; $i < $zip->numFiles; $i ++ ) {
			$files[] = $zip->statIndex( $i )['name'];
		}
		$zip->close();
		$this->assertSame( [ 'readme.html', 'license.txt' ], $files );

		$this->assertLessThanOrEqual( $temp_count + 1, \count( glob( get_temp_dir() . '*' ) ), 'Temp files are not being cleaned up' );

		unlink( 'C:\Users\mat\AppData\Local\Temp/d7d4671eed44043cd98b9f2498db9711' );
	}


	public function test_prevent_non_public_files_from_being_included(): void {
		$this->expectWpDie( 'A valid URL was not provided. http:../../README.md' );
		$this->expectWpDie( 'Failed creating zip file.' );
		Zip::in()->build_zip( [
			'../../README.md',
		], 'test_build_zip' );
	}


	public function test_forbidden_php_files(): void {
		$this->expectWpDie( 'PHP files are not allowed. https://onpointplugins.com/wp-config.php...
' );
		$this->expectWpDie( 'Failed creating zip file.' );
		Zip::in()->build_zip( [
			'https://onpointplugins.com/wp-config.php',
		], 'test_build_zip' );

		$this->expectWpDie( 'PHP files are not allowed. https://onpointplugins.com/wp-cron.php...
' );
		Zip::in()->build_zip( [
			'https://onpointplugins.com/wp-cron.php',
		], 'test_build_zip' );
	}


	public function test_get_paths(): void {
		$paths = call_private_method( Zip::in(), 'get_paths', [
			[
				'https://onpointplugins.com/wp/readme.html',
				'https://onpointplugins.com/wp/license.txt',
			], 'frank',
		] );
		$this->assertEquals( (object) [
			'file_name' => 'd7d4671eed44043cd98b9f2498db9711',
			'file_path' => 'C:\Users\mat\AppData\Local\Temp',
			'zip_path'  => 'C:\Users\mat\AppData\Local\Temp/d7d4671eed44043cd98b9f2498db9711',
			'zip_name'  => 'frank',
		], $paths );

		$paths = call_private_method( Zip::in(), 'get_paths', [
			[
				'https://onpointplugins.com/wp/readme.html',
				'https://onpointplugins.com/wp/license.txt',
			],
		] );
		$this->assertEquals( (object) [
			'file_name' => 'd7d4671eed44043cd98b9f2498db9711',
			'file_path' => 'C:\Users\mat\AppData\Local\Temp',
			'zip_path'  => 'C:\Users\mat\AppData\Local\Temp/d7d4671eed44043cd98b9f2498db9711',
			'zip_name'  => 'd7d4671eed44043cd98b9f2498db9711',
		], $paths );
	}


	/**
	 * @dataProvider provideValidateRequest
	 */
	public function test_handle_request( array $post, callable $setup ): void {
		$_POST = $post;
		$setup( $this );
		try {
			Zip::in()->handle_request();
		} catch ( \OutOfBoundsException $e ) {
			$this->assertSame( 'Exit called in test context.', $e->getMessage() );
		}
		$this->assertTrue( true );
	}


	public function test_init(): void {
		$this->assertFalse( get_private_property( Api::in(), 'initialized' ) );
		$this->assertFalse( get_private_property( Zip::in(), 'initialized' ) );
		Zip::init();
		$this->assertTrue( get_private_property( Api::in(), 'initialized' ) );
		$this->assertTrue( get_private_property( Zip::in(), 'initialized' ) );
	}


	public static function provideValidateRequest(): array {
		return [
			'no-data'     => [
				'post'  => [],
				'setup' => function( $class ) {
					$class->expectWpDie( 'No URL specified.' );
					$class->expectWpDie( 'Incorrect key sent.' );
				},
			],
			'url-only'    => [
				'post'  => [
					Zip::URLS => [
						'https://onpointplugins.com/wp/readme.html',
						'https://onpointplugins.com/wp/license.txt',
					],
				],
				'setup' => function( $class ) {
					$class->expectWpDie( 'Incorrect key sent.' );
				},
			],
			'invalid-key' => [
				'post'  => [
					Zip::URLS => [
						'https://onpointplugins.com/wp/readme.html',
						'https://onpointplugins.com/wp/license.txt',
					],
					// Old key.
					Zip::KEY  => \crypt( \AUTH_KEY, \AUTH_SALT ),
				],
				'setup' => function( $class ) {
					$class->expectWpDie( 'Incorrect key sent.' );
				},
			],
			'valid'       => [
				'post'  => [
					Zip::URLS => [
						'https://onpointplugins.com/wp/readme.html',
						'https://onpointplugins.com/wp/license.txt',
					],
					Zip::KEY  => 'fabcc6d946bd7f6d6919d493f04e069b',
				],
				'setup' => function( $class ) {
				},
			],
		];
	}
}
