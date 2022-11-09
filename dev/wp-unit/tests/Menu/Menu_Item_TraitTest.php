<?php

namespace Lipe\Project\Menu;

use Lipe\Lib\Menu\Menu_Item_Trait;

class Menu_Item {
	use Menu_Item_Trait;
}

/**
 * @author Mat Lipe
 * @since  January 2022
 *
 */
class Menu_Item_TraitTest extends \WP_UnitTestCase {

	public function test_get_object() : void {
		$post_id = self::factory()->post->create( [ 'post_title' => 'Hello World' ] );

		$menu_id = wp_create_nav_menu( 'Menu' );
		$item_title = 'Greetings';
		$item_id = wp_update_nav_menu_item(
			$menu_id,
			0,
			[
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'post',
				'menu-item-object-id' => $post_id,
				'menu-item-title'     => $item_title,
				'menu-item-status'    => 'publish',
			]
		);

		foreach ( get_posts( 'post_type=nav_menu_item' ) as $post ) {
			$this->assertFalse( property_exists( $post, 'db_id' ) );
			$object = Menu_Item::factory( $post );
			$this->assertTrue( property_exists( $object->get_object(), 'db_id' ) );
		}

		$this->setExpectedIncorrectUsage( 'Lipe\Lib\Menu\Menu_Item_Trait::factory' );
		Menu_Item::factory( null );

		$this->assertNotNull( Menu_Item::factory( $item_id )->get_object() );
		wp_delete_post( $post_id );
		$this->assertNull( Menu_Item::factory( $item_id )->get_object() );
	}
}
