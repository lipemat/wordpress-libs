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
 * @implements ArgsRules<array<string, mixed>>
 */
class Wp_Enqueue_Script implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	public const STRATEGY_ASYNC = 'async';
	public const STRATEGY_DEFER = 'defer';

	/**
	 * @phpstan-var self::STRATEGY_*
	 * @var 'defer'|'async'
	 */
	public string $strategy;

	/**
	 * @var bool
	 */
	public bool $in_footer;
}
