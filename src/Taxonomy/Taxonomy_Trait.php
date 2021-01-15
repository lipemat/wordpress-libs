<?php

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Meta\Mutator_Trait;

/**
 * @property int    $count
 * @property string $description
 * @property string $filter
 * @property string $name
 * @property int    $parent
 * @property string $slug
 * @property string $taxonomy
 * @property int    $term_group
 * @property int    $term_id
 * @property int    $term_taxonomy_id
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


	public function __construct( $term ) {
		if ( is_a( $term, \WP_Term::class ) ) {
			$this->term = $term;
			$this->term_id = $this->term->term_id;
		} else {
			$this->term_id = $term;
		}
	}


	public function get_object() : ?\WP_Term {
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
	 * @param int|\WP_Term $term
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $term ) {
		return new static( $term );
	}

}
