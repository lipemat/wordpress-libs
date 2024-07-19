<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

/**
 * @author Mat Lipe
 * @since  July 2024
 *
 */
class FilesTest extends \WP_UnitTestCase {
	protected function tearDown(): void {
		$filesystem = Files::in()->get_wp_filesystem();
		$filesystem->rmdir( dirname( __DIR__, 2 ) . '/fixtures/directory-copy', true );

		parent::tearDown();
	}


	public function test_copy_directory(): void {
		$source = dirname( __DIR__, 2 ) . '/fixtures/files-directory';
		$destination = dirname( __DIR__, 2 ) . '/fixtures/directory-copy';

		$this->assertFileDoesNotExist( $destination . '/.two' );
		$this->assertFileDoesNotExist( $destination . '/one.txt' );
		$this->assertFileDoesNotExist( $destination . '/next-level/.5' );
		$this->assertFileDoesNotExist( $destination . '/next-level/three.txt' );

		Files::in()->copy_directory( $source, $destination );
		$this->assertFileExists( $destination . '/.two' );
		$this->assertFileExists( $destination . '/one.txt' );
		$this->assertFileExists( $destination . '/next-level/.5' );
		$this->assertFileExists( $destination . '/next-level/three.txt' );
	}
}
