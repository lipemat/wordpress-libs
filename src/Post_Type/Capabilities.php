<?php

namespace Lipe\Lib\Post_Type;

/**
 * A fluent interface for setting post type capabilities.
 *
 * @link https://developer.wordpress.org/reference/functions/register_post_type/#capabilities
 *
 * @internal
 */
class Capabilities {
	/**
	 * Post type object.
	 *
	 * @var Custom_Post_Type
	 */
	protected Custom_Post_Type $post_type;


	/**
	 * Capabilities constructor.
	 *
	 * @param Custom_Post_Type $post_type - Post type object.
	 */
	public function __construct( Custom_Post_Type $post_type ) {
		$this->post_type = $post_type;
		$this->post_type->map_meta_cap = true;
	}


	/**
	 * Set the `edit_post` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function edit_post( string $capability ): Capabilities {
		$this->post_type->capabilities['edit_post'] = $capability;
		return $this;
	}


	/**
	 * Set the `read_post` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function read_post( string $capability ): Capabilities {
		$this->post_type->capabilities['read_post'] = $capability;
		return $this;
	}


	/**
	 * Set the `delete_post` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function delete_post( string $capability ): Capabilities {
		$this->post_type->capabilities['delete_post'] = $capability;
		return $this;
	}


	/**
	 * Set the `edit_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function edit_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['edit_posts'] = $capability;
		return $this;
	}


	/**
	 * Set the `edit_others_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function edit_others_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['edit_others_posts'] = $capability;
		return $this;
	}


	/**
	 * Set the `publish_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function publish_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['publish_posts'] = $capability;
		return $this;
	}


	/**
	 * Set the `read_private_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function read_private_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['read_private_posts'] = $capability;
		return $this;
	}


	/**
	 * Set the `delete_private_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function read( string $capability ): Capabilities {
		$this->post_type->capabilities['read'] = $capability;
		return $this;
	}


	/**
	 * Set the `delete_private_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function delete_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['delete_posts'] = $capability;
		return $this;
	}


	/**
	 * Set the `delete_private_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function delete_private_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['delete_private_posts'] = $capability;
		return $this;
	}


	/**
	 * Set the `delete_published_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function delete_published_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['delete_published_posts'] = $capability;
		return $this;
	}


	/**
	 * Set the `delete_others_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function delete_others_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['delete_others_posts'] = $capability;
		return $this;
	}


	/**
	 * Set the `edit_private_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function edit_private_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['edit_private_posts'] = $capability;
		return $this;
	}


	/**
	 * Set the `edit_published_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function edit_published_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['edit_published_posts'] = $capability;
		return $this;
	}


	/**
	 * Set the `create_posts` capability.
	 *
	 * @param string $capability - Capability to set.
	 *
	 * @return $this
	 */
	public function create_posts( string $capability ): Capabilities {
		$this->post_type->capabilities['create_posts'] = $capability;
		return $this;
	}
}
