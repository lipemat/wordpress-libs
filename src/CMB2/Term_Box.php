<?php

namespace Lipe\Lib\CMB2;

/**
 * A fluent interface for a CMB2 taxonomy meta box.
 */
class Term_Box extends Box {

	/**
	 * If object_types is set to 'term', and set to false,
	 * will remove the fields from the new-term screen.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#new_term_section
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
	 * it is required to provide a taxonomies property,
	 * which should be an array of Taxonomies.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Box-Properties#taxonomies
	 *
	 * @example array( 'category', 'post_tag' ),
	 *
	 * @var string[]
	 */
	public array $taxonomies;


	/**
	 * Term_Box constructor.
	 *
	 * @param string   $id         - Meta box ID.
	 * @param string[] $taxonomies - Taxonomies to add meta box to.
	 * @param string   $title      - Meta box title.
	 */
	public function __construct( $id, array $taxonomies, $title ) {
		$this->taxonomies = $taxonomies;
		parent::__construct( $id, [ 'term' ], $title );
	}
}
