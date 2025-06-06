<?php
declare( strict_types=1 );

namespace Lipe\Lib\Args;

use Lipe\Lib\Query\Clause\Date_Query;
use Lipe\Lib\Query\Clause\Meta_Query;
use Lipe\Lib\Query\Clause\Tax_Query;

/**
 * Shared functionality between various Args classes.
 *
 * @author Mat Lipe
 * @since  4.5.0
 *
 * @template SHAPE of array<string, mixed>
 */
trait Args {
	/**
	 * Various sub-clauses to be flattened via `get_args`.
	 *
	 * @var array<Date_Query|Meta_Query|Tax_Query>
	 */
	protected array $clauses = [];


	/**
	 * Optionally, pass existing arguments to preload this class.
	 *
	 * @phpstan-param SHAPE        $existing
	 *
	 * @param array<string, mixed> $existing - Existing arguments to preload.
	 */
	public function __construct( array $existing ) {
		$this->load_array_into_properties( $existing );
	}


	/**
	 * Merge the arguments from another `ArgsRules` object into this one.
	 *
	 * @phpstan-param ArgsRules<SHAPE> $overrides
	 *
	 * @param ArgsRules                $overrides - Args to override the current ones.
	 *
	 * @return void
	 */
	public function merge( ArgsRules $overrides ): void {
		$this->load_array_into_properties( $overrides->get_args() );
	}


	/**
	 * Get the finished arguments as an array.
	 *
	 * @phpstan-return SHAPE
	 * @return array<string, mixed>
	 */
	public function get_args(): array {
		foreach ( $this->clauses as $clause ) {
			if ( $clause->is_flattended() ) {
				continue;
			}
			$clause->flatten( $this );
			$clause->set_is_flattended( true );
		}

		$args = [];
		$object_vars = Utils::in()->get_public_object_vars( $this );
		foreach ( $object_vars as $_var => $_value ) {
			if ( $_value instanceof ArgsRules ) {
				$args[ $_var ] = $_value->get_args();
				continue;
			}

			if ( ! isset( $this->{$_var} ) ) {
				continue;
			}
			$args[ $_var ] = $this->{$_var};
		}

		return $args;
	}


	/**
	 * Set the arguments for this class based on an array
	 * of values.
	 *
	 * @phpstan-param SHAPE        $existing
	 *
	 * @param array<string, mixed> $existing - Existing arguments to load into properties.
	 *
	 * @return void
	 */
	protected function load_array_into_properties( array $existing ): void {
		foreach ( $existing as $arg => $value ) {
			if ( \property_exists( $this, $arg ) ) {
				$this->{$arg} = $value;
			} else {
				_doing_it_wrong( __METHOD__, esc_html( "Attempting to use the non-existent `{$arg}` argument during the construct of " . __CLASS__ . '.' ), '5.0.0' );
			}
		}
	}
}
