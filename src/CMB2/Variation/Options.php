<?php
/** @noinspection ClassMethodNameMatchesFieldNameInspection */
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Variation;

use Lipe\Lib\CMB2\Field;

/**
 * @author Mat Lipe
 * @since  June 2024
 * @phpstan-type OPTIONS_CALLBACK (callable( \CMB2_Field ): array<string|int, string>)|array<string|int, string>
 */
class Options extends Field {
	/**
	 * Whether to show select all button for items
	 * with multi select like multicheck.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck
	 *
	 * @default true
	 *
	 * @var bool
	 */
	protected bool $select_all_button;

	/**
	 * For fields that take an options array.
	 *
	 * These include select, radio, multicheck, wysiwyg and group.
	 * Should be an array where the keys are the option value,
	 * and the values are the option text.
	 *
	 * If you are doing any kind of database querying or logic/conditional checking,
	 * you're almost always better off using the options_cb parameter.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#options
	 *
	 * @var  array<string, string|bool>
	 */
	protected array $options = [];

	/**
	 * A callback to provide field options.
	 *
	 * It is recommended to use this parameter over the options parameter
	 * if you are doing anything complex to generate your options array,
	 * as the '*_cb' parameters are run when the field is generated,
	 * instead of on every page load (admin or otherwise).
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#options_cb
	 *
	 * @example my_get_options_function( $field ){ return [ value => label ] }
	 *
	 * @var callable( \CMB2_Field ): array<string, string>
	 */
	protected $options_cb;

	/**
	 * When using a field of a select type this defines whether we should
	 * show a "no option" option and what the value of said option will be.
	 *
	 * @var bool|string
	 */
	protected string|bool $show_option_none;


	/**
	 * For fields that take an options array.
	 *
	 * These include select, radio, multicheck, wysiwyg and group.
	 * Should be an array where the keys are the option value,
	 * and the values are the option text.
	 *
	 * If you are doing any kind of database querying or logic/conditional checking,
	 * you're almost always better off using the options_cb parameter.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#options
	 *
	 * @param array<string, string|bool> $options - Array of options.
	 */
	public function options( array $options ): Options {
		$this->options = $options;
		return $this;
	}


	/**
	 * When using a field of a select type this defines whether we should
	 * show a "no option" option and what the value of said option will be.
	 *
	 * @param bool|string $show_option_none - Label of no option selected option. Defaults to not shown.
	 */
	public function show_option_none( bool|string $show_option_none ): Options {
		$this->show_option_none = $show_option_none;
		return $this;
	}


	/**
	 * A callback to provide field options.
	 *
	 * It is recommended to use this parameter over the options parameter
	 * if you are doing anything complex to generate your options array,
	 * as the '*_cb' parameters are run when the field is generated,
	 * instead of on every page load (admin or otherwise).
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#options_cb
	 *
	 * @example my_get_options_function( $field ){ return [ value => label ] }
	 *
	 * @phpstan-param callable( \CMB2_Field ): array<string, string> $options_cb - Callback to provide field options.
	 *
	 * @param callable                                               $options_cb - Callback to provide field options.
	 */
	public function options_cb( callable $options_cb ): Options {
		$this->options_cb = $options_cb;
		return $this;
	}


	/**
	 * Whether to show select all button for items
	 * with multi select like multicheck.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck
	 *
	 * @default true
	 *
	 * @param bool $select_all_button - Whether to show the select all button.
	 */
	public function select_all_button( bool $select_all_button ): Options {
		$this->select_all_button = $select_all_button;
		return $this;
	}


	/**
	 * A field for selecting for provided options.
	 *
	 * @phpstan-param OPTIONS_CALLBACK $options_or_callback
	 *
	 * @param array|callable           $options_or_callback - [ $key => $label ] || function().
	 * @param bool|string|null         $show_option_none    - Label of no option selected option. Defaults to not shown.
	 *
	 * @return array{
	 *     options_cb?: callable( \CMB2_Field $field ): array<string|int, string>,
	 *     options?: array<string|int, string>,
	 *     show_option_none?: string|bool
	 * }
	 */
	public function option_args( callable|array $options_or_callback, bool|string|null $show_option_none = null ): array {
		if ( \is_callable( $options_or_callback ) ) {
			$_args = [
				'options_cb' => $options_or_callback,
			];
		} else {
			$_args = [
				'options' => $options_or_callback,
			];
		}
		if ( null !== $show_option_none ) {
			$_args['show_option_none'] = $show_option_none;
		}

		return $_args;
	}
}
