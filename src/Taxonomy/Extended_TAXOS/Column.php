<?php

namespace Lipe\Lib\Taxonomy\Extended_TAXOS;

use Lipe\Lib\Post_Type\Extended_CPTS\Argument_Abstract;
use Lipe\Lib\Taxonomy\Taxonomy_Extended;

/**
 * Base class for an Extended TAXOS argument.
 *
 */
class Column extends Argument_Abstract {

	protected $taxos;

	/**
	 * filters_array_key
	 *
	 * @see \Lipe\Lib\Taxonomy\Extended_TAXOS\Column::set()
	 *
	 * @var string
	 */
	protected $cols_array_key;


	/**
	 * Column constructor.
	 *
	 * @param Taxonomy_Extended $taxos
	 */
	public function __construct( Taxonomy_Extended $taxos ) {
		$this->taxos = $taxos;
	}


	/**
	 * Store args to cpt object
	 * This must be called from every method that is saving args
	 *
	 * or they will go nowhere
	 *
	 * @param array $args
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function set( array $args ) : void {
		if ( ! isset( $this->cols_array_key ) ) {
			$this->cols_array_key = sanitize_title_with_dashes( $args['title'] );
			$this->taxos->admin_cols[ $this->cols_array_key ] = [];
		}
		$existing = $this->taxos->admin_cols[ $this->cols_array_key ];

		$existing = array_merge( $existing, $args );
		$this->taxos->admin_cols[ $this->cols_array_key ] = $existing;
	}

	/**
	 * Store args to taxonomy object
	 * Then return the Column_Shared class
	 *
	 * @param array $args
	 *
	 * @return Column_Shared
	 */
	protected function return( array $args ) : Column_Shared {
		$this->set( $args );
		return new Column_Shared( $this, $args );
	}


	/**
	 * If you don't want to use one of Extended CPTS built-in column types,
	 * you can use a callback function to output your column value by using the function parameter.
	 * Anything callable can be passed as the value, such as a function name or a closure.
	 *
	 * @param string      $title
	 * @param callable    $callback
	 * @param string|null $cap - Capability required to see this column.
	 *
	 * @return Column_Shared
	 */
	public function custom( string $title, callable $callback, ?string $cap = null ) : Column_Shared {
		$_args = [
			'title'    => $title,
			'function' => $callback,
			'cap'      => $cap,
		];
		return $this->return( $_args );
	}


	/**
	 * Display the value of a meta field by using the meta_key parameter:
	 *
	 * If the meta field represents a Unix or MySQL timestamp,
	 * you can format the output as such using the date_format parameter.
	 * The value gets passed to PHP's date() function,
	 * so any standard date format is accepted.
	 *
	 *
	 * @param string $title
	 * @param string $meta_key
	 * @param string|null   $date_format
	 * @param null|string   $cap - Capability required to see this meta.
	 *
	 * @return Column_Shared
	 */
	public function meta( string $title, string $meta_key, ?string $date_format = null, ?string $cap = null ) : Column_Shared {
		$_args = [
			'title'    => $title,
			'meta_key' => $meta_key,
			'cap'      => $cap,
		];
		if ( null !== $date_format ) {
			$_args['date_format'] = $date_format;
		}

		return $this->return( $_args );
	}

}
