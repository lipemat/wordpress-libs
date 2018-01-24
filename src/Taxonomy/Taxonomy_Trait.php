<?php

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Meta\Meta_Repo;

/**
 * Trait Taxonomy_Trait
 *
 * @package Lipe\Lib\Taxonomy
 * @since 1.1.0
 */
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


	/**
	 *
	 * @param string $key
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_meta( string $key ) {
		return Meta_Repo::instance()->get_meta( $this->term_id, $key, 'term' );
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
