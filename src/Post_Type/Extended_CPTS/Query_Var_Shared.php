<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Shared object for interacting with query variables.
 *
 * @author  Mat Lipe
 *
 * @package Lipe\Lib\Post_Type\Custom_Post_Type_Extended
 */
class Query_Var_Shared extends Shared_Abstract {
	/**
	 * @var Query_var
	 */
	protected $query_var;

	/**
	 * For possible future use
	 *
	 * @var array
	 */
	protected $args;


	/**
	 * Query_var_Shared constructor.
	 *
	 * @param Query_var $query_var
	 * @param array     $args
	 */
	function __construct( Query_var $query_var, array $args ) {
		$this->args = $args;
		$this->query_var = $query_var;
	}


	/**
	 *
	 * @param $args
	 *
	 * @return Query_Var_Shared
	 */
	protected function return( array $args ) {
		$this->query_var->set( $args );
		return $this;
	}

	/**
	 * Any filter can be restricted, so it's only available to users
	 * with a given capability by using the cap parameter:
	 *
	 * @param  string $capability
	 *
	 * @example 'manage_options'
	 *
	 * @return Query_Var_Shared
	 */
	public function capability( $capability ) {
		return $this->return( [ 'cap' => $capability ] );
	}
}
