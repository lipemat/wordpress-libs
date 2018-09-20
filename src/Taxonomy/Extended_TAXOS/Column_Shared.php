<?php

namespace Lipe\Lib\Taxonomy\Extended_TAXOS;

use Lipe\Lib\Post_Type\Extended_CPTS\Shared_Abstract;

/**
 * Column_Shared
 *
 * @author  Mat Lipe
 * @since   7/29/2017
 *
 * @package Lipe\Lib\Taxonomy\Taxonomy_Extended
 */
class Column_Shared extends Shared_Abstract {
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
	 *
	 * @param array $args
	 *
	 * @return \Lipe\Lib\Taxonomy\Extended_TAXOS\Column_Shared
	 */
	protected function return( array $args ) {
		$this->column->set( $args );
		return $this;

	}


	/**
	 * Make this column the default sort column instead
	 * of the default 'title'
	 *
	 * @param string $direction - 'ASC', 'DESC' (default 'ASC' )
	 *
	 * @return \Lipe\Lib\Taxonomy\Extended_TAXOS\Column_Shared
	 */
	public function set_as_default_sort_column( $direction = 'ASC' ) {
		return $this->return( [ 'default' => $direction ] );
	}


}