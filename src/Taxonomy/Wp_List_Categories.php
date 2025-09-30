<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

/**
 * A fluent interface for the `wp_list_categories()` function in WordPress.
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_list_categories/
 *
 * @author Mat Lipe
 * @since  5.7.0
 */
class Wp_List_Categories extends Get_Terms {
	public const STYLE_LIST = 'list';
	public const STYLE_NONE = 'none';

	/**
	 * ID of category, or array of IDs of categories, that should get the 'current-cat' class.
	 *
	 * Default 0.
	 *
	 * @var int|int[]
	 */
	public int|array $current_category;

	/**
	 * Category depth. Used for tab indentation.
	 *
	 * Default 0.
	 *
	 * @phpstan-var positive-int | 0
	 *
	 * @var int
	 */
	public int $depth;

	/**
	 * Whether to echo or return the generated markup.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $echo;

	/**
	 * Text to use for the feed link.
	 *
	 * Default 'Feed for all posts filed under [cat name]'.
	 *
	 * @var string
	 */
	public string $feed;

	/**
	 * URL of an image to use for the feed link.
	 *
	 * Default empty string.
	 *
	 * @var string
	 */
	public string $feed_image;

	/**
	 * Feed type. Used to build feed link.
	 *
	 * Default empty string (default feed).
	 *
	 * @var string
	 */
	public string $feed_type;

	/**
	 * Whether to hide the `$title_li` element if no terms in the list.
	 *
	 * Default false (title will always be shown).
	 *
	 * @var bool
	 */
	public bool $hide_title_if_empty;

	/**
	 * Separator between links.
	 *
	 * Default '<br />'.
	 *
	 * @var string
	 */
	public string $separator;

	/**
	 * Whether to include post counts.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $show_count;

	/**
	 * Text to display for showing all categories.
	 *
	 * Default empty string.
	 *
	 * @var string
	 */
	public string $show_option_all;

	/**
	 * Text to display for the 'no categories' option.
	 *
	 * Default 'No categories'.
	 *
	 * @var string
	 */
	public string $show_option_none;

	/**
	 * The style used to display the categories list.
	 *
	 * If 'list', categories will be output as an unordered list.
	 * If left empty or another value, categories will be output separated by `<br>` tags.
	 *
	 * Default 'list'.
	 *
	 * @phpstan-var self::STYLE_*
	 * @var string
	 */
	public string $style;

	/**
	 * Text to use for the list title `<li>` element.
	 *
	 * Pass an empty string to disable.
	 *
	 * Default 'Categories'.
	 *
	 * @var string
	 */
	public string $title_li;

	/**
	 * Whether to use the category description as the title attribute.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $use_desc_for_title;

	/**
	 * Walker object to use to build the output.
	 *
	 * Default empty which results in a `Walker_Category` instance being used.
	 *
	 * @see \Walker_Category
	 *
	 * @var \Walker
	 */
	public \Walker $walker;
}
