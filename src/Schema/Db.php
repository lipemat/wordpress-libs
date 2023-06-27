<?php

namespace Lipe\Lib\Schema;

use Lipe\Lib\Traits\Version;

//phpcs:disable WordPress.DB -- This whole class is custom DB handler.

/**
 * Interact with custom Database Tables
 *
 * @notice You must set the necessary class constants in the child class.
 * @const  NAME - Name of table without the prefix.
 * @const  ID_FIELD - Primary key field.
 * @const  COLUMNS - Table columns.
 *
 * @phpstan-type WHERE array<string,float|string|null>|int
 */
abstract class Db {
	use Version;

	/**
	 * Name of the table without prefix. Prefix is set
	 * during construct.
	 */
	public const    NAME = __CLASS__;

	/**
	 * Primary key of the table. Typically, auto increment.
	 */
	protected const ID_FIELD = __CLASS__;

	/**
	 * Database columns with corresponding data type.
	 * Used to sanitize queries with any of the built-in sprintf specifiers.
	 *
	 * @notice     May exclude the primary key from this list if it is auto increment.
	 * @notice     Date should be added to this list even if using the current timestamp.
	 *
	 * @link       https://www.php.net/manual/en/function.sprintf.php
	 *
	 * @example    array(
	 * 'user_id'      => "%d",
	 * 'content_id'   => "%s",
	 * 'content_type' => "%s",
	 * 'amount'       => "%f",
	 * 'date'         => "%s"
	 * );
	 *
	 * @var array
	 */
	public const COLUMNS = [];

	/**
	 * Version of the table scheme.
	 *
	 * Bump to run `create_table` again when the table scheme changes.
	 */
	public const DB_VERSION = 1;

	/**
	 * Holds the database name with the prefix included.
	 *
	 * @internal
	 *
	 * @var string
	 */
	protected string $table;


	/**
	 * Db constructor.
	 *
	 * @see Db::NAME
	 */
	public function __construct() {
		global $wpdb;
		$this->table = $wpdb->prefix . static::NAME;

		$this->run_for_version( [ $this, 'run_updates' ], (string) static::DB_VERSION );
	}


	/**
	 * Get the name of the database table with the prefix included.
	 *
	 * @return string
	 */
	public function get_table() : string {
		return $this->table;
	}


	/**
	 * Retrieve data from this db table.
	 *
	 * Automatically maps the results to a single value or row if the
	 * `$count` is set to 1.
	 *
	 * @phpstan-param WHERE        $id_or_wheres
	 *
	 * @param array<string>|string $columns      Array or CSV of columns we want to return.
	 *                                           Pass '*' to return all columns.
	 *
	 * @param array|int            $id_or_wheres Row id or array or where column => value.
	 *                                           Adding a % within the value will turn the
	 *                                           query into a `LIKE` query.
	 *
	 * @param int|string           $count        Number of rows to return. An offset may also be
	 *                                           provided via `<offset>,<limit>` for pagination.
	 *                                           If set to 1 this will return a single value or row
	 *                                           instead of an array.
	 *
	 * @param string|null          $order_by     An ORDERBY column and direction.
	 *                                           Optionally pass `ASC` or `DESC` after the
	 *                                           column to specify direction.
	 *
	 * @return null|object|array<object>|\stdClass|string|array<string>
	 */
	public function get( $columns, $id_or_wheres = null, $count = null, string $order_by = null ) {
		global $wpdb;

		if ( \is_array( $columns ) ) {
			$columns = \implode( ',', $columns );
		}

		$sql = $this->get_select_query( $columns, $id_or_wheres, $count, $order_by );

		if ( false !== \strpos( $columns, '*' ) || false !== \strpos( $columns, ',' ) ) {
			if ( 1 === $count ) {
				return $wpdb->get_row( $sql );
			}

			return $wpdb->get_results( $sql );
		}
		if ( 1 === $count ) {
			return $wpdb->get_var( $sql );
		}

		return $wpdb->get_col( $sql );

	}


	/**
	 * Get a row by its id.
	 *
	 * @param int $id - Primary key value.
	 *
	 * @return object|null
	 */
	public function get_by_id( int $id ) {
		return $this->get( '*', $id, 1 );
	}


	/**
	 * Gets a paginated set of results with pagination information.
	 *
	 * @phpstan-param WHERE        $id_or_wheres
	 *
	 * @param array<string>|string $columns      Array or CSV of columns we want to return.
	 *                                           Pass '*' to return all columns.
	 * @param int                  $page         Page of paginated results to return.
	 * @param int                  $per_page     Number of rows to return for this page.
	 * @param array|int            $id_or_wheres Row id or array or where column => value.
	 *                                           Adding a % within the value will turn the
	 *                                           query into a `LIKE` query.
	 * @param string|null          $order_by     An ORDERBY column and direction.
	 *                                           Optionally pass `ASC` or `DESC` after the
	 *                                           column to specify direction.
	 *
	 * @return array{total: int, total_pages: int, items: array<object|string>|object|string|void|null}
	 */
	public function get_paginated( $columns, int $page, int $per_page, $id_or_wheres = null, string $order_by = null ) : array {
		global $wpdb;

		$count = $per_page;
		// Generate a 'LIMIT <offset>, <count>' keyword.
		if ( $page > 1 ) {
			$count = ( $page - 1 ) * $per_page . ', ' . $per_page;
		}

		$results = $this->get( $columns, $id_or_wheres, $count, $order_by );
		$total = $wpdb->get_var( $this->get_select_query( 'COUNT(*)', $id_or_wheres ) );

		return [
			'total'       => (int) $total,
			'total_pages' => (int) ceil( $total / $per_page ),
			'items'       => $results,
		];
	}


	/**
	 * Add a row to the table
	 *
	 * @param array $columns - column => value pairs to insert.
	 *
	 * @return int|bool - insert id on success or false
	 */
	public function add( array $columns ) {
		global $wpdb;

		$columns = $this->sort_columns( $columns );

		if ( $wpdb->insert( $this->get_table(), $columns, static::COLUMNS ) ) {
			return $wpdb->insert_id;
		}

		return false;
	}


	/**
	 * Delete a row from the database
	 *
	 * @phpstan-param WHERE $id_or_wheres
	 *
	 * @param int|array     $id_or_wheres - row id or array or column => values to use as where.
	 *
	 * @return int|false
	 */
	public function delete( $id_or_wheres ) {
		global $wpdb;

		if ( \is_numeric( $id_or_wheres ) ) {
			$id_or_wheres = [ static::ID_FIELD => $id_or_wheres ];
		}

		$formats = $this->get_formats( $id_or_wheres );

		return $wpdb->delete( $this->get_table(), $id_or_wheres, $formats );
	}


	/**
	 * Update a row(s) in the database.
	 *
	 * @phpstan-param WHERE $id_or_wheres
	 *
	 * @param int|array     $id_or_wheres - row id or array or column => values to use as where.
	 * @param array         $columns      - data to change.
	 *
	 * @return int|bool - number of rows updated or false on error.
	 */
	public function update( $id_or_wheres, array $columns ) {
		global $wpdb;

		if ( \is_numeric( $id_or_wheres ) ) {
			$id_or_wheres = [ static::ID_FIELD => $id_or_wheres ];
		}

		$column_formats = $this->get_formats( $columns );

		$formats = $this->get_formats( $id_or_wheres );

		return $wpdb->update( $this->get_table(), $columns, $id_or_wheres, $column_formats, $formats );
	}


	/**
	 * Replace a row in the table.
	 *
	 * Works exactly like `add` except if an old row in the table
	 * has the same value in a unique index, the old row is deleted
	 * before the new row is added.
	 *
	 * @since 3.14.0
	 *
	 * @param array $columns - column => value pairs to replace.
	 *
	 * @return int|bool - insert id on success or false
	 */
	public function replace( array $columns ) {
		global $wpdb;

		$columns = $this->sort_columns( $columns );

		if ( $wpdb->replace( $this->get_table(), $columns, static::COLUMNS ) ) {
			return $wpdb->insert_id;
		}

		return false;
	}


	/**
	 * Retrieve a `SELECT` query based on the provided criteria.
	 *
	 * @phpstan-param WHERE        $id_or_wheres
	 *
	 * @param array<string>|string $columns      Array or CSV of columns we want to return.
	 *                                           Pass '*' to return all columns.page.
	 * @param string|array         $id_or_wheres Row id or array or where column => value.
	 *                                           Adding a % within the value will turn the
	 *                                           query into a `LIKE` query.
	 * @param string|int           $count        Number of rows to return.
	 * @param ?string              $order_by     An ORDERBY column and direction.
	 *                                           Optionally pass `ASC` or `DESC`.
	 *
	 * @return string
	 */
	protected function get_select_query( $columns, $id_or_wheres = null, $count = null, string $order_by = null ) : string {
		global $wpdb;

		if ( \is_array( $columns ) ) {
			$columns = \implode( ',', $columns );
		}

		if ( \is_numeric( $id_or_wheres ) ) {
			$id_or_wheres = [ static::ID_FIELD => $id_or_wheres ];
			$count = 1;
		}

		$sql = "SELECT $columns FROM {$this->get_table()}";

		if ( null !== $id_or_wheres ) {
			$wheres = [];
			$values = [];
			$where_formats = $this->get_formats( $id_or_wheres );
			foreach ( $id_or_wheres as $column => $value ) {
				if ( null === $value ) {
					$wheres[ $column ] = "`$column` IS NULL";
					continue;
				}

				if ( false !== \strpos( (string) $value, '%' ) ) {
					$wheres[ $column ] = "`$column` LIKE " . \array_shift( $where_formats );
				} else {
					$wheres[ $column ] = "`$column` = " . \array_shift( $where_formats );
				}
				$values[] = $value;
			}
			// Allow filtering or adding of custom WHERE clauses.
			[ $wheres, $values ] = apply_filters_ref_array( 'lipe/lib/schema/db/get/wheres', [
				[ $wheres, $values ],
				$id_or_wheres,
				$columns,
				$this,
			] );
			if ( ! empty( $wheres ) ) {
				$where = ' WHERE ' . \implode( ' AND ', $wheres );
				$sql .= $wpdb->prepare( $where, $values );
			}
		}

		if ( ! empty( $order_by ) ) {
			$sql .= " ORDER BY $order_by";
		}

		if ( null !== $count ) {
			$sql .= " LIMIT $count";
		}

		return $sql;
	}


	/**
	 * Get the sprintf style formats matching an array of columns
	 *
	 * @link https://www.php.net/manual/en/function.sprintf.php
	 *
	 * @param array $columns - Columns to retrieve formats for.
	 *
	 * @return array
	 */
	protected function get_formats( array $columns ) : array {
		$formats = [];
		foreach ( $columns as $column => $value ) {
			if ( static::ID_FIELD === $column ) {
				$formats[] = '%d';
			} elseif ( ! empty( static::COLUMNS[ $column ] ) ) {
				$formats[] = static::COLUMNS[ $column ];
			} else {
				$formats[] = '%s';
			}
		}

		return $formats;
	}


	/**
	 * Sorts columns to match `static::COLUMNS` for use with query sanitization.
	 *
	 * @see Db::COLUMNS
	 *
	 * @param array $columns - Columns to sort.
	 *
	 * @return array
	 */
	protected function sort_columns( array $columns ) : array {
		$clean = [];

		foreach ( static::COLUMNS as $column => $type ) {
			if ( \array_key_exists( $column, $columns ) ) {
				$clean[ $column ] = $columns[ $column ];
				// Because we usually let MySQL handle default dates.
			} elseif ( 'date' !== $column ) {
				$clean[ $column ] = null;
			}
		}

		return $clean;
	}


	/**
	 * Run specified updates based on db version and update the option to match.
	 *
	 * @return void
	 */
	protected function run_updates() : void {
		$this->create_table();
		if ( method_exists( $this, 'update_table' ) ) {
			$this->update_table();
		}
	}


	/** Table creation *************************** */

	/**
	 *
	 * Create the custom db table
	 *
	 * @example
	 * require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	 *
	 * $sql = "CREATE TABLE IF NOT EXISTS " . $this->table . " (
	 * uid bigint(50) NOT NULL AUTO_INCREMENT,
	 * user_id bigint(20) NOT NULL,
	 * content_id varchar(100) NOT NULL,
	 * content_type varchar(100) NOT NULL,
	 * date TIMESTAMP DEFAULT UTC_TIMESTAMP ON UPDATE UTC_TIMESTAMP,
	 * PRIMARY KEY  (uid),
	 * KEY user_id (user_id),
	 * KEY content_id (content_id),
	 * KEY content_type (content_type)
	 * );";
	 *
	 * dbDelta( $sql );
	 *
	 * @notice dbDelta expects the "CREATE" etc. to be capitalized.
	 *
	 * @return void
	 */
	abstract protected function create_table() : void;

}
