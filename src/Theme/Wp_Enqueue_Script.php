<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

use Lipe\Lib\Query\Args_Interface;
use Lipe\Lib\Query\Args_Trait;

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
 */
class Wp_Enqueue_Script implements Args_Interface {
	/**
	 * @use Args_Trait<array<string, mixed>>
	 */
	use Args_Trait;

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
