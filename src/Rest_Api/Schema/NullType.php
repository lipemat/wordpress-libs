<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Resource_Schema;

/**
 * Null type for the schema.
 *
 * @author Mat Lipe
 * @since  5.2.0
 *
 * @link   https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#primitive-types
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class NullType implements TypeRules, ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	/**
	 * Data type for the schema.
	 *
	 * @phpstan-var 'null'
	 * @var string
	 */
	public string $type = Resource_Schema::TYPE_NULL;
}
