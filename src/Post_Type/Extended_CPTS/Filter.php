<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

use Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Filter
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type\Extended_CPTS
 */
class Filter {
	protected $CPTS;

	/**
	 *
	 * @see \Lipe\Lib\Post_Type\Extended_CPTS\Filter::set()
	 * @var string
	 */
	protected $filters_array_key;


	/**
	 * Filter constructor.
	 *
	 * @param \Lipe\Lib\Post_Type\Extended_CPTS $CPTS
	 */
	public function __construct( Extended_CPTS $CPTS ) {
		$this->CPTS = $CPTS;
	}


	/**
	 * Store args to cpt object
	 * This must be called from every method that is saving args
	 *
	 * or they will go nowhere
	 *
	 * @internal
	 *
	 * @param [] $args
	 *
	 * @return void
	 */
	public function set( array $args ) {
		if( !isset( $this->filters_array_key ) ){
			$this->filters_array_key = sanitize_title_with_dashes( $args[ 'title' ] );
			$this->CPTS->admin_filters[ $this->filters_array_key ] = [];
		}
		$existing = $this->CPTS->admin_filters[ $this->filters_array_key ];

		$existing = array_merge( $existing, $args );
		$this->CPTS->admin_filters[ $this->filters_array_key ] = $existing;
	}


	/**
	 * Displays a checkbox or a select dropdown for filtering by posts
	 * which have a meta field with the given key,
	 * regardless of its value
	 * (more specifically, if its value isn't empty-like, such as 0 or false).
	 *
	 * If just one value is passed as the meta_fields parameter, a checkbox will be shown:
	 * If multiple values are passed, a select dropdown will be shown for the user to choose from:
	 *
	 * @param string $title
	 * @param array  $meta_fields - [ $meta_key => $label ]
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Filter_Shared
	 */
	public function meta_exists( $title, array $meta_fields ) {
		$_args = [
			'title'       => $title,
			'meta_exists' => $meta_fields,
		];

		$this->set( $_args );

		return new Filter_Shared( $this, $_args );

	}


	/**
	 * Displays a text input for searching for posts that have that value for the given meta key.
	 * Uses a LIKE '%{value}%' query in SQL.
	 *
	 * @param $meta_key
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Admin-filters#post-meta-field-search-box
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Filter_Shared
	 */
	public function meta_search( $title, $meta_key ) {
		$_args = [
			'title'           => $title,
			'meta_search_key' => $meta_key,
		];

		$this->set( $_args );

		return new Filter_Shared( $this, $_args );
	}


	/**
	 * Displays a select dropdown populated with all the existing values for the given meta key:
	 *
	 * You can also manually specify a list of values if you wish, either as a list
	 * or as a callback function:
	 *
	 *
	 * @param string         $title
	 * @param string         $meta_key
	 * @param array|callable $options_or_callback - [ $key => $label ] || function()
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Filter_Shared
	 */
	public function meta( $title, $meta_key, $options_or_callback = null ) {
		$_args = [
			'title'    => $title,
			'meta_key' => $meta_key,
		];
		if( null !== $options_or_callback ){
			$_args[ 'options' ] = $options_or_callback;
		}

		$this->set( $_args );

		return new Filter_Shared( $this, $_args );
	}


	/**
	 * Displays a select dropdown populated with all the available terms for the given taxonomy:
	 *
	 * Note that this filter type requires the Extended Taxonomies library to be present.
	 *
	 * @param string $title
	 * @param string $taxonomy
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Filter_Shared
	 */
	public function taxonomy( $title, $taxonomy ) {
		$_args = [
			'title'    => $title,
			'taxonomy' => $taxonomy,
		];

		$this->set( $_args );

		return new Filter_Shared( $this, $_args );
	}

}