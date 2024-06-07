<?php
declare( strict_types=1 );

namespace Lipe\Lib\Db;

/**
 * Interface for interacting with a custom database table.
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @template FORMATS of array<string, "%d"|"%i"|"%f"|"%s">
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
