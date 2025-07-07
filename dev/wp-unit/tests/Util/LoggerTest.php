<?php
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
declare( strict_types=1 );

namespace Lipe\Lib\Util;

use Lipe\Lib\Util\Logger\Handles;
use Lipe\Lib\Util\Logger\Level;

/**
 * @author Mat Lipe
 * @since  July 2025
 *
 */
class LoggerTest extends \WP_UnitTestCase {

	public function test_notice(): void {
		Logger::factory( __METHOD__ )->notice( 'This is a notice message.' );

		$messages = Handles::in()->get_handles()[ 'testing' ]->get_messages();
		$this->assertCount( 1, $messages );
		$this->assertSame( [
			[
				'id'      => __METHOD__,
				'level'   => Level::Notice,
				'message' => 'This is a notice message.',
			],
		], $messages );

		Logger::factory( __METHOD__ )->notice( 'This is another notice message.' );
		$messages = Handles::in()->get_handles()[ 'testing' ]->get_messages();
		$this->assertCount( 2, $messages );
		$this->assertSame( [
			[
				'id'      => __METHOD__,
				'level'   => Level::Notice,
				'message' => 'This is a notice message.',
			],
			[
				'id'      => __METHOD__,
				'level'   => Level::Notice,
				'message' => 'This is another notice message.',
			],
		], $messages );

		$this->assertSame( [
			0 => '[NOTICE] Lipe\Lib\Util\LoggerTest::test_notice: This is a notice message.',
			1 => '[NOTICE] Lipe\Lib\Util\LoggerTest::test_notice: This is another notice message.',
		], Testing::in()->errors );
	}


	public function test_error(): void {
		Logger::factory( __METHOD__ )->error( 'This is an error message.' );

		$messages = Handles::in()->get_handles()[ 'testing' ]->get_messages();
		$this->assertCount( 1, $messages );
		$this->assertSame( [
			[
				'id'      => __METHOD__,
				'level'   => Level::Error,
				'message' => 'This is an error message.',
			],
		], $messages );

		Logger::factory( __METHOD__ )->error( 'This is another error message.' );
		$messages = Handles::in()->get_handles()[ 'testing' ]->get_messages();
		$this->assertCount( 2, $messages );
		$this->assertSame( [
			[
				'id'      => __METHOD__,
				'level'   => Level::Error,
				'message' => 'This is an error message.',
			],
			[
				'id'      => __METHOD__,
				'level'   => Level::Error,
				'message' => 'This is another error message.',
			],
		], $messages );

		$this->assertSame( [
			0 => '[ERROR] Lipe\Lib\Util\LoggerTest::test_error: This is an error message.',
			1 => '[ERROR] Lipe\Lib\Util\LoggerTest::test_error: This is another error message.',
		], Testing::in()->errors );
	}


	public function test_warn(): void {
		Logger::factory( __METHOD__ )->warn( 'This is a warning message.' );

		$messages = Handles::in()->get_handles()[ 'testing' ]->get_messages();
		$this->assertCount( 1, $messages );
		$this->assertSame( [
			[
				'id'      => __METHOD__,
				'level'   => Level::Warning,
				'message' => 'This is a warning message.',
			],
		], $messages );

		Logger::factory( __METHOD__ )->warn( 'This is another warning message.' );

		$messages = Handles::in()->get_handles()[ 'testing' ]->get_messages();
		$this->assertCount( 2, $messages );
		$this->assertSame( [
			[
				'id'      => __METHOD__,
				'level'   => Level::Warning,
				'message' => 'This is a warning message.',
			],
			[
				'id'      => __METHOD__,
				'level'   => Level::Warning,
				'message' => 'This is another warning message.',
			],
		], $messages );

		$this->assertSame( [
			0 => '[WARNING] Lipe\Lib\Util\LoggerTest::test_warn: This is a warning message.',
			1 => '[WARNING] Lipe\Lib\Util\LoggerTest::test_warn: This is another warning message.',
		], Testing::in()->errors );
	}


	public function test_debug(): void {
		Logger::factory( __METHOD__ )->debug( 'This is a debug message.' );

		$messages = Handles::in()->get_handles()[ 'testing' ]->get_messages();
		$this->assertCount( 1, $messages );
		$this->assertSame( [
			[
				'id'      => __METHOD__,
				'level'   => Level::Debug,
				'message' => 'This is a debug message.',
			],
		], $messages );

		Logger::factory( __METHOD__ )->debug( 'This is another debug message.' );
		$messages = Handles::in()->get_handles()[ 'testing' ]->get_messages();
		$this->assertCount( 2, $messages );
		$this->assertSame( [
			[
				'id'      => __METHOD__,
				'level'   => Level::Debug,
				'message' => 'This is a debug message.',
			],
			[
				'id'      => __METHOD__,
				'level'   => Level::Debug,
				'message' => 'This is another debug message.',
			],
		], $messages );

		$this->assertSame( [
			0 => '[DEBUG] Lipe\Lib\Util\LoggerTest::test_debug: This is a debug message.',
			1 => '[DEBUG] Lipe\Lib\Util\LoggerTest::test_debug: This is another debug message.',
		], Testing::in()->errors );
	}


	public function test_debug_off(): void {
		Testing::in()->is_wp_debug = false;
		Logger::factory( __METHOD__ )->debug( 'This message should not be logged.' );

		$messages = Handles::in()->get_handles()[ 'testing' ]->get_messages();
		$this->assertCount( 0, $messages );
	}
}
