<?php
//phpcs:disable WordPress.WP.I18n -- Using WP core translations.
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Post_Type\Custom_Post_Type\Register_Post_Type;
use Lipe\Lib\Theme\Dashicons;
use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Util\Strings;

/**
 * Register a custom post type.
 *
 * @link   https://developer.wordpress.org/reference/functions/register_post_type/
 *
 * @notice Must be constructed before the `init` hook runs
 *
 * @phpstan-type BULK 'updated'|'locked'|'deleted'|'trashed'|'untrashed'
 * @phpstan-import-type REWRITE from Register_Post_Type
 */
class Custom_Post_Type {
	use Memoize;

	/**
	 * Core feature(s) the post type supports.
	 *
	 * @see Custom_Post_Type::add_support()
	 * @see Custom_Post_Type::remove_support()
	 *
	 * @phpstan-var array<Register_Post_Type::SUPPORTS_*>
	 */
	public const DEFAULT_SUPPORTS = [
		Register_Post_Type::SUPPORTS_TITLE,
		Register_Post_Type::SUPPORTS_EDITOR,
		Register_Post_Type::SUPPORTS_AUTHOR,
		Register_Post_Type::SUPPORTS_THUMBNAIL,
		Register_Post_Type::SUPPORTS_EXCERPT,
	];

	protected const REGISTRY_OPTION    = 'lipe/lib/post-type/custom-post-type/registry';
	protected const CUSTOM_CAPS_OPTION = 'lipe/lib/post-type/custom-post-type/caps';

	/**
	 * Track the register post types for later use.
	 *
	 * @var array<string, Custom_Post_Type>
	 */
	protected static array $registry = [];

	/**
	 * Array of capabilities for this post type.
	 *
	 * `$capability_type` is used as a base to build capabilities by default.
	 *
	 * @link   https://developer.wordpress.org/reference/functions/register_post_type/#capabilities
	 *
	 * @var Capabilities
	 */
	public readonly Capabilities $capabilities;

	/**
	 * Individual labels for the post type.
	 *
	 * Preferred to be set using the `labels` method.
	 *
	 * @see Custom_Post_Type::labels()
	 *
	 * @var Labels
	 */
	public readonly Labels $labels;

	/**
	 * The post type slug.
	 *
	 * @var string
	 */
	public readonly string $name;

	/**
	 * Arguments passed to `register_post_type()` after all
	 * properties are set.
	 *
	 * @see Custom_Post_Type::get_post_type_args()
	 *
	 * @var Register_Post_Type
	 */
	public readonly Register_Post_Type $register_args;

	/**
	 * Tf true, will auto add custom capability type caps to administrator
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	protected bool $auto_admin_caps = true;


	/**
	 * Takes care of the necessary hook and registering.
	 *
	 * @param string $post_type The post type slug.
	 */
	final public function __construct( string $post_type ) {
		$this->name = $post_type;
		$this->labels = new Labels();
		$this->capabilities = new Capabilities( $this );
		$this->register_args = new Register_Post_Type( [] );
		$this->register_args->supports = static::DEFAULT_SUPPORTS;

		$this->hook();
		$this->labels();
	}


	/**
	 * Hook the post_type into WordPress
	 *
	 * @return void
	 */
	protected function hook(): void {
		// Allow methods added to the init hook to customize the post type.
		add_action( 'wp_loaded', function() {
			$this->register();
		}, 8, 0 );

		add_filter( 'adjust_post_updated_messages', fn( array $messages ) => $this->adjust_post_updated_messages( $messages ) );
		add_filter( 'bulk_post_updated_messages', fn( array $message, array $count ) => $this->adjust_bulk_edit_messages( $message, $count ), 10, 2 );

		if ( is_admin() ) {
			// For post types not registered on the front-end.
			add_action( 'wp_loaded', function() {
				$this->static_once( fn() => $this->check_rewrite_rules(), 'check_rewrite_rules' );
			}, 1_000 );
		}
	}


	/**
	 * Handles any calls which need to run to register this post type.
	 *
	 * @action wp_loaded 8 0
	 *
	 * @return void
	 */
	protected function register(): void {
		static::$registry[ $this->name ] = $this;
		register_post_type( $this->name, $this->get_post_type_args() );
		$this->add_administrator_capabilities( get_post_type_object( $this->name ) );
	}


	/**
	 * Text, which replaces the 'Featured Image' phrase for this post type.
	 *
	 * @param string $label - Text to use.
	 */
	public function featured_image_labels( string $label ): void {
		$lowercase = \strtolower( $label );

		$this->labels()->featured_image( $label );
		$this->labels()->set_featured_image( \sprintf( __( 'Set %s' ), $lowercase ) );
		$this->labels()->remove_featured_image( \sprintf( __( 'Remove %s' ), $lowercase ) );
		$this->labels()->use_featured_image( \sprintf( __( 'Use as %s' ), $lowercase ) );
	}


	/**
	 * Set the labels for the post type.
	 *
	 * @param string $singular - The singular label for the post type.
	 * @param string $plural   - The plural label for the post type.
	 *
	 * @return Labels
	 */
	public function labels( string $singular = '', string $plural = '' ): Labels {
		if ( '' === $singular && null === $this->labels->get_label( Labels::SINGULAR_NAME ) ) {
			$singular = \str_replace( [ '_', '-' ], ' ', $this->name );
			$singular = \ucwords( $singular );
		}
		if ( '' === $plural && null === $this->labels->get_label( Labels::NAME ) ) {
			$plural = Strings::in()->pluralize( $singular );
		}
		if ( '' !== $singular ) {
			$this->labels->singular_name( $singular );
		}
		if ( '' !== $plural ) {
			$this->labels->name( $plural );
		}
		return $this->labels;
	}


	/**
	 * Set a Gutenberg template for this post type.
	 *
	 * @link    https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/#locking
	 *
	 * @link    https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-templates/#custom-post-types
	 *
	 * @example [
	 *        array('core/image', array('align' => 'left')),
	 *        array('core/heading', array('placeholder' => 'Add Author…')),
	 *        array('core/paragraph', array('placeholder' => 'Add Description…'))
	 *    ]
	 *
	 * @phpstan-param Register_Post_Type::TEMPLATE_LOCK*              $template_lock
	 *
	 * @param array<int, array<int, string|array<string|int, mixed>>> $template      - The template to use.
	 * @param bool|string                                             $template_lock - The template lock to use.
	 *
	 * @return Custom_Post_Type
	 */
	public function gutenberg_template( array $template, bool|string $template_lock = false ): Custom_Post_Type {
		$this->gutenberg_compatible( true );

		$this->register_args->template = $template;
		$this->register_args->template_lock = $template_lock;

		return $this;
	}


	/**
	 * Filters the bulk edit message to match the custom post type
	 *
	 * @filter bulk_post_updated_messages 10 2
	 *
	 * @param array<string, array<BULK, string>> $bulk_messages - The bulk messages.
	 * @param array<BULK, int>                   $bulk_counts   - The bulk counts.
	 *
	 * @return array<string, array<BULK, string>>
	 */
	protected function adjust_bulk_edit_messages( array $bulk_messages, array $bulk_counts ): array {
		$single = $this->labels()->get_label( Labels::SINGULAR_NAME );
		$plural = $this->labels()->get_label( Labels::NAME );

		$bulk_messages[ $this->name ] = [
			'updated'   => _n(
				'%s ' . $single . ' updated.',
				'%s ' . $plural . ' updated.',
				$bulk_counts['updated']
			),
			'locked'    => _n(
				'%s ' . $single . ' not updated, somebody is editing it.',
				'%s ' . $plural . ' not updated, somebody is editing them.',
				$bulk_counts['locked']
			),
			'deleted'   => _n(
				'%s ' . $single . ' permanently deleted.',
				'%s ' . $plural . ' permanently deleted.',
				$bulk_counts['deleted']
			),
			'trashed'   => _n(
				'%s ' . $single . ' moved to the Trash.',
				'%s ' . $plural . ' moved to the Trash.',
				$bulk_counts['trashed']
			),
			'untrashed' => _n(
				'%s ' . $single . ' restored from the Trash.',
				'%s ' . $plural . ' restored from the Trash.',
				$bulk_counts['untrashed']
			),
		];

		return $bulk_messages;
	}


	/**
	 * Filter the post updated messages, so they match this post type
	 * Smart enough to handle public and none public types
	 *
	 * @filter post_updated_messages 10 1
	 *
	 * @param array<string, array<int, string>> $messages - The messages.
	 *
	 * @return array<string, array<int, ?string>>
	 */
	protected function adjust_post_updated_messages( array $messages = [] ): array {
		global $post, $post_ID;
		if ( ! $post instanceof \WP_Post ) {
			return $messages;
		}

		$single = $this->labels()->get_label( Labels::SINGULAR_NAME ) ?? '';
		$lower_label = \strtolower( $single );

		$view_link = false;
		$preview_link = false;

		if (
			( ! isset( $this->register_args->public ) || false !== $this->register_args->public )
			&&
			( ! isset( $this->register_args->publicly_queryable ) || false !== $this->register_args->publicly_queryable )
		) {
			$url = esc_url( (string) get_permalink( $post_ID ) );
			$preview_url = add_query_arg( 'preview', 'true', $url );
			$view_link = '<a href="' . $url . '">' . \sprintf( __( 'View the %s...' ), $this->labels()->get_label( Labels::NAME ), $lower_label ) . '</a>';
			$preview_link = '<a target="_blank" href="' . $preview_url . '">' . \sprintf( 'Preview %s', $lower_label ) . '</a>';
		}

		$messages[ $this->name ] = [
			0  => null,
			1  => \sprintf( __( '%1$s updated. %2$s' ), $single, $view_link ),
			2  => __( 'Custom field updated.' ),
			3  => __( 'Custom field deleted.' ),
			4  => \sprintf( __( '%s updated.' ), $single ),
			//phpcs:ignore WordPress.Security.NonceVerification -- Data is cast to int, pretty safe.
			5  => isset( $_GET['revision'] ) ? \sprintf( __( '%1$s restored to revision from %2$s' ), $single, wp_post_revision_title( (int) $_GET['revision'], false ) ) : null,
			6  => \sprintf( __( '%1$s published. %2$s' ), $single, $view_link ),
			7  => \sprintf( __( '%s saved.' ), $single ),
			8  => \sprintf( __( '%1$s submitted. %2$s' ), $single, $preview_link ),
			9  => \sprintf( __( '%3$s scheduled for: %1$s. %2$s' ), '<strong>' . date_i18n( __( 'M j, Y @ G:i' ) . '</strong>', \strtotime( $post->post_date ) ), $preview_link, $single ),
			10 => \sprintf( __( '%1$s draft updated. %2$s' ), $single, $preview_link ),

		];

		return $messages;
	}


	/**
	 * Set capabilities for the post type using the methods
	 * of the Capabilities class
	 *
	 * @return Capabilities
	 */
	public function capabilities(): Capabilities {
		return $this->capabilities;
	}


	/**
	 * Set the archive label for this post type
	 *
	 * @param string $label - The label to use.
	 */
	public function archive_label( string $label ): void {
		$this->labels()->archive_label( $label );
		add_filter( 'post_type_archive_title', fn( string $title ) => $this->get_post_type_archive_label( $title ) );
	}


	/**
	 * Used when retrieving the post type archive title
	 * Makes it match any customization done here.
	 *
	 * @param string $title - The title.
	 *
	 * @filter get_post_type_archive_label 10 1
	 *
	 * @return string
	 */
	protected function get_post_type_archive_label( string $title ): string {
		if ( is_post_type_archive( $this->name ) ) {
			$label = $this->labels->get_label( Labels::ARCHIVE_LABEL );
			if ( null !== $label ) {
				return $label;
			}
		}

		return $title;
	}


	/**
	 * Adds post type support.
	 *
	 * Serves as an alias for calling `add_post_type_support()` directly.
	 *
	 * Must be called before the post type is registered
	 *
	 * @phpstan-param Register_Post_Type::SUPPORTS_* $feature
	 *
	 * @param string                                 $feature - The feature being added.
	 *
	 * @return void
	 */
	public function add_support( string $feature ): void {
		if ( ! \in_array( $feature, $this->register_args->supports, true ) ) {
			$this->register_args->supports[] = $feature;
		}
	}


	/**
	 * Removes post type support.
	 * Serves as an alias for calling `remove_post_type_support()` directly.
	 *
	 * Must be called before the post type is registered
	 *
	 * @phpstan-param Register_Post_Type::SUPPORTS_* $feature
	 *
	 * @param string                                 $feature - The feature(s) to removed.
	 *
	 * @return void
	 */
	public function remove_support( string $feature ): void {
		$existing = \array_search( $feature, $this->register_args->supports, true );
		if ( false !== $existing ) {
			unset( $this->register_args->supports[ $existing ] );
		}
	}


	/**
	 * Removes a column from the posts list in the admin.
	 *
	 * Default WP columns are
	 * 1. 'author'.
	 * 2. 'date'.
	 *
	 * @param string $column - The column to remove.
	 */
	public function remove_column( string $column ): void {
		add_filter( "manage_edit-{$this->name}_columns", function( $columns ) use ( $column ) {
			unset( $columns[ $column ] );
			return $columns;
		} );
	}


	/**
	 * Exclude this post type from sitemaps.
	 *
	 * If the post type is not publicly viewable, this does nothing.
	 *
	 * @since 13.14.0
	 *
	 * @return void
	 */
	public function exclude_from_sitemaps(): void {
		add_filter( 'wp_sitemaps_post_types', function( $types ) {
			unset( $types[ $this->name ] );
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
	public function disable_single(): void {
		$this->show_in_nav_menus( false );

		add_filter( 'genesis_link_post_title', function( $is_link ) {
			if ( get_post_type() === $this->name ) {
				return false;
			}
			return $is_link;
		} );

		add_filter( 'is_post_type_viewable', function( bool $is_viewable, \WP_Post_Type $post_type ) {
			if ( $this->name === $post_type->name ) {
				return false;
			}
			return $is_viewable;
		}, 10, 2 );

		add_action( 'registered_post_type', function() {
			$rewrites = $this->get_rewrites();
			if ( \is_array( $rewrites ) && isset( $rewrites['slug'] ) && '' !== $rewrites['slug'] ) {
				remove_rewrite_tag( "%{$rewrites['slug']}%" );
			} else {
				$slug = sanitize_title_with_dashes( $this->name );
				remove_rewrite_tag( "%{$slug}%" );
			}
		} );
	}


	/**
	 * Turn on and off Gutenberg block editor support based on
	 * WP core requirements and $this->gutenberg_compatible
	 *
	 * `false`
	 * 1. Uses existing filter to disable block editor support.
	 *
	 * `true`
	 * 1. To enable block editor, we need to have show_in_rest set to true.
	 * 2. To enable block editor, we need to have editor support.
	 *
	 * @param bool $compatible - Whether to enable the block editor.
	 *
	 * @return void
	 */
	public function gutenberg_compatible( bool $compatible ): void {
		if ( $compatible ) {
			$this->show_in_rest();
			$this->add_support( Register_Post_Type::SUPPORTS_EDITOR );
		} else {
			add_filter( 'use_block_editor_for_post_type', function( $enabled, $post_type ) {
				if ( $post_type === $this->name ) {
					return false;
				}
				return $enabled;
			}, 10, 2 );
		}
	}


	/**
	 * Change the REST API controllers for this post type.
	 *
	 * @since 5.0.0
	 *
	 * @see   Custom_Post_Type::show_in_rest()
	 *
	 * @phpstan-param class-string<\WP_REST_Controller> $base
	 * @phpstan-param class-string<\WP_REST_Controller> $autosave
	 * @phpstan-param class-string<\WP_REST_Controller> $revisions
	 *
	 * @param string                                    $base              - Base controller for the post type.
	 * @param string                                    $autosave          - Autosave controller for the post type.
	 * @param string                                    $revisions         - Revisions controller for the post type.
	 * @param bool                                      $late_registration - Whether to register the post type after the autosave and
	 *                                                                     revisions controllers.
	 *
	 * @return void
	 */
	public function rest_controllers( string $base = \WP_REST_Posts_Controller::class, string $autosave = \WP_REST_Autosaves_Controller::class, string $revisions = \WP_REST_Revisions_Controller::class, bool $late_registration = false ): void {
		$this->register_args->autosave_rest_controller_class = $autosave;
		$this->register_args->rest_controller_class = $base;
		$this->register_args->revisions_rest_controller_class = $revisions;
		$this->register_args->late_route_registration = $late_registration;
	}


	/**
	 * Show or hide this post type in the REST API.
	 *
	 * @since 5.0.0
	 *
	 * @see   Custom_Post_Type::rest_controllers()
	 *
	 * @param bool    $show  - Whether to show in REST.
	 * @param ?string $base  - The base to use. Defaults to the post type.
	 * @param string  $space - The namespace to use.
	 *
	 * @return void
	 */
	public function show_in_rest( bool $show = true, ?string $base = null, string $space = 'wp/v2' ): void {
		$this->register_args->show_in_rest = $show;

		if ( $show ) {
			if ( ! isset( $this->register_args->rest_base ) ) {
				$this->register_args->rest_base = $base ?? $this->name;
			}
			if ( ! isset( $this->register_args->rest_namespace ) ) {
				$this->register_args->rest_namespace = $space;
			}
		} else {
			unset( $this->register_args->rest_base, $this->register_args->rest_namespace, $this->register_args->rest_controller_class );
		}
	}


	/**
	 * Show or hide this post type in the menu.
	 *
	 * @param Dashicons|string $icon             - Base64 encoded SVG, URL, 'none' or Dashicon enum.
	 * @param ?string          $parent_menu      - Parent menu item. Use existing top level menu like 'tools.php' or
	 *                                           'edit.php?post_type=page'.
	 * @param int              $position         - Position in the menu.
	 *
	 * @return void
	 */
	public function show_in_menu( Dashicons|string $icon = '', ?string $parent_menu = null, int $position = 5 ): void {
		$this->register_args->show_in_menu = true;
		$this->register_args->menu_position = $position;

		if ( null !== $parent_menu ) {
			$this->register_args->show_in_menu = $parent_menu;
		}
		if ( '' !== $icon ) {
			$this->register_args->menu_icon = $icon instanceof Dashicons ? $icon->value : $icon;
		}
	}


	/**
	 * Tf true, will auto add custom capability type caps to administrator.
	 *
	 * @default true
	 *
	 * @param bool $allowed - Whether to allow auto admin caps.
	 */
	public function allow_auto_admin_caps( bool $allowed ): void {
		$this->auto_admin_caps = $allowed;
	}


	/**
	 * Whether to allow this post type to be exported.
	 *
	 * @param bool $can_export - Whether to allow export.
	 */
	public function can_export( bool $can_export ): void {
		$this->register_args->can_export = $can_export;
	}


	/**
	 * The strings to use to build the read, edit, and delete capabilities.
	 *
	 * Passed as an array to allow for alternative plurals when using this argument
	 * as a base to build the capabilities.
	 * - e.g., array('story', 'stories').
	 *
	 * @phpstan-param string|array{
	 *     0: string,
	 *     1: string
	 * }                   $capability_type
	 *
	 * @param array|string $capability_type - The capability type.
	 */
	public function capability_type( array|string $capability_type ): void {
		$this->register_args->capability_type = $capability_type;
	}


	/**
	 * Whether to delete posts of this type when deleting a user.
	 * - If true, posts of this type belonging to the user will be moved to Trash
	 * when the user is deleted.
	 * - If false, posts of this type belonging to the user will *not* be
	 * trashed or deleted.
	 * - If not set (the default), posts are trashed if post type supports
	 * the 'author' feature. Otherwise, posts are not trashed or deleted.
	 *
	 * @param bool $delete_with_user - Whether to delete with user.
	 */
	public function delete_with_user( bool $delete_with_user ): void {
		$this->register_args->delete_with_user = $delete_with_user;
	}


	/**
	 * A short descriptive summary of what the post type is.
	 *
	 * @default ''
	 *
	 * @param string $description - The description.
	 */
	public function description( string $description ): void {
		$this->register_args->description = $description;
	}


	/**
	 * Whether to exclude posts with this post type from front end search results.
	 *
	 * @default Opposite value of `$public`.
	 *
	 * @param bool $is_excluded - Whether to exclude from search.
	 */
	public function exclude_from_search( bool $is_excluded ): void {
		$this->register_args->exclude_from_search = $is_excluded;
	}


	/**
	 * Enables post type archives.
	 *
	 * Will use post type slug if set to true, otherwise
	 * will use provided string.
	 *
	 * @link https://developer.wordpress.org/reference/functions/register_post_type/#has_archive
	 *
	 * @param bool|string $has_archive - Does the post type have an archive.
	 */
	public function has_archive( bool|string $has_archive ): void {
		$this->register_args->has_archive = $has_archive;
	}


	/**
	 * Whether the post type is hierarchical (e.g., page).
	 *
	 * @param bool $is_hierarchical - Whether to make the post type hierarchical.
	 */
	public function hierarchical( bool $is_hierarchical ): void {
		$this->register_args->hierarchical = $is_hierarchical;
	}


	/**
	 * Whether the post type is embeddable using oembed.
	 *
	 * Default is value of `public`.
	 *
	 * @since WP 6.8
	 *
	 * @param bool $is_embeddable - Whether to make the post type embeddable.
	 *
	 * @return void
	 */
	public function embeddable( bool $is_embeddable ): void {
		$this->register_args->embeddable = $is_embeddable;
	}


	/**
	 * Whether to use the internal default meta capability handling.
	 *
	 * @param bool $use_mapping - Whether to use mapping.
	 */
	public function map_meta_cap( bool $use_mapping ): void {
		$this->register_args->map_meta_cap = $use_mapping;
	}


	/**
	 * Whether a post type is intended for use publicly either via the admin interface or by front-end users.
	 *
	 * While the default settings of `$exclude_from_search`, `$publicly_queryable`, `$show_ui`, and `$show_in_nav_menus`
	 * are inherited from `$public`, each does not rely on this relationship and controls a very specific intention.
	 *
	 * @default true
	 *
	 * @param bool $is_public - Whether to make the post type public.
	 */
	public function public( bool $is_public ): void {
		$this->register_args->public = $is_public;
		if ( ! $is_public && ! isset( $this->register_args->rewrite ) ) {
			$this->register_args->rewrite = false;
		}
	}


	/**
	 * Whether queries can be performed on the front end for the post type as part of `parse_request()`.
	 *
	 * Endpoints would include:
	 *
	 * - `?post_type={post_type_key}`
	 * - `?{post_type_key}={single_post_slug}`
	 * - `?{post_type_query_var}={single_post_slug}`
	 *
	 * @default `$public`
	 *
	 * @param bool $is_queryable - Is the post type queryable?.
	 */
	public function publicly_queryable( bool $is_queryable ): void {
		$this->register_args->publicly_queryable = $is_queryable;
		if ( ! $is_queryable ) {
			$this->register_args->rewrite = false;
		}
	}


	/**
	 * Sets the query_var key for this post type.
	 *
	 * @default `$post_type`
	 *
	 * - If false, a post type cannot be loaded at `?{query_var}={post_slug}`.
	 * - If specified as a string, the query `?{query_var_string}={post_slug}` will be valid.
	 *
	 * @param bool|string $query_var - The query var to use.
	 */
	public function query_var( bool|string $query_var ): void {
		$this->register_args->query_var = $query_var;
	}


	/**
	 * Provide a callback function that will be called when setting
	 * up the meta boxes for the edit form.
	 *
	 * The callback function takes one argument $post,
	 * which contains the WP_Post object for the currently edited post
	 *
	 * @phpstan-param callable( \WP_Post ): void $register_cb
	 *
	 * @formatter:off
	 * @param callable $register_cb - The callback function.
	 * @formatter:on
	 */
	public function register_meta_box_cb( callable $register_cb ): void {
		$this->register_args->register_meta_box_cb = $register_cb;
	}


	/**
	 * Triggers the handling of rewrites for this post type.
	 *
	 * To prevent all rewrite, set to false.
	 *
	 * @default `true` using `$post_type` as slug. To specify rewrite rules,
	 * an array can be passed.
	 *
	 * @phpstan-param bool|REWRITE $rewrite
	 *
	 * @param array|bool           $rewrite - The rewrites to use.
	 */
	public function rewrite( bool|array $rewrite ): void {
		$this->register_args->rewrite = $rewrite;
	}


	/**
	 * Makes this post type available via the admin bar.
	 *
	 * @default `$show_in_menu`.
	 *
	 * @param bool $show - Whether to show in the admin bar.
	 */
	public function show_in_admin_bar( bool $show ): void {
		$this->register_args->show_in_admin_bar = $show;
	}


	/**
	 * Makes this post type available for selection in navigation menus.
	 *
	 * @default `$public`.
	 *
	 * @param bool $show - Whether to show in nav menus.
	 */
	public function show_in_nav_menus( bool $show ): void {
		$this->register_args->show_in_nav_menus = $show;
	}


	/**
	 * Whether to generate and allow a UI for managing this post type in the admin.
	 *
	 * @default `$public`.
	 *
	 * @param bool $show_ui - Whether to show the UI.
	 */
	public function show_ui( bool $show_ui ): void {
		$this->register_args->show_ui = $show_ui;
	}


	/**
	 * An array of taxonomy identifiers that will be registered for the post type.
	 *
	 * Taxonomies can be registered later with `register_taxonomy()` or
	 * `register_taxonomy_for_object_type()`.
	 *
	 * @param array<int, string> $taxonomies - The taxonomies to use.
	 */
	public function taxonomies( array $taxonomies ): void {
		$this->register_args->taxonomies = $taxonomies;
	}


	/**
	 * Build the args array for the post type definition.
	 *
	 * @return array<string, mixed>
	 */
	protected function get_post_type_args(): array {
		$args = $this->register_args;

		$args->can_export ??= true;
		$args->capabilities = \array_merge( $args->capabilities ?? [], $this->capabilities->get_capabilities() );
		$args->capability_type ??= 'post';
		$args->description ??= '';
		$args->has_archive ??= true;
		$args->hierarchical ??= false;
		$args->labels = $this->get_post_type_labels();
		$args->rewrite = $this->get_rewrites();
		$args->taxonomies ??= [];

		// These properties depend on each other.
		$args->public ??= true;
		$args->exclude_from_search ??= ! $args->public;
		$args->publicly_queryable ??= $args->public;
		$args->show_ui ??= $args->public;
		$args->show_in_menu ??= $args->show_ui;
		$args->show_in_admin_bar ??= (bool) $args->show_in_menu;
		$args->show_in_nav_menus ??= $args->public;

		$args = apply_filters( 'lipe/lib/schema/post_type_args', $args->get_args(), $this->name );
		return apply_filters( "lipe/lib/schema/post_type_args_{$this->name}", $args );
	}


	/**
	 * Build the labels array for the post type definition.
	 *
	 * @return array<Labels::*, string>
	 */
	protected function get_post_type_labels(): array {
		$single = $this->labels()->get_label( Labels::SINGULAR_NAME );
		$plural = $this->labels()->get_label( Labels::NAME );

		$labels = [
			'name'                     => $plural,
			'singular_name'            => $single,
			'add_new'                  => __( 'Add' ),
			'add_new_item'             => \sprintf( __( 'Add %s' ), $single ),
			'edit_item'                => \sprintf( __( 'Edit %s' ), $single ),
			'new_item'                 => \sprintf( __( 'New %s' ), $single ),
			'view_item'                => \sprintf( __( 'View %s' ), $single ),
			'view_items'               => \sprintf( __( 'View %s' ), $plural ),
			'search_items'             => \sprintf( __( 'Search %s' ), $plural ),
			'not_found'                => \sprintf( __( 'No %s Found' ), $plural ),
			'not_found_in_trash'       => \sprintf( __( 'No %s Found in Trash' ), $plural ),
			'parent_item_colon'        => \sprintf( __( 'Parent %s:' ), $single ),
			'all_items'                => \sprintf( __( 'All %s' ), $plural ),
			'archives'                 => \sprintf( __( '%s Archives' ), $single ),
			'attributes'               => \sprintf( __( '%s Attributes' ), $single ),
			'insert_into_item'         => \sprintf( __( 'Insert into %s' ), $single ),
			'uploaded_to_this_item'    => \sprintf( __( 'Uploaded to this %s' ), $single ),
			'featured_image'           => __( 'Featured Image' ),
			'set_featured_image'       => __( 'Set featured image' ),
			'remove_featured_image'    => __( 'Remove featured image' ),
			'use_featured_image'       => __( 'Use as featured image' ),
			'menu_name'                => $plural,
			'filter_items_list'        => \sprintf( __( 'Filter %s list' ), $plural ),
			'filter_by_date'           => __( 'Filter by date' ),
			'items_list_navigation'    => \sprintf( __( '%s list navigation' ), $plural ),
			'items_list'               => \sprintf( __( '%s list' ), $plural ),
			'item_published'           => \sprintf( __( '%s published.' ), $single ),
			'item_published_privately' => \sprintf( __( '%s published privately.' ), $single ),
			'item_reverted_to_draft'   => \sprintf( __( '%s reverted to draft.' ), $single ),
			'item_scheduled'           => \sprintf( __( '%s scheduled.' ), $single ),
			'item_updated'             => \sprintf( __( '%s updated.' ), $single ),
			'item_link'                => \sprintf( __( '%s Link.' ), $single ),
			'item_link_description'    => \sprintf( __( 'A link to a %s.' ), $single ),
		];

		$labels = wp_parse_args( $this->labels()->get_labels(), $labels );

		$labels = apply_filters( 'lipe/lib/post-type/labels', $labels, $this->name );
		return apply_filters( "lipe/lib/post-type/labels_{$this->name}", $labels );
	}


	/**
	 * Rewrites configuration.
	 *
	 * Set to `false` to disable rewrites.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/register_post_type/#rewrite
	 *
	 * Build the rewrites param with defaults if not set.
	 *
	 * @notice  The `ep_mask` parameter is mostly ignored and most likely
	 *          never needed to change.
	 *
	 * @return REWRITE|boolean
	 */
	protected function get_rewrites(): array|bool {
		return $this->register_args->rewrite ?? [
			'slug'       => sanitize_title_with_dashes( $this->name ),
			'with_front' => false,
		];
	}


	/**
	 * If the capability_type is not post it has custom capabilities
	 * We need to add these to the administrators of the site
	 *
	 * This gets called during $this->register_post_type()
	 *
	 * Checks to make sure we have not done this already
	 *
	 * @param \WP_Post_Type|null $post_type - The post type object.
	 *
	 * @return void
	 */
	protected function add_administrator_capabilities( ?\WP_Post_Type $post_type ): void {
		if ( ! $this->auto_admin_caps || null === $post_type || ( 'post' === $post_type->capability_type && [] === $this->capabilities()->get_capabilities() ) ) {
			return;
		}

		$previous = get_option( self::CUSTOM_CAPS_OPTION, [] );
		if ( isset( $previous[ $post_type->capability_type ] ) ) {
			return;
		}
		$admin = get_role( 'administrator' );
		if ( null === $admin ) {
			return;
		}

		foreach ( (array) $post_type->cap as $cap ) {
			$admin->add_cap( $cap );
		}

		$previous[ $post_type->capability_type ] = 1;
		update_option( self::CUSTOM_CAPS_OPTION, $previous );
	}


	/**
	 * If the post types registered through this API have changed,
	 * rewrite rules need to be flushed.
	 *
	 * @action wp_loaded 1_000 0
	 *
	 * @return void
	 */
	protected function check_rewrite_rules(): void {
		$slugs = \array_keys( static::$registry );
		if ( get_option( static::REGISTRY_OPTION ) !== $slugs ) {
			\flush_rewrite_rules();
			update_option( static::REGISTRY_OPTION, $slugs );
		}
	}


	/**
	 * Get a registered post type object.
	 *
	 * @param string $post_type - The post type slug.
	 *
	 * @return ?Custom_Post_Type
	 */
	public static function get_post_type( string $post_type ): ?Custom_Post_Type {
		return static::$registry[ $post_type ] ?? null;
	}
}
