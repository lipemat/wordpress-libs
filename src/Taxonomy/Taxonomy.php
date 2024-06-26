<?php

declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Util\Actions;

/**
 * Register taxonomies
 *
 * @notice Must be constructed before the init hook runs
 *
 * @example
 * $tax = new Taxonomy( %slug% );
 * $tax->hierarchical = FALSE;
 * $tax->meta_box_cb = false;
 * $tax->set_label( %singular%, %plural%  );
 * $tax->post_types = array( self::NAME );
 * $tax->slug = %slug;
 */
class Taxonomy {
	protected const REGISTRY_OPTION = 'lipe/lib/schema/taxonomy_registry';

	/**
	 * Track the register taxonomies for later use.
	 *
	 * @var Taxonomy[]
	 */
	protected static array $registry = [];

	/**
	 * Array of arguments to automatically use inside `wp_get_object_terms()` for this taxonomy.
	 *
	 * @var array<string,mixed>
	 */
	public array $args;

	/**
	 * The arguments for the taxonomy
	 * Set these in the constructed class
	 *
	 * @var mixed
	 */
	public $post_types = [];

	/**
	 * Whether a taxonomy is intended for use publicly either via the
	 * admin interface or by front-end users.
	 * The default settings of `$publicly_queryable`, `$show_ui`,
	 * and `$show_in_nav_menus` are inherited from `$public`.
	 *
	 * @default true
	 *
	 * @var bool
	 */
	public bool $public = true;

	/**
	 * Whether the taxonomy is publicly queryable.
	 *
	 * @default $this->public
	 *
	 * @var bool
	 */
	public bool $publicly_queryable;

	/**
	 * Whether to generate a default UI for managing this taxonomy.
	 *
	 * @notice `$this->show_in_rest` must be true to show in Gutenberg.
	 *
	 * @default $this->public
	 *
	 * @var bool
	 */
	public bool $show_ui;

	/**
	 * Slug to use for this taxonomy rewrite.
	 *
	 * @var string
	 */
	public string $slug;

	/**
	 * Whether to allow automatic creation of taxonomy columns
	 * on associated post-types lists
	 *
	 * @default false
	 *
	 * @var bool
	 */
	public bool $show_admin_column;

	/**
	 * Show this taxonomy in the admin menu.
	 * If set to true, it will show up under all object_types the
	 * taxonomy is assigned to.
	 *
	 * If a menu slug is provided, the taxonomy will show under the
	 * menu provided.
	 *
	 * If an array is provided, the taxonomy will show under the menu
	 * provided by the array key, and the order provided by the array value.
	 *
	 * @example 'tools.php'
	 * @example [ 'tools.php' => 6 ]
	 *
	 * @notice $this->show_ui must be set to true.
	 * @notice  this is extended to specify a menu slug
	 *
	 * @default $this->show_ui
	 *
	 * @var bool|string|array
	 */
	public $show_in_menu;

	/**
	 * True makes this taxonomy available for selection in navigation menus.
	 *
	 * @default $this->public
	 *
	 * @var bool
	 */
	public bool $show_in_nav_menus;

	/**
	 * Whether to include the taxonomy in the REST API
	 *
	 * @notice  Must be set to true to show in the Gutenberg editor.
	 *
	 * @default false
	 *
	 * @var bool
	 */
	public bool $show_in_rest = false;

	/**
	 * To change the base url of REST API route
	 *
	 * @default $this->taxonomy
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
	 * REST API Controller class name.
	 *
	 * @default 'WP_REST_Terms_Controller'
	 *
	 * @var string
	 */
	public string $rest_controller_class;

	/**
	 * Whether to allow the Tag Cloud widget to use this taxonomy.
	 *
	 * @default $this->show_ui
	 *
	 * @var bool
	 */
	public bool $show_tagcloud;

	/**
	 * Whether to show the taxonomy in the quick/bulk edit panel
	 *
	 * @default $this->show_ui
	 *
	 * @var bool
	 */
	public bool $show_in_quick_edit;

	/**
	 * Provide a callback function for the meta box display.
	 *
	 * - If not set, `post_categories_meta_box()` is used for
	 *  hierarchical taxonomies, and `post_tags_meta_box()` is used for non-hierarchical.
	 * - If false, no meta box is shown.
	 *
	 * @phpstan-var false|callable(\WP_Post,array): void
	 *
	 * @var false|callable
	 */
	public $meta_box_cb;

	/**
	 * Callback function for sanitizing taxonomy data saved from a meta box.
	 *
	 * If no callback is defined, an appropriate one is determined based on the value of `$meta_box_cb`.
	 *
	 * @phpstan-var callable(string,mixed): (int|string)[]
	 *
	 * @var callable
	 */
	public $meta_box_sanitize_cb;

	/***
	 * Include a description of the taxonomy.
	 *
	 * @default ''
	 *
	 * @var string
	 */
	public string $description = '';

	/**
	 * Is this taxonomy hierarchical (have descendants) like categories
	 * or not hierarchical like tags.
	 *
	 * @default false
	 *
	 * @var bool
	 */
	public bool $hierarchical = false;

	/**
	 * Works much like a hook, in that it will be called when the count is updated.
	 *
	 * Defaults:
	 * - `_update_post_term_count()` for taxonomies attached to post types, which confirms
	 *  that the objects are published before counting them.
	 * - `_update_generic_term_count()` for taxonomies attached to other object types, such as users.
	 *
	 * @phpstan-var callable(int[],\WP_Taxonomy): void
	 *
	 * @var callable
	 */
	public $update_count_callback;

	/**
	 * False to disable the query_var, set as string to use
	 * custom query_var instead of default
	 * True is not seen as a valid entry and will result in 404 issues.
	 *
	 * @default $this->taxonomy
	 *
	 * @var false|string|null
	 */
	public $query_var;

	/**
	 * Triggers the handling of rewrites for this taxonomy.
	 *
	 * Default true, using `$taxonomy` as slug.
	 *
	 * - To prevent a rewrite, set to false.
	 * - To specify rewrite rules, an array can be passed with any of these keys:
	 *
	 * @phpstan-var bool|array{
	 *     slug?: string,
	 *     with_front?: bool,
	 *     hierarchical?: bool,
	 *     ep_mask?: int,
	 * }
	 *
	 * @var bool|array<string,mixed>
	 */
	public $rewrite;

	/**
	 * Array of capabilities for this taxonomy.
	 *
	 * @phpstan-var array{
	 *     manage_terms: string,
	 *     edit_terms: string,
	 *     delete_terms: string,
	 *     assign_terms: string,
	 * }
	 *
	 * @var array<string,string>
	 */
	public array $capabilities;

	/**
	 * Whether terms in this taxonomy should be sorted in the
	 * order they are provided to `wp_set_object_terms()`
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $sort = false;

	/**
	 * Override any generated labels.
	 *
	 * Usually calling `Taxonomy::set_label` covers any required changes.
	 * Updating this property will fine tune existing or set special not included ones.
	 *
	 * @see      get_taxonomy_labels
	 * @see      Taxonomy::taxonomy_labels()
	 *
	 * @example  `['name_field_description' => [ $description, $description ]]`
	 *
	 * @var array<string,string>
	 */
	public array $labels = [];

	/**
	 * The taxonomy slug.
	 *
	 * @var string
	 */
	protected string $taxonomy = '';

	/**
	 * The default term added to new posts.
	 *
	 * @phpstan-var string|array{
	 *     name: string,
	 *     slug?: string,
	 *     description?: string,
	 * }
	 *
	 * @var string|array<string,string>
	 */
	protected $default_term;

	/**
	 * The singular label for the taxonomy.
	 *
	 * @var string
	 */
	protected string $label_singular = '';

	/**
	 * The plural label for the taxonomy.
	 *
	 * @var string
	 */
	protected string $label_plural = '';

	/**
	 * Label used for the admin menu.
	 *
	 * @var string
	 */
	protected string $label_menu = '';

	/**
	 * Terms to be automatically added to a taxonomy when
	 * it's registered.
	 *
	 * @var array
	 */
	protected array $initial_terms = [];

	/**
	 * Auto generate a post list filter.
	 *
	 * @var bool
	 */
	protected bool $post_list_filter = false;


	/**
	 * Add hooks to register taxonomy.
	 *
	 * @todo                     Remove default parameters in version 5.
	 *
	 * @param string       $taxonomy          - Taxonomy Slug (will convert a title to a slug as well).
	 * @param string|array $post_types        - May also be set by $this->post_types = array.
	 * @param string|bool  $show_admin_column - Whether to generate a post list column or not.
	 *                                        If a `string is passed` it wil be used for the
	 *                                        column label.
	 * @param bool         $post_list_filter  - Auto generate a post list filter for this taxonomy.
	 *
	 * @phpstan-ignore-next-line -- Using default parameters for backwards compatibility.
	 */
	public function __construct( string $taxonomy, $post_types = [ - 1 ], $show_admin_column = '0', bool $post_list_filter = false ) {
		if ( [ - 1 ] === $post_types ) {
			_doing_it_wrong( __METHOD__, '4.5.0', 'The `$post_types` argument is required. To not use post types, pass an empty array.' );
			$post_types = [];
		}
		if ( true === $post_list_filter ) {
			_deprecated_argument( __METHOD__, '4.5.0', 'The `$post_list_filter` argument is deprecated. Use the `Taxonomy::post_list_filter()` method instead.' );
		}
		if ( '0' !== $show_admin_column ) {
			_deprecated_argument( __METHOD__, '4.5.0', 'The `$show_admin_column` argument is deprecated. Use the `Taxonomy::show_admin_column()` method instead.' );
		} else {
			$show_admin_column = false;
		}

		$this->post_types = (array) $post_types;
		$this->show_admin_column = (bool) $show_admin_column;
		$this->post_list_filter( $post_list_filter );
		$this->taxonomy = \strtolower( \str_replace( ' ', '_', $taxonomy ) );
		$this->hook();

		if ( \is_string( $show_admin_column ) ) {
			$this->show_admin_column( $show_admin_column );
		}
	}


	/**
	 * Hook the taxonomy into WordPress
	 *
	 * @return void
	 */
	public function hook(): void {
		// So we can add and edit stuff on init hook.
		add_action( 'wp_loaded', [ $this, 'register' ], 8, 0 );
		add_action( 'admin_menu', [ $this, 'add_as_submenu' ] );

		add_action( 'restrict_manage_posts', [ $this, 'post_list_filters' ] );
		if ( is_admin() ) {
			add_action( 'parse_tax_query', [ $this, 'post_list_query_filters' ] );
			// If some taxonomies are not registered on the front end.
			Actions::in()->add_single_action( 'wp_loaded', [ __CLASS__, 'check_rewrite_rules' ], 1000 );
		}
	}


	/**
	 * Set capabilities for the taxonomy using the methods
	 * of the Capabilities class.
	 *
	 * @since 3.15.0
	 *
	 * @return Capabilities
	 */
	public function capabilities(): Capabilities {
		return new Capabilities( $this );
	}


	/**
	 * The name of the custom meta box to use on the post editing screen for this taxonomy.
	 *
	 * Three custom meta boxes are provided:
	 *
	 *  - 'radio' for a meta box with radio inputs
	 *  - 'simple' for a meta box with a simplified list of checkboxes
	 *  - 'dropdown' for a meta box with a dropdown menu
	 *
	 * @phpstan-param 'radio'|'dropdown'|'simple' $type
	 *
	 * @param string                              $type          - The type of UI to render.
	 * @param bool                                $checked_ontop - Move checked items to top.
	 *
	 * @return void
	 */
	public function meta_box( string $type, bool $checked_ontop = false ): void {
		$box = new Meta_Box( $this->taxonomy, $type, $checked_ontop );
		$this->meta_box_sanitize_cb = [ $box, 'translate_string_term_ids_to_int' ];
	}


	/**
	 * Filters to query to match the taxonomy drop-downs on the post list page
	 *
	 * Added to `parse_tax_query` action by `$this->hook()`.
	 *
	 * @param \WP_Query $query - The WP_Query object.
	 *
	 * @return void
	 */
	public function post_list_query_filters( \WP_Query $query ): void {
		global $pagenow;

		if ( 'edit.php' !== $pagenow || empty( $query->query_vars['post_type'] ) || ! \in_array( $query->query_vars['post_type'], $this->post_types, true ) ) {
			return;
		}

		$tax_query = [];
		if ( isset( $query->query_vars[ $this->taxonomy ] ) && ! empty( $query->query_vars[ $this->taxonomy ] ) ) {
			if ( is_numeric( $query->query_vars[ $this->taxonomy ] ) ) {
				$field = 'id';
			} else {
				$field = 'slug';
			}
			$tax_query[] = [
				'taxonomy' => $this->taxonomy,
				'terms'    => $query->query_vars[ $this->taxonomy ],
				'field'    => $field,
			];
		}

		if ( ! empty( $tax_query ) ) {
			$query->tax_query = new \WP_Tax_Query( $tax_query );
		}
	}


	/**
	 * Creates the drop-downs to filter the post list by this taxonomy
	 *
	 * @uses added to restrict_manage_posts hook by $this->hook()
	 *
	 * @return void
	 */
	public function post_list_filters(): void {
		global $typenow, $wp_query;
		$been_filtered = false;

		if ( ! $this->post_list_filter || ! \in_array( $typenow, $this->post_types, true ) ) {
			return;
		}

		$args = [
			'orderby'      => 'name',
			'hierarchical' => true,
			'show_count'   => true,
			'hide_empty'   => true,
		];

		/* translators: Plural label of taxonomy. */
		$args['show_option_all'] = sprintf( __( 'All %s' ), $this->get_label( 'plural' ) ); //phpcs:ignore WordPress.WP.I18n.MissingArgDomain
		$args['taxonomy'] = $this->taxonomy;
		$args['name'] = $this->taxonomy;

		if ( ! empty( $wp_query->query[ $this->taxonomy ] ) ) {
			if ( \is_numeric( $wp_query->query[ $this->taxonomy ] ) ) {
				$args['selected'] = (string) $wp_query->query[ $this->taxonomy ];
			} else {
				$term = get_term_by( 'slug', $wp_query->query[ $this->taxonomy ], $this->taxonomy );
				if ( $term instanceof \WP_Term ) {
					$args['selected'] = $term->term_id;
				}
			}
			$been_filtered = true;
		}
		wp_dropdown_categories( $args );

		if ( $been_filtered && ! empty( $_GET['post_type'] ) ) { //phpcs:ignore
			$post_type = \sanitize_key( $_GET['post_type'] ); //phpcs:ignore
			?>
			<a
				style="margin: 0 4px 0 1px;"
				href="<?= esc_url( admin_url( 'edit.php?post_type=' . esc_attr( $post_type ) ) ) ?>"
				class="button"
			>
				<?php esc_html_e( 'Clear Filters', 'lipe' ); ?>
			</a>
			<?php
		}
	}


	/**
	 * Specify terms to be added automatically when a taxonomy is created.
	 *
	 * @param array $terms = array( <slug> => <name> ) || array( <name> ).
	 *
	 * @return void
	 */
	public function add_initial_terms( array $terms = [] ): void {
		$this->initial_terms = $terms;
	}


	/**
	 * Removes a column from the terms list in the admin.
	 *
	 * Default WP columns are
	 * 1. 'description'
	 * 2. 'slug'
	 * 3. 'posts'.
	 *
	 * @param string $column - Column slug.
	 */
	public function remove_column( string $column ): void {
		add_filter( "manage_edit-{$this->taxonomy}_columns", function( $columns ) use ( $column ) {
			unset( $columns[ $column ] );
			return $columns;
		} );
	}


	/**
	 * Return the slug of this taxonomy, formatted appropriately.
	 *
	 * @return string
	 */
	public function get_slug(): string {
		if ( empty( $this->slug ) ) {
			$this->slug = \strtolower( \str_replace( ' ', '-', $this->taxonomy ) );
		}

		return $this->slug;
	}


	/**
	 * If $this->show_in_menu was set to a slug instead
	 * of a boolean, we add the taxonomy as a submenu of
	 * the provided slug.
	 *
	 * The taxonomy will be added at the end of the menu unless
	 * an order is provided by setting $this->show_in_menu to an array.
	 *
	 * @see   Taxonomy::$show_in_menu
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function add_as_submenu(): void {
		global $submenu;
		$edit_tags_file = 'edit-tags.php?taxonomy=%s';

		if ( ! \is_bool( $this->show_in_menu ) && ! empty( $this->show_in_menu ) ) {
			$tax = get_taxonomy( $this->taxonomy );
			$parent = $this->show_in_menu;
			$order = 100;
			if ( false !== $tax ) {
				if ( \is_array( $parent ) && \is_array( $this->show_in_menu ) ) {
					$parent = \key( $this->show_in_menu );
					$order = \reset( $this->show_in_menu );
				}
				//phpcs:ignore
				$submenu[ $parent ][ $order ] = [
					esc_attr( $tax->labels->menu_name ),
					$tax->cap->manage_terms,
					\sprintf( $edit_tags_file, $tax->name ),
				];
				\ksort( $submenu[ $parent ] );
			}
		}
		// Set the current parent menu for the custom location.
		add_filter( 'parent_file', [ $this, 'set_current_menu' ] );
	}


	/**
	 * Enable the admin post lists column for this taxonomy.
	 * Optionally set the label for the column. Defaults to the taxonomy label.
	 *
	 * WP core does not support changing the label using `show_admin_column` so
	 * we use a filter to change the label.
	 *
	 * @param string $label - Optional label to use for the column.
	 */
	public function show_admin_column( string $label = '' ): void {
		$this->show_admin_column = true;
		if ( '' === $label ) {
			return;
		}
		Actions::in()->add_filter_all( array_map( function( $post_type ) {
			return "manage_{$post_type}_posts_columns";
		}, $this->post_types ), function( array $columns ) use ( $label ) {
			$columns[ 'taxonomy-' . $this->taxonomy ] = $label;
			return $columns;
		} );
	}


	/**
	 * Enable/disable a post list filter for this taxonomy.
	 *
	 * @param bool $enabled - Whether to enable the post list filter.
	 *
	 * @return void
	 */
	public function post_list_filter( bool $enabled = true ): void {
		$this->post_list_filter = $enabled;
	}


	/**
	 * Set the default term which will be added to new posts which
	 * use this taxonomy.
	 *
	 * If the term does not exist, it will be created automatically.
	 *
	 * @requires WP 5.5.0+
	 *
	 * @param string $slug        - The slug of the term to use.
	 * @param string $name        - The name of the term to use.
	 * @param string $description - The description of the term to use.
	 *
	 * @return void
	 */
	public function set_default_term( string $slug, string $name, string $description = '' ): void {
		$this->default_term = [
			'description' => $description,
			'name'        => $name,
			'slug'        => $slug,
		];
	}


	/**
	 * Set the current admin menu, so the correct one is highlighted.
	 * Only used when $this->show_menu is set to a slug of a menu.
	 *
	 * @filter parent_file 10 1
	 *
	 * @see    Taxonomy::add_as_submenu();
	 *
	 * @interanl
	 *
	 * @param string $parent_file - Parent file slug to set as current.
	 *
	 * @return string
	 */
	public function set_current_menu( string $parent_file ): string {
		$screen = \get_current_screen();
		if ( null === $screen || null === $this->show_in_menu ) {
			return $parent_file;
		}
		if ( "edit-{$this->taxonomy}" === $screen->id && $this->taxonomy === $screen->taxonomy ) {
			return \is_array( $this->show_in_menu ) ? (string) \key( $this->show_in_menu ) : (string) $this->show_in_menu;
		}

		return $parent_file;
	}


	/**
	 * Handles any calls, which need to run to register this taxonomy.
	 *
	 * @return void
	 */
	public function register(): void {
		$this->register_taxonomy();
		static::$registry[ $this->taxonomy ] = $this;
		if ( \count( $this->initial_terms ) > 0 ) {
			$this->insert_initial_terms();
		}
	}


	/**
	 * Sets the singular and plural labels automatically
	 *
	 * @param string $singular - The singular label to use.
	 * @param string $plural   - The plural label to use.
	 *
	 * @return void
	 */
	public function set_label( string $singular = '', string $plural = '' ): void {
		if ( '' === $singular ) {
			$singular = ucwords( \str_replace( '_', ' ', $this->taxonomy ) );
		}
		if ( '' === $plural ) {
			if ( 'y' === \substr( $singular, - 1 ) ) {
				$plural = \substr( $singular, 0, - 1 ) . 'ies';
			} else {
				$plural = $singular . 's';
			}
		}

		$this->label_singular = $singular;
		$this->label_plural = $plural;
	}


	/**
	 * Returns the set menu label, or the plural label if not set.
	 *
	 * @return string
	 */
	public function get_menu_label(): string {
		if ( '' === $this->label_menu ) {
			$this->label_menu = $this->label_plural;
		}

		return $this->label_menu;
	}


	/**
	 * Sets the label for the menu
	 *
	 * @param string $label - The label to set it to.
	 *
	 * @return void
	 */
	public function set_menu_label( string $label ): void {
		$this->label_menu = $label;
	}


	/**
	 * Include a link in the "+ New" menu in the admin bar to
	 * quickly add a new term.
	 *
	 * Similar to how post types automatically have a link to add a new post.
	 *
	 * @since 4.10.0
	 *
	 * @return void
	 */
	public function show_in_admin_bar(): void {
		$cap = $this->capabilities['edit_terms'] ?? 'manage_categories';
		if ( ! current_user_can( $cap ) ) {
			return;
		}
		add_action( 'admin_bar_menu', function( \WP_Admin_Bar $wp_admin_bar ) {
			$wp_admin_bar->add_menu( [
				'id'     => 'new-' . $this->taxonomy,
				'title'  => $this->get_label(),
				'parent' => 'new-content',
				'href'   => admin_url( 'edit-tags.php?taxonomy=' . $this->taxonomy ),
			] );
		}, 100 );
	}


	/**
	 * Inserts any specified terms for a new taxonomy.
	 * Will run only once when term is first registered.
	 * Will only run on fresh taxonomies with no existing terms.
	 *
	 * @return void
	 */
	protected function insert_initial_terms(): void {
		$already_defaulted = get_option( 'lipe/lib/taxonomy/defaults-registry', [] );

		if ( ! isset( $already_defaulted[ $this->get_slug() ] ) ) {
			// Don't do anything if the taxonomy already has terms.
			$existing = get_terms( [
				'taxonomy' => $this->taxonomy,
				'fields'   => 'count',
			] );
			if ( \is_numeric( $existing ) && 0 === (int) $existing ) {
				foreach ( $this->initial_terms as $slug => $term ) {
					$args = [];
					if ( ! \is_numeric( $slug ) ) {
						$args['slug'] = $slug;
					}
					wp_insert_term( $term, $this->taxonomy, $args );
				}
			}
			$already_defaulted[ $this->get_slug() ] = 1;
			update_option( 'lipe/lib/taxonomy/defaults-registry', $already_defaulted, true );
		}
	}


	/**
	 * Register this taxonomy with WordPress
	 *
	 * Allow using a different process for registering taxonomies via
	 * child classes.
	 */
	protected function register_taxonomy(): void {
		register_taxonomy( $this->taxonomy, $this->post_types, $this->taxonomy_args() );
	}


	/**
	 * Build the args array for the post type definition
	 *
	 * @uses may be overridden using the matching class vars
	 *
	 * @return array
	 */
	protected function taxonomy_args(): array {
		$args = [
			'labels'                => $this->taxonomy_labels(),
			'args'                  => $this->args ?? null,
			'public'                => $this->public,
			'publicly_queryable'    => $this->publicly_queryable ?? $this->public,
			'show_ui'               => $this->show_ui ?? $this->public,
			'show_in_menu'          => $this->show_in_menu,
			'show_in_nav_menus'     => $this->show_in_nav_menus ?? $this->public,
			'show_in_rest'          => $this->show_in_rest,
			'rest_base'             => $this->rest_base ?? null,
			'rest_namespace'        => $this->rest_namespace ?? null,
			'rest_controller_class' => $this->rest_controller_class ?? null,
			'show_tagcloud'         => $this->show_tagcloud ?? null,
			'show_in_quick_edit'    => $this->show_in_quick_edit ?? null,
			'meta_box_cb'           => $this->meta_box_cb,
			'meta_box_sanitize_cb'  => $this->meta_box_sanitize_cb,
			'show_admin_column'     => $this->show_admin_column,
			'description'           => $this->description ?? null,
			'hierarchical'          => $this->hierarchical ?? null,
			'update_count_callback' => $this->update_count_callback,
			'query_var'             => $this->query_var ?? $this->taxonomy,
			'rewrite'               => $this->rewrites(),
			'capabilities'          => $this->capabilities ?? [],
			'sort'                  => $this->sort,
			'default_term'          => $this->default_term,
		];

		$args = apply_filters( 'lipe/lib/taxonomy/args', $args, $this->taxonomy );
		return apply_filters( "lipe/lib/taxonomy/args_{$this->taxonomy}", $args );
	}


	/**
	 * Build the labels array for the post type definition
	 *
	 * @param string|null $single - The singular label to use.
	 * @param string|null $plural - The plural label to use.
	 *
	 * @return array
	 */
	protected function taxonomy_labels( ?string $single = null, ?string $plural = null ): array {
		$single = $single ?? $this->get_label();
		$plural = $plural ?? $this->get_label( 'plural' );

		// phpcs:disable WordPress.WP.I18n
		$labels = [
			'name'                       => $plural,
			'singular_name'              => $single,
			'search_items'               => sprintf( __( 'Search %s' ), $plural ),
			'popular_items'              => sprintf( __( 'Popular %s' ), $plural ),
			'all_items'                  => sprintf( __( 'All %s' ), $plural ),
			'parent_item'                => sprintf( __( 'Parent %s' ), $single ),
			'parent_item_colon'          => sprintf( __( 'Parent %s:' ), $single ),
			'edit_item'                  => sprintf( __( 'Edit %s' ), $single ),
			'view_item'                  => sprintf( __( 'View %s' ), $single ),
			'update_item'                => sprintf( __( 'Update %s' ), $single ),
			'add_new_item'               => sprintf( __( 'Add New %s' ), $single ),
			'new_item_name'              => sprintf( __( 'New %s Name' ), $single ),
			'separate_items_with_commas' => sprintf( __( 'Separate %s with commas' ), $plural ),
			'add_or_remove_items'        => sprintf( __( 'Add or remove %s' ), $plural ),
			'choose_from_most_used'      => sprintf( __( 'Choose from the most used %s' ), $plural ),
			'not_found'                  => sprintf( __( 'No %s found' ), $plural ),
			'no_terms'                   => sprintf( __( 'No %s' ), $plural ),
			'no_item'                    => sprintf( __( 'No %s' ), strtolower( $plural ) ), // For extended taxos.
			'items_list_navigation'      => sprintf( __( '%s list navigation' ), $plural ),
			'items_list'                 => sprintf( __( '%s list' ), $plural ),
			'most_used'                  => __( 'Most Used' ),
			'back_to_items'              => sprintf( __( '&larr; Back to %s' ), $plural ),
			'menu_name'                  => $this->get_menu_label(),
		];
		// phpcs:enable WordPress.WP.I18n

		if ( ! empty( $this->labels ) ) {
			$labels = wp_parse_args( $this->labels, $labels );
		}

		$labels = apply_filters( 'lipe/lib/taxonomy/labels', $labels, $this->taxonomy );
		return apply_filters( "lipe/lib/taxonomy/labels_{$this->taxonomy}", $labels );
	}


	/**
	 * Retrieve a singular or plural label.
	 * Auto generate the label if necessary.
	 *
	 * @param 'plural' | 'singular' $quantity - The label quantity to retrieve.
	 *
	 * @return string
	 */
	protected function get_label( string $quantity = 'singular' ): string {
		if ( 'plural' === $quantity ) {
			if ( '' === $this->label_plural ) {
				$this->set_label( $this->label_singular );
			}

			return $this->label_plural;
		}

		if ( '' === $this->label_singular ) {
			$this->set_label();
		}

		return $this->label_singular;
	}


	/**
	 * Build rewrite args or pass the class var if set.
	 *
	 * @return array|bool|null
	 */
	protected function rewrites() {
		if ( empty( $this->rewrite ) ) {
			return [
				'slug'         => $this->get_slug(),
				'with_front'   => false,
				'hierarchical' => $this->hierarchical,
			];
		}

		return $this->rewrite;
	}


	/**
	 * If the taxonomies registered through this API have changed,
	 * rewrite rules need to be flushed.
	 *
	 * @static
	 */
	public static function check_rewrite_rules(): void {
		$slugs = wp_list_pluck( static::$registry, 'slug' );
		if ( get_option( static::REGISTRY_OPTION ) !== $slugs ) {
			flush_rewrite_rules();
			update_option( static::REGISTRY_OPTION, $slugs );
		}
	}


	/**
	 * Get a registered taxonomy object.
	 *
	 * @param string $taxonomy - Taxonomy slug.
	 *
	 * @return Taxonomy|null
	 */
	public static function get_taxonomy( string $taxonomy ): ?Taxonomy {
		return static::$registry[ $taxonomy ] ?? null;
	}
}
