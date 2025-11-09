<?php
declare( strict_types=1 );

namespace Lipe\Lib\Menu;

use Lipe\Lib\Libs\Container\Factory;
use Lipe\Lib\Post_Type\Post_Object_Trait;

/**
 * Nav Menu Item post type returned from `wp_get_nav_menu_items`.
 *
 * The same as other post types except additional properties are added
 * by `wp_setup_nav_menu_item`.
 *
 * @since 3.7.0
 *
 * @property int      $db_id
 * @property int      $menu_item_parent
 * @property int      $object_id
 * @property string   $object
 * @property string   $post_type
 * @property string   $type_label
 * @property string   $url
 * @property string   $title
 * @property string   $target
 * @property string   $attr_title
 * @property string   $description
 * @property string[] $classes
 * @property string   $xfn
 *
 * @template OPTIONS of array<string, mixed>
 */
trait Menu_Item_Trait {
	/**
	 * @use Factory<array{int|\WP_Post|null}>
	 */
	use Factory;

	/**
	 * @use Post_Object_Trait<OPTIONS>
	 */
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
	public function get_object(): ?\WP_Post {
		if ( ! isset( $this->post ) && 0 !== $this->post_id ) {
			$this->post = get_post( $this->post_id );
		}

		if ( ( $this->post instanceof \WP_Post ) && ! \property_exists( $this->post, 'db_id' ) ) {
			$item = wp_setup_nav_menu_item( $this->post );
			if ( $item instanceof \WP_Post && _is_valid_nav_menu_item( $item ) ) {
				$this->post = $item;
			} else {
				$this->post = null;
			}
		}

		return $this->post ?? null;
	}


	/**
	 * Does this post exist in the database?
	 *
	 * @return bool
	 */
	public function exists(): bool {
		return null !== $this->get_object();
	}


	/**
	 * Pass either an ID of the menu item or a WP_Post
	 * returned from `wp_get_nav_menu_items`.
	 *
	 * @param int|\WP_Post $post - ID or post object, null is not supported.
	 *
	 * @return static
	 */
	public static function factory( int|\WP_Post $post ): static {
		return static::createFactory( $post );
	}
}
