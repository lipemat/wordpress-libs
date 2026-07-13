<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

/**
 * A fluent interface for adjusting the labels of a taxonomy during
 * the registration process.
 *
 * @author   Mat Lipe
 * @since    5.0.0
 *
 * @see      Taxonomy::labels()
 * @see      Taxonomy::get_taxonomy_labels()
 */
class Labels {
	public const string ADD_NEW_ITEM               = 'add_new_item';
	public const string ADD_OR_REMOVE_ITEMS        = 'add_or_remove_items';
	public const string ALL_ITEMS                  = 'all_items';
	public const string BACK_TO_ITEMS              = 'back_to_items';
	public const string CHOOSE_FROM_MOST_USED      = 'choose_from_most_used';
	public const string DESC_FIELD_DESCRIPTION     = 'desc_field_description';
	public const string EDIT_ITEM                  = 'edit_item';
	public const string FILTER_BY_ITEM             = 'filter_by_item';
	public const string ITEM_LINK                  = 'item_link';
	public const string ITEM_LINK_DESCRIPTION      = 'item_link_description';
	public const string ITEMS_LIST                 = 'items_list';
	public const string ITEMS_LIST_NAVIGATION      = 'items_list_navigation';
	public const string MENU_NAME                  = 'menu_name';
	public const string MOST_USED                  = 'most_used';
	public const string NAME                       = 'name';
	public const string NAME_ADMIN_BAR             = 'name_admin_bar';
	public const string NAME_FIELD_DESCRIPTION     = 'name_field_description';
	public const string NEW_ITEM_NAME              = 'new_item_name';
	public const string NO_ITEM                    = 'no_item';
	public const string NO_TERMS                   = 'no_terms';
	public const string NOT_FOUND                  = 'not_found';
	public const string PARENT_FIELD_DESCRIPTION   = 'parent_field_description';
	public const string PARENT_ITEM                = 'parent_item';
	public const string PARENT_ITEM_COLON          = 'parent_item_colon';
	public const string POPULAR_ITEMS              = 'popular_items';
	public const string SEARCH_ITEMS               = 'search_items';
	public const string SINGLE_FIELD_DESCRIPTION   = 'single_field_description';
	public const string SEPARATE_ITEMS_WITH_COMMAS = 'separate_items_with_commas';
	public const string SINGULAR_NAME              = 'singular_name';
	public const string UPDATE_ITEM                = 'update_item';
	public const string VIEW_ITEM                  = 'view_item';

	/**
	 * Any labels that have been set.
	 *
	 * @var array<self::*, string>
	 */
	protected array $labels = [];


	/**
	 * Create a new Labels object.
	 *
	 * @param Taxonomy $taxonomy Taxonomy class currently registering.
	 */
	public function __construct(
		protected readonly Taxonomy $taxonomy
	) {
	}


	/**
	 * Set the plural name of the taxonomy.
	 *
	 * @param string $value - Name of the taxonomy.
	 *
	 * @return static
	 */
	public function name( string $value ): static {
		return $this->set( 'name', $value );
	}


	/**
	 * Set the singular name of the taxonomy.
	 *
	 * @param string $value - Singular name of the taxonomy.
	 *
	 * @return static
	 */
	public function singular_name( string $value ): static {
		return $this->set( 'singular_name', $value );
	}


	/**
	 * Set the search items label.
	 *
	 * @param string $value - Search items label.
	 *
	 * @return static
	 */
	public function search_items( string $value ): static {
		return $this->set( 'search_items', $value );
	}


	/**
	 * Set the popular items label.
	 *
	 * @param string $value - Popular items label.
	 *
	 * @return static
	 */
	public function popular_items( string $value ): static {
		return $this->set( 'popular_items', $value );
	}


	/**
	 * Set the all items label.
	 *
	 * @param string $value - All items label.
	 *
	 * @return static
	 */
	public function all_items( string $value ): static {
		return $this->set( 'all_items', $value );
	}


	/**
	 * Set the parent item label.
	 *
	 * @param string $value - Parent item label.
	 *
	 * @return static
	 */
	public function parent_item( string $value ): static {
		return $this->set( 'parent_item', $value );
	}


	/**
	 * Set the parent item colon label.
	 *
	 * @param string $value - Parent item colon label.
	 *
	 * @return static
	 */
	public function parent_item_colon( string $value ): static {
		return $this->set( 'parent_item_colon', $value );
	}


	/**
	 * Set the edit item label.
	 *
	 * @param string $value - Edit item label.
	 *
	 * @return static
	 */
	public function edit_item( string $value ): static {
		return $this->set( 'edit_item', $value );
	}


	/**
	 * Set the view item label.
	 *
	 * @param string $value - View item label.
	 *
	 * @return static
	 */
	public function view_item( string $value ): static {
		return $this->set( 'view_item', $value );
	}


	/**
	 * Set the update item label.
	 *
	 * @param string $value - Update item label.
	 *
	 * @return static
	 */
	public function update_item( string $value ): static {
		return $this->set( 'update_item', $value );
	}


	/**
	 * Set the add new item label.
	 *
	 * @param string $value - Add new item label.
	 *
	 * @return static
	 */
	public function add_new_item( string $value ): static {
		return $this->set( 'add_new_item', $value );
	}


	/**
	 * Set the new item name label.
	 *
	 * @param string $value - New item name label.
	 *
	 * @return static
	 */
	public function new_item_name( string $value ): static {
		return $this->set( 'new_item_name', $value );
	}


	/**
	 * Set the separate items with commas label.
	 *
	 * @param string $value - Separate items with commas label.
	 *
	 * @return static
	 */
	public function separate_items_with_commas( string $value ): static {
		return $this->set( 'separate_items_with_commas', $value );
	}


	/**
	 * Set the add or remove items label.
	 *
	 * @param string $value - Add or remove items label.
	 *
	 * @return static
	 */
	public function add_or_remove_items( string $value ): static {
		return $this->set( 'add_or_remove_items', $value );
	}


	/**
	 * Set the "choose from most used" label.
	 *
	 * @param string $value - Choose from most used label.
	 *
	 * @return static
	 */
	public function choose_from_most_used( string $value ): static {
		return $this->set( 'choose_from_most_used', $value );
	}


	/**
	 * Set the "not found" label.
	 *
	 * @param string $value - "Not found" label.
	 *
	 * @return static
	 */
	public function not_found( string $value ): static {
		return $this->set( 'not_found', $value );
	}


	/**
	 * Set the no terms label.
	 *
	 * @param string $value - No terms label.
	 *
	 * @return static
	 */
	public function no_terms( string $value ): static {
		return $this->set( 'no_terms', $value );
	}


	/**
	 * Set the items list navigation label.
	 *
	 * @param string $value - Items list navigation label.
	 *
	 * @return static
	 */
	public function no_item( string $value ): static {
		return $this->set( 'no_item', $value );
	}


	/**
	 * Set the items list navigation label.
	 *
	 * @param string $value - Items list navigation label.
	 *
	 * @return static
	 */
	public function items_list_navigation( string $value ): static {
		return $this->set( 'items_list_navigation', $value );
	}


	/**
	 * Set the items list label.
	 *
	 * @param string $value - Items list label.
	 *
	 * @return static
	 */
	public function items_list( string $value ): static {
		return $this->set( 'items_list', $value );
	}


	/**
	 * Set the most used label.
	 *
	 * @param string $value - Most used label.
	 *
	 * @return static
	 */
	public function most_used( string $value ): static {
		return $this->set( 'most_used', $value );
	}


	/**
	 * Set the back to items label.
	 *
	 * @param string $value - Back to items label.
	 *
	 * @return static
	 */
	public function back_to_items( string $value ): static {
		return $this->set( 'back_to_items', $value );
	}


	/**
	 * Set the menu name label.
	 *
	 * @param string $value - Menu name label.
	 *
	 * @return static
	 */
	public function menu_name( string $value ): static {
		return $this->set( 'menu_name', $value );
	}


	/**
	 * Description shown in the field.
	 *
	 * @param string $value - Description shown in the field.
	 *
	 * @return static
	 */
	public function desc_field_description( string $value ): static {
		return $this->set( 'desc_field_description', $value );
	}


	/**
	 * Description shown for the name of the field in the admin bar.
	 *
	 * @param string $value - Description shown for the name of the field in the admin bar.
	 *
	 * @return static
	 */
	public function name_admin_bar( string $value ): static {
		return $this->set( 'name_admin_bar', $value );
	}


	/**
	 * Description shown for the name of the field.
	 *
	 * @param string $value - Description shown for the name of the field.
	 *
	 * @return static
	 */
	public function name_field_description( string $value ): static {
		return $this->set( 'name_field_description', $value );
	}


	/**
	 * Description shown for the parent of the field.
	 *
	 * @param string $value - Description shown for the parent of the field.
	 *
	 * @return static
	 */
	public function parent_field_description( string $value ): static {
		return $this->set( 'parent_field_description', $value );
	}


	/**
	 * Description shown for the single field.
	 *
	 * @param string $value - Description shown for the single field.
	 *
	 * @return static
	 */
	public function single_field_description( string $value ): static {
		return $this->set( 'single_field_description', $value );
	}


	/**
	 * Set the filter by item label.
	 *
	 * @param string $value - Filter by item label.
	 *
	 * @return static
	 */
	public function filter_by_item( string $value ): static {
		return $this->set( 'filter_by_item', $value );
	}


	/**
	 * Set the item link label.
	 *
	 * @param string $value - Item link label.
	 *
	 * @return static
	 */
	public function item_link( string $value ): static {
		return $this->set( 'item_link', $value );
	}


	/**
	 * Set the item link description label.
	 *
	 * @param string $value - Item link description label.
	 *
	 * @return static
	 */
	public function item_link_description( string $value ): static {
		return $this->set( 'item_link_description', $value );
	}


	/**
	 * Set a label for the taxonomy.
	 *
	 * @phpstan-param self::* $key
	 *
	 * @param string          $key   - Key of the label to set.
	 * @param string          $value - Value of the label to set.
	 *
	 * @return static
	 */
	protected function set( string $key, string $value ): static {
		$this->labels[ $key ] = $value;
		return $this;
	}


	/**
	 * Get a label by key.
	 *
	 * @phpstan-param self::* $key
	 *
	 * @param string          $key - Key of the label to get.
	 *
	 * @return ?string
	 */
	public function get_label( string $key ): ?string {
		return $this->labels[ $key ] ?? null;
	}


	/**
	 * Get the finished labels array.
	 *
	 * @return array<self::*, string>
	 */
	public function get_labels(): array {
		return $this->labels;
	}
}
