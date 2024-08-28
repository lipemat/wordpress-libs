<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

/**
 * @author Mat Lipe
 * @since  August 2024
 *
 */
class LabelsTest extends \WP_UnitTestCase {

	/**
	 * @dataProvider provideLabelTypes
	 *
	 * @param string $label
	 */
	public function test_get_label( string $label ): void {
		$labels = new Labels();
		$labels->{$label}( 'Test ' . $label );
		$this->assertSame( 'Test ' . $label, $labels->get_label( $label ) );
	}


	public static function provideLabelTypes(): array {
		return [
			'name'                     => [ Labels::NAME ],
			'singular_name'            => [ Labels::SINGULAR_NAME ],
			'add_new'                  => [ Labels::ADD_NEW ],
			'add_new_item'             => [ Labels::ADD_NEW_ITEM ],
			'archive_label'            => [ Labels::ARCHIVE_LABEL ],
			'edit_item'                => [ Labels::EDIT_ITEM ],
			'new_item'                 => [ Labels::NEW_ITEM ],
			'view_item'                => [ Labels::VIEW_ITEM ],
			'view_items'               => [ Labels::VIEW_ITEMS ],
			'search_items'             => [ Labels::SEARCH_ITEMS ],
			'not_found'                => [ Labels::NOT_FOUND ],
			'not_found_in_trash'       => [ Labels::NOT_FOUND_IN_TRASH ],
			'parent_item_colon'        => [ Labels::PARENT_ITEM_COLON ],
			'all_items'                => [ Labels::ALL_ITEMS ],
			'archives'                 => [ Labels::ARCHIVES ],
			'attributes'               => [ Labels::ATTRIBUTES ],
			'insert_into_item'         => [ Labels::INSERT_INTO_ITEM ],
			'uploaded_to_this_item'    => [ Labels::UPLOADED_TO_THIS_ITEM ],
			'featured_image'           => [ Labels::FEATURED_IMAGE ],
			'set_featured_image'       => [ Labels::SET_FEATURED_IMAGE ],
			'remove_featured_image'    => [ Labels::REMOVE_FEATURED_IMAGE ],
			'use_featured_image'       => [ Labels::USE_FEATURED_IMAGE ],
			'menu_name'                => [ Labels::MENU_NAME ],
			'filter_items_list'        => [ Labels::FILTER_ITEMS_LIST ],
			'filter_by_date'           => [ Labels::FILTER_BY_DATE ],
			'items_list_navigation'    => [ Labels::ITEMS_LIST_NAVIGATION ],
			'items_list'               => [ Labels::ITEMS_LIST ],
			'item_published'           => [ Labels::ITEM_PUBLISHED ],
			'item_published_privately' => [ Labels::ITEM_PUBLISHED_PRIVATELY ],
			'item_reverted_to_draft'   => [ Labels::ITEM_REVERTED_TO_DRAFT ],
			'item_scheduled'           => [ Labels::ITEM_SCHEDULED ],
			'item_updated'             => [ Labels::ITEM_UPDATED ],
			'item_link'                => [ Labels::ITEM_LINK ],
			'item_link_description'    => [ Labels::ITEM_LINK_DESCRIPTION ],
		];
	}
}
