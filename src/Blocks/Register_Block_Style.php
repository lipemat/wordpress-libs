<?php
declare( strict_types=1 );

namespace Lipe\Lib\Blocks;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A fluent interface for calling `register_block_style`.
 *
 * @since  5.1.1
 *
 * @see    register_block_style()
 *
 * @link   https://developer.wordpress.org/reference/functions/register_block_style/
 *
 * @phpstan-type EXISTING array{
 *     name: string,
 *     label: string,
 *     inline_style: string,
 *     style_handle: string,
 *     is_default: bool
 * }
 */
class Register_Block_Style implements ArgsRules {
	/**
	 * @use Args<\Partial<EXISTING>>
	 */
	use Args;

	/**
	 * The identifier of the style used to compute a CSS class.
	 *
	 * @var string
	 */
	public string $name;

	/**
	 * A human-readable label for the style.
	 *
	 * @var string
	 */
	public string $label;

	/**
	 * Inline CSS code that registers the CSS class required for the style.
	 *
	 * All inline block styles will appear in the head tag.
	 *
	 * @var string
	 */
	public string $inline_style;

	/**
	 * A handle to an already registered style that should be enqueued in places
	 * where block styles are needed.
	 *
	 * Using this option gives you more control over where to enqueue the CSS.
	 *
	 * @var string
	 */
	public string $style_handle;

	/**
	 * Whether this style is the default style for the block.
	 *
	 * @var bool
	 */
	public bool $is_default;
}
