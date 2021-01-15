<?php

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
 *
 */
class Taxonomy {
	protected const REGISTRY_OPTION = 'lipe/lib/schema/taxonomy_registry';

	protected static $registry = [];

	/**
	 * The arguments for the taxonomy
	 * Set these in the constructed class
	 *
	 * @var mixed
	 *
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
	public $public;

	/**
	 * Whether the taxonomy is publicly queryable.
	 *
	 * @default $this->public
	 *
	 * @var bool
	 */
	public $publicly_queryable;

	/**
	 * Whether to generate a default UI for managing this taxonomy.
	 *
	 * @default $this->public
	 *
	 * @var bool
	 */
	public $show_ui;

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
	 * true makes this taxonomy available for selection in navigation menus.
	 *
	 * @default $this->public
	 *
	 * @var bool
	 */
	public $show_in_nav_menus;

	/**
	 * Whether to include the taxonomy in the REST API
	 *
	 * @notice  Must be set to true to show in the Gutenberg editor
	 *
	 * @default false
	 *
	 * @var bool
	 */
	public $show_in_rest = false;

	/**
	 * To change the base url of REST API route
	 *
	 * @default $this->taxonomy
	 *
	 * @var string
	 */
	public $rest_base;

	/**
	 * REST API Controller class name.
	 *
	 * @default 'WP_REST_Terms_Controller'
	 *
	 * @var string
	 */
	public $rest_controller_class;

	/**
	 * Whether to allow the Tag Cloud widget to use this taxonomy.
	 *
	 * @default $this->show_ui
	 *
	 * @var bool
	 */
	public $show_tagcloud;

	/**
	 * Whether to show the taxonomy in the quick/bulk edit panel
	 *
	 * @default $this->show_ui
	 *
	 * @var bool
	 */
	public $show_in_quick_edit;

	/**
	 * Provide a callback function name for the meta box display
	 *
	 * @var callable
	 */
	public $meta_box_cb;

	/**
	 * Whether to allow automatic creation of taxonomy columns
	 * on associated post-types lists
	 *
	 * @default false
	 *
	 * @var bool
	 */
	public $show_admin_column;

	/***
	 * Include a description of the taxonomy.
	 *
	 * @default ''
	 *
	 * @var string
	 */
	public $description;

	/**
	 * Is this taxonomy hierarchical (have descendants) like categories
	 * or not hierarchical like tags.
	 *
	 * @default false
	 *
	 * @var bool
	 */
	public $hierarchical;

	/**
	 * A function name that will be called when the count of
	 * an associated $object_type, such as post, is updated.
	 * Works much like a hook.
	 *
	 * @var callable
	 */
	public $update_count_callback;

	/**
	 * False to disable the query_var, set as string to use
	 * custom query_var instead of default
	 * True is not seen as a valid entry and will result in 404 issues
	 *
	 * @default $this->taxonomy
	 *
	 * @var false|string
	 */
	public $query_var;

	/**
	 * Assign a special rewrite args. Send only the ones wanted to change.
	 * Set too false to disable URL rewriting.
	 *
	 * {
	 * 'slug' - Used as pretty permalink text (i.e. /tag/) - defaults to $this->taxonomy
	 * 'with_front' - allowing permalinks to be prepended with front base - defaults to true
	 * 'hierarchical' - true or false allow hierarchical urls -  defaults to false
	 * 'ep_mask' - Assign an endpoint mask for this taxonomy - defaults to EP_NONE.
	 *}
	 *
	 * @default true
	 *
	 * @var array|bool
	 */
	public $rewrite;

	/**
	 * Capabilities for these terms
	 *{
	 * 'manage_terms' - 'manage_categories'
	 * 'edit_terms' - 'manage_categories'
	 * 'delete_terms' - 'manage_categories'
	 * 'assign_terms' - 'edit_posts'
	 * }
	 *
	 * @default []
	 *
	 * @var array
	 */
	public $capabilities = [];

	/**
	 * The default term added to new posts.
	 * Replaces "Uncategorized"
	 *
	 * @requires WP 5.5.0+
	 *
	 * @var string|array {
	 * @type string $name        Name of default term.
	 * @type string $slug        Slug for default term. Default empty.
	 * @type string $description Description for default term. Default empty.
	 *     }
	 */
	public $default_term;

	/**
	 * Whether this taxonomy should remember the order in which terms
	 * are added to objects.
	 *
	 * @var bool
	 */
	public $sort;

	public $slug;

	/**
	 * The taxonomy slug
	 *
	 * @var string
	 */
	protected $taxonomy = '';

	/**
	 * Override any generated labels here.
	 *
	 * @since 2.6.1
	 *
	 * @var array
	 */
	public $labels = [];

	protected $label_singular = '';

	protected $label_plural = '';

	protected $label_menu = '';

	/**
	 * Terms to be automatically added to a taxonomy when
	 * it's registered.
	 *
	 * @var array
	 */
	protected $initial_terms = [];

	/**
	 * Set to true during __construct() auto generate a post list filter
	 *
	 * _post_list_filter
	 *
	 * @var bool
	 */
	protected $_post_list_filter = false;


	/**
	 *
	 * Takes care of the necessary hook and registering
	 *
	 * @notice set the class vars to edit arguments
	 *
	 * @param string       $taxonomy          - Taxonomy Slug ( will convert a title to a slug as well )
	 * @param string|array $post_types        - May also be set by $this->post_types = array
	 * @param string|bool  $show_admin_column - Whether to generate a post list column or not.
	 *                                        If a `string is passed` it wil be used for the
	 *                                        column label
	 * @param bool         $post_list_filter
	 */
	public function __construct( string $taxonomy, $post_types = [], $show_admin_column = false, $post_list_filter = false ) {
		$this->post_types = (array) $post_types;

		$this->show_admin_column = (bool) $show_admin_column;
		$this->_post_list_filter = $post_list_filter;
		$this->taxonomy = strtolower( str_replace( ' ', '_', $taxonomy ) );
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
	public function hook() : void {
		//so we can add and edit stuff on init hook
		add_action( 'wp_loaded', [ $this, 'register' ], 8, 0 );
		add_action( 'admin_menu', [ $this, 'add_as_submenu' ] );

		if ( $this->_post_list_filter ) {
			add_action( 'restrict_manage_posts', [ $this, 'post_list_filters' ] );
			if ( is_admin() ) {
				add_action( 'parse_tax_query', [ $this, 'post_list_query_filters' ] );
			}
		}

		if ( is_admin() ) { // In case there are some taxonomies not registered on front end.
			Actions::in()->add_single_action( 'wp_loaded', [ __CLASS__, 'check_rewrite_rules' ], 1000 );
		}
	}


	/**
	 * If the taxonomies registered through this API have changed,
	 * rewrite rules need to be flushed.
	 *
	 * @static
	 */
	public static function check_rewrite_rules() : void {
		$slugs = wp_list_pluck( self::$registry, 'slug' );
		if ( get_option( self::REGISTRY_OPTION ) !== $slugs ) {
			\flush_rewrite_rules();
			update_option( self::REGISTRY_OPTION, $slugs );
		}
	}


	/**
	 * Get a registered taxonomy object
	 *
	 * @static
	 *
	 * @param string $taxonomy
	 *
	 * @return Taxonomy_Extended|Taxonomy|null
	 */
	public static function get_taxonomy( string $taxonomy ) {
		return self::$registry[ $taxonomy ] ?? null;
	}


	/**
	 * Filters to query to match the taxonomy drop-downs on the post list page
	 *
	 * @param \WP_Query $query
	 *
	 * @uses added to parse_tax_query action by $this->hook()
	 *
	 * @return void
	 *
	 */
	public function post_list_query_filters( \WP_Query $query ) : void {
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
	public function post_list_filters() : void {
		global $typenow, $wp_query;
		$been_filtered = false;

		if ( ! \in_array( $typenow, $this->post_types, true ) ) {
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
			if ( is_numeric( $wp_query->query[ $this->taxonomy ] ) ) {
				$args['selected'] = $wp_query->query[ $this->taxonomy ];
			} else {
				$args['selected'] = get_term_by( 'slug', $wp_query->query[ $this->taxonomy ], $this->taxonomy )->term_id;
			}
			$been_filtered = true;
		}
		wp_dropdown_categories( $args );

		if ( $been_filtered && isset( $_GET['post_type'] ) ) {
			$post_type = \sanitize_key( $_GET['post_type'] );
			?>
			<a
				style="margin: 0 4px 0 1px;"
				href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . esc_attr( $post_type ) ) ); ?>"
				class="button">
				<?php esc_html_e( 'Clear Filters', 'lipe' ); ?>
			</a>
			<?php
		}
	}


	/**
	 * Specify terms to be added automatically when a taxonomy is created.
	 *
	 * @param array $terms = array( <slug> => <name> );
	 *
	 * @return void
	 */
	public function add_initial_terms( array $terms = [] ) : void {
		$this->initial_terms = $terms;
	}


	/**
	 * Removes a column from the terms list in the admin.
	 *
	 * Default WP columns are
	 * 1. 'description'
	 * 2. 'slug'
	 * 3. 'posts'
	 *
	 * @param string $column
	 *
	 * @since 2.21.0
	 *
	 */
	public function remove_column( string $column ) : void {
		add_filter( "manage_edit-{$this->taxonomy}_columns", function ( $columns ) use ( $column ) {
			unset( $columns[ $column ] );
			return $columns;
		} );
	}


	/**
	 * Inserts any specified terms for a new taxonomy.
	 * Will run only once when term is first registered.
	 * Will only run on fresh taxonomies with no existing terms.
	 *
	 * @return void
	 */
	protected function insert_initial_terms() : void {
		$already_defaulted = get_option( 'lipe/lib/taxonomy/defaults-registry', [] );

		if ( ! isset( $already_defaulted[ $this->get_slug() ] ) ) {
			// don't do anything if the taxonomy already has terms
			if ( ! get_terms( $this->taxonomy, [
				'hide_empty' => false,
				'number'     => 1,
			] ) ) {
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
	 * Return the slug of this taxonomy, formatted appropriately
	 *
	 * @return string
	 */
	public function get_slug() : string {
		if ( empty( $this->slug ) ) {
			$this->slug = strtolower( str_replace( ' ', '-', $this->taxonomy ) );
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
	 * @since 1.6.0
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function add_as_submenu() : void {
		global $submenu;
		$edit_tags_file = 'edit-tags.php?taxonomy=%s';

		if ( ! \is_bool( $this->show_in_menu ) && ! empty( $this->show_in_menu ) ) {
			$tax = get_taxonomy( $this->taxonomy );
			$parent = $this->show_in_menu;
			$order = 100;
			if ( null !== $tax ) {
				if ( \is_array( $parent ) ) {
					$parent = \key( $this->show_in_menu );
					$order = \reset( $this->show_in_menu );
				}
				$submenu[ $parent ][ $order ] = [ //phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				                                  esc_attr( $tax->labels->menu_name ),
				                                  $tax->cap->manage_terms,
				                                  \sprintf( $edit_tags_file, $tax->name ),
				];
				\ksort( $submenu[ $parent ] );
			}
		}
		//set the current parent menu for the custom location
		add_filter( 'parent_file', [ $this, 'set_current_menu' ] );
	}


	/**
	 * Change the admin column's label to a provided string.
	 *
	 * Add support for specifying the label to use instead of just
	 * generating the column or not.
	 *
	 * Automatically called within __construct() but may be called
	 * directly if desired.
	 *
	 * @param string $label
	 *
	 * @see   Taxonomy::__construct()
	 *
	 * @since 2.21.1
	 */
	public function show_admin_column( string $label ) : void {
		Actions::in()->add_filter_all( array_map( function ( $post_type ) {
			return "manage_{$post_type}_posts_columns";
		}, $this->post_types ), function ( array $columns ) use ( $label ) {
			$columns[ 'taxonomy-' . $this->taxonomy ] = $label;
			return $columns;
		} );
	}


	/**
	 * Set the default term which will be added to new posts which
	 * use this taxonomy.
	 *
	 * If the term does not exist, it will be created automatically.
	 *
	 * @requires WP 5.5.0+
	 *
	 * @param string $slug
	 * @param string $name
	 * @param string $description
	 *
	 * @since    2.19.0
	 *
	 * @return void
	 */
	public function set_default_term( string $slug, string $name, string $description = '' ) : void {
		$this->default_term = compact( 'description', 'name', 'slug' );
	}


	/**
	 * Set the current admin menu so the correct one is highlighted.
	 * Only used when $this->show_menu is set to a slug of a menu.
	 *
	 * @filter parent_file 10 1
	 *
	 * @param string|array $parent_file
	 *
	 * @see    Taxonomy::add_as_submenu();
	 *
	 * @interanl
	 *
	 * @return string
	 */
	public function set_current_menu( $parent_file ) : string {
		$screen = \get_current_screen();
		if ( null === $screen || null === $this->show_in_menu ) {
			return $parent_file;
		}
		if ( "edit-{$this->taxonomy}" === $screen->id && $this->taxonomy === $screen->taxonomy ) {
			return \is_array( $this->show_in_menu ) ? key( $this->show_in_menu ) : $this->show_in_menu;
		}

		return $parent_file;
	}


	/**
	 * Handles any calls which need to run to register this taxnomy
	 *
	 * @since 1.6.0
	 *
	 *
	 * @return void
	 */
	public function register() : void {
		$this->register_taxonomy();
		self::$registry[ $this->taxonomy ] = $this;
		if ( $this->initial_terms ) {
			$this->insert_initial_terms();
		}
	}


	/**
	 * Register this taxonomy with WordPress
	 *
	 * Allow using a different process for registering taxonomies via
	 * child classes.
	 *
	 * @since 1.6.0
	 *
	 */
	protected function register_taxonomy() : void {
		register_taxonomy( $this->taxonomy, $this->post_types, $this->taxonomy_args() );
	}


	/**
	 * Build the args array for the post type definition
	 *
	 * @uses may be overridden using the matching class vars
	 *
	 * @return array
	 */
	protected function taxonomy_args() : array {
		$args = [
			'labels'                => $this->taxonomy_labels(),
			'public'                => $this->public,
			'publicly_queryable'    => $this->publicly_queryable,
			'show_ui'               => $this->show_ui,
			'show_in_menu'          => $this->show_in_menu,
			'show_in_nav_menus'     => $this->show_in_nav_menus,
			'show_in_rest'          => $this->show_in_rest,
			'rest_base'             => $this->rest_base,
			'rest_controller_class' => $this->rest_controller_class,
			'show_tagcloud'         => $this->show_tagcloud,
			'show_in_quick_edit'    => $this->show_in_quick_edit,
			'meta_box_cb'           => $this->meta_box_cb,
			'show_admin_column'     => $this->show_admin_column,
			'description'           => $this->description,
			'hierarchical'          => $this->hierarchical,
			'update_count_callback' => $this->update_count_callback,
			'query_var'             => $this->query_var ?? $this->taxonomy,
			'rewrite'               => $this->rewrites(),
			'capabilities'          => $this->capabilities,
			'sort'                  => $this->sort,
			'default_term'          => $this->default_term,
		];

		$args = apply_filters( 'lipe/lib/taxonomy/args', $args, $this->taxonomy );
		$args = apply_filters( "lipe/lib/taxonomy/args_{$this->taxonomy}", $args );

		return $args;
	}


	/**
	 * Build the labels array for the post type definition
	 *
	 * @param null|string $single
	 * @param null|string $plural
	 *
	 * @return array
	 */
	protected function taxonomy_labels( $single = null, $plural = null ) : array {
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
			'no_item'                    => sprintf( __( 'No %s' ), strtolower( $plural ) ), //For extended taxos.
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
		$labels = apply_filters( "lipe/lib/taxonomy/labels_{$this->taxonomy}", $labels );

		return $labels;
	}


	/**
	 * Retrieve a singular or plural label.
	 * Auto generate the label if necessary.
	 *
	 * @param string $quantity - (plural,singular)
	 *
	 * @return null|string
	 */
	protected function get_label( $quantity = 'singular' ) : ?string {
		if ( 'plural' === $quantity ) {
			if ( ! $this->label_plural ) {
				$this->set_label( $this->label_singular );
			}

			return $this->label_plural;
		}

		if ( ! $this->label_singular ) {
			$this->set_label();
		}

		return $this->label_singular;
	}


	/**
	 * Sets the singular and plural labels automatically
	 *
	 * @param string $singular
	 * @param string $plural
	 *
	 * @return void
	 *
	 */
	public function set_label( $singular = '', $plural = '' ) : void {
		if ( ! $singular ) {
			$singular = ucwords( str_replace( '_', ' ', $this->taxonomy ) );
		}
		if ( ! $plural ) {
			if ( 'y' === substr( $singular, - 1 ) ) {
				$plural = substr( $singular, 0, - 1 ) . 'ies';
			} else {
				$plural = $singular . 's';
			}
		}

		$this->label_singular = $singular;
		$this->label_plural = $plural;
	}


	/**
	 *
	 * Returns the set menu label or the plural label if not set
	 *
	 * @return string
	 *
	 */
	public function get_menu_label() : string {
		if ( ! $this->label_menu ) {
			$this->label_menu = $this->label_plural;
		}

		return $this->label_menu;
	}


	/**
	 *
	 * Build rewrite args or pass the the class var if set
	 *
	 * @return array|null
	 */
	protected function rewrites() : ?array {
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
	 * Sets the label for the menu
	 *
	 * @param string $label - the label to set it to
	 *
	 * @return void
	 */
	public function set_menu_label( string $label ) : void {
		$this->label_menu = $label;
	}

}
