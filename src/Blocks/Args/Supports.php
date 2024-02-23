<?php
//phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
declare( strict_types=1 );

namespace Lipe\Lib\Blocks\Args;

use Lipe\Lib\Query\Args_Interface;
use Lipe\Lib\Query\Args_Trait;

/**
 * A fluent interface for the `supports` argument of `register_block_type`.
 *
 * @author Mat Lipe
 * @since  4.7.0
 *
 * @link   https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports
 */
class Supports implements Args_Interface {
	use Args_Trait;

	/**
	 * This property adds block controls which allow to change block’s alignment.
	 *
	 * @var bool|array<int, 'left' | 'right' | 'full' | 'wide'>
	 */
	public $align;

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
	 *      background?: boolean,
	 *      gradients?: boolean,
	 *      text?: boolean,
	 *      link?: boolean,
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
	public $interactivity;

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
	public $layout;

	/**
	 * False allows the block just once per post.
	 *
	 * @var bool
	 */
	public bool $multiple;

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
	 * Support the typography UI controls.
	 *
	 * @var array{
	 *     fontSize?: bool,
	 *     lineHeight?: bool,
	 * }
	 */
	public array $typography;
}
