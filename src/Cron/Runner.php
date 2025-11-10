<?php
declare( strict_types=1 );

namespace Lipe\Lib\Cron;

use Lipe\Lib\Libs\Container\Factory;

/**
 * Run on cron event based on the cron object passed in.
 *
 * @author  Mat Lipe
 * @since   4.10.0
 *
 * @example `Runner::factory(MyCron::in())->init()`
 *
 */
class Runner {
	/**
	 * @use Factory<array{Cron}>
	 */
	use Factory;

	/**
	 * Build a new cron runner instance.
	 *
	 * @param Cron $cron - The cron event configuration.
	 */
	final protected function __construct(
		protected readonly Cron $cron,
	) {
	}


	/**
	 * Register the cron event with WordPress.
	 *
	 * Not called automatically to allow access to this cron outside
	 * the initialization process.
	 *
	 * @return void
	 */
	public function init(): void {
		add_action( $this->cron->get_name(), [ $this, 'run_task' ] );
		$this->schedule_task();
	}


	/**
	 * Store a last run stamp and run the `run` method.
	 *
	 * @interal
	 *
	 * @see Cron::run()
	 *
	 * @return void
	 */
	public function run_task(): void {
		update_option( $this->cron->get_name() . '/last-run', time() );
		$this->cron->run();
	}


	/**
	 * Get the timestamp this cron will run next.
	 *
	 * @return int|false
	 */
	public function get_next_run(): int|false {
		return wp_next_scheduled( $this->cron->get_name() );
	}


	/**
	 * Get the timestamp of the last time this cron was run.
	 *
	 * false if it has never run.
	 *
	 * @return int|false
	 */
	public function get_last_run(): int|false {
		return get_option( $this->cron->get_name() . '/last-run', false );
	}


	/**
	 * Schedule the task with the WordPress cron system.
	 *
	 * @return void
	 */
	protected function schedule_task(): void {
		if ( false === $this->get_next_run() ) {
			wp_schedule_event( time() - 1, $this->cron->get_recurrence(), $this->cron->get_name() );
		}
	}


	/**
	 * Factory method to create a new instance of this class.
	 *
	 * @param Cron $event - The cron event to run.
	 *
	 * @return static
	 */
	public static function factory( Cron $event ): static {
		return static::factorize( $event );
	}
}
