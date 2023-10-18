<?php
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

/**
 * A fluent interface for changing the labels of a <post type singular> type during the register.
 *
 * @link   https://developer.wordpress.org/reference/functions/get_post_type_labels/
 *
 * @author Mat Lipe
 * @since  4.0.0
 *
 * @interal
 *
 * @see    Custom_Post_Type::labels()
 */
class Labels {
	/**
	 * Custom <post type singular> Type class currently registering.
	 *
	 * @var Custom_Post_Type
	 */
	protected Custom_Post_Type $cpt;


	/**
	 * Labels constructor.
	 *
	 * @param Custom_Post_Type $cpt - The Custom_Post_Type instance currently registering.
	 */
	public function __construct( Custom_Post_Type $cpt ) {
		$this->cpt = $cpt;
	}


	/**
	 * The general name for the <post type singular> type, usually plural.
	 *
	 * Default is '<post type plural>'
	 *
	 * @param string $label - General name for the post type, usually plural.
	 *
	 * @return $this
	 */
	public function name( string $label ): Labels {
		$this->cpt->labels['name'] = $label;
		return $this;
	}


	/**
	 * Name for one object of this <post type singular> type.
	 *
	 * Default is '<post type singular>'
	 *
	 * @param string $label - Name for one object of this post type.
	 *
	 * @return $this
	 */
	public function singular_name( string $label ): Labels {
		$this->cpt->labels['singular_name'] = $label;
		return $this;
	}


	/**
	 * Default is 'Add New' for both hierarchical and non-hierarchical types.
	 *
	 * @param string $label - Add new post label.
	 *
	 * @return $this
	 */
	public function add_new( string $label ): Labels {
		$this->cpt->labels['add_new'] = $label;
		return $this;
	}


	/**
	 * Label for adding a new singular item.
	 *
	 * Default is 'Add New <post type singular>'
	 *
	 * @param string $label - Label for adding a new singular item.
	 *
	 * @return $this
	 */
	public function add_new_item( string $label ): Labels {
		$this->cpt->labels['add_new_item'] = $label;
		return $this;
	}


	/**
	 * Label for editing a singular item.
	 *
	 * Default is 'Edit <post type singular>'
	 *
	 * @param string $label - Label for editing a singular item.
	 *
	 * @return $this
	 */
	public function edit_item( string $label ): Labels {
		$this->cpt->labels['edit_item'] = $label;
		return $this;
	}


	/**
	 * Label for the new item page title.
	 *
	 * Default is 'New <post type singular>'
	 *
	 * @param string $label - Label for the new item page title.
	 *
	 * @return $this
	 */
	public function new_item( string $label ): Labels {
		$this->cpt->labels['new_item'] = $label;
		return $this;
	}


	/**
	 * Label for viewing a singular item.
	 *
	 * Default is 'View <post type singular>'
	 *
	 * @param string $label - Label for viewing a singular item.
	 *
	 * @return $this
	 */
	public function view_item( string $label ): Labels {
		$this->cpt->labels['view_item'] = $label;
		return $this;
	}


	/**
	 * Label for viewing <post type singular> type archives.
	 *
	 * Default is 'View <post type plural>'
	 *
	 * @param string $label - Label for viewing <post type singular> type archives.
	 *
	 * @return $this
	 */
	public function view_items( string $label ): Labels {
		$this->cpt->labels['view_items'] = $label;
		return $this;
	}


	/**
	 * Label for searching plural items.
	 *
	 * Default is 'Search <post type plural>'
	 *
	 * @param string $label - Label for searching plural items.
	 *
	 * @return $this
	 */
	public function search_items( string $label ): Labels {
		$this->cpt->labels['search_items'] = $label;
		return $this;
	}


	/**
	 * Label used when no items are found.
	 *
	 * Default is 'No <post type plural> found'
	 *
	 * @param string $label - Label used when no items are found.
	 *
	 * @return $this
	 */
	public function not_found( string $label ): Labels {
		$this->cpt->labels['not_found'] = $label;
		return $this;
	}


	/**
	 * Label used when no items are in the Trash.
	 *
	 * Default is 'No <post type plural> found in Trash'
	 *
	 * @param string $label - Label used when no items are in the Trash.
	 *
	 * @return $this
	 */
	public function not_found_in_trash( string $label ): Labels {
		$this->cpt->labels['not_found_in_trash'] = $label;
		return $this;
	}


	/**
	 * Label used to prefix parents of hierarchical items.
	 * Not used on non-hierarchical <post type singular> types.
	 *
	 * Default is 'Parent Page:'.
	 *
	 * @param string $label - Label used to prefix parents of hierarchical items.
	 *
	 * @return $this
	 */
	public function parent_item_colon( string $label ): Labels {
		$this->cpt->labels['parent_item_colon'] = $label;
		return $this;
	}


	/**
	 * Label to signify all items in a submenu link.
	 *
	 * Default is 'All <post type plural>'
	 *
	 * @param string $label - Label to signify all items in a submenu link.
	 *
	 * @return $this
	 */
	public function all_items( string $label ): Labels {
		$this->cpt->labels['all_items'] = $label;
		return $this;
	}


	/**
	 * Label for archives in nav menus.
	 *
	 * Default is '<post type singular> Archives'
	 *
	 * @param string $label - Label for archives in nav menus.
	 *
	 * @return $this
	 */
	public function archives( string $label ): Labels {
		$this->cpt->labels['archives'] = $label;
		return $this;
	}


	/**
	 * Label for the attributes meta box.
	 *
	 * Default is '<post type singular> Attributes'
	 *
	 * @param string $label - Label for the attributes meta box.
	 *
	 * @return $this
	 */
	public function attributes( string $label ): Labels {
		$this->cpt->labels['attributes'] = $label;
		return $this;
	}


	/**
	 * Label for the media frame button.
	 *
	 * Default is 'Insert into <post type singular>'
	 *
	 * @param string $label - Label for the media frame button.
	 *
	 * @return $this
	 */
	public function insert_into_item( string $label ): Labels {
		$this->cpt->labels['insert_into_item'] = $label;
		return $this;
	}


	/**
	 * Label for the media frame filter.
	 *
	 * Default is 'Uploaded to this <post type singular>'
	 *
	 * @param string $label - Label for the media frame filter.
	 *
	 * @return $this
	 */
	public function uploaded_to_this_item( string $label ): Labels {
		$this->cpt->labels['uploaded_to_this_item'] = $label;
		return $this;
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
	 * @return $this
	 */
	public function featured_image( string $label ): Labels {
		$this->cpt->labels['featured_image'] = $label;
		return $this;
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
	 * @return $this
	 */
	public function set_featured_image( string $label ): Labels {
		$this->cpt->labels['set_featured_image'] = $label;
		return $this;
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
	 * @return $this
	 */
	public function remove_featured_image( string $label ): Labels {
		$this->cpt->labels['remove_featured_image'] = $label;
		return $this;
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
	 * @return $this
	 */
	public function use_featured_image( string $label ): Labels {
		$this->cpt->labels['use_featured_image'] = $label;
		return $this;
	}


	/**
	 * Label for the menu name.
	 *
	 * Default is the same as `name`.
	 *
	 * @param string $label - Label for the menu name.
	 *
	 * @return $this
	 */
	public function menu_name( string $label ): Labels {
		$this->cpt->labels['menu_name'] = $label;
		return $this;
	}


	/**
	 * Label for the table views hidden heading.
	 *
	 * Default is 'Filter <post type plural> list'
	 *
	 * @param string $label - Label for the table views hidden heading.
	 *
	 * @return $this
	 */
	public function filter_items_list( string $label ): Labels {
		$this->cpt->labels['filter_items_list'] = $label;
		return $this;
	}


	/**
	 * Label for the date filter in list tables.
	 *
	 * Default is 'Filter by date'.
	 *
	 * @param string $label - Label for the date filter in list tables.
	 *
	 * @return $this
	 */
	public function filter_by_date( string $label ): Labels {
		$this->cpt->labels['filter_by_date'] = $label;
		return $this;
	}


	/**
	 * Label for the table pagination hidden heading.
	 *
	 * Default is '<post type plural> list navigation'
	 *
	 * @param string $label - Label for the table pagination hidden heading.
	 *
	 * @return $this
	 */
	public function items_list_navigation( string $label ): Labels {
		$this->cpt->labels['items_list_navigation'] = $label;
		return $this;
	}


	/**
	 * Label for the table hidden heading.
	 *
	 * Default is '<post type plural> list'
	 *
	 * @param string $label - Label for the table hidden heading.
	 *
	 * @return $this
	 */
	public function items_list( string $label ): Labels {
		$this->cpt->labels['items_list'] = $label;
		return $this;
	}


	/**
	 * Label used when an item is published.
	 *
	 * Default is '<post type singular> published.'
	 *
	 * @param string $label - Label used when an item is published.
	 *
	 * @return $this
	 */
	public function item_published( string $label ): Labels {
		$this->cpt->labels['item_published'] = $label;
		return $this;
	}


	/**
	 * Label used when an item is published with private visibility.
	 *
	 * Default is '<post type singular> published privately.'
	 *
	 * @param string $label - Label used when an item is published with private visibility.
	 *
	 * @return $this
	 */
	public function item_published_privately( string $label ): Labels {
		$this->cpt->labels['item_published_privately'] = $label;
		return $this;
	}


	/**
	 * Label used when an item is switched to a draft.
	 *
	 * Default is '<post type singular> reverted to draft.'
	 *
	 * @param string $label - Label used when an item is switched to a draft.
	 *
	 * @return $this
	 */
	public function item_reverted_to_draft( string $label ): Labels {
		$this->cpt->labels['item_reverted_to_draft'] = $label;
		return $this;
	}


	/**
	 * Label used when an item is scheduled for publishing.
	 *
	 * Default is '<post type singular> scheduled.'
	 *
	 * @param string $label - Label used when an item is scheduled for publishing.
	 *
	 * @return $this
	 */
	public function item_scheduled( string $label ): Labels {
		$this->cpt->labels['item_scheduled'] = $label;
		return $this;
	}


	/**
	 * Label used when an item is updated.
	 *
	 * Default is '<post type singular> updated.'
	 *
	 * @param string $label - Label used when an item is updated.
	 *
	 * @return $this
	 */
	public function item_updated( string $label ): Labels {
		$this->cpt->labels['item_updated'] = $label;
		return $this;
	}


	/**
	 * Title for a navigation link block variation.
	 *
	 * Default is '<post type singular> Link'
	 *
	 * @param string $label - Title for a navigation link block variation.
	 *
	 * @return $this
	 */
	public function item_link( string $label ): Labels {
		$this->cpt->labels['item_link'] = $label;
		return $this;
	}


	/**
	 * Description for a navigation link block variation.
	 *
	 * Default is 'A link to a <post type singular>.'
	 *
	 * @param string $label - Description for a navigation link block variation.
	 *
	 * @return $this
	 */
	public function item_link_description( string $label ): Labels {
		$this->cpt->labels['item_link_description'] = $label;
		return $this;
	}
}
