<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Base class for an Extended CPT shared filter.
 *
 */
class Filter_Shared extends Shared_Abstract{
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
	 * @param Filter $filter
	 * @param array  $args
	 */
	public function __construct( Filter $filter, array $args ) {
		$this->args = $args;
		$this->filter = $filter;
	}


	/**
	 *
	 * @param array $args
	 *
	 * @return Filter_Shared
	 */
	protected function return( array $args ) : Filter_Shared {
		$this->filter->set( $args );
		return $this;
	}


	/**
	 * Any filter can be restricted, so it's only shown to users
	 * with a given capability by using the cap parameter.
	 *
	 * @param string $capability
	 *
	 * @example 'manage_options'
	 *
	 * @return Filter_Shared
	 */
	public function capability( $capability ) : Filter_Shared {
		return $this->return( [ 'cap' => $capability ] );
	}


	/**
	 * The meta_query parameter can be used to pass an array of arguments
	 * to the WP_Meta_Query that's generated when filtering the screen by meta fields.
	 *
	 * @param array $query
	 *
	 * @return Filter_Shared
	 */
	public function meta_query( array $query ) : Filter_Shared {
		return $this->return( [ 'meta_query' => $query ] ); //phpcs:ignore
	}

}
