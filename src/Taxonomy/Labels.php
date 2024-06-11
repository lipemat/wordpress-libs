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
 * @interal
 *
 * @see      Taxonomy::labels()
 * @see      Taxonomy::taxonomy_labels()
 *
 * @formatter:off
 * @phpstan-type LABEL 'name'|'singular_name'|'search_items'|'popular_items'|'all_items'|'parent_item'|'parent_item_colon'|'edit_item'|'view_item'|'update_item'|'add_new_item'|'new_item_name'|'separate_items_with_commas'|'add_or_remove_items'|'choose_from_most_used'|'not_found'|'no_terms'|'no_item'|'items_list_navigation'|'items_list'|'most_used'|'back_to_items'|'menu_name'
 * @formatter:on
 */
class Labels {
	/**
	 * Any labels that have been set.
	 *
	 * @var array<LABEL, string>
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
	 * @return $this
	 */
	public function name( string $value ): static {
		return $this->set( 'name', $value );
	}


	/**
	 * Set the singular name of the taxonomy.
	 *
	 * @param string $value - Singular name of the taxonomy.
	 *
	 * @return $this
	 */
	public function singular_name( string $value ): static {
		return $this->set( 'singular_name', $value );
	}


	/**
	 * Set the search items label.
	 *
	 * @param string $value - Search items label.
	 *
	 * @return $this
	 */
	public function search_items( string $value ): static {
		return $this->set( 'search_items', $value );
	}


	/**
	 * Set the popular items label.
	 *
	 * @param string $value - Popular items label.
	 *
	 * @return $this
	 */
	public function popular_items( string $value ): static {
		return $this->set( 'popular_items', $value );
	}


	/**
	 * Set the all items label.
	 *
	 * @param string $value - All items label.
	 *
	 * @return $this
	 */
	public function all_items( string $value ): static {
		return $this->set( 'all_items', $value );
	}


	/**
	 * Set the parent item label.
	 *
	 * @param string $value - Parent item label.
	 *
	 * @return $this
	 */
	public function parent_item( string $value ): static {
		return $this->set( 'parent_item', $value );
	}


	/**
	 * Set the parent item colon label.
	 *
	 * @param string $value - Parent item colon label.
	 *
	 * @return $this
	 */
	public function parent_item_colon( string $value ): static {
		return $this->set( 'parent_item_colon', $value );
	}


	/**
	 * Set the edit item label.
	 *
	 * @param string $value - Edit item label.
	 *
	 * @return $this
	 */
	public function edit_item( string $value ): static {
		return $this->set( 'edit_item', $value );
	}


	/**
	 * Set the view item label.
	 *
	 * @param string $value - View item label.
	 *
	 * @return $this
	 */
	public function view_item( string $value ): static {
		return $this->set( 'view_item', $value );
	}


	/**
	 * Set the update item label.
	 *
	 * @param string $value - Update item label.
	 *
	 * @return $this
	 */
	public function update_item( string $value ): static {
		return $this->set( 'update_item', $value );
	}


	/**
	 * Set the add new item label.
	 *
	 * @param string $value - Add new item label.
	 *
	 * @return $this
	 */
	public function add_new_item( string $value ): static {
		return $this->set( 'add_new_item', $value );
	}


	/**
	 * Set the new item name label.
	 *
	 * @param string $value - New item name label.
	 *
	 * @return $this
	 */
	public function new_item_name( string $value ): static {
		return $this->set( 'new_item_name', $value );
	}


	/**
	 * Set the separate items with commas label.
	 *
	 * @param string $value - Separate items with commas label.
	 *
	 * @return $this
	 */
	public function separate_items_with_commas( string $value ): static {
		return $this->set( 'separate_items_with_commas', $value );
	}


	/**
	 * Set the add or remove items label.
	 *
	 * @param string $value - Add or remove items label.
	 *
	 * @return $this
	 */
	public function add_or_remove_items( string $value ): static {
		return $this->set( 'add_or_remove_items', $value );
	}


	/**
	 * Set the "choose from most used" label.
	 *
	 * @param string $value - Choose from most used label.
	 *
	 * @return $this
	 */
	public function choose_from_most_used( string $value ): static {
		return $this->set( 'choose_from_most_used', $value );
	}


	/**
	 * Set the "not found" label.
	 *
	 * @param string $value - "Not found" label.
	 *
	 * @return $this
	 */
	public function not_found( string $value ): static {
		return $this->set( 'not_found', $value );
	}


	/**
	 * Set the no terms label.
	 *
	 * @param string $value - No terms label.
	 *
	 * @return $this
	 */
	public function no_terms( string $value ): static {
		return $this->set( 'no_terms', $value );
	}


	/**
	 * Set the items list navigation label.
	 *
	 * @param string $value - Items list navigation label.
	 *
	 * @return $this
	 */
	public function no_item( string $value ): static {
		return $this->set( 'no_item', $value );
	}


	/**
	 * Set the items list navigation label.
	 *
	 * @param string $value - Items list navigation label.
	 *
	 * @return $this
	 */
	public function items_list_navigation( string $value ): static {
		return $this->set( 'items_list_navigation', $value );
	}


	/**
	 * Set the items list label.
	 *
	 * @param string $value - Items list label.
	 *
	 * @return $this
	 */
	public function items_list( string $value ): static {
		return $this->set( 'items_list', $value );
	}


	/**
	 * Set the most used label.
	 *
	 * @param string $value - Most used label.
	 *
	 * @return $this
	 */
	public function most_used( string $value ): static {
		return $this->set( 'most_used', $value );
	}


	/**
	 * Set the back to items label.
	 *
	 * @param string $value - Back to items label.
	 *
	 * @return $this
	 */
	public function back_to_items( string $value ): static {
		return $this->set( 'back_to_items', $value );
	}


	/**
	 * Set the menu name label.
	 *
	 * @param string $value - Menu name label.
	 *
	 * @return $this
	 */
	public function menu_name( string $value ): static {
		return $this->set( 'menu_name', $value );
	}


	/**
	 * Set a label for the taxonomy.
	 *
	 * @phpstan-param LABEL $key
	 *
	 * @param string        $key   - Key of the label to set.
	 * @param string        $value - Value of the label to set.
	 *
	 * @return $this
	 */
	protected function set( string $key, string $value ): static {
		$this->labels[ $key ] = $value;
		return $this;
	}


	/**
	 * Get a label by key.
	 *
	 * @phpstan-param LABEL $key
	 *
	 * @param string        $key - Key of the label to get.
	 *
	 * @return ?string
	 */
	public function get_label( string $key ): ?string {
		return $this->labels[ $key ] ?? null;
	}


	/**
	 * Get the finished labels array.
	 *
	 * @return array<LABEL, string>
	 */
	public function get_labels(): array {
		return $this->labels;
	}
}
