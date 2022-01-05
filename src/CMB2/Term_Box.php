<?php

namespace Lipe\Lib\CMB2;

/**
 * CMB2 taxonomy meta box fluent interface.
 */
class Term_Box extends Box {

	/**
	 * if object_types is set to 'term', and set to false,
	 * will remove the fields from the new-term screen.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Box-Properties#new_term_section
	 *
	 * @default true
	 *
	 * @example false
	 *
	 * @var string
	 */
	public $new_term_section;

	/**
	 * If object_types is set to 'term',
	 * it is required to provide a the taxonomies property,
	 * which should be an array of Taxonomies.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Box-Properties#taxonomies
	 *
	 * @example array( 'category', 'post_tag' ),
	 *
	 * @var string[]
	 */
	public $taxonomies;


	public function __construct( $id, array $taxonomies, $title ) {
		$this->taxonomies = $taxonomies;
		parent::__construct( $id, [ 'term' ], $title );
	}
}
