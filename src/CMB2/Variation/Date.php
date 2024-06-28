<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Variation;

use Lipe\Lib\CMB2\Field;

/**
 * Date field variation,
 *
 * @author Mat Lipe
 * @since  June 5.0.0
 *
 */
class Date extends Field {
	/**
	 * Field parameter used in the date field types which allows specifying
	 * the php date format for your field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#date_format
	 * @link https://php.net/manual/en/function.date.php.
	 *
	 * @var string
	 */
	protected string $date_format;

	/**
	 * Used for date/timestamp fields.
	 *
	 * Optional to specify a timezone to use when
	 * calculating the timestamp offset.
	 *
	 * Defaults to timezone stored in WP options.
	 *
	 * @var string;
	 */
	protected string $timezone;

	/**
	 * Used for date/time fields
	 *
	 * Optionally make this field honor the timezone selected
	 * in the select_timezone field specified above in the form.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#text_date
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#select_timezone
	 *
	 * @example 'key_of_select_timezone_field'
	 *
	 * @var string
	 */
	protected string $timezone_meta_key;


	/**
	 * Field parameter used in the date field types which allows specifying
	 * the php date format for your field.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#date_format
	 * @link https://php.net/manual/en/function.date.php.
	 *
	 * @param string $date_format - PHP date format.
	 */
	public function date_format( string $date_format ): Date {
		$this->date_format = $date_format;
		return $this;
	}


	/**
	 * Used for date/timestamp fields.
	 *
	 * Optional to specify a timezone to use when
	 * calculating the timestamp offset.
	 *
	 * Defaults to timezone stored in WP options.
	 *
	 * @param string $timezone - Timezone to use.
	 */
	public function timezone( string $timezone ): Date {
		$this->timezone = $timezone;
		return $this;
	}


	/**
	 * Used for date/time fields
	 *
	 * Optionally make this field honor the timezone selected
	 * in the select_timezone field specified above in the form.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#text_date
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#select_timezone
	 *
	 * @param string $timezone_meta_key - Meta key to retrieve timezone from.
	 */
	public function timezone_meta_key( string $timezone_meta_key ): Date {
		$this->timezone_meta_key = $timezone_meta_key;
		return $this;
	}


	/**
	 * A field for selecting a date.
	 *
	 * @example https://github.com/CMB2/CMB2/wiki/Field-Types#additional-field-options
	 *
	 * @param string               $date_format         - PHP date format.
	 * @param string               $timezone_meta_key   - Meta key to retrieve timezone from.
	 * @param array<string, mixed> $date_picker_options - Options to pass to datepicker.
	 * @param array<string, mixed> $time_picker_options - Options to pass to timepicker.
	 *
	 * @return array<string, string|array<string, string>>
	 */
	public function date_args( string $date_format = 'm/d/Y', string $timezone_meta_key = '', array $date_picker_options = [], array $time_picker_options = [] ): array {
		$_args = [
			'date_format' => $date_format,
		];
		if ( '' !== $timezone_meta_key ) {
			$_args['timezone_meta_key'] = $timezone_meta_key;
		}

		if ( [] !== $date_picker_options ) {
			$_args['attributes'] = [
				'data-datepicker' => (string) wp_json_encode( $date_picker_options ),
			];
		}
		if ( [] !== $time_picker_options ) {
			$_args['attributes'] = [
				'data-timepicker' => (string) wp_json_encode( $time_picker_options ),
			];
		}

		return $_args;
	}
}
