<?php
declare( strict_types=1 );

namespace Lipe\Lib\Cron;

/**
 * Represents a single cron task.
 *
 * @author  Mat Lipe
 * @since   4.10.0
 */
interface Cron {
	public const NAME = __CLASS__;


	/**
	 * Get the name of this task to be used as cron slug.
	 *
	 * @return string
	 */
	public function get_name(): string;


	/**
	 * Run the task.
	 *
	 * @return void
	 */
	public function run(): void;


	/**
	 * How often the event should reoccur.
	 * hourly, twicedaily, daily
	 *
	 * If going to be using custom recurrence intervals, it is best
	 * to create a class for managing them with interval constants to return
	 * with this method.
	 *
	 * @return string
	 */
	public function get_recurrence(): string;
}
