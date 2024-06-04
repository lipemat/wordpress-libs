<?php
declare( strict_types=1 );

namespace Lipe\Lib\Settings\Settings_Page;

use Lipe\Lib\Settings\Settings_Page;

/**
 * Rules for registering a Settings Page
 *
 * @link   https://developer.wordpress.org/reference/functions/add_menu_page/
 * @link   https://developer.wordpress.org/reference/functions/add_submenu_page/
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @see    Settings_Page
 */
interface Settings {

	/**
	 * Get a unique id for the settings page.
	 *
	 * Commonly `self::NAME` or `__CLASS__`.
	 *
	 * @return string
	 */
	public function get_id(): string;


	/**
	 * Get the title of this settings page.
	 *
	 * @return string
	 */
	public function get_title(): string;


	/**
	 * Get the sections for this settings page.
	 *
	 * @return Section[]
	 */
	public function get_sections(): array;


	/**
	 * Is this a network settings page?
	 *
	 * @return bool
	 */
	public function is_network(): bool;


	/**
	 * Parent menu to display the settings page under.
	 *
	 * - null: Top level menu item.
	 *
	 * @example - 'options-general.php': Under the settings menu.
	 *          - 'settings.php': Under the settings menu in the network admin.
	 *
	 * @return ?string
	 */
	public function get_parent_menu_slug(): ?string;


	/**
	 * Optional description for this settings page displayed
	 * under the title.
	 *
	 * @return string
	 */
	public function get_description(): string;


	/**
	 * Required user capability to view this page.
	 *
	 * @example - 'manage_options': Administrator
	 *          - 'edit_posts': Editor
	 *
	 * @return string
	 */
	public function get_capability(): string;


	/**
	 * Get the icon for the settings page.
	 *
	 * - Dashicons: https://developer.wordpress.org/resource/dashicons/
	 * - Custom SVG: Use the SVG markup for the icon.
	 * - '' (empty string): No icon.
	 * - 'none': empty icon for styling with CSS.
	 *
	 * @return string
	 */
	public function get_icon(): string;


	/**
	 * Get the position of the menu item.
	 *
	 * @see  Settings_Page::POSITION_* for common positions.
	 *
	 * See the WordPress documentation for more default positions.
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_menu_page/#menu-structure
	 *
	 * @return int
	 */
	public function get_position(): int;
}
