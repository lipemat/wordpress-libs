<?php
declare( strict_types=1 );

namespace {

	/**
	 * @phpstan-type LogEntry array{message: string, id: string}
	 */
	class QM {
		/** @var array<int, LogEntry> */
		public static array $debug = [];

		/** @var array<int, LogEntry> */
		public static array $error = [];

		/** @var array<int, LogEntry> */
		public static array $notice = [];

		/** @var array<int, LogEntry> */
		public static array $warning = [];


		/**
		 * @param string $message
		 * @param string $id
		 *
		 * @return void
		 */
		public static function debug( string $message, array $context = [] ): void {
			self::$debug[] = [ 'message' => $message, 'context' => $context ];
		}


		/**
		 * @param string $message
		 * @param string $id
		 *
		 * @return void
		 */
		public static function error( string $message, array $context = [] ): void {
			self::$error[] = [ 'message' => $message, 'context' => $context ];
		}


		/**
		 * @param string $message
		 * @param string $id
		 *
		 * @return void
		 */
		public static function notice( string $message, array $context = [] ): void {
			self::$notice[] = [ 'message' => $message, 'context' => $context ];
		}


		/**
		 * @param string $message
		 * @param string $id
		 *
		 * @return void
		 */
		public static function warning( string $message, array $context = [] ): void {
			self::$warning[] = [ 'message' => $message, 'context' => $context ];
		}


		public static function clear(): void {
			self::$debug = [];
			self::$error = [];
			self::$notice = [];
			self::$warning = [];
		}
	}
}

namespace Lipe\Lib\Util\Logger {

	use Lipe\Lib\Util\Logger;

	/**
	 * @author Mat Lipe
	 * @since  July 2025
	 *
	 */
	class Query_MonitorTest extends \WP_UnitTestCase {

		public function test_actions_called(): void {
			\QM::clear();

			Logger::factory( __METHOD__ )->notice( 'This is a notice message.' );
			Logger::factory( __METHOD__ )->error( 'This is an error message.' );
			Logger::factory( __METHOD__ )->warn( 'This is a warning message.' );
			Logger::factory( __METHOD__ )->debug( 'This is a debug message.' );

			$this->assertSame(
				[
					'debug'   => [
						[
							'message' => 'Lipe\Lib\Util\Logger\Query_MonitorTest::test_actions_called: This is a debug message.',
							'context' => [],
						],
					],
					'notice'  => [
						[
							'message' => 'Lipe\Lib\Util\Logger\Query_MonitorTest::test_actions_called: This is a notice message.',
							'context' => [],
						],
					],
					'warning' => [
						[
							'message' => 'Lipe\Lib\Util\Logger\Query_MonitorTest::test_actions_called: This is a warning message.',
							'context' => [],
						],
					],
					'error'   => [
						[
							'message' => 'Lipe\Lib\Util\Logger\Query_MonitorTest::test_actions_called: This is an error message.',
							'context' => [],
						],
					],
				],
				[
					'debug'   => \QM::$debug,
					'notice'  => \QM::$notice,
					'warning' => \QM::$warning,
					'error'   => \QM::$error,
				]
			);
		}
	}
}
