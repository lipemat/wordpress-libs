<?php

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Meta\Meta_Repo;

trait Taxonomy_Trait {

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
	protected $term = null;


	public function __construct( $term_id ) {
		$this->term_id = $term_id;
	}


	public function get_term() {
		if( $this->term != null ){
			return $this->term;
		}
		$this->term = get_term( $this->term_id );

		return $this->term;

	}


	public function get_meta( $key ) {
		return Meta_Repo::instance()->get_meta( $this->term_id, $key );
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