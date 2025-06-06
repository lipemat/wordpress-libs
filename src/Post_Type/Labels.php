<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

/**
 * A fluent interface for changing the labels of a `Custom_Post_Type type` during the register.
 *
 * @link   https://developer.wordpress.org/reference/functions/get_post_type_labels/
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @see    Custom_Post_Type::labels()
 * @see    Custom_Post_Type::get_post_type_labels()
 */
class Labels {
	public const NAME                     = 'name';
	public const SINGULAR_NAME            = 'singular_name';
	public const ADD_NEW                  = 'add_new';
	public const ADD_NEW_ITEM             = 'add_new_item';
	public const ARCHIVE_LABEL            = 'archive_label';
	public const EDIT_ITEM                = 'edit_item';
	public const NEW_ITEM                 = 'new_item';
	public const VIEW_ITEM                = 'view_item';
	public const VIEW_ITEMS               = 'view_items';
	public const SEARCH_ITEMS             = 'search_items';
	public const NOT_FOUND                = 'not_found';
	public const NOT_FOUND_IN_TRASH       = 'not_found_in_trash';
	public const PARENT_ITEM_COLON        = 'parent_item_colon';
	public const ALL_ITEMS                = 'all_items';
	public const ARCHIVES                 = 'archives';
	public const ATTRIBUTES               = 'attributes';
	public const INSERT_INTO_ITEM         = 'insert_into_item';
	public const UPLOADED_TO_THIS_ITEM    = 'uploaded_to_this_item';
	public const FEATURED_IMAGE           = 'featured_image';
	public const SET_FEATURED_IMAGE       = 'set_featured_image';
	public const REMOVE_FEATURED_IMAGE    = 'remove_featured_image';
	public const USE_FEATURED_IMAGE       = 'use_featured_image';
	public const MENU_NAME                = 'menu_name';
	public const FILTER_ITEMS_LIST        = 'filter_items_list';
	public const ITEMS_LIST_NAVIGATION    = 'items_list_navigation';
	public const ITEMS_LIST               = 'items_list';
	public const ITEM_PUBLISHED           = 'item_published';
	public const ITEM_PUBLISHED_PRIVATELY = 'item_published_privately';
	public const ITEM_REVERTED_TO_DRAFT   = 'item_reverted_to_draft';
	public const ITEM_SCHEDULED           = 'item_scheduled';
	public const ITEM_UPDATED             = 'item_updated';
	public const ITEM_LINK                = 'item_link';
	public const ITEM_LINK_DESCRIPTION    = 'item_link_description';
	public const FILTER_BY_DATE           = 'filter_by_date';

	/**
	 * Holds any customizations to the labels.
	 *
	 * @var array<self::*, string> $labels
	 */
	protected array $labels = [];


	/**
	 * The general name for the <post type singular> type, usually plural.
	 *
	 * Default is '<post type plural>'
	 *
	 * @param string $label - General name for the post type, usually plural.
	 *
	 * @return Labels
	 */
	public function name( string $label ): Labels {
		return $this->set( self::NAME, $label );
	}


	/**
	 * Name for one object of this <post type singular> type.
	 *
	 * Default is '<post type singular>'
	 *
	 * @param string $label - Name for one object of this post type.
	 *
	 * @return Labels
	 */
	public function singular_name( string $label ): Labels {
		return $this->set( self::SINGULAR_NAME, $label );
	}


	/**
	 * Default is 'Add' for both hierarchical and non-hierarchical types.
	 *
	 * @param string $label - Add new post label.
	 *
	 * @return Labels
	 */
	public function add_new( string $label ): Labels {
		return $this->set( self::ADD_NEW, $label );
	}


	/**
	 * Label for adding a new singular item.
	 *
	 * Default is 'Add <post type singular>'
	 *
	 * @param string $label - Label for adding a new singular item.
	 *
	 * @return Labels
	 */
	public function add_new_item( string $label ): Labels {
		return $this->set( self::ADD_NEW_ITEM, $label );
	}


	/**
	 * Used when retrieving the post type archive title
	 *
	 * @param string $label - Label for the archive page.
	 *
	 * @return Labels
	 */
	public function archive_label( string $label ): Labels {
		return $this->set( self::ARCHIVE_LABEL, $label );
	}


	/**
	 * Label for editing a singular item.
	 *
	 * Default is 'Edit <post type singular>'
	 *
	 * @param string $label - Label for editing a singular item.
	 *
	 * @return Labels
	 */
	public function edit_item( string $label ): Labels {
		return $this->set( self::EDIT_ITEM, $label );
	}


	/**
	 * Label for the new item page title.
	 *
	 * Default is 'New <post type singular>'
	 *
	 * @param string $label - Label for the new item page title.
	 *
	 * @return Labels
	 */
	public function new_item( string $label ): Labels {
		return $this->set( self::NEW_ITEM, $label );
	}


	/**
	 * Label for viewing a singular item.
	 *
	 * Default is 'View <post type singular>'
	 *
	 * @param string $label - Label for viewing a singular item.
	 *
	 * @return Labels
	 */
	public function view_item( string $label ): Labels {
		return $this->set( self::VIEW_ITEM, $label );
	}


	/**
	 * Label for viewing <post type singular> type archives.
	 *
	 * Default is 'View <post type plural>'
	 *
	 * @param string $label - Label for viewing <post type singular> type archives.
	 *
	 * @return Labels
	 */
	public function view_items( string $label ): Labels {
		return $this->set( self::VIEW_ITEMS, $label );
	}


	/**
	 * Label for searching plural items.
	 *
	 * Default is 'Search <post type plural>'
	 *
	 * @param string $label - Label for searching plural items.
	 *
	 * @return Labels
	 */
	public function search_items( string $label ): Labels {
		return $this->set( self::SEARCH_ITEMS, $label );
	}


	/**
	 * Label used when no items are found.
	 *
	 * Default is 'No <post type plural> found'
	 *
	 * @param string $label - Label used when no items are found.
	 *
	 * @return Labels
	 */
	public function not_found( string $label ): Labels {
		return $this->set( self::NOT_FOUND, $label );
	}


	/**
	 * Label used when no items are in the Trash.
	 *
	 * Default is 'No <post type plural> found in Trash'
	 *
	 * @param string $label - Label used when no items are in the Trash.
	 *
	 * @return Labels
	 */
	public function not_found_in_trash( string $label ): Labels {
		return $this->set( self::NOT_FOUND_IN_TRASH, $label );
	}


	/**
	 * Label used to prefix parents of hierarchical items.
	 * Not used on non-hierarchical <post type singular> types.
	 *
	 * Default is 'Parent Page:'.
	 *
	 * @param string $label - Label used to prefix parents of hierarchical items.
	 *
	 * @return Labels
	 */
	public function parent_item_colon( string $label ): Labels {
		return $this->set( self::PARENT_ITEM_COLON, $label );
	}


	/**
	 * Label to signify all items in a submenu link.
	 *
	 * Default is 'All <post type plural>'
	 *
	 * @param string $label - Label to signify all items in a submenu link.
	 *
	 * @return Labels
	 */
	public function all_items( string $label ): Labels {
		return $this->set( self::ALL_ITEMS, $label );
	}


	/**
	 * Label for archives in nav menus.
	 *
	 * Default is '<post type singular> Archives'
	 *
	 * @param string $label - Label for archives in nav menus.
	 *
	 * @return Labels
	 */
	public function archives( string $label ): Labels {
		return $this->set( self::ARCHIVES, $label );
	}


	/**
	 * Label for the attributes meta box.
	 *
	 * Default is '<post type singular> Attributes'
	 *
	 * @param string $label - Label for the attributes meta box.
	 *
	 * @return Labels
	 */
	public function attributes( string $label ): Labels {
		return $this->set( self::ATTRIBUTES, $label );
	}


	/**
	 * Label for the media frame button.
	 *
	 * Default is 'Insert into <post type singular>'
	 *
	 * @param string $label - Label for the media frame button.
	 *
	 * @return Labels
	 */
	public function insert_into_item( string $label ): Labels {
		return $this->set( self::INSERT_INTO_ITEM, $label );
	}


	/**
	 * Label for the media frame filter.
	 *
	 * Default is 'Uploaded to this <post type singular>'
	 *
	 * @param string $label - Label for the media frame filter.
	 *
	 * @return Labels
	 */
	public function uploaded_to_this_item( string $label ): Labels {
		return $this->set( self::UPLOADED_TO_THIS_ITEM, $label );
	}


	/**
	 * Label for the featured image meta box title.
	 *
	 * Default is 'Featured image'.
	 *
	 * @see Custom_Post_Type::set_featured_image_labels()
	 *
	 * @param string $label - Label for the featured image meta box title.
	 *
	 * @return Labels
	 */
	public function featured_image( string $label ): Labels {
		return $this->set( self::FEATURED_IMAGE, $label );
	}


	/**
	 * Label for setting the featured image.
	 *
	 * Default is 'Set featured image'.
	 *
	 * @see Custom_Post_Type::set_featured_image_labels()
	 *
	 * @param string $label - Label for setting the featured image.
	 *
	 * @return Labels
	 */
	public function set_featured_image( string $label ): Labels {
		return $this->set( self::SET_FEATURED_IMAGE, $label );
	}


	/**
	 * Label for removing the featured image.
	 *
	 * Default is 'Remove featured image'.
	 *
	 * @see Custom_Post_Type::set_featured_image_labels()
	 *
	 * @param string $label - Label for removing the featured image.
	 *
	 * @return Labels
	 */
	public function remove_featured_image( string $label ): Labels {
		return $this->set( self::REMOVE_FEATURED_IMAGE, $label );
	}


	/**
	 * Label in the media frame for using a featured image.
	 *
	 * Default is 'Use as featured image'.
	 *
	 * @see Custom_Post_Type::set_featured_image_labels()
	 *
	 * @param string $label - Label in the media frame for using a featured image.
	 *
	 * @return Labels
	 */
	public function use_featured_image( string $label ): Labels {
		return $this->set( self::USE_FEATURED_IMAGE, $label );
	}


	/**
	 * Label for the menu name.
	 *
	 * Default is the same as `name`.
	 *
	 * @param string $label - Label for the menu name.
	 *
	 * @return Labels
	 */
	public function menu_name( string $label ): Labels {
		return $this->set( self::MENU_NAME, $label );
	}


	/**
	 * Label for the table views hidden heading.
	 *
	 * Default is 'Filter <post type plural> list'
	 *
	 * @param string $label - Label for the table views hidden heading.
	 *
	 * @return Labels
	 */
	public function filter_items_list( string $label ): Labels {
		return $this->set( self::FILTER_ITEMS_LIST, $label );
	}


	/**
	 * Label for the date filter in list tables.
	 *
	 * Default is 'Filter by date'.
	 *
	 * @param string $label - Label for the date filter in list tables.
	 *
	 * @return Labels
	 */
	public function filter_by_date( string $label ): Labels {
		return $this->set( self::FILTER_BY_DATE, $label );
	}


	/**
	 * Label for the table pagination hidden heading.
	 *
	 * Default is '<post type plural> list navigation'
	 *
	 * @param string $label - Label for the table pagination hidden heading.
	 *
	 * @return Labels
	 */
	public function items_list_navigation( string $label ): Labels {
		return $this->set( self::ITEMS_LIST_NAVIGATION, $label );
	}


	/**
	 * Label for the table hidden heading.
	 *
	 * Default is '<post type plural> list'
	 *
	 * @param string $label - Label for the table hidden heading.
	 *
	 * @return Labels
	 */
	public function items_list( string $label ): Labels {
		return $this->set( self::ITEMS_LIST, $label );
	}


	/**
	 * Label used when an item is published.
	 *
	 * Default is '<post type singular> published.'
	 *
	 * @param string $label - Label used when an item is published.
	 *
	 * @return Labels
	 */
	public function item_published( string $label ): Labels {
		return $this->set( self::ITEM_PUBLISHED, $label );
	}


	/**
	 * Label used when an item is published with private visibility.
	 *
	 * Default is '<post type singular> published privately.'
	 *
	 * @param string $label - Label used when an item is published with private visibility.
	 *
	 * @return Labels
	 */
	public function item_published_privately( string $label ): Labels {
		return $this->set( self::ITEM_PUBLISHED_PRIVATELY, $label );
	}


	/**
	 * Label used when an item is switched to a draft.
	 *
	 * Default is '<post type singular> reverted to draft.'
	 *
	 * @param string $label - Label used when an item is switched to a draft.
	 *
	 * @return Labels
	 */
	public function item_reverted_to_draft( string $label ): Labels {
		return $this->set( self::ITEM_REVERTED_TO_DRAFT, $label );
	}


	/**
	 * Label used when an item is scheduled for publishing.
	 *
	 * Default is '<post type singular> scheduled.'
	 *
	 * @param string $label - Label used when an item is scheduled for publishing.
	 *
	 * @return Labels
	 */
	public function item_scheduled( string $label ): Labels {
		return $this->set( self::ITEM_SCHEDULED, $label );
	}


	/**
	 * Label used when an item is updated.
	 *
	 * Default is '<post type singular> updated.'
	 *
	 * @param string $label - Label used when an item is updated.
	 *
	 * @return Labels
	 */
	public function item_updated( string $label ): Labels {
		return $this->set( self::ITEM_UPDATED, $label );
	}


	/**
	 * Title for a navigation link block variation.
	 *
	 * Default is '<post type singular> Link'
	 *
	 * @param string $label - Title for a navigation link block variation.
	 *
	 * @return Labels
	 */
	public function item_link( string $label ): Labels {
		return $this->set( self::ITEM_LINK, $label );
	}


	/**
	 * Description for a navigation link block variation.
	 *
	 * Default is 'A link to a <post type singular>.'
	 *
	 * @param string $label - Description for a navigation link block variation.
	 *
	 * @return Labels
	 */
	public function item_link_description( string $label ): Labels {
		return $this->set( self::ITEM_LINK_DESCRIPTION, $label );
	}


	/**
	 * Get a label for the post type.
	 *
	 * @phpstan-param self::* $label_key
	 *
	 * @param string          $label_key - The label to get.
	 *
	 * @return ?string
	 */
	public function get_label( string $label_key ): ?string {
		return $this->labels[ $label_key ] ?? null;
	}


	/**
	 * Get all labels for the post type.
	 *
	 * @return array<self::*, string>
	 */
	public function get_labels(): array {
		return $this->labels;
	}


	/**
	 * Set a label for the post type.
	 *
	 * @phpstan-param self::* $label_key
	 *
	 * @param string          $label_key - The label to set.
	 * @param string          $label     - The value to set.
	 *
	 * @return Labels
	 */
	protected function set( string $label_key, string $label ): Labels {
		$this->labels[ $label_key ] = $label;
		return $this;
	}
}
