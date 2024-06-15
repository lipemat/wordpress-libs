<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

/**
 * A fluent interface for setting taxonomy capabilities.
 *
 * @link  https://developer.wordpress.org/reference/functions/register_taxonomy
 *
 * @since 3.15.0
 *
 * @see   Taxonomy::capabilities()
 */
class Capabilities {
	public const ASSIGN_TERMS = 'assign_terms';
	public const DELETE_TERMS = 'delete_terms';
	public const EDIT_TERMS   = 'edit_terms';
	public const MANAGE_TERMS = 'manage_terms';

	/**
	 * Any capabilities that have been set.
	 *
	 * @var array<self::*, string>
	 */
	protected array $capabilities = [];


	/**
	 * Capabilities constructor.
	 *
	 * @param Taxonomy $taxonomy - The taxonomy object.
	 */
	public function __construct(
		protected Taxonomy $taxonomy
	) {
	}


	/**
	 * Set the 'manage_terms' capability.
	 *
	 * @param string $capability - The capability to set.
	 *
	 * @return Capabilities
	 */
	public function manage_terms( string $capability = 'manage_categories' ): Capabilities {
		return $this->set( 'manage_terms', $capability );
	}


	/**
	 * Set the 'edit_terms' capability.
	 *
	 * @param string $capability - The capability to set.
	 *
	 * @return Capabilities
	 */
	public function edit_terms( string $capability = 'manage_categories' ): Capabilities {
		return $this->set( 'edit_terms', $capability );
	}


	/**
	 * Set the 'delete_terms' capability.
	 *
	 * @param string $capability - The capability to set.
	 *
	 * @return Capabilities
	 */
	public function delete_terms( string $capability = 'manage_categories' ): Capabilities {
		return $this->set( 'delete_terms', $capability );
	}


	/**
	 * Set the 'assign_terms' capability.
	 *
	 * @param string $capability - The capability to set.
	 *
	 * @return Capabilities
	 */
	public function assign_terms( string $capability = 'edit_posts' ): Capabilities {
		return $this->set( 'assign_terms', $capability );
	}


	/**
	 * Set a capability.
	 *
	 * @phpstan-param self::* $key
	 *
	 * @param string          $key   - Key for the capability.
	 * @param string          $value - The capability to set.
	 *
	 * @return Capabilities
	 */
	protected function set( string $key, string $value ): Capabilities {
		$this->capabilities[ $key ] = $value;
		return $this;
	}


	/**
	 * Get the capability for a specific capability.
	 *
	 * @phpstan-param self::* $capability
	 *
	 * @param string          $capability - The capability to get.
	 *
	 * @return ?string
	 */
	public function get_cap( string $capability ): ?string {
		return $this->capabilities[ $capability ] ?? null;
	}


	/**
	 * Get the capabilities that have been set.
	 *
	 * @return array<self::*, string>
	 */
	public function get_capabilities(): array {
		return $this->capabilities;
	}
}
