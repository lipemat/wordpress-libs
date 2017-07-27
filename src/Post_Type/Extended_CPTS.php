<?php

namespace Lipe\Lib\Post_Type;

/**
 * Register
 *
 * @author  Mat Lipe
 * @since   7/27/2017
 *
 * @package Lipe\Project\Post_Types
 */
class Extended_CPTS extends Custom_Post_Type {

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
	 * Whether to show this post type on the 'At a Glance' section of the admin
	 */
	public $dashboard_glance = null;

	/**
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Other-admin-parameters
	 */
	public $enter_title_here = null;

	/**
	 *
	 *  Text which replaces the 'Featured Image' phrase for this post type
	 */
	public $featured_image = null;

	/**
	 * permastruck
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Custom-permalink-structures
	 */
	public $permastruck = null;

	/**
	 *
	 * Whether to show Quick Edit links for this post type
	 */
	public $quick_edit = null;

	/**
	 * Add the post type to the site's main RSS feed:
	 *
	 */
	public $show_in_feed = null;

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


	protected function get_post_type_args() {
		$args = parent::post_type_args();

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


	public function register_post_type() {
		$post_type = register_extended_post_type( $this->post_type, $this->get_post_type_args() );

		if( !is_wp_error( $post_type ) ){
			parent::$registry[ $this->post_type ] = get_class( $this );
			if( $post_type->args[ 'capability_type' ] != "post" ){
				$this->add_administrator_capabilities( $post_type );
			}

		}
	}

}