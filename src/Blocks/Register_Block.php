<?php

declare( strict_types=1 );

namespace Lipe\Lib\Blocks;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Blocks\Args\Prop;
use Lipe\Lib\Blocks\Args\Source;
use Lipe\Lib\Blocks\Args\Supports;

/**
 * A fluent interface for calling `register_block_type`.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @see    register_block_type()
 *
 * @link   https://developer.wordpress.org/reference/functions/register_block_type/
 *
 * @phpstan-type ATTR_SHAPE array{
 *     type: Prop::TYPE_*,
 *     default?: mixed,
 *     enum?: array<string|int|bool>,
 *     selector?: string,
 *     source?: Source::SOURCE_*,
 *     attribute?: string,
 *     query?: array<string, array{
 *         source?: Source::SOURCE_*,
 *         type?: Prop::TYPE_*,
 *         attribute?: string,
 *     }>
 * }
 * @phpstan-type BLOCK_ATTRIBUTES array<string, ATTR_SHAPE>
 */
class Register_Block implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	/**
	 * Block API version.
	 *
	 * @var int
	 */
	public int $api_version;

	/**
	 * Human-readable block type label.
	 *
	 * @var string
	 */
	public string $title;

	/**
	 * Block type category classification, used in search interfaces to arrange
	 * block types by a category.
	 *
	 * @var string
	 */
	public string $category;

	/**
	 * Setting parent lets a block require that it is only available when nested
	 * within the specified blocks.
	 *
	 * @var array<int, string>
	 */
	public array $parent;

	/**
	 * Setting ancestor makes a block available only inside the specified block
	 * types at any position of the ancestor's block subtree.
	 *
	 * @var array<int, string>
	 */
	public array $ancestor;

	/**
	 * Block type icon.
	 *
	 * @var string
	 */
	public string $icon;

	/**
	 * A detailed block type description.
	 *
	 * @var string
	 */
	public string $description;

	/**
	 * Additional keywords to produce block type as result in search interfaces.
	 *
	 * @var array<int, string>
	 */
	public array $keywords;

	/**
	 * The translation textdomain.
	 *
	 * @var string
	 */
	public string $textdomain;

	/**
	 * Alternative block styles.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-styles/
	 *
	 * @var array<int, array{
	 *   name: string,
	 *   label: string,
	 *   inline_style?: string,
	 *   style_handle?: string,
	 *   is_default?: bool,
	 * }>
	 */
	public array $styles;

	/**
	 * Supported features.
	 *
	 * @see  Register_Block::supports()
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
	 *
	 * @var array<string,mixed>|Supports
	 */
	public array|Supports $supports;

	/**
	 * Structured data for the block preview.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	public array $example;

	/**
	 * Block type render callback.
	 *
	 * @phpstan-var callable( array<string, mixed>, string, \WP_Block= ) : string
	 *
	 * @var callable
	 */
	public $render_callback;

	/**
	 * Block type attributes property schemas.
	 *
	 * @phpstan-var BLOCK_ATTRIBUTES
	 *
	 * @var array<string, array<string, mixed>>
	 */
	public array $attributes;

	/**
	 * Limit blocks allowed to be direct children when InnerBlocks are used.
	 *
	 * @var array<int, string>
	 */
	public array $allowed_blocks;

	/**
	 * Context values inherited by blocks of this type.
	 *
	 * @var array<int, string>
	 */
	public array $uses_context;

	/**
	 * Context provided by blocks of this type.
	 *
	 * @var array<string, string>
	 */
	public array $provides_context;

	/**
	 * Block type editor only script handles.
	 *
	 * @var array<int, string>
	 */
	public array $editor_script_handles;

	/**
	 * Block type front end and editor script handles.
	 *
	 * @var array<int, string>
	 */
	public array $script_handles;

	/**
	 * Custom CSS selectors for block theme.json style generation.
	 *
	 * @link https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-selectors.md
	 * @link https://raw.githubusercontent.com/WordPress/gutenberg/trunk/schemas/json/block.json
	 *
	 * @see  BlockSelector in @types/js-boilerplate
	 *
	 * @phpstan-var array{
	 *     root: string,
	 *     border?: string | array{
	 *         color?: string,
	 *         root?: string,
	 *         radius?: string,
	 *         style?: string,
	 *         width?: string,
	 *     },
	 *     color?: string | array{
	 *          root?:string,
	 *          background?: string,
	 *          text?: string,
	 *     },
	 *     dimensions?: string | array{
	 *          root?: string,
	 *          minHeight?: string,
	 *     },
	 *     spacing?: string | array{
	 *          root?: string,
	 *          padding?: string,
	 *          margin?: string,
	 *          blockGap?: string,
	 *     },
	 *     typography?: string | array{
	 *          root?: string,
	 *          fontFamily?: string,
	 *          fontSize?: string,
	 *          fontStyle?: string,
	 *          fontWeight?: string,
	 *          letterSpacing?: string,
	 *          lineHeight?: string,
	 *          textDecoration?: string,
	 *          textTransform?: string,
	 *     }
	 * }
	 *
	 * @var array<string, mixed>
	 */
	public array $selectors;

	/**
	 * Block type editor only style handles.
	 *
	 * @var array<int, string>
	 */
	public array $editor_style_handles;

	/**
	 * Block type front-end and editor style handles.
	 *
	 * @var array<int, string>
	 */
	public array $style_handles;

	/**
	 * Block type front-end only style handles.
	 *
	 * @var array<int, string>
	 */
	public array $view_style_handles;

	/**
	 * Block type front-end only script handles.
	 *
	 * @var array<int, string>
	 */
	public array $view_script_handles;

	/**
	 * Block type front-end only module script handles.
	 *
	 * @var array<int, string>
	 */
	public array $view_script_module_ids;

	/**
	 * Block variations.
	 *
	 * @var array<int, array<string, mixed>>
	 */
	public array $variations;

	/**
	 * Block variations callback.
	 *
	 * @var callable(): array<int, array<string, mixed>>
	 */
	public $variation_callback;

	/**
	 * Block hooks available in WP 6.4+.
	 *
	 * @link https://make.wordpress.org/core/2023/10/15/introducing-block-hooks-for-dynamic-blocks/
	 *
	 * @var array<string, 'before'|'after'|'first_child'|'last_child'>
	 */
	public array $block_hooks;


	/**
	 * Supported features via a subclass fluent interface.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
	 *
	 * @return Supports
	 */
	public function supports(): Supports {
		if ( isset( $this->supports ) && $this->supports instanceof Supports ) {
			return $this->supports;
		}
		$this->supports = new Supports( [] );
		return $this->supports;
	}
}
