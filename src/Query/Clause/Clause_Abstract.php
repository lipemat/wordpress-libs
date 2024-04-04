<?php
declare( strict_types=1 );

namespace Lipe\Lib\Query\Clause;

/**
 * Do not use this. It will be removed in version 5.
 *
 * @deprecated In favor of `Clause_Trait`.
 *
 * @implements Clause_Interface<Clause_Abstract>
 */
abstract class Clause_Abstract implements Clause_Interface {
	/**
	 * Pass generic to trait.
	 *
	 * @use Clause_Trait<Clause_Abstract>
	 */
	use Clause_Trait;
}
