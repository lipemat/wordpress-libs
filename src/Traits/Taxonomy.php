<?php

namespace Lipe\Lib\Traits;

trait Taxonomy {

	/**
	 * current
	 *
	 * @static
	 * @var self()
	 */
	static $current;

	/**
	 * tax
	 *
	 * @static
	 * @var \Lipe\Lib\Schema\Taxonomy $tax
	 */
	public static $tax;

	/**
	 * term_id
	 *
	 * @var int
	 */
	public $term_id;

	/**
	 * term
	 *
	 * @var object
	 */
	public $term = null;


	public function __construct( $term_id ) {
		$this->term_id = $term_id;
		self::$current = $this;
	}


	/***** Static *************/

	public static function register_taxonomy() {
		self::$tax = new \Lipe\Lib\Schema\Taxonomy( static::NAME );
	}


	public function get_term() {
		if( $this->term != null ){
			return $this->term;
		}
		$this->term = get_term( $this->term_id, static::NAME );

		return $this->term;

	}

}