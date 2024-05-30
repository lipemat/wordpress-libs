<?php
declare( strict_types=1 );

namespace Lipe\Lib\Cron;

/**
 * @author Mat Lipe
 * @since  May 2024
 *
 */
class RunnerTest extends \WP_UnitTestCase {
	public function testRun(): void {
		$mock = new class() implements Cron {
			public function get_name(): string {
				return 'runner-test';
			}


			public function get_recurrence(): string {
				return 'daily';
			}


			public function run(): void {
				update_option( 'runner-test', time() );
			}
		};

		Runner::factory( $mock )->init();
		$this->assertNotEmpty( wp_get_schedule( 'runner-test' ) );
		_set_cron_array( [] );
		$this->assertFalse( wp_get_schedule( 'runner-test' ) );

		$runner = Runner::factory( $mock );
		call_private_method( $runner, 'schedule_task' );
		$this->assertNotEmpty( wp_get_schedule( 'runner-test' ) );
		$this->assertEquals( date( 'd/m/y' ), date( 'd/m/y', wp_next_scheduled( 'runner-test' ) ) );
		\wp_cron_run_all();

		$this->assertEquals( date( 'd/m/y' ), date( 'd/m/y', get_option( 'runner-test' ) ) );

		$this->assertEquals( date( 'd/m/y' ), date( 'd/m/y', $runner->get_last_run() ) );

		$this->assertEquals( date( 'd/m/y', \strtotime( '+1 day' ) ), date( 'd/m/y', wp_next_scheduled( 'runner-test' ) ) );
		$this->assertEquals( date( 'd/m/y', \strtotime( '+1 day' ) ), date( 'd/m/y', $runner->get_next_run() ) );
	}
}
