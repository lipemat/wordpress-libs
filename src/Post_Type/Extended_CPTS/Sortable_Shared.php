<?php

namespace Lipe\Lib\Post_Type\Extended_CPTS;

/**
 * Base class for an Extended CPT shared sortable.
 *
 */
class Sortable_Shared extends Shared_Abstract {
	/**
	 * @var Sortable
	 */
	protected Sortable $sortable;

	/**
	 * For possible future use
	 *
	 * @var array
	 */
	protected array $args;


	/**
	 * Sortable_Shared constructor.
	 *
	 * @param Sortable $sortable
	 * @param array    $args
	 */
	public function __construct( Sortable $sortable, array $args ) {
		$this->args = $args;
		$this->sortable = $sortable;
	}


	/**
	 *
	 * @param array $args
	 *
	 * @return Sortable_Shared
	 */
	protected function return( array $args ) : Sortable_Shared {
		$this->sortable->set( $args );
		return $this;
	}


	/**
	 * Make this sortable the default orderby
	 * on any FE WP_Query
	 *
	 * @param string $direction - 'ASC', 'DESC' (default 'ASC' ).
	 *
	 * @return Sortable_Shared
	 */
	public function set_as_default_sort_sortable( string $direction = 'ASC' ) : Sortable_Shared {
		return $this->return( [ 'default' => $direction ] );
	}

}
