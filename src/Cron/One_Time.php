<?php
declare( strict_types=1 );

namespace Lipe\Lib\Cron;

use Lipe\Lib\Container\Factory;

/**
 * Schedule a single cron event.
 *
 * @author  Mat Lipe
 * @since   5.8.0
 *
 * @example
 *     // To initialize the cron event handler.
 *     One_Time::factory(MyCron::in())->init();
 *     // To schedule the single event.
 *     One_Time::factory(MyCron::in())->schedule($data);
 *
 */
class One_Time {
	/**
	 * @use Factory<array{SingleCron}>
	 */
	use Factory;

	/**
	 * Build a new cron runner instance.
	 *
	 * @param SingleCron $cron - The cron event configuration.
	 */
	final protected function __construct(
		protected readonly SingleCron $cron,
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
		add_action( $this->cron->get_name(), $this->run_task( ... ), 10 );
	}


	/**
	 * Schedule the one-time event.
	 *
	 * @param mixed    $data        - The data to pass to the cron event.
	 * @param int|null $timestamp   - The timestamp to schedule the event.
	 *                              Defaults to the current time.
	 *
	 * @return bool|\WP_Error
	 */
	public function schedule( mixed $data, ?int $timestamp = null ): bool|\WP_Error {
		return wp_schedule_single_event( $timestamp ?? ( time() - 1 ), $this->cron->get_name(), [ $data ] );
	}


	/**
	 * Get the timestamp this cron will run next.
	 *
	 * @param mixed $data   - The data to pass to the cron event.
	 *                      Must match the data passed to `schedule`.
	 *
	 * @return int|false
	 */
	public function get_next_run( mixed $data ): int|false {
		return wp_next_scheduled( $this->cron->get_name(), [ $data ] );
	}


	/**
	 * Get the timestamp of the last time this cron was run.
	 *
	 * `false` if it has never run.
	 *
	 * @return int|false
	 */
	public function get_last_run(): int|false {
		return get_option( $this->cron->get_name() . '/last-run', false );
	}


	/**
	 * Store a last run stamp and run the `run` method.
	 *
	 * @param mixed $args - The arguments passed to the cron event.
	 *
	 * @return void
	 */
	protected function run_task( mixed $args ): void {
		update_option( $this->cron->get_name() . '/last-run', time() );
		$this->cron->run( $args );
	}


	/**
	 * Build a new One_Time cron instance.
	 *
	 * @param SingleCron $cron - Cron to register.
	 *
	 * @return static
	 */
	public static function factory( SingleCron $cron ): static {
		return static::factorize( $cron );
	}
}
