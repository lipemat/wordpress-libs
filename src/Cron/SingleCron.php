<?php
declare( strict_types=1 );

namespace Lipe\Lib\Cron;

interface SingleCron {
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
	 * @param mixed $data - Data to be passed to the cron job.
	 *
	 * @return void
	 */
	public function run( mixed $data ): void;
}
