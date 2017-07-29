<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Sortable_Shared
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type\Extended_CPTS
 */
class Sortable_Shared {

	protected $sortable;

	/**
	 * For possible future use
	 *
	 * @var array
	 */
	protected $args;


	/**
	 * Sortable_Shared constructor.
	 *
	 * @param \Lipe\Lib\Post_Type\Extended_CPTS\Sortable $sortable
	 * @param array                                      $args
	 */
	function __construct( Sortable $sortable, array $args ) {
		$this->args = $args;
		$this->sortable = $sortable;
	}


	/**
	 * Make this sortable the default orderby
	 * on any FE WP_Query
	 *
	 * @param string $direction - 'ASC', 'DESC' (default 'ASC' )
	 *
	 * @return void
	 */
	public function set_as_default_sort_sortable( $direction = 'ASC' ) {
		$this->sortable->set( [ 'default' => $direction ] );
	}

}