<?php
//phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase -- Nothing we can do about this.
declare( strict_types=1 );

namespace Lipe\Lib\Blocks\Args;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A fluent interface for the `supports` argument of `register_block_type`.
 *
 * @author Mat Lipe
 * @since  4.7.0
 *
 * @link   https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class Supports implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	/**
	 * Anchors let you link directly to a specific block on a page.
	 * This property adds a field to define an id for the block, and a button
	 * to copy the direct link.
	 *
	 * @var bool
	 */
	public bool $anchor;

	/**
	 * This property adds block controls which allow to change block’s alignment.
	 *
	 * @var bool|array<int, 'left' | 'right' | 'full' | 'wide'>
	 */
	public array|bool $align;

	/**
	 * This property allows to enable wide alignment for your theme.
	 * To disable this behavior for a single block, set this flag to false.
	 *
	 * @var bool
	 */
	public bool $alignWide;

	/**
	 * Allows enabling the definition of an aria-label for the block, without exposing a UI field.
	 *
	 * @var bool
	 */
	public bool $ariaLabel;

	/**
	 * False removes the support for the generated className.
	 *
	 * @var bool
	 */
	public bool $className;

	/**
	 * Support color selections.
	 *
	 * @var array{
	 *     background?: bool,
	 *     button?: bool,
	 *     enableContrastChecker?: bool,
	 *     gradients?: bool,
	 *     link?: bool,
	 *     text?: bool,
	 *     heading?: bool,
	 * }
	 */
	public array $color;

	/**
	 * False removes the support for the custom className.
	 *
	 * @var bool
	 */
	public bool $customClassName;

	/**
	 * Enable dimensions UI control.
	 *
	 * @var array{
	 *     aspectRatio?: bool,
	 *     minHeight?: bool,
	 * }
	 */
	public array $dimensions;

	/**
	 * Enable block control for filters.
	 *
	 * @var array{
	 *     duotone?: bool,
	 * }
	 */
	public array $filter;

	/**
	 * False removes support for an HTML mode.
	 *
	 * @var bool
	 */
	public bool $html;

	/**
	 * Hide block from all block inserters in favor of programmatic insertion.
	 *
	 * @var bool
	 */
	public bool $inserter;

	/**
	 * Support the interactivity API.
	 *
	 * @var bool|array{
	 *     clientNavigation?: boolean,
	 *     interactive?: boolean,
	 * }
	 */
	public array|bool $interactivity;

	/**
	 * Applies to blocks that are containers for inner blocks.
	 * If set to true the layout type will be flow.
	 *
	 * @var bool|array{
	 *      default?: array{
	 *          type: string
	 *      },
	 *      allowSwitching?: bool,
	 *      allowEditing?: bool,
	 *      allowInheriting?: bool,
	 *      allowSizingOnChildren?: bool,
	 *      allowVerticalAlignment?: bool,
	 *      allowJustification?: bool,
	 *      allowOrientation?: bool,
	 *      allowCustomContentAndWideSize?: bool,
	 *  }
	 */
	public array|bool $layout;

	/**
	 * False allows the block just once per post.
	 *
	 * @var bool
	 */
	public bool $multiple;

	/**
	 * False removes the support for Options dropdown block renaming.
	 *
	 * @var bool
	 */
	public bool $renaming;

	/**
	 * False removes the support for the reusable block.
	 *
	 * @var bool
	 */
	public bool $reusable;

	/**
	 * False hides the lock options from block options dropdown.
	 *
	 * @var bool
	 */
	public bool $lock;

	/**
	 * Signals that a block supports some of the CSS style properties related to position.
	 *
	 * @var array{
	 *     sticky?: boolean,
	 * }
	 */
	public array $position;

	/**
	 * Adds block controls which allow the user to set a box shadow for a block.
	 * Shadows are disabled by default.
	 *
	 * @var bool
	 */
	public bool $shadow;

	/**
	 * Support the spacing UI controls.
	 *
	 * @var array{
	 *     blockGap?: bool|array<'horizontal'|'vertical'>,
	 *     margin?: bool|array<'top'|'bottom'|'left'|'right'>,
	 *     padding?: bool|array<'top'|'bottom'|'left'|'right'>,
	 * }
	 */
	public array $spacing;

	/**
	 * Whether the block can split when the Enter key is pressed or when blocks are pasted.
	 *
	 * @var bool
	 */
	public bool $splitting;

	/**
	 * Support the typography UI controls.
	 *
	 * @var array{
	 *     fontSize?: bool,
	 *     lineHeight?: bool,
	 *     textAlign?: bool|array<'left'|'right'|'center'>,
	 * }
	 */
	public array $typography;
}
