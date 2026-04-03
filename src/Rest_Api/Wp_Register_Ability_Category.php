<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;

/**
 * A fluent interface for the `wp_register_ability_category` function.
 *
 * @link   https://developer.wordpress.org/apis/abilities-api/php-reference/#registering-categories
 *
 * @author Mat Lipe
 * @since  6.0.0
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class Wp_Register_Ability_Category implements ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	/**
	 * The human-readable label for the ability category.
	 *
	 * @required
	 *
	 * @var string
	 */
	public string $label;

	/**
	 * A description of the ability category.
	 *
	 * @required
	 *
	 * @var string
	 */
	public string $description;

	/**
	 * Additional configuration for the ability category.
	 *
	 * Included in the REST API response but current has no internal use.
	 *
	 * @var array<string, mixed>
	 */
	public array $meta;
}
