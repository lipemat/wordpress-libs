<?php
//phpcs:disable WordPress.NamingConventions.ValidVariableName
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Resource_Schema;

/**
 * Integer schema type.
 *
 * @author Mat Lipe
 * @since  5.2.0
 *
 * @link   https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#numbers
 *
 * @implements ArgsRules<array<string, mixed>>
 */
class IntegerType implements TypeRules, ArgsRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	/**
	 * The minimum value the value can be.
	 *
	 * @var int
	 */
	public int $minimum;

	/**
	 * The maximum value the value can be.
	 *
	 * @var int
	 */
	public int $maximum;

	/**
	 * Data type for the schema.
	 *
	 * @phpstan-var 'integer'
	 * @var string
	 */
	public string $type = Resource_Schema::TYPE_INTEGER;

	/**
	 * Exclusive minimum value from the allowed range.
	 *
	 * @var bool
	 */
	public bool $exclusiveMinimum;

	/**
	 * Exclusive maximum value from the allowed range.
	 *
	 * @var bool
	 */
	public bool $exclusiveMaximum;

	/**
	 * The value must be a multiple of the given number.
	 *
	 * @var int
	 */
	public int $multipleOf;


	/**
	 * Exclude the maximum value from the allowed range.
	 *
	 * @param bool $is_exclusive - `true` if the value cannot equal the maximum value.
	 *
	 * @return static
	 */
	public function exclusive_maximum( bool $is_exclusive ): static {
		$this->exclusiveMaximum = $is_exclusive;
		return $this;
	}


	/**
	 * Exclude the minimum value from the allowed range.
	 *
	 * @param bool $is_exclusive - `true` if the value cannot equal the minimum value.
	 *
	 * @return static
	 */
	public function exclusive_minimum( bool $is_exclusive ): static {
		$this->exclusiveMinimum = $is_exclusive;
		return $this;
	}


	/**
	 * Assert the value is a multiple of the given number.
	 *
	 * @param int $multiple_of - The number the value must be a multiple of.
	 *
	 * @return static
	 */
	public function multiple_of( int $multiple_of ): static {
		$this->multipleOf = $multiple_of;
		return $this;
	}


	/**
	 * Assert the value is greater than or equal to the given number.
	 *
	 * If `exclusive_minimum` is set to `true` the value must be greater than the given number.
	 *
	 * @param int $minimum - The minimum value the value must be greater than or equal to.
	 *
	 * @return static
	 */
	public function minimum( int $minimum ): static {
		$this->minimum = $minimum;
		return $this;
	}


	/**
	 * Assert the value is less than or equal to the given number.
	 *
	 * If `exclusive_maximum` is set to `true` the value must be less than the given number.
	 *
	 * @param int $maximum - The maximum value the value must be less than or equal to.
	 *
	 * @return static
	 */
	public function maximum( int $maximum ): static {
		$this->maximum = $maximum;
		return $this;
	}
}
