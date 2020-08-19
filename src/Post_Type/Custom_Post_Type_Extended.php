<?php

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Post_Type\Extended_CPTS\Column;
use Lipe\Lib\Post_Type\Extended_CPTS\Filter;
use Lipe\Lib\Post_Type\Extended_CPTS\Query_Var;
use Lipe\Lib\Post_Type\Extended_CPTS\Sortable;

/**
 * Extends our Custom_Post_Type class with support
 * for extended-cpts
 *
 * @author  Mat Lipe
 *
 * @package Lipe\Lib\Post_Type
 */
class Custom_Post_Type_Extended extends Custom_Post_Type {

	/**
	 * admin_cols
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Admin-columns
	 */
	public $admin_cols = [];

	/**
	 * admin_filters
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Admin-filters
	 */
	public $admin_filters = [];

	/**
	 * Add params the post type archive query
	 *
	 * @example
	 * # Show all posts on the post type archive:
	 *    ['nopaging' => true ]
	 *
	 * @var array
	 */
	public $archive = [];

	/**
	 * Force the use of the block editor for this post type.
	 * Must be used in combination with the `show_in_rest` argument.
	 * The primary use of this argument is to prevent the block editor
	 * from being used by setting it to false when `show_in_rest` is set to true.
	 *
	 * @var bool
	 */
	public $block_editor;

	/**
	 * Whether to show this post type on the 'At a Glance' section of the admin
	 */
	public $dashboard_glance;

	/**
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Other-admin-parameters
	 */
	public $enter_title_here;

	/**
	 * rewrite
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Custom-permalink-structures
	 */
	public $rewrite;

	/**
	 *
	 * Whether to show Quick Edit links for this post type
	 */
	public $quick_edit;

	/**
	 * Add the post type to the site's main RSS feed:
	 *
	 */
	public $show_in_feed;

	/**
	 * site_sortables
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Query-vars-for-sorting
	 */
	public $site_sortables = [];

	/**
	 * site_filters
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Query-vars-for-filtering
	 */
	public $site_filters = [];


	/**
	 * Allows a custom permalink structure to be specified via the permastruct
	 * parameter in the rewrite argument.
	 *
	 * @param string $permastruct
	 *
	 * @link     https://github.com/johnbillion/extended-cpts/wiki/Custom-permalink-structures#examples
	 *
	 * @example  '/foo/%custom_tax%/%article%'
	 *
	 * @return void
	 */
	public function rewrite( string $permastruct ) : void {
		$this->rewrite['permastruct'] = $permastruct;
	}

	/**
	 * Extended CPTs provides a mechanism for registering public query vars
	 * which allow users to filter your post type archives by various fields.
	 * This also works in WP_Query, although the main advantage
	 * is the fact these are public query vars accessible via URL parameters.
	 *
	 * Think of these as the front-end equivalent of list table filters in the admin area,
	 * minus the UI.
	 *
	 * It also allows you to filter posts in WP_Query thusly:
	 *
	 * @link    https://github.com/johnbillion/extended-cpts/wiki/Query-vars-for-filtering#example
	 * @example new WP_Query( array(
	 * 'post_type' => 'article',
	 * $query_var    => 'bar',
	 * ) );
	 *
	 * @example test.loc/articles/?{$query_var}=bar
	 *
	 *
	 * @return Query_Var
	 */
	public function site_filters() : Query_Var {
		return new Query_Var( $this );
	}


	/**
	 * Extended CPTs provides a mechanism for registering values for the public
	 * orderby query var, which allows users to sort your post type archives
	 * by various fields.
	 * This also works in WP_Query, which makes ordering custom post type
	 * listings very powerful and dead easy.
	 *
	 * Think of these as the front-end equivalent of sortable columns
	 * in the admin area, minus the UI.
	 *
	 * @example
	 * new WP_Query( array(
	 * 'post_type' => 'article',
	 * 'orderby'   => $sort_key,
	 * 'order'     => 'DESC',
	 * ) );
	 *
	 *
	 * @return Sortable
	 */
	public function site_sortables() : Sortable {
		return new Sortable( $this );
	}


	/**
	 * Add a column programmatically
	 *
	 * Return an object that you can follow along with
	 * to enter all params without memorizing any of them.
	 *
	 * @example admin_cols()->p2p( 'p2p title', 'p_to_o', 'view' )->set_as_default_sort_column( 'DESC' )
	 *
	 *
	 * @return Column
	 */
	public function admin_cols() : Column {
		return new Column( $this );
	}


	/**
	 * Add a filter programmatically
	 *
	 * Returns an object that you can follow along with
	 * to enter in all the params without memorizing any of them
	 *
	 * @return Filter
	 */
	public function admin_filters() : Filter {
		return new Filter( $this );
	}


	protected function get_post_type_args() : array {
		$args = $this->post_type_args();

		foreach ( get_object_vars( $this ) as $_var => $_value ) {
			if ( property_exists( get_parent_class( $this ), $_var ) ) {
				continue;
			}
			if ( isset( $this->{$_var} ) ) {
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


	/**
	 * Register the post type using args from our normal
	 * Custom_Post_Type class and this class
	 *
	 */
	public function register_post_type() : void {
		\register_extended_post_type( $this->post_type, $this->get_post_type_args() );
	}

}
