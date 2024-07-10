<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Meta\MetaType;
use Lipe\Lib\Meta\Mutator_Trait;
use Lipe\Lib\Meta\Repo;

/**
 * Shared methods for interacting with the WordPress taxonomy object.
 *
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
 *
 * @template OPTIONS of array<string, mixed>
 */
trait Taxonomy_Trait {
	/**
	 * @use Mutator_Trait<OPTIONS>
	 */
	use Mutator_Trait;

	/**
	 * Term ID.
	 *
	 * @var int
	 */
	public int $term_id;

	/**
	 * Term object.
	 *
	 * @var ?\WP_Term
	 */
	protected ?\WP_Term $term = null;


	/**
	 * Construct this class with either term object or term ID.
	 *
	 * @param int|\WP_Term $term - Term object or term ID.
	 */
	public function __construct( $term ) {
		if ( is_a( $term, \WP_Term::class ) ) {
			$this->term = $term;
			$this->term_id = $this->term->term_id;
		} else {
			$this->term_id = (int) $term;
		}
	}


	/**
	 * Get the term object.
	 *
	 * @return \WP_Term|null
	 */
	public function get_object(): ?\WP_Term {
		if ( null !== $this->term ) {
			return $this->term;
		}
		$this->term = get_term( $this->term_id );

		return $this->term;
	}


	/**
	 * Get the term ID.
	 *
	 * @return int
	 */
	public function get_id(): int {
		return $this->term_id;
	}


	/**
	 *  Used to determine the type of meta to retrieve or update.
	 *
	 * @return MetaType
	 */
	public function get_meta_type(): MetaType {
		return MetaType::TERM;
	}


	/**
	 * Create a new instance of this class.
	 *
	 * @param int|\WP_Term $term - Term ID or term object.
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $term ) {
		return new static( $term );
	}
}
