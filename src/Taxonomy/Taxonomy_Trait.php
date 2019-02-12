<?php

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Meta\Mutator_Trait;

/**
 * Trait Taxonomy_Trait
 *
 * @package Lipe\Lib\Taxonomy
 * @since   1.1.0
 */
trait Taxonomy_Trait {
	use Mutator_Trait;

	/**
	 * term_id
	 *
	 * @var int
	 */
	protected $term_id;

	/**
	 * term
	 *
	 * @var \WP_Term
	 */
	protected $term;


	public function __construct( $term_id ) {
		$this->term_id = $term_id;
	}


	public function get_term() {
		if ( null !== $this->term ) {
			return $this->term;
		}
		$this->term = get_term( $this->term_id );

		return $this->term;

	}


	public function get_id() : int {
		return (int) $this->term_id;
	}


	public function get_meta_type() : string {
		return 'term';
	}


	/*************** static *********************/

	/**
	 *
	 * @param $term_id
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $term_id ) {
		return new static( $term_id );
	}

}
