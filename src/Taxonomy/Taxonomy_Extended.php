<?php

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Taxonomy\Extended_TAXOS\Column;

/**
 * Taxonomy_Extended
 *
 * Extends our Taxonomy class with support for
 * extended-taxos
 *
 *
 * @see \register_extended_taxonomy()
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
	 * @var null
	 */
	public $allow_hierarchy = null;

	/**
	 * Whether to always show checked terms at the top of the meta box
	 *
	 * @var null
	 */
	public $checked_ontop = null;

	/**
	 * Whether to show this taxonomy on the 'At a Glance' section of the admin dashboard
	 *
	 * @var null
	 */
	public $dashboard_glance = null;

	/**
	 * allow only one to be set
	 *
	 * @var null
	 */
	public $exclusive = null;

	/**
	 * Use a special meta box structure
	 *
	 * @field 'radio'
	 * @field 'dropdown'
	 * @field 'simple'
	 *
	 * @var null
	 */
	public $meta_box = null;

	/**
	 * Add a column pragmatically
	 *
	 * Return an object that you can follow along with
	 * to enter in all params without memorizing any of them
	 *
	 * @example admin_cols()->p2p( 'p2p title', 'p_to_o', 'view' )->set_as_default_sort_column( 'DESC' )
	 *
	 *
	 * @return Column
	 */
	public function admin_cols(){
		return new Column( $this );
	}


	public function meta_box( string $type ) : void {
		$this->meta_box = $type;
	}


	protected function get_taxonomy_args() {
		$args = parent::taxonomy_args();
		foreach( get_object_vars( $this ) as $_var => $_value ){
			if( property_exists( get_parent_class( $this ), $_var ) ){
				continue;
			}
			if( $this->{$_var} !== null ){
				if( is_array( $this->{$_var} ) ){
					if( !empty( $this->{$_var} ) ){
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
