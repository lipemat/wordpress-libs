<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Query_Var_Shared
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Post_Type\Extended_CPTS
 */
class Query_Var_Shared {
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
	 * @param \Lipe\Lib\Post_Type\Extended_CPTS\Query_var $query_var
	 * @param array                                      $args
	 */
	function __construct( Query_var $query_var, array $args ) {
		$this->args = $args;
		$this->query_var = $query_var;
	}

	/**
	 * Any filter can be restricted so it's only available to users
	 * with a given capability by using the cap parameter:
	 *
	 * @param  string $capability
	 *
	 * @example 'manage_options'
	 *
	 * @return void
	 */
	public function capability( $capability ) {
		$this->query_var->set( [ 'cap' => $capability ] );
	}
}