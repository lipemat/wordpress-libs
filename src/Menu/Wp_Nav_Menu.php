<?php
declare( strict_types=1 );

namespace Lipe\Lib\Menu;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A fluent interface for genenrating the arguments for the `wp_nav_menu` function.
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_nav_menu/
 *
 * @author Mat Lipe
 * @since  5.5.0
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class Wp_Nav_Menu implements ArgsRules {
	public const ITEM_SPACING_DISCARD  = 'discard';
	public const ITEM_SPACING_PRESERVE = 'preserve';

	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	/**
	 * Desired menu. Accepts a menu ID, slug, name, or object.
	 *
	 * Default empty.
	 *
	 * @var int|string|\WP_Term
	 */
	public int|string|\WP_Term $menu;

	/**
	 * CSS class to use for the ul element which forms the menu.
	 *
	 * Default 'menu'.
	 *
	 * @var string
	 */
	public string $menu_class;

	/**
	 * The ID that is applied to the ul element which forms the menu.
	 *
	 * Default is the menu slug, incremented.
	 *
	 * @var string
	 */
	public string $menu_id;

	/**
	 * Weither to show and which HTML element to wrap the menu with.
	 *
	 * Default 'div'.
	 *
	 * @see 'wp_nav_menu_container_allowedtags' filter.
	 *
	 * @phpstan-var 'div'|'nav'|false
	 *
	 * @var string|false
	 */
	public string|false $container;

	/**
	 * Class applied to the container.
	 *
	 * Default 'menu-{menu slug}-container'.
	 *
	 * @var string
	 */
	public string $container_class;

	/**
	 * The ID that is applied to the container.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $container_id;

	/**
	 * The aria-label attribute that is applied to the container when it's a nav element.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $container_aria_label;

	/**
	 * If the menu doesn't exist, a callback function will fire.
	 *
	 * Default is 'wp_page_menu'. Set to false for no fallback.
	 *
	 * @phpstan-var (callable(mixed[]): (string|void))|false
	 *
	 * @var callable|false
	 */
	public $fallback_cb;

	/**
	 * Text before the link markup.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $before;

	/**
	 * Text after the link markup.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $after;

	/**
	 * Text before the link text.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $link_before;

	/**
	 * Text after the link text.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $link_after;

	/**
	 * Whether to echo the menu or return it.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $echo;

	/**
	 * How many levels of the hierarchy are to be included. 0 means all.
	 *
	 * Default 0.
	 *
	 * @var int
	 */
	public int $depth;

	/**
	 * Instance of a custom walker class.
	 *
	 * Default empty.
	 *
	 * @var \Walker
	 */
	public \Walker $walker;

	/**
	 * Theme location to be used.
	 * - Must be registered with register_nav_menu() to be selectable by the user.
	 *
	 * @var string
	 */
	public string $theme_location;

	/**
	 * How the list items should be wrapped. Uses printf() format with numbered placeholders.
	 *
	 * Default `ul` with an id and class.
	 *
	 * @var string
	 */
	public string $items_wrap;

	/**
	 * Whether to preserve whitespace within the menu's HTML.
	 *
	 * - Accepts 'preserve' or 'discard'.
	 *
	 * Default 'preserve'.
	 *
	 * @phpstan-var self::ITEM_SPACING_*
	 *
	 * @var string
	 */
	public string $item_spacing;
}
