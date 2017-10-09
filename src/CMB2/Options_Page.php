<?php

namespace Lipe\Lib\CMB2;

/**
 * Options_Page
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @package Lipe\Lib\CMB2
 */
class Options_Page extends Box {

	/**
	 * This parameter is for options-page metaboxes only and defaults to 'admin_menu',
	 * to register your options-page at the network level:
	 *
	 * Example 'network_admin_menu'
	 *
	 * @var string
	 */
	public $admin_menu_hook = 'admin_menu';

	/**
	 * This parameter is for options-page metaboxes only,
	 * and is sent along to add_menu_page()/add_submenu_page()
	 * to define the capability required to view the options page.
	 *
	 * Example 'edit_posts'
	 *
	 * @var string
	 */
	public $capability = 'manage_options';

	/**
	 * This parameter is for options-page metaboxes only
	 * and allows overriding the options page form output.
	 *
	 * Example 'my_callback_function_to_display_output'
	 *
	 * @var callable
	 */
	public $display_cb = false;

	/**
	 * This parameter is for options-page metaboxes only,
	 * and is sent along to add_menu_page() to define the menu icon.
	 * Only applicable if parent_slug is left empty.
     * 
	 * Example 'dashicons-chart-pie'
	 *
	 * @var string
	 */
	public $icon_url;

	/**
	 * This parameter is for options-page metaboxes only,
	 * and is sent along to add_menu_page()/add_submenu_page() to define the menu title.
	 *
	 * Example 'Site Options
	 *
	 * @var string
	 */
	public $menu_title;

	/**
     * @deprecated in favor of $this->admin_menu_hook
     *
     * @see Options_Page::admin_menu_hook
	 *
	 */
	public $network;

	/**
	 * This parameter is for options-page metaboxes only,
	 * and is sent along to add_submenu_page() to define the parent-menu item slug.
	 *
	 * Example 'tools.php'
	 *
	 * @var string
	 */
	public $parent_slug;

	/**
	 * This parameter is for options-page metaboxes only,
	 * and is sent along to add_menu_page() to define the menu position.
	 * Only applicable if parent_slug is left empty.
	 *
	 * Example 6
	 *
	 * @var int
	 */
	public $position;

	/**
	 * This parameter is for options-page metaboxes only and
	 * defines the text for the options page save button. defaults to 'Save'.
	 *
	 * Example 'Save Settings'
	 *
	 * @var string
	 */
	public $save_button;

	/**
	 * This parameter is for options-page metaboxes only and
	 * defines the settings page slug. Defaults to $id.
     *
     * Example 'my_options_page_slug'
	 *
	 * @var string
	 */
	public $option_key;


	/**
	 * Options Page constructor.
	 *
	 * @param  string $id
	 * @param  string $title
	 */
	public function __construct( $id, $title ) {
		if( null === $this->option_key ){
		    $this->option_key = $id;
		}
		parent::__construct( $id, [ 'options-page' ], $title );
	}
}