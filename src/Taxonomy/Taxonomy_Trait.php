<?php

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Meta\Repo;

/**
 * Trait Taxonomy_Trait
 *
 * @package Lipe\Lib\Taxonomy
 * @since   1.1.0
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
		if ( null !== $this->term ) {
			return $this->term;
		}
		$this->term = get_term( $this->term_id );

		return $this->term;

	}


	public function get_id() : int {
		return (int) $this->term_id;
	}


	/**
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_meta( string $key, $default = null ) {
		$value = Repo::instance()->get_value( $this->term_id, $key, 'term' );
		if ( null !== $default && empty( $value ) ) {
			return $default;
		}

		return $value;
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
