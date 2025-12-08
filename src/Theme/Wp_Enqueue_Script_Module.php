<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * `wp_enqueue_script_module` $args
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_enqueue_script_module/
 * @since  WP 6.9
 *
 * @author Mat Lipe
 * @since  5.8.0
 *
 * @see    wp_enqueue_script_module
 *
 * @phpstan-type SCRIPT_MODULE array{
 *     fetchpriority?: 'auto'|'high'|'low',
 *     in_footer?: bool
 * }
 *
 * @implements ArgsRules<SCRIPT_MODULE>
 */
class Wp_Enqueue_Script_Module implements ArgsRules {
	/**
	 * @use Args<SCRIPT_MODULE>
	 */
	use Args;

	public const FETCH_PRIORITY_AUTO = 'auto';
	public const FETCH_PRIORITY_HIGH = 'high';
	public const FETCH_PRIORITY_LOW  = 'low';

	/**
	 * Whether to enqueue the script in the footer.
	 *
	 * @var bool
	 */
	public bool $in_footer;

	/**
	 * Sets the priority of the script's loading.
	 *
	 * May also be set via:
	 * `wp_script_modules()->set_fetchpriority( $handle, 'low' )`
	 *
	 * @phpstan-var self::FETCH_PRIORITY_*
	 * @var 'auto'|'high'|'low'
	 */
	public string $fetchpriority;
}
