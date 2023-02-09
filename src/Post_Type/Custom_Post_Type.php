<?php

declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Util\Actions;

/**
 * Register a custom post type.
 *
 */
class Custom_Post_Type {
	protected const REGISTRY_OPTION    = 'lipe/lib/post-type/custom-post-type/registry';
	protected const CUSTOM_CAPS_OPTION = 'lipe/lib/post-type/custom-post-type/caps';

	/**
	 * Tf true, will auto add custom capability type caps to administrator
	 * Defaults to true
	 *
	 * @var bool
	 */
	public bool $auto_admin_caps = true;

	/**
	 * Label used when retrieving the post type archive title
	 *
	 * @var string
	 */
	public string $archive_label = '';

	/**
	 * A short descriptive summary of what the post type is.
	 *
	 * Default empty.
	 *
	 * @var string
	 */
	public string $description;

	/**
	 * Whether the post type is hierarchical (e.g. page).
	 *
	 * @var bool
	 */
	public bool $hierarchical = false;

	/**
	 * The strings to use to build the read, edit, and delete capabilities.
	 *
	 * Passed as an array to allow for alternative plurals when using this argument
	 * as a base to build the capabilities.
	 * - e.g. array('story', 'stories').
	 *
	 * @phpstan-var array{
	 *     0: string,
	 *     1: string,
	 * }
	 *
	 * @var array<int,string>
	 */
	public array $capability_type = [ 'post', 'posts' ];

	/**
	 * Array of capabilities for this post type.
	 *
	 * `$capability_type` is used as a base to build capabilities by default.
	 *
	 * @see `get_post_type_capabilities()`.
	 *
	 * @phpstan-var array{
	 *     edit_post?: string,
	 *     read_post?: string,
	 *     delete_post?: string,
	 *     edit_posts?: string,
	 *     edit_others_posts?: string,
	 *     delete_posts?: string,
	 *     publish_posts?: string,
	 *     read_private_posts?: string,
	 *     read?: string,
	 *     delete_private_posts?: string,
	 *     delete_published_posts?: string,
	 *     delete_others_posts?: string,
	 *     edit_private_posts?: string,
	 *     edit_published_posts?: string,
	 *     create_posts?: string,
	 * }
	 *
	 * @link   https://developer.wordpress.org/reference/functions/register_post_type/#capabilities
	 *
	 * @notice if you set only some of these you probably want to
	 *         set $this->map_meta_cap = true
	 *
	 * @var array<string,string>
	 */
	public array $capabilities = [];

	/**
	 * Core feature(s) the post type supports.
	 *
	 * Serves as an alias for calling `add_post_type_support()` directly.
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
	 * The 'revisions' feature dictates whether the post type will store revisions.
	 * The 'comments' feature dictates whether the comments count will show on the edit screen.
	 *
	 * A feature can also be specified as an array of arguments to provide additional
	 * information about supporting the feature.
	 * Example:
	 *     array( 'my_feature', array( 'field' => 'value' ) )
	 *
	 * @var array<int, (string|array<string, mixed>)>
	 */
	public array $supports = [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ];

	/**
	 * Whether to delete posts of this type when deleting a user.
	 *   - If true, posts of this type belonging to the user will be moved to Trash
	 *     when the user is deleted.
	 *   - If false, posts of this type belonging to the user will *not* be
	 *     trashed or deleted.
	 *   - If not set (the default), posts are trashed if post type supports
	 *     the 'author' feature. Otherwise, posts are not trashed or deleted.
	 *
	 * @var bool
	 */
	public bool $delete_with_user;

	/**
	 * Provide a callback function that will be called when setting
	 * up the meta boxes for the edit form.
	 *
	 * The callback function takes one argument $post,
	 * which contains the WP_Post object for the currently edited post
	 *
	 * @phpstan-var callable(\WP_Post): void
	 *
	 * @default none
	 *
	 * @var callable
	 */
	public $register_meta_box_cb;

	/**
	 * Set too false to disable gutenberg block editor for this post type.
	 * Set to true to enable gutenberg block editor for
	 * this post type.
	 *
	 * If set to true, this will also enable
	 * 1. editor support
	 * 2. Rest API support
	 *
	 * @var bool
	 */
	public bool $gutenberg_compatible;

	/**
	 * Whether to use the internal default meta capability handling.
	 *
	 * @var bool
	 */
	public bool $map_meta_cap = false;

	/**
	 * Label used in the menu.
	 *
	 * @var string
	 */
	public string $menu_name = '';

	/**
	 * The URL to the icon to be used for this menu.
	 *
	 *   - Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme -- this should
	 * begin with `data:image/svg+xml;base64,`.
	 *   - Pass the name of a Dashicons helper class to use a font icon, e.g. `dashicons-chart-pie`.
	 *   - Pass `'none'` to leave `div.wp-menu-image` empty so an icon can be added via CSS.
	 *
	 * Defaults to use the posts icon.
	 *
	 * @var string
	 */
	public string $menu_icon;

	/**
	 * The position in the menu order the post type should appear.
	 *
	 * To work, `$show_in_menu` must be true.
	 *
	 * @var int
	 */
	public int $menu_position = 5;

	/**
	 * Whether a post type is intended for use publicly either via the admin interface or by front-end users.
	 *
	 * While the default settings of `$exclude_from_search`, `$publicly_queryable`, `$show_ui`, and `$show_in_nav_menus`
	 * are inherited from `$public`, each does not rely on this relationship and controls a very specific intention.
	 *
	 * @var bool
	 */
	public bool $public = true;

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
	 *
	 * @var bool
	 */
	public bool $publicly_queryable;

	/**
	 * Whether to exclude posts with this post type from front end search results.
	 *
	 * Default is the opposite value of `$public`.
	 *
	 * @var bool
	 */
	public bool $exclude_from_search;

	/**
	 * Enables post type archives.
	 *
	 * Will use post type slug if set to true, otherwise
	 * will use provided string.
	 *
	 * @link https://developer.wordpress.org/reference/functions/register_post_type/#has_archive
	 *
	 * @var bool|string
	 */
	public $has_archive = true;

	/**
	 * @var string
	 */
	public string $slug = '';

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
	public $query_var = true;

	/**
	 * Whether to generate and allow a UI for managing this post type in the admin.
	 *
	 * Default is value of `$public`.
	 *
	 * @var bool
	 */
	public bool $show_ui;

	/**
	 * Where to show the post type in the admin menu. To work, `$show_ui` must be true.
	 *
	 *   - If true the post type is shown in its own top level menu.
	 *   - If false, no menu is shown.
	 *   - If a string of an existing top level menu (eg. 'tools.php' or 'edit.php?post_type=page'), the post type will
	 * be placed as a sub-menu of that.
	 *
	 * Default is value of `$show_ui`.
	 *
	 * @var bool
	 */
	public bool $show_in_menu;

	/**
	 * Makes this post type available for selection in navigation menus.
	 *
	 * Default is value of `$public`.
	 *
	 * @var bool
	 */
	public bool $show_in_nav_menus;

	/**
	 * Makes this post type available via the admin bar.
	 *
	 * Default is value of `$show_in_menu`.
	 *
	 * @var bool
	 */
	public bool $show_in_admin_bar;

	/**
	 * Whether to include the post type in the REST API.
	 *
	 * @notice Must be set to true to support Gutenberg
	 *
	 * @link   https://make.wordpress.org/core/2018/10/30/block-editor-filters/
	 *
	 * @var bool
	 */
	public bool $show_in_rest = false;

	/**
	 * The base slug that this post type will use when accessed using the REST API.
	 *
	 * @default $this->post_type
	 *
	 * @var string
	 */
	public string $rest_base;

	/**
	 * To change the namespace URL of REST API route.
	 *
	 * Default is wp/v2.
	 *
	 * @var string
	 */
	public string $rest_namespace;

	/**
	 * REST API controller class name.
	 *
	 * Default is 'WP_REST_Posts_Controller'.
	 *
	 * @phpstan-var class-string<\WP_REST_Controller>
	 *
	 * @var string
	 */
	public string $rest_controller_class;

	/**
	 * Triggers the handling of rewrites for this post type.
	 *
	 * To prevent all rewrite, set to false.
	 *
	 * Defaults to true, using `$post_type` as slug. To specify rewrite rules,
	 * an array can be passed.
	 *
	 * @phpstan-var null|bool|array{
	 *     slug?: string,
	 *     with_front?: bool,
	 *     feeds?: bool,
	 *     pages?: bool,
	 *     ep_mask?: int,
	 * }
	 *
	 * @var bool|array<string,mixed>
	 */
	public $rewrite;

	/**
	 * Whether to allow this post type to be exported.
	 *
	 * @var bool
	 */
	public bool $can_export = true;

	/**
	 * An array of taxonomy identifiers that will be registered for the post type.
	 *
	 * Taxonomies can be registered later with `register_taxonomy()` or
	 * `register_taxonomy_for_object_type()`.
	 *
	 * Default empty array.
	 *
	 * @var array<int,string>
	 */
	public array $taxonomies = [];

	/**
	 * @var array
	 */
	public array $labels;

	/**
	 * The post type slug.
	 *
	 * @var string
	 */
	protected string $post_type = '';

	/**
	 * Track the register post types for later use.
	 *
	 * @var array
	 */
	protected static array $registry = [];

	/**
	 * A singular label for this post type.
	 *
	 * @var string
	 */
	protected string $post_type_label_singular = '';

	/**
	 * A plural label for this post type.
	 *
	 * @var string
	 */
	protected string $post_type_label_plural = '';

	/**
	 * Gutenberg Template for this post type.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-templates/#custom-post-types
	 *
	 * @var array<int, array<int, string|array<string, mixed>>>
	 */
	protected array $template;

	/**
	 * Locking of the Gutenberg template.
	 *   - If set to 'all', the user cannot insert new blocks,
	 *     move existing blocks and delete blocks.
	 *   - If set to 'insert', the user can move existing blocks
	 *     but cannot insert new blocks and delete blocks
	 *
	 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-templates/#locking
	 *
	 *
	 * @phpstan-var 'all'|'contentOnly'|'insert'|false
	 *
	 * @var string|false
	 */
	protected $template_lock;


	/**
	 * Takes care of the necessary hook and registering.
	 *
	 * @param string $post_type
	 */
	final public function __construct( string $post_type ) {
		$this->post_type = $post_type;
		$this->hook();
	}


	/**
	 * Hook the post_type into WordPress
	 *
	 * @return void
	 */
	public function hook() : void {
		// allow methods added to the init hook to customize the post type.
		add_action( 'wp_loaded', [ $this, 'register' ], 8, 0 );

		add_filter( 'adjust_post_updated_messages', [ $this, 'adjust_post_updated_messages' ] );
		add_filter( 'post_type_archive_title', [ $this, 'get_post_type_archive_label' ] );
		add_filter( 'bulk_post_updated_messages', [ $this, 'adjust_bulk_edit_messages' ], 10, 2 );

		if ( is_admin() ) { // In case there are posts types not registered on front end.
			Actions::in()->add_single_action( 'wp_loaded', [ __CLASS__, 'check_rewrite_rules' ], 1000 );
		}
	}


	/**
	 * If the post types registered through this API have changed,
	 * rewrite rules need to be flushed.
	 *
	 * @static
	 *
	 * @return void
	 *
	 */
	public static function check_rewrite_rules() : void {
		$slugs = wp_list_pluck( static::$registry, 'slug' );
		if ( get_option( static::REGISTRY_OPTION ) !== $slugs ) {
			\flush_rewrite_rules();
			update_option( static::REGISTRY_OPTION, $slugs );
		}
	}


	/**
	 * Handles any calls which need to run to register this post type
	 *
	 * @return void
	 */
	public function register() : void {
		$this->handle_block_editor_support();
		$this->register_post_type();
		static::$registry[ $this->post_type ] = $this;
		$this->add_administrator_capabilities( get_post_type_object( $this->post_type ) );
	}


	/**
	 * Register this post type with WordPress
	 *
	 * Allow using a different process for registering post types via
	 * child classes.
	 *
	 */
	protected function register_post_type() : void {
		\register_post_type( $this->post_type, $this->post_type_args() );
	}


	/**
	 * Turn on and off Gutenberg block editor support based on
	 * WP core requirements and $this->gutenberg_compatible
	 *
	 * 1. There is a filter to disable block editor support
	 * 2. To enable block editor, we need to have show_in_rest set to true
	 * 3. To enable block editor, we need to have editor support.
	 *
	 * @return void
	 */
	protected function handle_block_editor_support() : void {
		if ( false === $this->gutenberg_compatible ) {
			add_filter( 'use_block_editor_for_post_type', function( $enabled, $post_type ) {
				if ( $post_type === $this->post_type ) {
					return false;
				}

				return $enabled;
			}, 10, 2 );
		} elseif ( true === $this->gutenberg_compatible ) {
			$this->show_in_rest = true;
			$this->supports[] = 'editor';
		}
	}


	/**
	 * Build the args array for the post type definition.
	 *
	 * @return array
	 */
	protected function post_type_args() : array {
		$args = [
			'labels'                => $this->post_type_labels(),
			'description'           => $this->description ?? '',
			'public'                => $this->public,
			'exclude_from_search'   => $this->exclude_from_search ?? null,
			'publicly_queryable'    => $this->publicly_queryable ?? null,
			'show_ui'               => $this->show_ui ?? null,
			'show_in_nav_menus'     => $this->show_in_nav_menus ?? null,
			'show_in_menu'          => $this->show_in_menu ?? null,
			'show_in_admin_bar'     => $this->show_in_admin_bar ?? null,
			'menu_position'         => $this->menu_position,
			'menu_icon'             => $this->menu_icon ?? null,
			'capability_type'       => $this->capability_type,
			'capabilities'          => $this->capabilities,
			'map_meta_cap'          => $this->map_meta_cap,
			'hierarchical'          => $this->hierarchical,
			'supports'              => $this->supports,
			'register_meta_box_cb'  => $this->register_meta_box_cb,
			'taxonomies'            => $this->taxonomies,
			'has_archive'           => $this->has_archive,
			'rewrite'               => $this->rewrites(),
			'query_var'             => $this->query_var,
			'can_export'            => $this->can_export,
			'delete_with_user'      => $this->delete_with_user ?? null,
			'show_in_rest'          => $this->show_in_rest,
			'rest_base'             => $this->rest_base ?? null,
			'rest_namespace'        => $this->rest_namespace ?? null,
			'rest_controller_class' => $this->rest_controller_class ?? null,
			'template'              => $this->template ?? null,
			'template_lock'         => $this->template_lock,
		];

		$args = apply_filters( 'lipe/lib/schema/post_type_args', $args, $this->post_type );
		return apply_filters( "lipe/lib/schema/post_type_args_{$this->post_type}", $args );
	}


	/**
	 * Build the labels array for the post type definition.
	 *
	 * @param string|null $single
	 * @param string|null $plural
	 *
	 * @return array
	 */
	protected function post_type_labels( string $single = null, string $plural = null ) : array {
		$single = $single ?? $this->get_post_type_label();
		$plural = $plural ?? $this->get_post_type_label( 'plural' );

		// phpcs:disable WordPress.WP.I18n
		$labels = [
			'name'                     => $plural,
			'singular_name'            => $single,
			'add_new'                  => __( 'Add New' ),
			'add_new_item'             => sprintf( __( 'Add New %s' ), $single ),
			'edit_item'                => sprintf( __( 'Edit %s' ), $single ),
			'new_item'                 => sprintf( __( 'New %s' ), $single ),
			'view_item'                => sprintf( __( 'View %s' ), $single ),
			'view_items'               => sprintf( __( 'View %s' ), $plural ),
			'search_items'             => sprintf( __( 'Search %s' ), $plural ),
			'not_found'                => sprintf( __( 'No %s Found' ), $plural ),
			'not_found_in_trash'       => sprintf( __( 'No %s Found in Trash' ), $plural ),
			'parent_item_colon'        => sprintf( __( 'Parent %s:' ), $single ),
			'all_items'                => sprintf( __( 'All %s' ), $plural ),
			'archives'                 => sprintf( __( '%s Archives' ), $single ),
			'attributes'               => sprintf( __( '%s Attributes' ), $single ),
			'insert_into_item'         => sprintf( __( 'Insert into %s' ), $single ),
			'uploaded_to_this_item'    => sprintf( __( 'Uploaded to this %s' ), $single ),
			'featured_image'           => __( 'Featured Image' ),
			'set_featured_image'       => __( 'Set featured image' ),
			'remove_featured_image'    => __( 'Remove featured image' ),
			'use_featured_image'       => __( 'Use as featured image' ),
			'filter_items_list'        => sprintf( __( 'Filter %s list' ), $plural ),
			'items_list_navigation'    => sprintf( __( '%s list navigation' ), $plural ),
			'items_list'               => sprintf( __( '%s list' ), $plural ),
			'item_published'           => sprintf( __( '%s published.' ), $single ),
			'item_published_privately' => sprintf( __( '%s published privately.' ), $single ),
			'item_reverted_to_draft'   => sprintf( __( '%s reverted to draft.' ), $single ),
			'item_scheduled'           => sprintf( __( '%s scheduled.' ), $single ),
			'item_updated'             => sprintf( __( '%s updated.' ), $single ),
			'menu_name'                => empty( $this->menu_name ) ? $plural : $this->menu_name,
		];
		// phpcs:enable WordPress.WP.I18n

		if ( ! empty( $this->labels ) ) {
			$labels = wp_parse_args( $this->labels, $labels );
		}

		$labels = apply_filters( 'lipe/lib/post-type/labels', $labels, $this->post_type );
		return apply_filters( "lipe/lib/post-type/labels_{$this->post_type}", $labels );
	}


	/**
	 * Get the post type's label.
	 *
	 * @param string $quantity - (singular,plural).
	 *
	 * @return string
	 */
	public function get_post_type_label( string $quantity = 'singular' ) : string {
		if ( 'plural' === $quantity ) {
			if ( empty( $this->post_type_label_plural ) ) {
				$this->set_post_type_label( $this->post_type_label_singular );
			}

			return $this->post_type_label_plural;
		}
		if ( empty( $this->post_type_label_singular ) ) {
			$this->set_post_type_label( $this->post_type_label_singular, $this->post_type_label_plural );
		}

		return $this->post_type_label_singular;
	}


	/**
	 * Text, which replaces the 'Featured Image' phrase for this post type
	 *
	 * @notice Replaces the `featured_image` property for extended-cpts, which does
	 *         not work with our current structure.
	 *
	 * @param string $label - Text to use.
	 *
	 */
	public function set_featured_image_labels( string $label ) : void {
		$lowercase = strtolower( $label );

		$this->labels = wp_parse_args( $this->labels, [
			'featured_image'        => $label,
			'set_featured_image'    => sprintf( 'Set %s', $lowercase ),
			'remove_featured_image' => sprintf( 'Remove %s', $lowercase ),
			'use_featured_image'    => sprintf( 'Use as %s', $lowercase ),
		] );
	}


	/**
	 * Set the labels for the post type.
	 *
	 * @param string $singular
	 * @param string $plural
	 *
	 * @return void
	 */
	public function set_post_type_label( string $singular = '', string $plural = '' ) : void {
		if ( ! $singular ) {
			$singular = str_replace( '_', ' ', $this->post_type );
			$singular = ucwords( $singular );
		}

		if ( ! $plural ) {
			$end = substr( $singular, - 1 );
			if ( 's' === $end ) {
				$plural = ucwords( $singular . 'es' );
			} elseif ( 'y' === $end ) {
				$plural = ucwords( rtrim( $singular, 'y' ) . 'ies' );
			} else {
				$plural = ucwords( $singular . 's' );
			}
		}
		$this->post_type_label_singular = $singular;
		$this->post_type_label_plural = $plural;
	}


	/**
	 * Rewrites configuration.
	 *
	 * Set to `false` to disable rewrites.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/register_post_type/#rewrite
	 *
	 * Build the rewrites param. Will send defaults if not set/
	 *
	 * @notice  The `ep_mask` parameter is mostly ignored and most likely
	 *          never needed to change.
	 *
	 * @return array|boolean
	 */
	protected function rewrites() {
		return $this->rewrite ?? [
			'slug'       => $this->get_slug(),
			'with_front' => false,
		];
	}


	/**
	 * Return the slug of this post type, formatted appropriately
	 *
	 * @return string
	 */
	public function get_slug() : string {
		if ( empty( $this->slug ) ) {
			$this->slug = strtolower( str_replace( ' ', '-', $this->post_type ) );
		}

		return $this->slug;
	}


	/**
	 * If the capability_type is not post it has custom capabilities
	 * We need to add these to the administrators of the site
	 *
	 * This gets called during $this->register_post_type()
	 *
	 * Checks to make sure we have not done this already
	 *
	 * @param \WP_Post_Type|null $post_type
	 *
	 * @return void
	 */
	protected function add_administrator_capabilities( ?\WP_Post_Type $post_type ) : void {
		if ( ! $this->auto_admin_caps || null === $post_type || 'post' === $post_type->capability_type ) {
			return;
		}

		$previous = \get_option( static::CUSTOM_CAPS_OPTION, [] );
		if ( isset( $previous[ $post_type->capability_type ] ) ) {
			return;
		}
		$admin = \get_role( 'administrator' );
		if ( null === $admin ) {
			return;
		}

		foreach ( (array) $post_type->cap as $cap ) {
			$admin->add_cap( $cap );
		}

		$previous[ $post_type->capability_type ] = 1;
		update_option( static::CUSTOM_CAPS_OPTION, $previous );
	}


	/**
	 * Set a Gutenberg template for this post type.
	 *
	 *
	 * @link    https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/#locking
	 *
	 * @link    https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-templates/#custom-post-types
	 *
	 * @example array(
	 *        array( 'core/image', array(
	 *            'align' => 'left',
	 *       ) ),
	 *        array( 'core/heading', array(
	 *            'placeholder' => 'Add Author...',
	 *        ) ),
	 *        array( 'core/paragraph', array(
	 *            'placeholder' => 'Add Description...',
	 *        ) ),
	 *    )
	 *
	 * @phpstan-param 'all'|'contentOnly'|'insert'|false $template_lock
	 *
	 * @param array        $template
	 * @param string|false $template_lock
	 *
	 * @return Custom_Post_Type
	 */
	public function gutenberg_template( array $template, $template_lock = false ) : Custom_Post_Type {
		$this->template = $template;
		$this->template_lock = $template_lock;

		return $this;
	}


	/**
	 * Get a registered post type object.
	 *
	 * @param string $post_type
	 *
	 * @return Custom_Post_Type|Custom_Post_Type_Extended|null
	 */
	public function get_post_type( string $post_type ) {
		return static::$registry[ $post_type ] ?? null;
	}


	/**
	 * Filters the bulk edit message to match the custom post type
	 *
	 * @filter bulk_post_updated_messages 10 2
	 *
	 * @param array $bulk_messages
	 * @param array $bulk_counts
	 *
	 * @return array
	 */
	public function adjust_bulk_edit_messages( array $bulk_messages, array $bulk_counts ) : array {
		// phpcs:disable WordPress.WP.I18n
		$bulk_messages[ $this->post_type ] = [
			'updated'   => _n(
				'%s ' . $this->post_type_label_singular . ' updated.',
				'%s ' . $this->post_type_label_plural . ' updated.',
				$bulk_counts['updated']
			),
			'locked'    => _n(
				'%s ' . $this->post_type_label_singular . ' not updated, somebody is editing it.',
				'%s ' . $this->post_type_label_plural . ' not updated, somebody is editing them.',
				$bulk_counts['locked']
			),
			'deleted'   => _n(
				'%s ' . $this->post_type_label_singular . ' permanently deleted.',
				'%s ' . $this->post_type_label_plural . ' permanently deleted.',
				$bulk_counts['deleted']
			),
			'trashed'   => _n(
				'%s ' . $this->post_type_label_singular . ' moved to the Trash.',
				'%s ' . $this->post_type_label_plural . ' moved to the Trash.',
				$bulk_counts['trashed']
			),
			'untrashed' => _n(
				'%s ' . $this->post_type_label_singular . ' restored from the Trash.',
				'%s ' . $this->post_type_label_plural . ' restored from the Trash.',
				$bulk_counts['untrashed']
			),
		];
		// phpcs:enable

		return $bulk_messages;
	}


	/**
	 * Filter the post updated messages, so they match this post type
	 * Smart enough to handle public and none public types
	 *
	 * @filter post_updated_messages 10 1
	 *
	 * @param array $messages
	 *
	 * @return array
	 */
	public function adjust_post_updated_messages( array $messages = [] ) : array {
		global $post, $post_ID;

		$lower_label = strtolower( $this->get_post_type_label() );
		$view_link = false;
		$preview_link = false;
		// phpcs:disable WordPress.WP.I18n
		if ( false !== $this->public && false !== $this->publicly_queryable ) {
			$url = esc_url( get_permalink( $post_ID ) );
			$preview_url = add_query_arg( 'preview', 'true', $url );
			$view_link = '<a href="' . $url . '">' . sprintf( __( 'View the %s...' ), $this->get_post_type_label(), $lower_label ) . '</a>';
			$preview_link = '<a target="_blank" href="' . $preview_url . '">' . sprintf( 'Preview %s', $lower_label ) . '</a>';
		}

		$messages[ $this->post_type ] = [
			0  => null,
			1  => sprintf( __( '%1$s updated. %2$s' ), $this->get_post_type_label(), $view_link ),
			2  => __( 'Custom field updated.' ),
			3  => __( 'Custom field deleted.' ),
			4  => sprintf( __( '%s updated.' ), $this->get_post_type_label() ),
			5  => isset( $_GET['revision'] ) ? sprintf( __( '%1$s restored to revision from %2$s' ), $this->get_post_type_label(), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, //phpcs:ignore
			6  => sprintf( __( '%1$s published. %2$s' ), $this->get_post_type_label(), $view_link ),
			7  => sprintf( __( '%s saved.' ), $this->get_post_type_label() ),
			8  => sprintf( __( '%1$s submitted. %2$s' ), $this->get_post_type_label(), $preview_link ),
			9  => sprintf( __( '%3$s scheduled for: %1$s. %2$s' ), '<strong>' . date_i18n( __( 'M j, Y @ G:i' ) . '</strong>', strtotime( $post->post_date ) ), $preview_link, $this->get_post_type_label() ),
			10 => sprintf( __( '%1$s draft updated. %2$s' ), $this->get_post_type_label(), $preview_link ),

		];
		// phpcs:enable

		return $messages;
	}


	/**
	 * Set capabilities for the post type using the methods
	 * of the Capabilities class
	 *
	 * @return Capabilities
	 *
	 */
	public function capabilities() : Capabilities {
		return new Capabilities( $this );
	}


	/**
	 * Used when retrieving the post type archive title
	 * Makes it match any customization done here
	 *
	 * @param string $title
	 *
	 * @filter get_post_type_archive_label 10 1
	 *
	 * @return string
	 */
	public function get_post_type_archive_label( string $title ) : string {
		if ( is_post_type_archive( $this->post_type ) ) {
			if ( $this->archive_label ) {
				$title = $this->archive_label;
			} else {
				$title = $this->get_post_type_label( 'plural' );
			}
		}

		return $title;
	}


	/**
	 * Adds post type support.
	 * Send a single feature or array of features.
	 *
	 * Must be called before the post type is registered
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
	 * A feature can also be specified as an array of arguments to provide additional
	 * information about supporting the feature.
	 * Example:
	 *     array( 'my_feature', array( 'field' => 'value' ) )
	 *
	 * @param array|string $features
	 *
	 * @return void
	 */
	public function add_support( $features ) : void {
		$features = (array) $features;
		$this->supports = \array_unique( \array_merge( $this->supports, $features ) );
	}


	/**
	 * Removes post type support.
	 * Send a single feature or array of features
	 *
	 * Must be called before the post type is registered
	 *
	 * @param array|string $features
	 *
	 * @return void
	 */
	public function remove_support( $features ) : void {
		$features = (array) $features;
		$this->supports = array_diff( $this->supports, $features );
	}


	/**
	 * Removes a column from the posts list in the admin.
	 *
	 * Default WP columns are
	 * 1. 'author'
	 * 2. 'date'
	 *
	 * @param string $column
	 *
	 */
	public function remove_column( string $column ) : void {
		add_filter( "manage_edit-{$this->post_type}_columns", function( $columns ) use ( $column ) {
			unset( $columns[ $column ] );
			return $columns;
		} );
	}


	/**
	 * Exclude this post type from sitemaps.
	 *
	 * If the post type is publicly viewable, this does nothing.
	 *
	 * @since 13.14.0
	 *
	 * @return void
	 */
	public function exclude_from_sitemaps() : void {
		add_filter( 'wp_sitemaps_post_types', function( $types ) {
			unset( $types[ $this->post_type ] );
			return $types;
		} );
	}


	/**
	 * Disable single template while leaving the archive intact.
	 *
	 * @link     https://wordpress.stackexchange.com/a/403951/129914
	 *
	 * @requires WP 5.9.0+.
	 *
	 * @return void
	 */
	public function disable_single() : void {
		$this->show_in_nav_menus = false;

		add_filter( 'genesis_link_post_title', function( $is_link ) {
			if ( get_post_type() === $this->post_type ) {
				return false;
			}
			return $is_link;
		} );

		add_filter( 'is_post_type_viewable', function( $is_viewable, $post_type ) {
			if ( $this->post_type === $post_type->name ) {
				return false;
			}
			return $is_viewable;
		}, 10, 2 );

		add_action( 'registered_post_type', function() {
			$rewrites = $this->rewrites();
			if ( \is_array( $rewrites ) && ! empty( $rewrites['slug'] ) ) {
				remove_rewrite_tag( "%{$rewrites['slug' ]}%" );
			} else {
				remove_rewrite_tag( "%{$this->get_slug()}%" );
			}
		} );
	}


	/**
	 * @param string $post_type
	 *
	 * @return Custom_Post_Type|Custom_Post_Type_Extended
	 */
	public static function factory( string $post_type ) : Custom_Post_Type {
		return new static( $post_type );
	}
}
