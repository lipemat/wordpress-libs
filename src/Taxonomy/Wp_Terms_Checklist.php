<?php
declare( strict_types=1 );

namespace Lipe\Lib\Taxonomy;

use Lipe\Lib\Query\Args_Interface;
use Lipe\Lib\Query\Args_Trait;

/**
 * @author Mat Lipe
 * @since  May 2024
 *
 */
class Wp_Terms_Checklist implements Args_Interface {
	use Args_Trait;

	/**
	 * ID of the category to output along with its descendants.
	 * Default 0.
	 *
	 * @var int
	 */
	public int $descendants_and_self;

	/**
	 * Array of category IDs to mark as checked.
	 *
	 * Default false.
	 *
	 * @var int[]|false
	 */
	public false|array $selected_cats;

	/**
	 * Array of category IDs to receive the 'popular-category' class.
	 *
	 * Default false.
	 *
	 * @var int[]|false
	 */
	public array|false $popular_cats;

	/**
	 * Walker object to use to build the output.
	 *
	 * Default `Walker_Category_Checklist`.
	 *
	 * @var \Walker
	 */
	public \Walker $walker;

	/**
	 * The taxonomy to retrieve terms from.
	 *
	 * Default 'category'.
	 *
	 * @var string
	 */
	public string $taxonomy;

	/**
	 * Whether to move checked items out of the hierarchy and to
	 * the top of the list.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $checked_ontop;

	/**
	 * Whether to echo the output or return it.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $echo;
}
