<?php

namespace Lipe\Lib\Taxonomy\Extended_TAXOS;

/**
 * Column_Shared
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Taxonomy\Extended_TAXOS
 */
class Column_Shared {
	protected $column;

	protected $args;


	/**
	 * Column_Shared constructor.
	 *
	 * @param \Lipe\Lib\Taxonomy\Extended_TAXOS\Column $column
	 * @param array                                    $args
	 */
	function __construct( Column $column, array $args ) {
		$this->args = $args;
		$this->column = $column;
	}


	/**
	 * Make this column the default sort column instead
	 * of the default 'title'
	 *
	 * @param string $direction - 'ASC', 'DESC' (default 'ASC' )
	 *
	 * @return void
	 */
	public function set_as_default_sort_column( $direction = 'ASC' ) {
		$this->column->set( [ 'default' => $direction ] );
	}


}