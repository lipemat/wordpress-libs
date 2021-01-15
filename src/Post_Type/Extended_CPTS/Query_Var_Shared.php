<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Shared object for interacting with query variables.
 *
 */
class Query_Var_Shared extends Shared_Abstract {
	/**
	 * @var Query_Var
	 */
	protected $query_var;

	/**
	 * For possible future use
	 *
	 * @var array
	 */
	protected $args;


	/**
	 * Query_Var_Shared constructor.
	 *
	 * @param Query_Var $query_var
	 * @param array     $args
	 */
	public function __construct( Query_Var $query_var, array $args ) {
		$this->args = $args;
		$this->query_var = $query_var;
	}


	/**
	 *
	 * @param array $args
	 *
	 * @return Query_Var_Shared
	 */
	protected function return( array $args ) : Query_Var_Shared {
		$this->query_var->set( $args );
		return $this;
	}


	/**
	 * Any filter can be restricted, so it's only available to users
	 * with a given capability by using the cap parameter:
	 *
	 * @param string $capability
	 *
	 * @example 'manage_options'
	 *
	 * @return Query_Var_Shared
	 */
	public function capability( string $capability ) : Query_Var_Shared {
		return $this->return( [ 'cap' => $capability ] );
	}
}
