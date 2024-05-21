<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

/**
 * A fluent interface for the `wp_dropdown_categories()` function in WordPress.
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_dropdown_categories/
 *
 * @author Mat Lipe
 * @since  4.10.0
 */
class Wp_Dropdown_Categories extends Get_Terms {
	public const FIELD_TERM_ID     = 'term_id';
	public const FIELD_NAME        = 'name';
	public const FIELD_SLUG        = 'slug';
	public const FIELD_TERM_GROUP  = 'term_group';
	public const FIELD_TAXONOMY_ID = 'term_taxonomy_id';
	public const FIELD_TAXONOMY    = 'taxonomy';
	public const FIELD_DESCRIPTION = 'description';
	public const FIELD_PARENT      = 'parent';
	public const FIELD_COUNT       = 'count';

	/**
	 * The 'id' of an element that contains descriptive text for the select.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $aria_describedby;

	/**
	 * Text to display for showing all categories.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $show_option_all;

	/**
	 * Text to display for showing no categories.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $show_option_none;

	/**
	 * Value to use when no category is selected.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $option_none_value;

	/**
	 * Whether to include post counts.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $show_count;

	/**
	 * Whether to echo or return the generated markup.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $echo;

	/**
	 * Maximum depth.
	 *
	 * Default 0.
	 *
	 * @phpstan-var positive-int | 0
	 *
	 * @var int
	 */
	public int $depth;

	/**
	 * Tab index for the select element.
	 *
	 * Default 0 (no tabindex).
	 *
	 * @var int
	 */
	public int $tab_index;

	/**
	 * Value for the 'id' attribute of the select element.
	 *
	 * Defaults to the value of `$name`.
	 *
	 * @var string
	 */
	public string $id;

	/**
	 * Value for the 'class' attribute of the select element.
	 *
	 * Default 'postform'.
	 *
	 * @var string
	 */
	public string $class;

	/**
	 * Value of the option that should be selected.
	 *
	 * Default 0.
	 *
	 * @var int|string
	 */
	public string|int $selected;

	/**
	 * Term field that should be used to populate the 'value' attribute of the option elements.
	 *
	 * Accepts any valid term field: 'term_id', 'name', 'slug', 'term_group', 'term_taxonomy_id', 'taxonomy', 'description', 'parent',
	 * 'count'.
	 *
	 * Default 'term_id'.
	 *
	 * @phpstan-var self::FIELD_*
	 * @var string
	 */
	public string $value_field;

	/**
	 * True to skip generating markup if no categories are found.
	 *
	 * Default false (create select element even if no categories are found).
	 *
	 * @var bool
	 */
	public bool $hide_if_empty;

	/**
	 * Whether the `<select>` element should have the HTML5 'required' attribute.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $required;

	/**
	 * Walker object to use to build the output.
	 *
	 * Default empty which results in a `Walker_CategoryDropdown` instance being used.
	 *
	 * @see \Walker_CategoryDropdown
	 *
	 * @var \Walker
	 */
	public \Walker $walker;
}
