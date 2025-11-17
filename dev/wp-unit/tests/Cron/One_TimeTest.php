<?php
declare( strict_types=1 );

namespace Lipe\Lib\Cron;

/**
 * @author Mat Lipe
 * @since  November 2025
 *
 */
class One_TimeTest extends \WP_UnitTestCase {
	public function test_schedule(): void {
		$mock = new class() implements SingleCron {
			public function get_name(): string {
				return 'one-time-test';
			}


			public function run( mixed $data ): void {
				update_option( 'one-time-test-data', $data );
			}
		};

		$one_time = One_Time::factory( $mock );
		$one_time->init();

		$test_data = [ 'key' => 'value', 'timestamp' => time() ];
		$timestamp = \strtotime( '+1 hour' );

		$this->assertFalse( $one_time->get_next_run( $test_data ) );

		$result = $one_time->schedule( $test_data, $timestamp );
		$this->assertTrue( $result );

		$next_run = $one_time->get_next_run( $test_data );
		$this->assertNotFalse( $next_run );
		$this->assertEquals( $timestamp, $next_run );

		\wp_cron_run_all();

		$this->assertFalse( get_option( 'one-time-test-data' ) );
		$this->assertFalse( $one_time->get_last_run() );

		wp_cron_run_event( 'one-time-test' );
		$this->assertEquals( date( 'd/m/y H:i' ), date( 'd/m/y H:i', $one_time->get_last_run() ) );
		$this->assertFalse( $one_time->get_next_run( $test_data ) );

		$data = get_option( 'one-time-test-data' );
		$this->assertSame( 'value', $data['key'] );
		$this->assertIsInt( $data['timestamp'] );
		$this->assertThat( $data['timestamp'],
			$this->logicalAnd(
				$this->greaterThan( \time() - 2 ),
				$this->lessThan( \time() + 2 )
			)
		);
	}


	public function test_default_schedule(): void {
		$mock = new class() implements SingleCron {
			public function get_name(): string {
				return 'one-time-immediate';
			}


			public function run( mixed $data ): void {
				update_option( 'one-time-immediate-data', $data );
			}
		};

		One_Time::factory( $mock )->init();

		$test_data = 'immediate-test';
		$one_time = One_Time::factory( $mock );

		$result = $one_time->schedule( $test_data );
		$this->assertTrue( $result );

		$next_run = $one_time->get_next_run( $test_data );
		$this->assertNotFalse( $next_run );

		$this->assertThat(
			$next_run,
			$this->logicalAnd(
				$this->lessThan( \time() ),
				$this->greaterThan( \time() - 2 )
			)
		);

		\wp_cron_run_all();

		$this->assertEquals( $test_data, get_option( 'one-time-immediate-data' ) );
		$this->assertFalse( $one_time->get_next_run( $test_data ) );
	}
}
