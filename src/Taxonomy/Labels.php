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
 * @see      Taxonomy::taxonomy_labels()
 */
class Labels {
	public const ADD_NEW_ITEM               = 'add_new_item';
	public const ADD_OR_REMOVE_ITEMS        = 'add_or_remove_items';
	public const ALL_ITEMS                  = 'all_items';
	public const BACK_TO_ITEMS              = 'back_to_items';
	public const CHOOSE_FROM_MOST_USED      = 'choose_from_most_used';
	public const EDIT_ITEM                  = 'edit_item';
	public const ITEMS_LIST                 = 'items_list';
	public const ITEMS_LIST_NAVIGATION      = 'items_list_navigation';
	public const MENU_NAME                  = 'menu_name';
	public const MOST_USED                  = 'most_used';
	public const NAME                       = 'name';
	public const NEW_ITEM_NAME              = 'new_item_name';
	public const NOT_FOUND                  = 'not_found';
	public const NO_ITEM                    = 'no_item';
	public const NO_TERMS                   = 'no_terms';
	public const PARENT_ITEM                = 'parent_item';
	public const PARENT_ITEM_COLON          = 'parent_item_colon';
	public const POPULAR_ITEMS              = 'popular_items';
	public const SEARCH_ITEMS               = 'search_items';
	public const SEPARATE_ITEMS_WITH_COMMAS = 'separate_items_with_commas';
	public const SINGULAR_NAME              = 'singular_name';
	public const UPDATE_ITEM                = 'update_item';
	public const VIEW_ITEM                  = 'view_item';

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
	 * @return Labels
	 */
	public function name( string $value ): Labels {
		return $this->set( 'name', $value );
	}


	/**
	 * Set the singular name of the taxonomy.
	 *
	 * @param string $value - Singular name of the taxonomy.
	 *
	 * @return Labels
	 */
	public function singular_name( string $value ): Labels {
		return $this->set( 'singular_name', $value );
	}


	/**
	 * Set the search items label.
	 *
	 * @param string $value - Search items label.
	 *
	 * @return Labels
	 */
	public function search_items( string $value ): Labels {
		return $this->set( 'search_items', $value );
	}


	/**
	 * Set the popular items label.
	 *
	 * @param string $value - Popular items label.
	 *
	 * @return Labels
	 */
	public function popular_items( string $value ): Labels {
		return $this->set( 'popular_items', $value );
	}


	/**
	 * Set the all items label.
	 *
	 * @param string $value - All items label.
	 *
	 * @return Labels
	 */
	public function all_items( string $value ): Labels {
		return $this->set( 'all_items', $value );
	}


	/**
	 * Set the parent item label.
	 *
	 * @param string $value - Parent item label.
	 *
	 * @return Labels
	 */
	public function parent_item( string $value ): Labels {
		return $this->set( 'parent_item', $value );
	}


	/**
	 * Set the parent item colon label.
	 *
	 * @param string $value - Parent item colon label.
	 *
	 * @return Labels
	 */
	public function parent_item_colon( string $value ): Labels {
		return $this->set( 'parent_item_colon', $value );
	}


	/**
	 * Set the edit item label.
	 *
	 * @param string $value - Edit item label.
	 *
	 * @return Labels
	 */
	public function edit_item( string $value ): Labels {
		return $this->set( 'edit_item', $value );
	}


	/**
	 * Set the view item label.
	 *
	 * @param string $value - View item label.
	 *
	 * @return Labels
	 */
	public function view_item( string $value ): Labels {
		return $this->set( 'view_item', $value );
	}


	/**
	 * Set the update item label.
	 *
	 * @param string $value - Update item label.
	 *
	 * @return Labels
	 */
	public function update_item( string $value ): Labels {
		return $this->set( 'update_item', $value );
	}


	/**
	 * Set the add new item label.
	 *
	 * @param string $value - Add new item label.
	 *
	 * @return Labels
	 */
	public function add_new_item( string $value ): Labels {
		return $this->set( 'add_new_item', $value );
	}


	/**
	 * Set the new item name label.
	 *
	 * @param string $value - New item name label.
	 *
	 * @return Labels
	 */
	public function new_item_name( string $value ): Labels {
		return $this->set( 'new_item_name', $value );
	}


	/**
	 * Set the separate items with commas label.
	 *
	 * @param string $value - Separate items with commas label.
	 *
	 * @return Labels
	 */
	public function separate_items_with_commas( string $value ): Labels {
		return $this->set( 'separate_items_with_commas', $value );
	}


	/**
	 * Set the add or remove items label.
	 *
	 * @param string $value - Add or remove items label.
	 *
	 * @return Labels
	 */
	public function add_or_remove_items( string $value ): Labels {
		return $this->set( 'add_or_remove_items', $value );
	}


	/**
	 * Set the "choose from most used" label.
	 *
	 * @param string $value - Choose from most used label.
	 *
	 * @return Labels
	 */
	public function choose_from_most_used( string $value ): Labels {
		return $this->set( 'choose_from_most_used', $value );
	}


	/**
	 * Set the "not found" label.
	 *
	 * @param string $value - "Not found" label.
	 *
	 * @return Labels
	 */
	public function not_found( string $value ): Labels {
		return $this->set( 'not_found', $value );
	}


	/**
	 * Set the no terms label.
	 *
	 * @param string $value - No terms label.
	 *
	 * @return Labels
	 */
	public function no_terms( string $value ): Labels {
		return $this->set( 'no_terms', $value );
	}


	/**
	 * Set the items list navigation label.
	 *
	 * @param string $value - Items list navigation label.
	 *
	 * @return Labels
	 */
	public function no_item( string $value ): Labels {
		return $this->set( 'no_item', $value );
	}


	/**
	 * Set the items list navigation label.
	 *
	 * @param string $value - Items list navigation label.
	 *
	 * @return Labels
	 */
	public function items_list_navigation( string $value ): Labels {
		return $this->set( 'items_list_navigation', $value );
	}


	/**
	 * Set the items list label.
	 *
	 * @param string $value - Items list label.
	 *
	 * @return Labels
	 */
	public function items_list( string $value ): Labels {
		return $this->set( 'items_list', $value );
	}


	/**
	 * Set the most used label.
	 *
	 * @param string $value - Most used label.
	 *
	 * @return Labels
	 */
	public function most_used( string $value ): Labels {
		return $this->set( 'most_used', $value );
	}


	/**
	 * Set the back to items label.
	 *
	 * @param string $value - Back to items label.
	 *
	 * @return Labels
	 */
	public function back_to_items( string $value ): Labels {
		return $this->set( 'back_to_items', $value );
	}


	/**
	 * Set the menu name label.
	 *
	 * @param string $value - Menu name label.
	 *
	 * @return Labels
	 */
	public function menu_name( string $value ): Labels {
		return $this->set( 'menu_name', $value );
	}


	/**
	 * Set a label for the taxonomy.
	 *
	 * @phpstan-param self::* $key
	 *
	 * @param string          $key   - Key of the label to set.
	 * @param string          $value - Value of the label to set.
	 *
	 * @return Labels
	 */
	protected function set( string $key, string $value ): Labels {
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
