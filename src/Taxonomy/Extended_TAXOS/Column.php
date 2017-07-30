<?php

namespace Lipe\Lib\Taxonomy\Extended_TAXOS;

use Lipe\Lib\Taxonomy\Extended_TAXOS;

/**
 * Column
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Taxonomy\Extended_TAXOS
 */
class Column {

	protected $TAXOS;

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
	 * @param \Lipe\Lib\Taxonomy\Extended_TAXOS $TAXOS
	 */
	public function __construct( Extended_TAXOS $TAXOS ) {
		$this->TAXOS = $TAXOS;
	}


	/**
	 * Store args to cpt object
	 * This must be called from every method that is saving args
	 *
	 * or they will go nowhere
	 *
	 * @internal
	 *
	 * @param [] $args
	 *
	 * @return void
	 */
	public function set( array $args ) {
		if( !isset( $this->cols_array_key ) ){
			$this->cols_array_key = sanitize_title_with_dashes( $args[ 'title' ] );
			$this->TAXOS->admin_cols[ $this->cols_array_key ] = [];
		}
		$existing = $this->TAXOS->admin_cols[ $this->cols_array_key ];

		$existing = array_merge( $existing, $args );
		$this->TAXOS->admin_cols[ $this->cols_array_key ] = $existing;
	}

	/**
	 * Store args to taxonomy object
	 * Then return the Column_Shared class
	 *
	 * @param array $args
	 *
	 * @return \Lipe\Lib\Taxonomy\Extended_TAXOS\Column_Shared
	 */
	protected function return( array $args ){
		$this->set( $args );
		return new Column_Shared( $this, $args );
	}


	/**
	 * If you don't want to use one of Extended CPT's built-in column types,
	 * you can use a callback function to output your column value by using the function parameter.
	 * Anything callable can be passed as the value, such as a function name or a closure.
	 *
	 * @param string   $title
	 * @param callable $callback
	 *
	 * @return \Lipe\Lib\Taxonomy\Extended_TAXOS\Column_Shared
	 */
	public function custom( $title, $callback ) {
		$_args = [
			'title'    => $title,
			'function' => $callback,
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
	 * @param string $date_format
	 *
	 * @return \Lipe\Lib\Taxonomy\Extended_TAXOS\Column_Shared
	 */
	public function meta( $title, $meta_key, $date_format = null ) {
		$_args = [
			'title'    => $title,
			'meta_key' => $meta_key,
		];
		if( null !== $date_format ){
			$_args[ 'date_format' ] = $date_format;
		}

		return $this->return( $_args );
	}

}