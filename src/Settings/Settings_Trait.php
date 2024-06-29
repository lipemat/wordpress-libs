<?php
declare( strict_types=1 );

namespace Lipe\Lib\Settings;

use Lipe\Lib\Meta\MetaType;
use Lipe\Lib\Meta\Mutator_Trait;
use Lipe\Lib\Meta\Repo;

/**
 * CMB2 registered settings pages.
 *
 * @example ```php
 * class My_Settings {
 * @use Settings_Trait<array{
 *              'my_option': string,
 *              'another_option': int,
 *   }>
 *   use Settings_Trait;
 * }
 * ```
 * @note    Class constants can't be used as keys in the generic
 *          due to PHPStan limitations, use the full string.
 *
 * @template OPTIONS of array<string, mixed>
 */
trait Settings_Trait {
	use Mutator_Trait;

	/**
	 * Settings page ID.
	 *
	 * @return string
	 */
	public function get_id(): string {
		return static::NAME;
	}


	/**
	 * Used to determine the type of meta to retrieve or update.
	 *
	 * @return MetaType
	 */
	public function get_meta_type(): MetaType {
		return MetaType::OPTION;
	}


	/**
	 * Get an option from the Meta repo.
	 *
	 * @template T of static::*
	 * @template D of mixed
	 *
	 * @phpstan-param T $key
	 * @phpstan-param D $default_value
	 *
	 * @param string    $key           - Option key.
	 * @param mixed     $default_value - Default value if option is not set.
	 *
	 * @phpstan-return D|OPTIONS[T]
	 * @return mixed
	 */
	public function get_option( string $key, $default_value = null ) {
		return $this->get_meta( $key, $default_value );
	}


	/**
	 * Update an option.
	 *
	 * If a callable is passed, it will be called with the previous value
	 * as the only argument.
	 * If `$callback_default` is passed, it will be used as the default value for `$this->get_meta()`.
	 *
	 * @template T of static::*
	 * @template D of mixed
	 *
	 * @phpstan-param T      $key
	 * @phpstan-param D      $callback_default
	 *
	 * @phpstan-param OPTIONS[T]|(callable( D|OPTIONS[T]): OPTIONS[T]) $value
	 *
	 * @param string         $key              - Option key.
	 * @param mixed|callable $value            - Option value.
	 * @param mixed          $callback_default - Default value for get during callback.
	 *
	 * @return void
	 */
	public function update_option( string $key, $value, $callback_default = null ): void {
		$this->update_meta( $key, $value, $callback_default );
	}
}
