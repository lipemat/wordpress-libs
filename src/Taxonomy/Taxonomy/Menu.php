<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy\Taxonomy;

use Lipe\Lib\Taxonomy\Taxonomy;
use Lipe\Lib\Theme\Dashicons;

/**
 * A custom handler for adding taxonomy to the admin menu.
 * - Sub menu
 * - Parent menu
 *
 * Will replace the default taxonomy menu with a custom one since
 * WP does not support custom taxonomy menu locations OTB.
 *
 * @author Mat Lipe
 * @since  5.0.0
 *
 * @see    Taxonomy::show_in_menu()
 */
class Menu {
	/**
	 * The slug of the parent menu to add this taxonomy to.
	 *
	 * @var string
	 */
	protected string $parent_menu;


	/**
	 * Build an instance of the Menu class.
	 *
	 * @param Taxonomy $taxonomy - Taxonomy object.
	 */
	public function __construct(
		protected Taxonomy $taxonomy
	) {
	}


	/**
	 * Add the taxonomy to the admin menu as a sub menu.
	 *
	 * @param string $parent_menu - The slug of the parent menu to add this taxonomy to.
	 * @param int    $position    - The position in the menu to place this taxonomy.
	 */
	public function sub_menu( string $parent_menu, int $position = 100 ): void {
		$this->taxonomy->register_args->show_in_menu = false;

		add_action( 'admin_menu', function() use ( $parent_menu, $position ) {
			add_submenu_page(
				$parent_menu,
				$this->get_menu_name(),
				$this->get_menu_name(),
				$this->get_capability(),
				$this->get_edit_url(),
				position: $position
			);
			$this->add_parent_file_filter( $parent_menu );
		} );
	}


	/**
	 * Add the taxonomy to the admin menu as a parent menu.
	 *
	 * @param string|Dashicons $icon     - The icon to use for the menu.
	 *                                   URL, SVG, 'none' or Dashicons class.
	 * @param int|null         $position - The position in the menu to place this taxonomy.
	 */
	public function parent_menu( string|Dashicons $icon = 'dashicons-category', ?int $position = null ): void {
		$this->taxonomy->register_args->show_in_menu = false;

		add_action( 'admin_menu', function() use ( $icon, $position ) {
			$parent_menu = $this->get_edit_url();
			add_menu_page(
				$this->get_menu_name(),
				$this->get_menu_name(),
				$this->get_capability(),
				$parent_menu,
				icon_url: $icon instanceof Dashicons ? $icon->value : $icon,
				position: $position
			);
			$this->add_parent_file_filter( $parent_menu );
		} );
	}


	/**
	 * Get the name of the menu.
	 *
	 * @return string
	 */
	protected function get_menu_name(): string {
		$tax = get_taxonomy( $this->taxonomy->name );
		if ( $tax instanceof \WP_Taxonomy ) {
			return \esc_attr( $tax->labels->menu_name );
		}
		return '';
	}


	/**
	 * Get the capability required to manage this taxonomy.
	 *
	 * @return string
	 */
	protected function get_capability(): string {
		$tax = get_taxonomy( $this->taxonomy->name );
		if ( $tax instanceof \WP_Taxonomy ) {
			return $tax->cap->manage_terms;
		}
		return 'manage_categories';
	}


	/**
	 * Get the URL of to edit this taxonomy.
	 *
	 * @return string
	 */
	protected function get_edit_url(): string {
		$edit_tags_file = 'edit-tags.php?taxonomy=%s';
		return \sprintf( $edit_tags_file, $this->taxonomy->name );
	}


	/**
	 * Add a filter to set the current menu to the custom parent.
	 *
	 * @param string $parent_menu - Parent menu provided to the taxonomy.
	 */
	protected function add_parent_file_filter( string $parent_menu ): void {
		$this->parent_menu = $parent_menu;
		add_filter( 'parent_file', fn( string $current ) => $this->set_current_menu( $current ) );
	}


	/**
	 * Set the current admin menu, so the correct one is highlighted.
	 * Only used when $this->menu_configuration['parent'] is set to a slug of a menu.
	 *
	 * @filter parent_file 10 1
	 *
	 * @param string $current_parent - Pre-filtered parent menu.
	 *
	 * @return string
	 */
	protected function set_current_menu( string $current_parent ): string {
		$screen = \get_current_screen();
		if ( null === $screen ) {
			return $current_parent;
		}
		if ( "edit-{$this->taxonomy->name}" === $screen->id && $this->taxonomy->name === $screen->taxonomy ) {
			return $this->parent_menu;
		}

		return $current_parent;
	}
}
