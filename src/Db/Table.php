<?php
declare( strict_types=1 );

namespace Lipe\Lib\Db;

/**
 * Interface for interacting with a custom database table.
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @template FORMATS of array<string, "%d"|"%f"|"%s">
 * @template COLUMNS of array<string, string|float|int|null>
 * @template PARTIALS of array<key-of<COLUMNS>, float|string|int|null>
 */
interface Table {
	/**
	 * Get the column names and formats for the table.
	 *
	 * @phpstan-return FORMATS
	 */
	public function get_column_formats(): array;


	/**
	 * Get the name of the field that is the primary key.
	 *
	 * @note PHPStan return must overriden in child class to reduce the type
	 *       to the single key of the array.
	 *       (e.g., phpstan-return "ID")
	 *
	 * @phpstan-return key-of<FORMATS>
	 */
	public function get_id_field(): string;


	/**
	 * Get the name of the database table without the prefix.
	 *
	 * @return string
	 */
	public function get_table_base(): string;
}
