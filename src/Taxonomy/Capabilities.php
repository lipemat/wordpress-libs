<?php

namespace Lipe\Lib\Taxonomy;

/**
 * A fluent interface for setting taxonomy capabilities.
 *
 * @link  https://developer.wordpress.org/reference/functions/register_taxonomy
 *
 * @since 3.15.0
 *
 * @internal
 */
class Capabilities {
	/**
	 * @var Taxonomy|Taxonomy_Extended
	 */
	protected $taxonomy;


	public function __construct( Taxonomy $taxonomy ) {
		$this->taxonomy = $taxonomy;
	}


	public function manage_terms( string $capability = 'manage_categories' ) : void {
		$this->taxonomy->capabilities['manage_terms'] = $capability;
	}


	public function edit_terms( string $capability = 'manage_categories' ) : void {
		$this->taxonomy->capabilities['edit_terms'] = $capability;
	}


	public function delete_terms( string $capability = 'manage_categories' ) : void {
		$this->taxonomy->capabilities['delete_terms'] = $capability;
	}


	public function assign_terms( string $capability = 'edit_posts' ) : void {
		$this->taxonomy->capabilities['assign_terms'] = $capability;
	}
}
