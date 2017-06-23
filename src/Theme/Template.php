<?php

namespace Lipe\Lib\Theme;

use Lipe\Lib\Traits\Singleton;

class Template {
	use Singleton;


	/**
	 * Render of an array of attributes to be used in markup
	 *
	 * @param    [] $atts
	 *
	 * @return    string
	 */
	function esc_attr( array $atts ) {
		$e = [];
		foreach( $atts as $k => $v ){
			if( is_array( $v ) || is_object( $v ) ){
				$v = json_encode( $v );
			} elseif( is_bool( $v ) ) {
				$v = $v ? 1 : 0;
			} elseif( is_string( $v ) ) {
				$v = trim( $v );
			}
			$e[] = $k . '="' . esc_attr( $v ) . '"';
		}

		return implode( ' ', $e );
	}


	/**
	 * Check if we on a a 'post' post type page
	 * For determining if we should have a blog
	 * style layout etc.
	 * Searches:
	 * - blog page template
	 * - post archive
	 * - single post
	 * - category
	 * - date and 'post' post type
	 *
	 * @return bool
	 */
	function is_posts_page() {
		if( is_page_template( 'page_blog.php' ) ||
		    is_post_type_archive( 'post' ) ||
		    is_singular( 'post' ) ||
		    is_category() ||
		    ( is_date() && get_post_type() == 'post' )
		){
			return true;

		} else {
			return false;
		}
	}


	/**
	 * Removes the post meta and info from the output
	 *
	 * @uses  can be called anywhere before the loop
	 */
	function remove_post_data() {
		add_action( 'genesis_before_loop', function () {
			remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
			remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
			remove_action( 'genesis_before_post_content', 'genesis_post_info' );
			remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
		} );
	}


	/**
	 * Change Layout
	 *
	 * Changes the pages layout
	 *
	 * @uses    call this anytime before the get_head() hook
	 * @uses    - defaults to 'full-width-content'
	 *
	 * @param string $layout - desired layout
	 *                       -  'full-width-content'
	 *                       -  'content-sidebar'
	 *                       -  'sidebar-content'
	 *                       -  'content-sidebar-sidebar'
	 *                       -  'sidebar-sidebar-content'
	 *                       -  'sidebar-content-sidebar'
	 *
	 * @example may be used in the single() or before() hooks etc
	 *
	 * @return void
	 */
	function change_layout( $layout = 'full-width-content' ) {
		add_filter( 'genesis_site_layout', function () use ( $layout ) {
			return $layout;
		} );
	}

}
