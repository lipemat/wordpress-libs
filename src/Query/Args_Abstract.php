<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query;

use Lipe\Lib\Query\Clause\Clause_Abstract;

/**
 * Shared functionality between various Args classes.
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 */
abstract class Args_Abstract {
	/**
	 * Various sub-clauses to be flattened via `get_args`.
	 *
	 * @var Clause_Abstract[]
	 */
	protected array $clauses = [];


	/**
	 * Optionally pass existing arguments to preload this class.
	 *
	 * @param array $existing
	 */
	public function __construct( array $existing = [] ) {
		foreach ( $existing as $arg => $value ) {
			if ( \property_exists( $this, $arg ) ) {
				$this->{$arg} = $value;
			}
		}
	}


	/**
	 * Get the finished arguments as an array.
	 *
	 * @return array
	 */
	public function get_args() : array {
		foreach ( $this->clauses as $clause ) {
			$clause->flatten( $this );
		}

		$args = [];
		foreach ( get_object_vars( $this ) as $_var => $_value ) {
			if ( ! isset( $this->{$_var} ) || 'clauses' === $_var ) {
				continue;
			}
			$args[ $_var ] = $this->{$_var};
		}

		return $args;
	}
}
