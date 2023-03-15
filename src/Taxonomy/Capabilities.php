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
	 * @var Taxonomy
	 */
	protected Taxonomy $taxonomy;


	public function __construct( Taxonomy $taxonomy ) {
		$this->taxonomy = $taxonomy;
	}


	public function manage_terms( string $capability = 'manage_categories' ) : Capabilities {
		$this->taxonomy->capabilities['manage_terms'] = $capability;
		return $this;
	}


	public function edit_terms( string $capability = 'manage_categories' ) : Capabilities {
		$this->taxonomy->capabilities['edit_terms'] = $capability;
		return $this;
	}


	public function delete_terms( string $capability = 'manage_categories' ) : Capabilities {
		$this->taxonomy->capabilities['delete_terms'] = $capability;
		return $this;
	}


	public function assign_terms( string $capability = 'edit_posts' ) : Capabilities {
		$this->taxonomy->capabilities['assign_terms'] = $capability;
		return $this;
	}
}
