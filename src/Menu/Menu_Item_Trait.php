<?php

namespace Lipe\Lib\Menu;

use Lipe\Lib\Post_Type\Post_Object_Trait;

/**
 * Nav Menu Item post type returned from `wp_get_nav_menu_items`.
 *
 * Same as other post types except additional properties are added
 * by `wp_setup_nav_menu_item`.
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
}
