<?php

namespace Lipe\Lib\Schema;

/**
 * Taxonomy
 *
 * Register taxonomies
 *
 * Must be constructed before the init hook runs so this can do it's thing
 *
 * @example
 * $tax = new Taxonomy( %slug% );
 * $tax->hierarchical = FALSE;
 * $tax->meta_box_cb = false;
 * $tax->set_label( %singular%, %plural%  );
 * $tax->post_types = array( self::NAME );
 * $tax->slug = %slug;
 *
 *
 */
class Taxonomy {

	private static $taxonomy_registry = [];

	private static $rewrite_checked = false;

	/**
	 * The arguments for the taxonomy
	 * Set these in the constructed class
	 *
	 * @var mixed
	 *
	 */
	public $post_types = [];

	public $public = true;

	public $show_ui = null;

	public $show_in_nav_menus = null;

	public $show_admin_column = false;

	public $show_tagcloud = null;

	public $hierarchical = false;

	public $update_count_callback = null;

	public $query_var = null;

	public $capabilities = [];

	public $slug = null;

	public $meta_box_cb = null;

	public $rewrite = null;

	/**
	 * The taxonomy slug
	 *
	 * @var string
	 */
	protected $taxonomy = '';

	protected $label_singular = '';

	protected $label_plural = '';

	protected $label_menu = '';

	protected $default_terms = [];

	/**
	 * Set to true during __construct() auto generate a post list filter
	 *
	 * _post_list_filter
	 *
	 * @var bool
	 */
	private $_post_list_filter = false;


	/**
	 * Construct
	 *
	 * Takes care of the necessary hook and registering
	 *
	 * @uses set the class vars to edit arguments
	 *
	 * @param string $taxonomy - Taxonomy Slug ( will convert a title to a slug as well )
	 * @param        array     [$post_types] - may also be set by $this->post_types = array()
	 * @param        bool      [$show_admin_column]- generate a post list column
	 * @param        bool      [$_post_list_filter] - generate a post list filter
	 *
	 */
	public function __construct( $taxonomy, $post_types = [], $show_admin_column = false, $post_list_filter = false ) {
		$this->post_types = (array) $post_types;

		$this->show_admin_column = $show_admin_column;
		$this->_post_list_filter = $post_list_filter;

		if( !self::$rewrite_checked ){
			add_action( 'init', [ __CLASS__, 'check_rewrite_rules' ], 10000, 0 );
			self::$rewrite_checked = true;
		}

		$this->taxonomy = strtolower( str_replace( ' ', '_', $taxonomy ) );
		$this->hook();
	}


	/**
	 * Hook the taxonomy into worpress
	 */
	public function hook() {
		//so we can add and edit stuff on init hook
		add_action( 'wp_loaded', [ $this, 'register_taxonomy' ], 8, 0 );
		add_action( 'wp_loaded', [ $this, 'register_default_terms' ], 9, 0 );

		if( $this->_post_list_filter ){
			add_action( 'restrict_manage_posts', [ $this, 'post_list_filters' ] );
			if( is_admin() ){
				add_action( 'parse_tax_query', [ $this, 'post_list_query_filters' ] );
			}
		}

	}


	/**
	 * @static
	 *
	 * If the post types registered through this API have changed,
	 * rewrite rules need to be flushed.
	 */
	public static function check_rewrite_rules() {
		if( get_option( 'lipe/lib/schema/taxonomy_registry' ) != self::$taxonomy_registry ){
			add_action( 'init', 'flush_rewrite_rules', 10000, 0 );
			update_option( 'lipe/lib/schema/taxonomy_registry', self::$taxonomy_registry );
		}
	}


	/**
	 * Get a registered taxonomy object
	 *
	 * @static
	 *
	 * @param $taxonomy
	 *
	 * @return Taxonomy|NULL
	 */
	public static function get_taxonomy( $taxonomy ) {
		if( isset( self::$taxonomy_registry[ $taxonomy ] ) ){
			return self::$taxonomy_registry[ $taxonomy ];
		}

		return null;
	}


	/**
	 * Post List Query Filters
	 *
	 * Filters to query to match the taxonomy drop-downs on the post list page
	 *
	 * @uses added to the parse_tax_query action by $this->hook()
	 *
	 * @param \WP_Query $query
	 *
	 * @return void
	 *
	 */
	function post_list_query_filters( $query ) {
		global $pagenow;

		if( ( $pagenow != 'edit.php' ) || empty( $query->query_vars[ 'post_type' ] ) || !in_array( $query->query_vars[ 'post_type' ], $this->post_types ) ){
			return;
		}

		$tax_query = [];
		if( isset( $query->query_vars[ $this->taxonomy ] ) ){
			if( !empty( $query->query_vars[ $this->taxonomy ] ) ){
				if( is_numeric( $query->query_vars[ $this->taxonomy ] ) ){
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
		}

		if( !empty( $tax_query ) ){
			$query->tax_query = new \WP_Tax_Query( $tax_query );
		}

	}


	/**
	 * Post List Filter
	 *
	 * Creates the drop-downs to filter the post list by taxonomy
	 *
	 * @uses added to the restrict_manage_posts hook by $this->hook()
	 *
	 * @return void
	 */
	function post_list_filters() {
		global $typenow, $wp_query;
		$been_filtered = false;

		if( !in_array( $typenow, $this->post_types ) ){
			return;
		}

		$args = [
			'orderby'      => 'name',
			'hierarchical' => true,
			'show_count'   => true,
			'hide_empty'   => true,
		];

		$the_taxonomy = get_taxonomy( $this->taxonomy );

		$args[ 'show_option_all' ] = __( "Show All", 'steelcase' ) . ' ' . $the_taxonomy->label;
		$args[ 'taxonomy' ] = $this->taxonomy;
		$args[ 'name' ] = $this->taxonomy;

		if( !empty( $wp_query->query[ $this->taxonomy ] ) ){
			if( !is_numeric( $wp_query->query[ $this->taxonomy ] ) ){
				$args[ 'selected' ] = get_term_by( 'slug', $wp_query->query[ $this->taxonomy ], $this->taxonomy )->term_id;
			} else {
				$args[ 'selected' ] = $wp_query->query[ $this->taxonomy ];
			}
			$been_filtered = true;
		}
		wp_dropdown_categories( $args );

		if( $been_filtered ){
			?>
            <a style="margin: 1px 8px 0 58px;position: absolute;" href="edit.php?post_type=<?php echo $_GET[ 'post_type' ]; ?>" class="button">
                Clear Filters
            </a>
			<?php
		}

	}


	/**
	 * Set Default Terms
	 *
	 * Specify terms to be registered automatically when a taxonomy is created
	 *
	 * @param array $terms = array( slug' => term, slug => term );
	 *
	 * @return void
	 */
	public function set_default_terms( $terms = [] ) {
		$this->default_terms = $terms;
	}


	public function register_default_terms() {
		if( empty( $this->default_terms ) ){
			return;
		}

		$already_defaulted = get_option( 'lipe/lib/schema/taxonomy_defaults_registry', [] );
		if( !in_array( $this->get_slug(), $already_defaulted ) ){
			// don't do anything if the taxonomy already has terms
			if( !get_terms( $this->taxonomy, [ 'hide_empty' => false, 'number' => 1 ] ) ){
				foreach( $this->default_terms as $slug => $term ){
					$args = [];
					if( !is_numeric( $slug ) ){
						$args[ 'slug' ] = $slug;
					}
					wp_insert_term( $term, $this->taxonomy, $args );
				}
			}
			$already_defaulted[] = $this->get_slug();
			update_option( 'lipe/lib/schema/defaults_registry', $already_defaulted, true );
		}
	}


	/**
	 * Return the slug of the supertype
	 *
	 * @return string supertype slug
	 */
	public function get_slug() {
		if( empty( $this->slug ) ){
			$this->slug = strtolower( str_replace( ' ', '-', $this->taxonomy ) );
		}

		return $this->slug;
	}


	/**
	 * Register this post type with WordPress
	 *
	 * @return void
	 */
	public function register_taxonomy() {
		$response = register_taxonomy( $this->taxonomy, $this->post_types, $this->taxonomy_args() );
		if( !is_wp_error( $response ) ){
			self::$taxonomy_registry[ $this->taxonomy ] = $this;
		}
	}


	/**
	 * Build the args array for the post type definition
	 *
	 * @uses may be overridden using the matching class vars
	 *
	 * @return array
	 */
	protected function taxonomy_args() {
		$args = [
			'labels'                => $this->taxonomy_labels(),
			'public'                => $this->public,
			'show_ui'               => $this->show_ui,
			'show_in_nav_menus'     => $this->show_in_nav_menus,
			'show_admin_column'     => $this->show_admin_column,
			'show_tagcloud'         => $this->show_tagcloud,
			'hierarchical'          => $this->hierarchical,
			'update_count_callback' => $this->update_count_callback,
			'query_var'             => empty( $this->query_var ) ? $this->taxonomy : $this->query_var,
			'rewrite'               => $this->rewrites(),
			'capabilities'          => $this->capabilities,
			'meta_box_cb'           => $this->meta_box_cb,
		];

		$args = apply_filters( 'lipe/lib/schema/taxonomy_args', $args, $this->taxonomy );
		$args = apply_filters( "lipe/lib/schema/taxonomy_args_{$this->taxonomy}", $args );

		return $args;
	}


	/**
	 * Build the labels array for the post type definition
	 *
	 * @param string $single
	 * @param string $plural
	 *
	 * @return array
	 */
	protected function taxonomy_labels( $single = '', $plural = '' ) {
		$single = $single ? $single : $this->get_label( 'singular' );
		$plural = $plural ? $plural : $this->get_label( 'plural' );
		$labels = [
			'name'                       => $plural,
			'singular_name'              => $single,
			'search_items'               => sprintf( __( 'Search %s' ), $plural ),
			'popular_items'              => sprintf( __( 'Popular %s' ), $plural ),
			'all_items'                  => sprintf( __( 'All %s' ), $plural ),
			'parent_item'                => sprintf( __( 'Parent %s' ), $single ),
			'parent_item_colon'          => sprintf( __( 'Parent %s:' ), $single ),
			'edit_item'                  => sprintf( __( 'Edit %s' ), $single ),
			'update_item'                => sprintf( __( 'Update %s' ), $single ),
			'add_new_item'               => sprintf( __( 'Add New %s' ), $single ),
			'new_item_name'              => sprintf( __( 'New %s Name' ), $single ),
			'separate_items_with_commas' => sprintf( __( 'Separate %s with commas' ), $plural ),
			'add_or_remove_items'        => sprintf( __( 'Add or remove %s' ), $plural ),
			'choose_from_most_used'      => sprintf( __( 'Choose from the most used %s' ), $plural ),
			'menu_name'                  => $this->get_menu_label(),
		];

		$labels = apply_filters( 'lipe/lib/schema/taxonomy_labels', $labels, $this->taxonomy );
		$labels = apply_filters( "lipe/lib/schema/taxonomy_labels_{$this->taxonomy}", $labels );

		return $labels;
	}


	public function get_label( $quantity = 'singular' ) {
		switch ( $quantity ){
			case 'plural':
				if( !$this->label_plural ){
					$this->set_label( $this->label_singular );
				}

				return $this->label_plural;
			default:
				if( !$this->label_singular ){
					$this->set_label();
				}

				return $this->label_singular;
		}
	}


	/**
	 * Set Label
	 *
	 * Sets the singular and plural labels automatically
	 *
	 * @since 3.6.14
	 *
	 * @return void
	 * @uses  $this->label_singular
	 * @uses  $this->label_plural
	 *
	 */
	public function set_label( $singular = '', $plural = '' ) {
		if( !$singular ){
			$singular = ucwords( str_replace( '_', ' ', $this->taxonomy ) );
		}
		if( !$plural ){
			if( substr( $singular, - 1 ) == 'y' ){
				$plural = substr( $singular, 0, - 1 ) . 'ies';
			} else {
				$plural = $singular . 's';
			}
		}

		$this->label_singular = $singular;
		$this->label_plural = $plural;
	}


	/**
	 * Get Menu Label
	 *
	 * Returns the set menu label or the plural label if not set
	 *
	 * @since 3.6.14
	 *
	 * @uses  $this->label_menu
	 * @uses  $this->label_plural
	 *
	 * @return string
	 *
	 */
	public function get_menu_label() {
		if( !$this->label_menu ){
			$this->label_menu = $this->label_plural;
		}

		return $this->label_menu;
	}


	/**
	 * Rewrites
	 *
	 * Build rewrite args or pass the the class var if set
	 *
	 * @return array
	 */
	private function rewrites() {
		if( empty( $this->rewrite ) ){
			return [
				'slug'         => $this->get_slug(),
				'with_front'   => false,
				'hierarchical' => $this->hierarchical,
			];
		} else {
			return $this->rewrite;
		}
	}


	/**
	 * Set Menu Label
	 *
	 * Sets the label for the menu
	 *
	 * @since 3.6.14
	 *
	 * @param string $label - the label to set it to
	 *
	 * @uses  $this->label_menu
	 * @uses  $this->label_plural
	 *
	 * @return void
	 *
	 */
	public function set_menu_label( $label ) {
		$this->label_menu = $label;
	}
}
