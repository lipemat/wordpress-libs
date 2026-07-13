<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * `wp_enqueue_scripts` $args
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 *
 * @author Mat Lipe
 * @since  4.8.0
 *
 * @see    wp_enqueue_script
 *
 * @phpstan-type SCRIPT array{
 *     in_footer?: bool,
 *     fetchpriority?: 'auto'|'high'|'low',
 *     strategy?: 'async'|'defer'
 * }
 *
 * @implements ArgsRules<SCRIPT>
 */
class Wp_Enqueue_Script implements ArgsRules {
	/**
	 * @use Args<SCRIPT>
	 */
	use Args;

	public const string FETCH_PRIORITY_AUTO = 'auto';
	public const string FETCH_PRIORITY_HIGH = 'high';
	public const string FETCH_PRIORITY_LOW  = 'low';

	public const string STRATEGY_ASYNC = 'async';
	public const string STRATEGY_DEFER = 'defer';

	/**
	 * Browser script loading strategy.
	 *
	 * @phpstan-var self::STRATEGY_*
	 * @var 'defer'|'async'
	 */
	public string $strategy;

	/**
	 * Whether to enqueue the script in the footer.
	 *
	 * @var bool
	 */
	public bool $in_footer;

	/**
	 * Sets the priority of the script's loading.
	 *
	 * @since WP 6.9
	 *
	 * May also be set via:
	 * `wp_script_add_data($handle, 'fetchpriority', 'low')`
	 *
	 * @phpstan-var self::FETCH_PRIORITY_*
	 * @var 'auto'|'high'|'low'
	 */
	public string $fetchpriority;
}
