<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Sortable_Shared
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type\Custom_Post_Type_Extended
 */
class Sortable_Shared extends Shared_Abstract {

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
	 *
	 * @param array $args
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Sortable_Shared
	 */
	protected function return( array $args ) {
		$this->sortable->set( $args );
		return $this;
	}



	/**
	 * Make this sortable the default orderby
	 * on any FE WP_Query
	 *
	 * @param string $direction - 'ASC', 'DESC' (default 'ASC' )
	 *
	 * @return \Lipe\Lib\Post_Type\Extended_CPTS\Sortable_Shared
	 */
	public function set_as_default_sort_sortable( $direction = 'ASC' ) {
		return $this->return( [ 'default' => $direction ] );
	}

}