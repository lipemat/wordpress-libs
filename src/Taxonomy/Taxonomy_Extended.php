<?php

declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Taxonomy\Extended_TAXOS\Column;

/**
 * Extends our Taxonomy class with support for additional
 * arguments provided by `extended-cpts`.
 *
 * @link https://github.com/johnbillion/extended-cpts/wiki/Registering-taxonomies
 *
 * @see  register_extended_taxonomy()
 *
 * @phpstan-type META_CALLBACK callable(\WP_Post, array{
 *         args:mixed,
 *         callback:callable,
 *         id:string,id:title
 *      }): string
 */
class Taxonomy_Extended extends Taxonomy {

	/**
	 * Admin screen columns to show for this taxonomy.
	 *
	 * @see \Extended_Taxonomy_Admin::cols()
	 *
	 * @var array<string,mixed>
	 */
	public array $admin_cols = [];

	/**
	 * All this does currently is disable the hierarchy in the taxonomy's rewrite rules.
	 *
	 * @var bool
	 */
	public bool $allow_hierarchy;

	/**
	 * Whether to always show checked terms at the top of the meta box
	 *
	 * @var bool
	 */
	public bool $checked_ontop;

	/**
	 * Whether to show this taxonomy on the 'At a Glance' section of the admin dashboard
	 *
	 * @var bool
	 */
	public bool $dashboard_glance;

	/**
	 * This parameter isn't feature complete. All it does currently is set the meta box
	 * to the 'radio' meta box, thus meaning any given post can only have one term
	 * associated with it for that taxonomy.
	 *
	 * 'exclusive' isn't really the right name for this, as terms aren't exclusive to a
	 * post, but rather each post can exclusively have only one term. It's not feature
	 * complete because you can edit a post in Quick Edit and give it more than one term
	 * from the taxonomy.
	 *
	 * @var bool
	 */
	public bool $exclusive;

	/**
	 * The name of the custom meta box to use on the post editing screen for this taxonomy.
	 *
	 * Three custom meta boxes are provided:
	 *
	 *  - 'radio' for a meta box with radio inputs
	 *  - 'simple' for a meta box with a simplified list of checkboxes
	 *  - 'dropdown' for a meta box with a dropdown menu
	 *  - `callback` for a custom meta box
	 *  - `false` remove the meta box
	 *
	 * You can also pass the name of a callback function, eg `my_super_meta_box()`,
	 * or boolean `false` to remove the meta box.
	 *
	 * Default `null`, meaning the standard meta box is used.
	 *
	 * @phpstan-var 'radio'|'dropdown'|'simple'|META_CALLBACK|false
	 *
	 * @var string|callable|false
	 */
	protected $meta_box;


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
