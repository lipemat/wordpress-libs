<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query;

use Lipe\Lib\Query\Clause\Date_Query;
use Lipe\Lib\Query\Clause\Meta_Query;
use Lipe\Lib\Query\Clause\Tax_Query;

/**
 * Shared functionality between various Args classes.
 *
 * @author Mat Lipe
 * @since  4.5.0
 */
trait Args_Trait {
	/**
	 * Various sub-clauses to be flattened via `get_args`.
	 *
	 * @var array<Date_Query|Meta_Query|Tax_Query>
	 */
	protected array $clauses = [];

	/**
	 * Subclasses which contain their own args to be flattened via `get_args`.
	 *
	 * The array key is the property name, and the value is the class to be flattened.
	 *
	 * @var array<string, Args_Interface>
	 */
	protected array $sub_args = [];


	/**
	 * Optionally pass existing arguments to preload this class.
	 *
	 * @param array $existing - Existing arguments to preload.
	 *
	 * @phpstan-ignore-next-line -- Using default `$existing` value for backwards compatibility.
	 */
	public function __construct( array $existing = [] ) {
		foreach ( $existing as $arg => $value ) {
			if ( \property_exists( $this, $arg ) ) {
				$this->{$arg} = $value;
			} else {
				// phpcs:ignore -- `trigger_error` is used to prevent IDE inspections for unhandled exceptions.
				trigger_error( esc_html( "Attempting to use the non-existent `{$arg}` argument during the construct of " . __CLASS__ . '.' ) );
			}
		}
	}


	/**
	 * Merge the arguments from another Args_Interface object into this one.
	 *
	 * @param Args_Interface $overrides - Args to override the current ones.
	 *
	 * @return void
	 */
	public function merge( Args_Interface $overrides ): void {
		$this->__construct( $overrides->get_args() );
	}


	/**
	 * Get the finished arguments as an array.
	 *
	 * @return array<string, mixed>
	 */
	public function get_args(): array {
		foreach ( $this->clauses as $clause ) {
			$clause->flatten( $this );
		}
		foreach ( $this->sub_args as $prop => $sub_class ) {
			$this->{$prop} = $sub_class->get_args();
		}

		$args = [];
		foreach ( get_object_vars( $this ) as $_var => $_value ) {
			if ( ! isset( $this->{$_var} ) || 'clauses' === $_var || 'sub_args' === $_var ) {
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
	 * @noinspection MagicMethodsValidityInspection
	 *
	 * @param string $name  - Name of non-existent property.
	 * @param mixed  $value - Value attempted to set, which we don't care about.
	 *
	 * @throws \LogicException - Any usage throws.
	 *
	 * @phpstan-return no-return
	 * @return void
	 */
	public function __set( string $name, mixed $value ) { //phpcs:ignore -- $value is required in the magic method.
		/* translators: {property name} {class name} */
		throw new \LogicException( \sprintf( esc_html__( 'Attempting to use the non-existent `%1$s` argument on %2$s.', 'lipe' ), esc_html( $name ), __CLASS__ ) );
	}
}
