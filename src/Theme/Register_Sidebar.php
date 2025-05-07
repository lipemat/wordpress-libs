<?php
declare( strict_types=1 );

namespace Lipe\Lib\Theme;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A fluent interface for calling `register_sidebar()`.
 *
 * @author Mat Lipe
 * @since  5.5.0
 *
 * @phpstan-type SidebarArgs array{
 *     name: string,
 *     id: string,
 *     description: string,
 *     class: string,
 *     before_widget: string,
 *     after_widget: string,
 *     before_title: string,
 *     after_title: string,
 *     before_sidebar: string,
 *     after_sidebar: string,
 *     show_in_rest: bool,
 * }
 *
 * @implements ArgsRules<\Partial<SidebarArgs>>
 */
class Register_Sidebar implements ArgsRules {
	/**
	 * @use Args<\Partial<SidebarArgs>>
	 */
	use Args;

	/**
	 * The name of the sidebar.
	 * Default 'Sidebar $instance'.
	 *
	 * @var string
	 */
	public string $name;

	/**
	 * The ID of the sidebar.
	 * Default 'sidebar-$instance'.
	 *
	 * @var string
	 */
	public string $id;

	/**
	 * The description of the sidebar, displayed in the Widgets inteface.
	 *
	 * @var string
	 */
	public string $description;

	/**
	 * Extra CSS class to assign to the sidebar in the Widgets interface.
	 *
	 * @var string
	 */
	public string $class;

	/**
	 * HTML content to prepend to each widget's HTML output when assigned
	 * to this sidebar.
	 * Receives the widget's ID attribute as `%1$s`
	 * and class name as `%2$s`.
	 *
	 * Default is an opening list item element.
	 *
	 * @var string
	 */
	public string $before_widget;

	/**
	 * HTML content to append to each widget's HTML output when assigned
	 * to this sidebar.
	 *
	 * Default is a closing list item element.
	 *
	 * @var string
	 */
	public string $after_widget;

	/**
	 * HTML content to prepend to the sidebar title when displayed.
	 *
	 * Default is an opening h2 element.
	 *
	 * @var string
	 */
	public string $before_title;

	/**
	 * HTML content to append to the sidebar title when displayed.
	 *
	 * Default is a closing h2 element.
	 *
	 * @var string
	 */
	public string $after_title;

	/**
	 * HTML content to prepend to the sidebar when displayed.
	 * Receives the `$id` argument as `%1$s` and `$class` as `%2$s`.
	 * Outputs after the {@see 'dynamic_sidebar_before'} action.
	 *
	 * Default empty string.
	 *
	 * @var string
	 */
	public string $before_sidebar;

	/**
	 * HTML content to append to the sidebar when displayed.
	 * Outputs before the {@see 'dynamic_sidebar_after'} action.
	 *
	 * Default empty string.
	 *
	 * @var string
	 */
	public string $after_sidebar;

	/**
	 * Whether to show this sidebar publicly in the REST API.
	 *
	 * Defaults to only showing the sidebar to administrator users.
	 *
	 * @var bool
	 */
	public bool $show_in_rest;
}
