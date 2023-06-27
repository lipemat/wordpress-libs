<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query;

use Lipe\Lib\Query\Clause\Clause_Abstract;

/**
 * Shared functionality between various Args classes.
 *
 * @author Mat Lipe
 * @since  4.0.0
 */
abstract class Args_Abstract {
	/**
	 * Various sub-clauses to be flattened via `get_args`.
	 *
	 * @var array<Clause_Abstract<static>>
	 */
	protected array $clauses = [];


	/**
	 * Optionally pass existing arguments to preload this class.
	 *
	 * @param array $existing - Existing arguments to preload.
	 */
	public function __construct( array $existing = [] ) {
		foreach ( $existing as $arg => $value ) {
			if ( \property_exists( $this, $arg ) ) {
				$this->{$arg} = $value;
			} else {
				//phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
				trigger_error( esc_html( "Attempting to use the non-existent `{$arg}` argument during the construct of " . __CLASS__ . '.' ) );
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


	/**
	 * Prevent setting any non-existent properties on this class.
	 *
	 * If the property does not exist, the argument is not supported.
	 *
	 * @param string $name  - Name of non-existent property.
	 * @param mixed  $value - Value attempted to set, which we don't care about.
	 *
	 * @throws \LogicException - Any usage throws.
	 *
	 * @return void
	 */
	public function __set( string $name, $value ) {
		/* translators: {property name} {class name} */
		throw new \LogicException( sprintf( __( 'Attempting to use the non-existent `%1$s` argument on %2$s.', 'lipe' ), $name, __CLASS__ ) );
	}
}
