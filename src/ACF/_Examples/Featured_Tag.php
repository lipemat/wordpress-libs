<?php

namespace Lipe\Project\Post_Meta;

use Lipe\Lib\ACF\Group;

/**
 * Featured_Tag
 *
 * @author  Mat Lipe
 * @since   5/12/2017
 *
 * @package Lipe\Project\Post_Meta
 */
class Featured_Tag extends Meta_Group_Abstract {
	const NAME = 'featured-tag';

	const FEATURED_TAG = 'featured_tag';


	function get_config( $post_types = [] ) {
		$this->key = self::NAME;
		$this->group = new Group( $this->key );
		$this->group->set( 'title', 'Featured Tag' );
		$this->group->set_post_types( $post_types );
		$this->group->set_position( 'acf_after_title' );
		$this->group->set( 'style', 'seamless' );

		$this->add_field( self::FEATURED_TAG, 'Featured Tag', [
			'type'         => 'text',
			'instructions' => 'This tag will display on ribbons for this post on the home page',
		] );

		return $this->group->get_attributes();
	}

}