<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Filter_Shared
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type\Extended_CPTS
 */
class Filter_Shared {
	protected $filter;

	/**
	 * For possible future use
	 *
	 * @var array
	 */
	protected $args;


	/**
	 * Filter_Shared constructor.
	 *
	 * @param \Lipe\Lib\Post_Type\Extended_CPTS\Filter $filter
	 * @param array                                    $args
	 */
	function __construct( Filter $filter, array $args ) {
		$this->args = $args;
		$this->filter = $filter;
	}


	/**
	 * Any filter can be restricted so it's only shown to users
	 * with a given capability by using the cap parameter:
	 *
	 * @param  string $capability
	 *
	 * @example 'manage_options'
	 *
	 * @return void
	 */
	public function capability( $capability ) {
		$this->filter->set( [ 'cap' => $capability ] );
	}


	/**
	 * The meta_query parameter can be used to pass an array of arguments
	 * to the WP_Meta_Query that's generated when filtering the screen by meta fields.
	 *
	 * @param array $query
	 *
	 * @return void
	 */
	public function meta_query( array $query ){
		$this->filter->set( [ 'meta_query' => $query ] );
	}

}