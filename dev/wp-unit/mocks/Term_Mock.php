<?php
declare( strict_types=1 );

namespace mocks;

use Lipe\Lib\Taxonomy\Taxonomy_Trait;

/**
 * Mock Term Object for interacting with the Taxonomy_Trait
 *
 * @author Mat Lipe
 * @since  February 2023
 *
 */
class Term_Mock implements \ArrayAccess {
	use Taxonomy_Trait;
}
