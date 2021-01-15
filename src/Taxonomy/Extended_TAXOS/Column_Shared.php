<?php

namespace Lipe\Lib\Taxonomy\Extended_TAXOS;

use Lipe\Lib\Post_Type\Extended_CPTS\Shared_Abstract;

/**
 * Base class for an Extended TAXOS shared column.
 *
 */
class Column_Shared extends Shared_Abstract {
	protected $column;

	protected $args;


	/**
	 * Column_Shared constructor.
	 *
	 * @param Column $column
	 * @param array  $args
	 */
	public function __construct( Column $column, array $args ) {
		$this->args = $args;
		$this->column = $column;
	}


	/**
	 *
	 * @param array $args
	 *
	 * @return Column_Shared
	 */
	protected function return( array $args ) : Column_Shared {
		$this->column->set( $args );
		return $this;

	}


	/**
	 * Make this column the default sort column instead
	 * of the default 'title'
	 *
	 * @param string $direction - 'ASC', 'DESC' (default 'ASC' )
	 *
	 * @return Column_Shared
	 */
	public function set_as_default_sort_column( $direction = 'ASC' ) : Column_Shared {
		return $this->return( [ 'default' => $direction ] );
	}


}
