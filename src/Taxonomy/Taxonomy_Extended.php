<?php

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Taxonomy\Extended_TAXOS\Column;

/**
 * Extends our Taxonomy class with support for additional
 * arguments provided by `extended-cpts`.
 *
 * @link https://github.com/johnbillion/extended-cpts/wiki/Registering-taxonomies
 *
 * @see  \register_extended_taxonomy()
 */
class Taxonomy_Extended extends Taxonomy {

	/**
	 * @see \Extended_Taxonomy_Admin::cols()
	 *
	 *
	 * @var array
	 */
	public $admin_cols = [];

	/**
	 * All this does currently is disable hierarchy in the taxonomy's rewrite rules
	 *
	 * @var bool
	 */
	public $allow_hierarchy;

	/**
	 * Whether to always show checked terms at the top of the meta box
	 *
	 * @var bool
	 */
	public $checked_ontop;

	/**
	 * Whether to show this taxonomy on the 'At a Glance' section of the admin dashboard
	 *
	 * @var bool
	 */
	public $dashboard_glance;

	/**
	 * allow only one to be set
	 *
	 * @var bool
	 */
	public $exclusive;

	/**
	 * Use a special meta box structure
	 *
	 * @field 'radio'
	 * @field 'dropdown'
	 * @field 'simple'
	 *
	 * @var string
	 */
	public $meta_box;


	/**
	 * Add a column programmatically.
	 *
	 * Return an object that you can follow along with
	 * to enter all params without memorizing any of them.
	 *
	 * @example admin_cols()->meta( 'Custom Title', 'custom-meta-key' )->set_as_default_sort_column( 'DESC' )
	 *
	 * @return Column
	 */
	public function admin_cols() : Column {
		return new Column( $this );
	}


	/**
	 * Special meta box UI.
	 *
	 * @param 'radio'|'dropdown'|'simple'| callable $type - Type of meta box UI.
	 *
	 * @return void
	 */
	public function meta_box( $type ) : void {
		$this->meta_box = $type;
	}


	protected function get_taxonomy_args() : array {
		$args = $this->taxonomy_args();
		foreach ( get_object_vars( $this ) as $_var => $_value ) {
			if ( property_exists( get_parent_class( $this ), $_var ) ) {
				continue;
			}
			if ( null !== $this->{$_var} ) {
				if ( \is_array( $this->{$_var} ) ) {
					if ( ! empty( $this->{$_var} ) ) {
						$args[ $_var ] = $this->{$_var};
					}
				} else {
					$args[ $_var ] = $this->{$_var};
				}
			}
		}

		return $args;
	}


	public function register_taxonomy() : void {
		register_extended_taxonomy( $this->taxonomy, $this->post_types, $this->get_taxonomy_args() );
	}

}
