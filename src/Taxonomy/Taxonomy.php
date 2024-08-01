<?php
// phpcs:disable WordPress.WP.I18n -- Using global translations.
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Taxonomy\Taxonomy\Menu;
use Lipe\Lib\Taxonomy\Taxonomy\Register_Taxonomy;
use Lipe\Lib\Traits\Memoize;
use Lipe\Lib\Util\Actions;
use Lipe\Lib\Util\Strings;

/**
 * Register taxonomy with WordPress.
 *
 * Follows many of the standard `register_taxonomy` arguments with some
 * customizations and additional features.
 *
 * @link   https://developer.wordpress.org/reference/functions/register_taxonomy/
 *
 * @notice Must be constructed before the `init` hook runs
 *
 * @phpstan-import-type REWRITE from Register_Taxonomy
 * @phpstan-import-type DEFAULT from Register_Taxonomy
 */
class Taxonomy {
	use Memoize;

	protected const REGISTRY_OPTION = 'lipe/lib/schema/taxonomy_registry';

	/**
	 * Track the register taxonomies for later use.
	 *
	 * @var Taxonomy[]
	 */
	protected static array $registry = [];

	/**
	 * Array of post types to attach this taxonomy to.
	 *
	 * @var string[]
	 */
	public readonly array $post_types;

	/**
	 * Array of capabilities for this taxonomy.
	 *
	 * @var Capabilities
	 */
	public readonly Capabilities $capabilities;

	/**
	 * Override any generated labels.
	 *
	 * Usually calling `Taxonomy::set_label` covers any required changes.
	 * Updating this property will fine tune existing or set special not included ones.
	 *
	 * @see      get_taxonomy_labels
	 * @see      Taxonomy::get_taxonomy_labels()
	 *
	 * @var Labels
	 */
	public readonly Labels $labels;

	/**
	 * The taxonomy slug.
	 *
	 * @var string
	 */
	public readonly string $name;

	/**
	 * The arguments to pass to `register_taxonomy()`.
	 *
	 * @see Taxonomy::get_taxonomy_args()
	 *
	 * @var Register_Taxonomy
	 */
	public readonly Register_Taxonomy $register_args;

	/**
	 * Array of arguments to automatically use inside `wp_get_object_terms()` for this taxonomy.
	 *
	 * @var Get_Terms
	 */
	protected Get_Terms $args;

	/**
	 * Terms to be automatically added to a taxonomy when
	 * it's registered.
	 *
	 * @var array<string|int, string>
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
	 * @param string   $taxonomy   - Taxonomy Slug.
	 * @param string[] $post_types - Post types to attach this taxonomy to.
	 */
	public function __construct( string $taxonomy, array $post_types ) {
		$this->post_types = $post_types;
		$this->name = $taxonomy;
		$this->labels = new Labels( $this );
		$this->capabilities = new Capabilities( $this );
		$this->register_args = new Register_Taxonomy( [] );

		$this->labels();
		$this->hook();
	}


	/**
	 * Hook the taxonomy into WordPress
	 *
	 * @return void
	 */
	protected function hook(): void {
		// So we can add and edit stuff on init hook.
		add_action( 'wp_loaded', function() {
			$this->register();
		}, 8, 0 );
		add_action( 'restrict_manage_posts', function() {
			$this->post_list_filters();
		} );
		if ( is_admin() ) {
			// If some taxonomies are not registered on the front end.
			add_action( 'wp_loaded', function() {
				$this->static_once( fn() => $this->check_rewrite_rules(), 'check_rewrite_rules' );
			}, 1_000 );
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
		return $this->capabilities;
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
	 * @phpstan-param Meta_Box::TYPE_* $type
	 *
	 * @param string                   $type          - The type of UI to render.
	 * @param bool                     $checked_ontop - Move checked items to top.
	 *
	 * @return void
	 */
	public function meta_box( string $type, bool $checked_ontop = false ): void {
		$box = new Meta_Box( $this->name, $type, $checked_ontop );
		$this->register_args->meta_box_sanitize_cb = [ $box, 'translate_string_term_ids_to_int' ];
	}


	/**
	 * Provide a callback function for the meta box display.
	 *
	 * @see      Taxonomy::meta_box()
	 *
	 * @since    5.0.0
	 *
	 * @formatter:off
	 * @phpstan-param false|callable(\WP_Post,array{args: array{taxonomy: string}, id: string, title: string}): void $callback
	 * @phpstan-param callable(string,mixed): (int|string)[]                                                         $sanitize
	 *
	 * @param callable|false $callback - Callback function for the meta box display.
	 * @param callable       $sanitize - Callback function for sanitizing taxonomy data saved from a meta box.
	 * @formatter:on
	 *
	 * @return void
	 */
	public function custom_meta_box( callable|false $callback, callable $sanitize ): void {
		$this->register_args->meta_box_cb = $callback;
		$this->register_args->meta_box_sanitize_cb = $sanitize;
	}


	/**
	 * Creates the drop-downs to filter the post list by this taxonomy
	 *
	 * @action restrict_manage_posts 10 0
	 *
	 * @return void
	 */
	protected function post_list_filters(): void {
		global $typenow, $wp_query;
		if ( ! $this->post_list_filter || ! \in_array( $typenow, $this->post_types, true ) ) {
			return;
		}
		if ( ! $wp_query instanceof \WP_Query ) {
			return;
		}

		$args = new Wp_Dropdown_Categories( [] );
		$args->orderby = 'name';
		$args->value_field = 'slug';
		$args->hierarchical = true;
		$args->show_count = true;
		$args->hide_empty = true;
		/* translators: Plural label of taxonomy. */
		$args->show_option_all = \sprintf( __( 'All %s' ), $this->labels->get_label( 'name' ) ?? $this->labels->get_label( 'singular_name' ) ?? '' );
		$args->taxonomy = $this->name;
		$args->name = $this->name;

		if ( isset( $wp_query->query[ $this->name ] ) && '' !== $wp_query->query[ $this->name ] ) {
			$args->selected = (string) $wp_query->query[ $this->name ];
			add_action( 'manage_posts_extra_tablenav', function() {
				$this->static_once( fn() => $this->clear_filters_button(), 'clear_filters_button' );
			}, 1_000 );
		}

		wp_dropdown_categories( $args->get_args() );
	}


	/**
	 * Specify terms to be added automatically when a taxonomy is created.
	 *
	 * @param array<int|string, string> $terms = array( <slug> => <name> ) || array( <name> ).
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
		add_filter( "manage_edit-{$this->name}_columns", function( $columns ) use ( $column ) {
			unset( $columns[ $column ] );
			return $columns;
		} );
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
		$this->register_args->show_admin_column = true;
		if ( '' === $label ) {
			return;
		}
		Actions::in()->add_filter_all( array_map( function( $post_type ) {
			return "manage_{$post_type}_posts_columns";
		}, $this->post_types ), function( array $columns ) use ( $label ) {
			$columns[ 'taxonomy-' . $this->name ] = $label;
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
	public function default_term( string $slug, string $name, string $description = '' ): void {
		$this->register_args->default_term = [
			'description' => $description,
			'name'        => $name,
			'slug'        => $slug,
		];
	}


	/**
	 * Show the taxonomy in the admin menu under a specific menu and priority.
	 *
	 * - By default will simply enable the taxonomy to show in the menu.
	 * - Use the `parent_menu` method to add a top-level menu item.
	 * - Use the `sub_menu` method to add a sub-menu item.
	 *
	 * @since 5.0.0
	 *
	 * @return Menu
	 */
	public function show_in_menu(): Menu {
		$this->register_args->show_in_menu = true;
		return new Menu( $this );
	}


	/**
	 * Show or hide this post type in the REST API.
	 *
	 * @since    5.0.0
	 *
	 * @see      Custom_Post_Type::rest_controllers()
	 *
	 * @formatter:off
	 * @phpstan-param class-string<\WP_REST_Controller> $controller
	 *
	 * @param bool    $show       - Whether to show in REST.
	 * @param ?string $base       - The base to use. Defaults to the taxonomy.
	 * @param string  $space      - The namespace to use.
	 * @param string  $controller - The controller class to use.
	 * @formatter:on
	 *
	 * @return void
	 */
	public function show_in_rest( bool $show = true, ?string $base = null, string $space = 'wp/v2', string $controller = \WP_REST_Terms_Controller::class ): void {
		$this->register_args->show_in_rest = $show;

		if ( $show ) {
			$this->register_args->rest_base = $base ?? $this->name;
			$this->register_args->rest_namespace = $space;
			$this->register_args->rest_controller_class = $controller;
		} else {
			unset( $this->register_args->rest_base, $this->register_args->rest_namespace, $this->register_args->rest_controller_class );
		}
	}


	/**
	 * Query arguments to automatically use inside `wp_get_object_terms()`
	 * for this taxonomy.
	 *
	 * @param Get_Terms $query_args - The arguments to use.
	 */
	public function args( Get_Terms $query_args ): void {
		$this->args = $query_args;
	}


	/**
	 * Include a description of the taxonomy.
	 *
	 * @param string $description - The description to use.
	 */
	public function description( string $description ): void {
		$this->register_args->description = $description;
	}


	/**
	 * Is this taxonomy hierarchical (have descendants) like categories
	 * or not hierarchical like tags.
	 *
	 * @default false
	 *
	 * @param bool $is_hierarchical - Whether to make the taxonomy hierarchical.
	 */
	public function hierarchical( bool $is_hierarchical ): void {
		$this->register_args->hierarchical = $is_hierarchical;
	}


	/**
	 * Whether a taxonomy is intended for use publicly either via the
	 * admin interface or by front-end users.
	 * The default settings of `$publicly_queryable`, `$show_ui`,
	 * and `$show_in_nav_menus` are inherited from `$public`.
	 *
	 * @default true
	 *
	 * @param bool $is_public - Whether to make the taxonomy public.
	 */
	public function public( bool $is_public ): void {
		$this->register_args->public = $is_public;
	}


	/**
	 * Whether the taxonomy is publicly queryable.
	 *
	 * @default `$public`
	 *
	 * @param bool $is_queryable - Whether to allow public queries.
	 */
	public function publicly_queryable( bool $is_queryable ): void {
		$this->register_args->publicly_queryable = $is_queryable;
	}


	/**
	 * False to disable the query_var, set as string to use
	 * custom query_var instead of default.
	 *
	 * True is not seen as a valid entry and will result in 404 issues.
	 *
	 * @default `$taxonomy`
	 *
	 * @param false|string $query_var - Custom query var to use.
	 */
	public function query_var( bool|string $query_var ): void {
		$this->register_args->query_var = $query_var;
	}


	/**
	 * Triggers the handling of rewrites for this taxonomy.
	 *
	 * Default true, using `$taxonomy` as slug.
	 *
	 * - To prevent a rewrite, set to false.
	 * - To specify rewrite rules, an array can be passed with any of these keys:
	 *   `array{
	 *      slug?: string
	 *      with_front?: bool
	 *      hierarchical?: bool
	 *      ep_mask?: int
	 *   }`
	 *
	 * @phpstan-param bool|REWRITE $rewrite
	 *
	 * @param array|bool           $rewrite - Configuration for rewrites.
	 */
	public function rewrite( bool|array $rewrite ): void {
		$this->register_args->rewrite = $rewrite;
	}


	/**
	 * True makes this taxonomy available for selection in navigation menus.
	 *
	 * @default `$public`
	 *
	 * @param bool $show - Whether to show in nav menus.
	 */
	public function show_in_nav_menus( bool $show ): void {
		$this->register_args->show_in_nav_menus = $show;
	}


	/**
	 * Whether to show the taxonomy in the quick/bulk edit panel
	 *
	 * @default `$show_ui`
	 *
	 * @param bool $show - Whether to show in the quick edit panel.
	 */
	public function show_in_quick_edit( bool $show ): void {
		$this->register_args->show_in_quick_edit = $show;
	}


	/**
	 * Whether to allow the Tag Cloud widget to use this taxonomy.
	 *
	 * @default `$show_ui`
	 *
	 * @param bool $show - Whether to show the tag cloud.
	 */
	public function show_tagcloud( bool $show ): void {
		$this->register_args->show_tagcloud = $show;
	}


	/**
	 * Whether to generate a default UI for managing this taxonomy.
	 *
	 * @notice  `$show_in_rest` must be true to show in Gutenberg.
	 *
	 * @default `$public`
	 *
	 * @param bool $show - Whether to show the UI.
	 */
	public function show_ui( bool $show ): void {
		$this->register_args->show_ui = $show;
	}


	/**
	 * Whether terms in this taxonomy should be sorted in the
	 * order they are provided to `wp_set_object_terms()`
	 *
	 * @default false
	 *
	 * @param bool $should_short - Whether to sort the terms.
	 */
	public function sort( bool $should_short ): void {
		$this->register_args->sort = $should_short;
	}


	/**
	 * Works much like a hook, in that it will be called when the count is updated.
	 *
	 * Defaults:
	 * - `_update_post_term_count()` for taxonomies attached to post types, which confirms
	 * that the objects are published before counting them.
	 * - `_update_generic_term_count()` for taxonomies attached to other object types, such as users.
	 *
	 * @phpstan-param callable(int[],\WP_Taxonomy): void $update_cb
	 *
	 * @formatter:off
	 * @param callable $update_cb - Callback function to use.
	 * @formatter:on
	 */
	public function update_count_callback( callable $update_cb ): void {
		$this->register_args->update_count_callback = $update_cb;
	}


	/**
	 * Handles any calls, which need to run to register this taxonomy.
	 *
	 * @action wp_loaded 8 0
	 *
	 * @return void
	 */
	protected function register(): void {
		register_taxonomy( $this->name, $this->post_types, $this->get_taxonomy_args() );
		static::$registry[ $this->name ] = $this;
		if ( \count( $this->initial_terms ) > 0 ) {
			$this->insert_initial_terms();
		}
	}


	/**
	 * Sets the singular and plural labels automatically.
	 *
	 * @param string $singular - The singular label to use.
	 * @param string $plural   - The plural label to use.
	 *
	 * @return Labels
	 */
	public function labels( string $singular = '', string $plural = '' ): Labels {
		if ( '' === $singular ) {
			$singular = \ucwords( \str_replace( [ '-', '_' ], ' ', $this->name ) );
		}
		if ( '' === $plural ) {
			$plural = Strings::in()->pluralize( $singular );
		}

		$this->labels->singular_name( $singular );
		$this->labels->name( $plural );
		return $this->labels;
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
		$cap = $this->capabilities->get_cap( 'edit_terms' ) ?? 'manage_categories';
		if ( ! current_user_can( $cap ) ) {
			return;
		}
		add_action( 'admin_bar_menu', function( \WP_Admin_Bar $wp_admin_bar ) {
			$wp_admin_bar->add_menu( [
				'id'     => 'new-' . $this->name,
				'title'  => $this->labels->get_label( 'singular_name' ) ?? '',
				'parent' => 'new-content',
				'href'   => admin_url( 'edit-tags.php?taxonomy=' . $this->name ),
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

		if ( ! isset( $already_defaulted[ $this->name ] ) ) {
			// Don't do anything if the taxonomy already has terms.
			$existing = get_terms( [
				'taxonomy' => $this->name,
				'fields'   => 'count',
			] );
			if ( \is_numeric( $existing ) && 0 === (int) $existing ) {
				foreach ( $this->initial_terms as $slug => $term ) {
					$args = [];
					if ( ! \is_numeric( $slug ) ) {
						$args['slug'] = $slug;
					}
					wp_insert_term( $term, $this->name, $args );
				}
			}
			$already_defaulted[ $this->name ] = 1;
			update_option( 'lipe/lib/taxonomy/defaults-registry', $already_defaulted, true );
		}
	}


	/**
	 * Build the args array for the taxonomy definition
	 *
	 * @return array<string, mixed>
	 */
	protected function get_taxonomy_args(): array {
		$args = $this->register_args;

		$args->capabilities = $this->capabilities->get_capabilities();
		$args->description ??= '';
		$args->hierarchical ??= false;
		$args->labels = $this->get_taxonomy_labels();
		$args->public ??= true;
		$args->publicly_queryable ??= $args->public;
		$args->rewrite = $this->get_rewrites();
		$args->show_in_nav_menus ??= $args->public;
		$args->show_ui ??= $args->public;
		$args->sort ??= false;
		if ( isset( $this->args ) ) {
			$args->args = $this->args->get_args();
		}

		$args = apply_filters( 'lipe/lib/taxonomy/args', $args->get_args(), $this->name );
		return apply_filters( "lipe/lib/taxonomy/args_{$this->name}", $args );
	}


	/**
	 * Build the labels array for the post type definition
	 *
	 * @param string|null $single - The singular label to use.
	 * @param string|null $plural - The plural label to use.
	 *
	 * @return array<Labels::*, string>
	 */
	protected function get_taxonomy_labels( ?string $single = null, ?string $plural = null ): array {
		$single = $single ?? $this->labels->get_label( 'singular_name' );
		$plural = (string) ( $plural ?? $this->labels->get_label( 'name' ) );
		$menu = $this->labels->get_label( 'menu_name' ) ?? $this->labels->get_label( 'name' );

		$labels = [
			'name'                       => $plural,
			'singular_name'              => $single,
			'search_items'               => \sprintf( __( 'Search %s' ), $plural ),
			'popular_items'              => \sprintf( __( 'Popular %s' ), $plural ),
			'all_items'                  => \sprintf( __( 'All %s' ), $plural ),
			'parent_item'                => \sprintf( __( 'Parent %s' ), $single ),
			'parent_item_colon'          => \sprintf( __( 'Parent %s:' ), $single ),
			'edit_item'                  => \sprintf( __( 'Edit %s' ), $single ),
			'view_item'                  => \sprintf( __( 'View %s' ), $single ),
			'update_item'                => \sprintf( __( 'Update %s' ), $single ),
			'add_new_item'               => \sprintf( __( 'Add New %s' ), $single ),
			'new_item_name'              => \sprintf( __( 'New %s Name' ), $single ),
			'separate_items_with_commas' => \sprintf( __( 'Separate %s with commas' ), $plural ),
			'add_or_remove_items'        => \sprintf( __( 'Add or remove %s' ), $plural ),
			'choose_from_most_used'      => \sprintf( __( 'Choose from the most used %s' ), $plural ),
			'not_found'                  => \sprintf( __( 'No %s found' ), $plural ),
			'no_terms'                   => \sprintf( __( 'No %s' ), $plural ),
			'no_item'                    => \sprintf( __( 'No %s' ), \strtolower( $plural ) ), // For extended taxos.
			'items_list_navigation'      => \sprintf( __( '%s list navigation' ), $plural ),
			'items_list'                 => \sprintf( __( '%s list' ), $plural ),
			'most_used'                  => __( 'Most Used' ),
			'back_to_items'              => \sprintf( __( '&larr; Back to %s' ), $plural ),
			'menu_name'                  => $menu,
		];
		$labels = wp_parse_args( $this->labels->get_labels(), $labels );

		$labels = apply_filters( 'lipe/lib/taxonomy/labels', $labels, $this->name );
		return apply_filters( "lipe/lib/taxonomy/labels_{$this->name}", $labels );
	}


	/**
	 * Build rewrite args or pass the class var if set.
	 *
	 * @phpstan-return REWRITE|bool
	 * @return array|bool
	 */
	protected function get_rewrites(): array|bool {
		return $this->register_args->rewrite ?? [
			'slug'         => sanitize_title_with_dashes( $this->name ),
			'with_front'   => false,
			'hierarchical' => $this->register_args->hierarchical ?? false,
		];
	}


	/**
	 * If the taxonomies registered through this API have changed,
	 * rewrite rules need to be flushed.
	 *
	 * @action wp_loaded 1_000 0
	 */
	protected function check_rewrite_rules(): void {
		$slugs = \array_keys( static::$registry );
		if ( get_option( self::REGISTRY_OPTION ) !== $slugs ) {
			flush_rewrite_rules();
			update_option( self::REGISTRY_OPTION, $slugs );
		}
	}


	/**
	 * Render a button to clear the filters on the post list page.
	 *
	 * @action manage_posts_extra_tablenav 1000
	 */
	protected function clear_filters_button(): void {
		// phpcs:ignore WordPress.Security.NonceVerification -- No nonce is available.
		$post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';
		if ( '' !== $post_type ) {
			$base_url = admin_url( 'edit.php?post_type=' . $post_type );
		} else {
			$base_url = admin_url( 'edit.php' );
		}
		?>
		<a
			href="<?= esc_url( $base_url ) ?>"
			class="button lipe-libs-taxonomy-clear-filters"
		>
			<?php esc_html_e( 'Clear Filters', 'lipe' ); ?>
		</a>
		<?php
	}


	/**
	 * Get a registered taxonomy object.
	 *
	 * @param string $taxonomy - Taxonomy slug.
	 *
	 * @return ?Taxonomy
	 */
	public static function get_taxonomy( string $taxonomy ): ?Taxonomy {
		return static::$registry[ $taxonomy ] ?? null;
	}
}
