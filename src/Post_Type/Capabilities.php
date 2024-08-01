<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

/**
 * A fluent interface for setting post type capabilities.
 *
 * @link https://developer.wordpress.org/reference/functions/register_post_type/#capabilities
 *
 * @see  Custom_Post_Type::capabilities()
 */
class Capabilities {
	public const CREATE_POSTS           = 'create_posts';
	public const DELETE_OTHERS_POSTS    = 'delete_others_posts';
	public const DELETE_POST            = 'delete_post';
	public const DELETE_POSTS           = 'delete_posts';
	public const DELETE_PRIVATE_POSTS   = 'delete_private_posts';
	public const DELETE_PUBLISHED_POSTS = 'delete_published_posts';
	public const EDIT_OTHERS_POSTS      = 'edit_others_posts';
	public const EDIT_POST              = 'edit_post';
	public const EDIT_POSTS             = 'edit_posts';
	public const EDIT_PRIVATE_POSTS     = 'edit_private_posts';
	public const EDIT_PUBLISHED_POSTS   = 'edit_published_posts';
	public const PUBLISH_POSTS          = 'publish_posts';
	public const READ                   = 'read';
	public const READ_POST              = 'read_post';
	public const READ_PRIVATE_POSTS     = 'read_private_posts';

	/**
	 * @var array<self::*, string>
	 */
	protected array $capabilities = [];


	/**
	 * Capabilities constructor.
	 *
	 * @param Custom_Post_Type $post_type - Post type object.
	 */
	public function __construct(
		protected Custom_Post_Type $post_type
	) {
	}


	/**
	 * Set the `edit_post` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function edit_post( string $capability ): Capabilities {
		return $this->set( 'edit_post', $capability );
	}


	/**
	 * Set the `read_post` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function read_post( string $capability ): Capabilities {
		return $this->set( 'read_post', $capability );
	}


	/**
	 * Set the `delete_post` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function delete_post( string $capability ): Capabilities {
		return $this->set( 'delete_post', $capability );
	}


	/**
	 * Set the `edit_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function edit_posts( string $capability ): Capabilities {
		return $this->set( 'edit_posts', $capability );
	}


	/**
	 * Set the `edit_others_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function edit_others_posts( string $capability ): Capabilities {
		return $this->set( 'edit_others_posts', $capability );
	}


	/**
	 * Set the `publish_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function publish_posts( string $capability ): Capabilities {
		return $this->set( 'publish_posts', $capability );
	}


	/**
	 * Set the `read_private_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function read_private_posts( string $capability ): Capabilities {
		return $this->set( 'read_private_posts', $capability );
	}


	/**
	 * Set the `delete_private_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function read( string $capability ): Capabilities {
		return $this->set( 'read', $capability );
	}


	/**
	 * Set the `delete_private_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function delete_posts( string $capability ): Capabilities {
		return $this->set( 'delete_posts', $capability );
	}


	/**
	 * Set the `delete_private_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function delete_private_posts( string $capability ): Capabilities {
		return $this->set( 'delete_private_posts', $capability );
	}


	/**
	 * Set the `delete_published_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function delete_published_posts( string $capability ): Capabilities {
		return $this->set( 'delete_published_posts', $capability );
	}


	/**
	 * Set the `delete_others_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function delete_others_posts( string $capability ): Capabilities {
		return $this->set( 'delete_others_posts', $capability );
	}


	/**
	 * Set the `edit_private_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function edit_private_posts( string $capability ): Capabilities {
		return $this->set( 'edit_private_posts', $capability );
	}


	/**
	 * Set the `edit_published_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function edit_published_posts( string $capability ): Capabilities {
		return $this->set( 'edit_published_posts', $capability );
	}


	/**
	 * Set the `create_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return Capabilities
	 */
	public function create_posts( string $capability ): Capabilities {
		return $this->set( 'create_posts', $capability );
	}


	/**
	 * Set the capability.
	 *
	 * Also sets the post type to map meta capabilities.
	 *
	 * @phpstan-param self::* $capability_name
	 *
	 * @param string          $capability_name - Capability name to set.
	 * @param string          $capability      - Capability to set.
	 *
	 * @return Capabilities
	 */
	protected function set( string $capability_name, string $capability ): Capabilities {
		$this->capabilities[ $capability_name ] = $capability;
		$this->post_type->map_meta_cap( true );
		return $this;
	}


	/**
	 * Get the capability for a specific capability.
	 *
	 * @phpstan-param self::* $capability_name
	 *
	 * @param string          $capability_name - The capability to get.
	 *
	 * @return ?string
	 */
	public function get_cap( string $capability_name ): ?string {
		return $this->capabilities[ $capability_name ] ?? null;
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
