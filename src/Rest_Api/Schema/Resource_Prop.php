<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Resource_Schema;

/**
 * Property of the schema when in a Resource context.
 *
 * @author Mat Lipe
 * @since  5.2.0
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class Resource_Prop implements ArgsRules, PropRules {
	use Prop;

	/**
	 * Content in which to include this prop.
	 *
	 * @phpstan-var array<Resource_Schema::CONTEXT_*>
	 *
	 * @var array
	 */
	public array $context;

	/**
	 * Is this field readonly?
	 *
	 * @var bool
	 */
	public bool $readonly;


	/**
	 * Content in which to include this prop.
	 *
	 * @phpstan-param array<Resource_Schema::CONTEXT_*> $context
	 *
	 * @param array                                     $context - Content in which to include this prop.
	 */
	public function context( array $context ): static {
		$this->context = $context;
		return $this;
	}


	/**
	 * Mark this field as readonly.
	 *
	 * @param bool $is_readonly - Is this field readonly?.
	 */
	public function readonly( bool $is_readonly ): static {
		$this->readonly = $is_readonly;
		return $this;
	}
}
