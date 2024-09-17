<?php
//phpcs:disable WordPress.NamingConventions.ValidVariableName
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Rest_Api\Resource_Schema;

/**
 * @author Mat Lipe
 * @since  5.2.0
 *
 * @link   https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#strings
 * @link   https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#format
 */
class StringType implements ArgsRules, TypeRules {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args;

	public const FORMAT_DATE_TIME = 'date-time';
	public const FORMAT_EMAIL     = 'email';
	public const FORMAT_URI       = 'uri';
	public const FORMAT_IP        = 'ip';
	public const FORMAT_UUID      = 'uuid';
	public const FORMAT_HEX_COLOR = 'hex-color';

	/**
	 * Data type for the schema.
	 *
	 * @phpstan-var 'string'
	 * @var string
	 */
	public string $type = Resource_Schema::TYPE_STRING;

	/**
	 * Regular expression pattern to match against.
	 *
	 * @var string
	 */
	public string $pattern;

	/**
	 * Minimum length of the string.
	 *
	 * @var int
	 */
	public int $minLength;

	/**
	 * Maximum length of the string.
	 *
	 * @var int
	 */
	public int $maxLength;

	/**
	 * Format of the string.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#objects
	 *
	 * @phpstan-var self::FORMAT_*
	 *
	 * @var string
	 */
	public string $format;

	/**
	 * List of allowed strings.
	 *
	 * @var string[]
	 */
	public array $enum;


	/**
	 * Define a list of allowed strings.
	 *
	 * @param string[] $values - List of allowed strings.
	 *
	 * @return StringType
	 */
	public function enum( array $values ): StringType {
		$this->enum = $values;
		return $this;
	}


	/**
	 * Reqruie a string to be of a specific format.
	 *
	 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#format
	 *
	 * @phpstan-param self::FORMAT_* $format
	 *
	 * @param string                 $format - Required format.
	 *
	 * @return StringType
	 */
	public function format( string $format ): StringType {
		$this->format = $format;
		return $this;
	}


	/**
	 * Maximum length of the string.
	 *
	 * @param int $maxLength - Maximum length.
	 *
	 * @return StringType
	 */
	public function max_length( int $maxLength ): StringType {
		$this->maxLength = $maxLength;
		return $this;
	}


	/**
	 * Minimum length of the string.
	 *
	 * @param int $minLength - Minimum length.
	 *
	 * @return StringType
	 */
	public function min_length( int $minLength ): StringType {
		$this->minLength = $minLength;
		return $this;
	}


	/**
	 * Regular expression pattern to match against.
	 *
	 * @param string $pattern - Regular expression pattern.
	 *
	 * @return StringType
	 */
	public function pattern( string $pattern ): StringType {
		$this->pattern = $pattern;
		return $this;
	}
}
