<?php
//phpcs:disable Squiz.Commenting.VariableComment.MissingVar -- Just clutters up typed code.
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type\Custom_Post_Type;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Post_Type\Capabilities;

/**
 * A fluent interface for registering a custom post type.
 *
 * @link   https://developer.wordpress.org/reference/functions/register_post_type/
 *
 * @author Mat Lipe
 * @since  5.0.0
 *
 * @phpstan-type REWRITE array{
 *     slug?: string,
 *     with_front?: bool,
 *     feeds?: bool,
 *     pages?: bool,
 *     ep_mask?: int,
 * }
 */
class Register_Post_Type implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	public const TEMPLATE_LOCK_ALL     = 'all';
	public const TEMPLATE_LOCK_CONTENT = 'contentOnly';
	public const TEMPLATE_LOCK_INSERT  = 'insert';
	public const TEMPLATE_LOCK_FALSE   = false;

	public const SUPPORTS_AUTHOR          = 'author';
	public const SUPPORTS_AUTOSAVE        = 'autosave';
	public const SUPPORTS_COMMENTS        = 'comments';
	public const SUPPORTS_CUSTOM_FIELDS   = 'custom-fields';
	public const SUPPORTS_EDITOR          = 'editor';
	public const SUPPORTS_EXCERPT         = 'excerpt';
	public const SUPPORTS_PAGE_ATTRIBUTES = 'page-attributes';
	public const SUPPORTS_POST_FORMATS    = 'post-formats';
	public const SUPPORTS_REVISIONS       = 'revisions';
	public const SUPPORTS_THUMBNAIL       = 'thumbnail';
	public const SUPPORTS_TITLE           = 'title';
	public const SUPPORTS_TRACKBACKS      = 'trackbacks';

	/**
	 * Name of the post type shown in the menu. Usually plural.
	 *
	 * Default is value of `$labels['name']`.
	 */
	public string $label;

	/**
	 * An array of labels for this post type.
	 *
	 * If not set, post labels are inherited for non-hierarchical types and page labels for hierarchical ones.
	 *
	 * See `get_post_type_labels()` for a full list of supported labels.
	 *
	 * @var array<string,string>
	 */
	public array $labels;

	/**
	 * A short descriptive summary of what the post type is.
	 *
	 * Default empty.
	 */
	public string $description;

	/**
	 * Whether a post type is intended for use publicly either via the admin interface or by front-end users.
	 *
	 * While the default settings of `$exclude_from_search`, `$publicly_queryable`, `$show_ui`, and `$show_in_nav_menus`
	 * are inherited from `$public`, each does not rely on this relationship and controls a very specific intention.
	 *
	 * Default false.
	 */
	public bool $public;

	/**
	 * Whether the post type is hierarchical (e.g., page).
	 *
	 * Default false.
	 */
	public bool $hierarchical;

	/**
	 * Whether to exclude posts with this post type from front end search results.
	 *
	 * Default is the opposite value of `$public`.
	 */
	public bool $exclude_from_search;

	/**
	 * Whether queries can be performed on the front end for the post type as part of `parse_request()`.
	 *
	 * Endpoints would include:
	 *
	 *   - `?post_type={post_type_key}`
	 *   - `?{post_type_key}={single_post_slug}`
	 *   - `?{post_type_query_var}={single_post_slug}`
	 *
	 * If not set, the default is inherited from `$public`.
	 */
	public bool $publicly_queryable;

	/**
	 * Whether to generate and allow a UI for managing this post type in the admin.
	 *
	 * Default is value of `$public`.
	 */
	public bool $show_ui;

	/**
	 * Where to show the post type in the admin menu. To work, `$show_ui` must be true.
	 *
	 *   - If true the post type is shown in its own top level menu.
	 *   - If false, no menu is shown.
	 *   - If a string of an existing top level menu (eg. 'tools.php' or 'edit.php?post_type=page'), the post type will be placed as a
	 *   sub-menu of that.
	 *
	 * Default is value of `$show_ui`.
	 *
	 * @var bool|string
	 */
	public string|bool $show_in_menu;

	/**
	 * Makes this post type available for selection in navigation menus.
	 *
	 * Default is value of `$public`.
	 */
	public bool $show_in_nav_menus;

	/**
	 * Makes this post type available via the admin bar.
	 *
	 * Default is value of `$show_in_menu`.
	 */
	public bool $show_in_admin_bar;

	/**
	 * Whether to include the post type in the REST API.
	 *
	 * Set this to true for the post type to be available in the block editor.
	 */
	public bool $show_in_rest;

	/**
	 * To change the base URL of REST API route.
	 *
	 * Default is `$post_type`.
	 */
	public string $rest_base;

	/**
	 * To change the namespace URL of REST API route.
	 *
	 * Default is wp/v2.
	 */
	public string $rest_namespace;

	/**
	 * REST API controller class name.
	 *
	 * Default is 'WP_REST_Posts_Controller'.
	 *
	 * @phpstan-var class-string<\WP_REST_Controller>
	 */
	public string $rest_controller_class;

	/**
	 * REST API autosave controller class name.
	 *
	 * Default is 'WP_REST_Autosaves_Controller'.
	 *
	 * @phpstan-var class-string<\WP_REST_Controller>
	 */
	public string $autosave_rest_controller_class;

	/**
	 * REST API revisions controller class name.
	 *
	 * Default is 'WP_REST_Revisions_Controller'.
	 *
	 * @phpstan-var class-string<\WP_REST_Controller>
	 */
	public string $revisions_rest_controller_class;

	/**
	 * A flag to direct the REST API controllers for an autosave / revisions should be registered before/after the post type controller.
	 */
	public bool $late_route_registration;

	/**
	 * The position in the menu order the post type should appear. To work, `$show_in_menu` must be true.
	 *
	 * Default null (at the bottom).
	 */
	public int $menu_position;

	/**
	 * The URL to the icon to be used for this menu.
	 *
	 *   - Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme -- this should begin with
	 *   `data:image/svg+xml;base64,`.
	 *   - Pass the name of a Dashicons helper class to use a font icon, e.g. `dashicons-chart-pie`.
	 *   - Pass `'none'` to leave `div.wp-menu-image` empty, so an icon can be added via CSS.
	 *
	 * Defaults to use the posts icon.
	 */
	public string $menu_icon;

	/**
	 * The strings to use to build the read, edit, and delete capabilities.
	 *
	 * Passed as an array to allow for alternative plurals when using this argument as a base to build the capabilities, e.g.,
	 * array('story', 'stories').
	 *
	 * Default ['post', 'posts'].
	 *
	 * @var array<int,string>|string
	 * @phpstan-var string|array{
	 *     0: string,
	 *     1: string,
	 * }
	 */
	public string|array $capability_type;

	/**
	 * Array of capabilities for this post type.
	 *
	 * `$capability_type` is used as a base to build capabilities by default. See `get_post_type_capabilities()`.
	 *
	 * @var array<string,string>
	 * @phpstan-var array<Capabilities::*, string>
	 */
	public array $capabilities;

	/**
	 * Whether to use the internal default meta capability handling.
	 *
	 * Default false.
	 */
	public bool $map_meta_cap;

	/**
	 * Core feature(s) the post type supports. Serves as an alias for calling `add_post_type_support()` directly.
	 *
	 * Core features include:
	 *
	 *   - 'title'
	 *   - 'editor'
	 *   - 'comments'
	 *   - 'revisions'
	 *   - 'trackbacks'
	 *   - 'author'
	 *   - 'excerpt'
	 *   - 'page-attributes'
	 *   - 'thumbnail'
	 *   - 'custom-fields'
	 *   - 'post-formats'
	 *
	 * Additionally, the 'revisions' feature dictates whether the post type will store revisions, and the 'comments'
	 * feature dictates whether the comments count will show on the edit screen. A feature can also be specified as
	 * an array of arguments to provide additional information about supporting feature. Example:
	 *
	 *     array('my_feature', array('field' => 'value'))
	 *
	 * Default is an array containing 'title' and 'editor'.
	 *
	 * @var array<int, (string|array<string, mixed>)>
	 */
	public array $supports;

	/**
	 * Provide a callback function that sets up the meta boxes for the edit form.
	 *
	 * Do `remove_meta_box()` and `add_meta_box()` calls in the callback.
	 *
	 * Default null.
	 *
	 * @var callable
	 * @phpstan-var callable(\WP_Post): void
	 */
	public $register_meta_box_cb;

	/**
	 * An array of taxonomy identifiers that will be registered for the post type.
	 *
	 * Taxonomies can be registered later with `register_taxonomy()` or `register_taxonomy_for_object_type()`.
	 *
	 * Default empty array.
	 *
	 * @var array<int,string>
	 */
	public array $taxonomies;

	/**
	 * Whether there should be post type archives, or if a string, the archive slug to use.
	 *
	 * Will generate the proper rewrite rules if `$rewrite` is enabled.
	 *
	 * Default false.
	 *
	 * @var bool|string
	 */
	public string|bool $has_archive;

	/**
	 * Triggers the handling of rewrites for this post type.
	 *
	 * To prevent a rewrite, set to false.
	 *
	 * Defaults to true, using `$post_type` as slug. To specify rewrite rules,
	 * an array can be passed.
	 *
	 * @var bool|array<string,mixed>
	 * @phpstan-var bool|REWRITE
	 */
	public array|bool $rewrite;

	/**
	 * Sets the query_var key for this post type.
	 *
	 * Defaults to `$post_type` key.
	 *
	 *   - If false, a post type cannot be loaded at `?{query_var}={post_slug}`.
	 *   - If specified as a string, the query `?{query_var_string}={post_slug}` will be valid.
	 *
	 * @var string|bool
	 */
	public string|bool $query_var;

	/**
	 * Whether to allow this post type to be exported.
	 *
	 * Default true.
	 */
	public bool $can_export;

	/**
	 * Whether to delete posts of this type when deleting a user.
	 *
	 *   - If true, posts of this type belonging to the user will be moved to Trash when the user is deleted.
	 *   - If false, posts of this type belonging to the user will *not* be trashed or deleted.
	 *   - If not set (the default), posts are trashed if post type supports the 'author' feature. Otherwise, posts are not trashed or
	 *   deleted.
	 *
	 * Default null.
	 */
	public bool $delete_with_user;

	/**
	 * Array of blocks to use as the default initial state for an editor session.
	 *
	 * Each item should be an array containing block name and optional attributes.
	 *
	 * Default empty array.
	 *
	 * @var array<int, array<int, string|array<string, mixed>>>
	 */
	public array $template;

	/**
	 * Whether the block template should be locked if `$template` is set.
	 *
	 *   - If set to 'all', the user cannot insert new blocks, move existing blocks and delete blocks.
	 *   - If set to 'insert', the user can move existing blocks but cannot insert new blocks and delete blocks
	 *
	 * Default false.
	 *
	 * @var string|false
	 * @phpstan-var self::TEMPLATE_LOCK_*
	 */
	public string|false $template_lock;
}
