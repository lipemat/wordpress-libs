<?php

declare( strict_types=1 );

namespace Lipe\Lib\Blocks;

use Lipe\Lib\Query\Args_Abstract;

/**
 * A fluent interface for calling `register_block_type`.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @see register_block_type()
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_type/
 */
class Register_Block extends Args_Abstract {
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
	 * @var array<int, array<string, mixed>>
	 * @phpstan-var array<int, array{
	 *   name: string,
	 *   label: string,
	 *   inline_style: string,
	 *   style_handle: string,
	 *   is_default: bool,
	 * }>
	 */
	public array $styles;

	/**
	 * Supported features.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
	 *
	 * @var array<string,mixed>
	 */
	public array $supports;

	/**
	 * Structured data for the block preview.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	public array $example;

	/**
	 * Block type render callback.
	 *
	 * @phpstan-var callable(array<string, mixed>, string): string
	 *
	 * @var callable
	 */
	public $render_callback;

	/**
	 * Block type attributes property schemas.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	public array $attributes;

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
	 * Block type editor only style handles.
	 *
	 * @var array<int, string>
	 */
	public array $editor_style_handles;

	/**
	 * Block type front end and editor style handles.
	 *
	 * @var array<int, string>
	 */
	public array $style_handles;

	/**
	 * Block type front end only script handles.
	 *
	 * @var array<int, string>
	 */
	public array $view_script_handles;

	/**
	 * Block variations.
	 *
	 * @var array<int, array<string, mixed>>
	 */
	public array $variations;
}
