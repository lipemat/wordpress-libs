<?php

namespace Lipe\Lib\Post_Type;

/**
 * Capabilities
 *
 * Make all capabilities of a post type to methods which we may
 * interact with.
 *
 * @author  Mat Lipe
 * @since   1.6.0
 *
 * @internal
 *
 * @package Lipe\Lib\Post_Type
 */
class Capabilities {
	/**
	 * post_type
	 *
	 * @var Custom_Post_Type_Extended|Custom_Post_Type
	 */
	private $post_type;


	public function __construct( Custom_Post_Type $post_type ) {
		$this->post_type               = $post_type;
		$this->post_type->map_meta_cap = true;
	}


	public function edit_post( string $capability ) : void {
		$this->post_type->capabilities['edit_post'] = $capability;
	}


	public function read_post( string $capability ) : void {
		$this->post_type->capabilities['read_post'] = $capability;
	}


	public function delete_post( string $capability ) : void {
		$this->post_type->capabilities['delete_post'] = $capability;
	}


	public function edit_posts( string $capability ) : void {
		$this->post_type->capabilities['edit_posts'] = $capability;
	}


	public function edit_others_posts( string $capability ) : void {
		$this->post_type->capabilities['edit_others_posts'] = $capability;
	}


	public function publish_posts( string $capability ) : void {
		$this->post_type->capabilities['publish_posts'] = $capability;
	}


	public function read_private_posts( string $capability ) : void {
		$this->post_type->capabilities['read_private_posts'] = $capability;
	}


	public function read( string $capability ) : void {
		$this->post_type->capabilities['read'] = $capability;
	}


	public function delete_posts( string $capability ) : void {
		$this->post_type->capabilities['delete_posts'] = $capability;
	}


	public function delete_private_posts( string $capability ) : void {
		$this->post_type->capabilities['delete_private_posts'] = $capability;
	}


	public function delete_published_posts( string $capability ) : void {
		$this->post_type->capabilities['delete_published_posts'] = $capability;
	}


	public function delete_others_posts( string $capability ) : void {
		$this->post_type->capabilities['delete_others_posts'] = $capability;
	}


	public function edit_private_posts( string $capability ) : void {
		$this->post_type->capabilities['edit_private_posts'] = $capability;
	}


	public function edit_published_posts( string $capability ) : void {
		$this->post_type->capabilities['edit_published_posts'] = $capability;
	}


	public function create_posts( string $capability ) : void {
		$this->post_type->capabilities['create_posts'] = $capability;
	}
}
