<?php

namespace Lipe\Lib\Menu;

use Lipe\Lib\Post_Type\Post_Object_Trait;

/**
 * Nav Menu Item post type returned from `wp_get_nav_menu_items`.
 *
 * Same as other post types except additional properties are added
 * by `wp_setup_nav_menu_item`.
 *
 * @since 3.7.0
 *
 * @property int    $db_id
 * @property int    $menu_item_parent
 * @property int    $object_id
 * @property string $object
 * @property string $post_type
 * @property string $type_label
 * @property string $url
 * @property string $title
 * @property string $target
 * @property string $attr_title
 * @property string $description
 * @property array  $classes
 * @property string $xfn
 *
 */
trait Menu_Item_Trait {
	use Post_Object_Trait;

	/**
	 * Retrieve the post then run it through `wp_setup_nav_menu_item`
	 * to add additional properties.
	 *
	 * Also, automatically adds properties to a `WP_Post` passed to `factory`
	 * without coming from `wp_get_nav_menu_items`.
	 *
	 * @return \WP_Post|null
	 */
	public function get_object() : ?\WP_Post {
		if ( null === $this->post ) {
			$this->post = get_post( $this->post_id );
		}
		if ( ! empty( $this->post ) ) {
			if ( ! property_exists( $this->post, 'db_id' ) ) {
				$this->post = wp_setup_nav_menu_item( $this->post );
			}
			if ( ! _is_valid_nav_menu_item( $this->post ) ) {
				$this->post = null;
			}
		}

		return $this->post;
	}


	/**
	 * Pass either an ID of the menu item, or a WP_Post
	 * returned from `wp_get_nav_menu_items`.
	 *
	 * @param int|\WP_Post $post - ID or post object, null is not supported.
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $post ) {
		if ( empty( $post ) ) {
			_doing_it_wrong( __METHOD__, 'Null is not supported for menu items.', '3.7.1' );
		}
		return new static( $post );
	}

}
