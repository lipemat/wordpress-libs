<?php

namespace Lipe\Lib\Schema;

use Lipe\Lib\Traits\Version;

/**
 * Interact with custom Database Tables
 *
 * Set the necessary class constants in the child class like so:
 *
 * protected const NAME = 'personal'; // Table name without prefix (prefix is set during construct)
 * protected const ID_FIELD = 'personal_id';
 * protected const DB_VERSION = 1;
 *
 * protected const COLUMNS = []
 */
abstract class Db {
	use Version;

	public const    NAME     = __CLASS__;
	protected const ID_FIELD = __CLASS__;

	/**
	 * Version of the table scheme.
	 *
	 * Bump to run `create_table` again when the table scheme changes.
	 */
	public const DB_VERSION = 1;

	/**
	 * Database columns with corresponding data type.
	 * Used to sanitize queries with any of the built in sprintf specifiers.
	 *
	 * @notice     May exclude the primary key from this list if it is auto increment
	 * @notice     Date should be added to this list even if default current timestamp
	 *
	 * @link       https://www.php.net/manual/en/function.sprintf.php
	 *
	 * @example    array(
	 * 'user_id'      => "%d",
	 * 'content_id'   => "%s",
	 * 'content_type' => "%s",
	 * 'amount'       => "%f",
	 * 'date'         => "%d"
	 * );
	 *
	 * @var array
	 */
	public const COLUMNS = [];

	/**
	 * Holds the database name with prefix included.
	 *
	 * @internal
	 *
	 * @var string
	 */
	protected $table;


	/**
	 * Db constructor.
	 *
	 * @see Db::NAME
	 */
	public function __construct() {
		global $wpdb;
		$this->table = $wpdb->prefix . static::NAME;

		$this->run_for_version( [ $this, 'run_updates' ], static::DB_VERSION );
	}


	/**
	 * Get the name of the database table with prefix included.
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
	 * @param array<string>|string $columns      - Array or CSV of columns we want to return.
	 *                                           Pass '*' to return all columns.
	 *
	 * @param array|int            $id_or_wheres - Row id or array or where column => value.
	 *                                           Adding a % within the value will turn the
	 *                                           query into a `LIKE` query.
	 *
	 * @param int                  $count        - Number of rows to return.
	 *                                           If set to 1 this will return a single value
	 *                                           or row depending on the number of columns
	 *                                           set in `$columns`.
	 *
	 * @param string               $order_by     - An ORDERBY column and direction.
	 *                                           Optionally pass `ASC` or `DESC` after the
	 *                                           column to specify direction.
	 *
	 * @return array<object>|object|string|int
	 *
	 */
	public function get( $columns, $id_or_wheres = null, $count = null, $order_by = null ) {
		global $wpdb;

		if ( \is_array( $columns ) ) {
			$columns = implode( ',', $columns );
		}

		if ( is_numeric( $id_or_wheres ) ) {
			$id_or_wheres = [ static::ID_FIELD => $id_or_wheres ];
			$count = 1;
		}

		$sql = "SELECT $columns FROM {$this->get_table()}";

		if ( null !== $id_or_wheres ) {
			$wheres = [];
			$values = [];
			$where_formats = $this->get_formats( $id_or_wheres );
			foreach ( $id_or_wheres as $column => $value ) {
				if ( false !== strpos( $value, '%' ) ) {
					$wheres[ $column ] = "`$column` LIKE " . array_shift( $where_formats );
				} else {
					$wheres[ $column ] = "`$column` = " . array_shift( $where_formats );
				}
				$values[] = $value;
			}
			$where = ' WHERE ' . implode( ' AND ', $wheres );
			//phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
			$sql .= $wpdb->prepare( $where, $values );
		}

		if ( null !== $order_by ) {
			$sql .= " ORDER BY $order_by";
		}

		if ( null !== $count ) {
			$sql .= " LIMIT $count";
		}

		if ( '*' === $columns || \substr_count( $columns, ',' ) > 1 ) {
			if ( 1 === $count ) {
				return $wpdb->get_row( $sql );
			}

			return $wpdb->get_results( $sql );
		}
		if ( 1 === $count ) {
			return $wpdb->get_var( $sql );
		}

		return $wpdb->get_col( $sql );
		//phpcs:enable WordPress.DB.PreparedSQL.NotPrepared

	}


	/**
	 * Get a row by it's id.
	 *
	 * @param int $id - Primary key value.
	 *
	 *
	 * @return object|null
	 */
	public function get_by_id( int $id ) {
		return $this->get( '*', $id, 1 );
	}


	/**
	 * Add a row to the table
	 *
	 * @param array $columns
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
	 * @param int|array $id_or_wheres - row id or array or column => values to use as where
	 *
	 * @since 1.6.1
	 *
	 * @return int|false
	 */
	public function delete( $id_or_wheres ) {
		global $wpdb;

		if ( is_numeric( $id_or_wheres ) ) {
			$id_or_wheres = [ static::ID_FIELD => $id_or_wheres ];
		}

		$formats = $this->get_formats( $id_or_wheres );

		return $wpdb->delete( $this->get_table(), $id_or_wheres, $formats );
	}


	/**
	 *
	 * @param int|array $id_or_wheres - row id or array or column => values to use as where
	 * @param array     $columns      - data to change
	 *
	 * @return int|bool - number of rows updated or false on error
	 */
	public function update( $id_or_wheres, array $columns ) {
		global $wpdb;

		if ( is_numeric( $id_or_wheres ) ) {
			$id_or_wheres = [ static::ID_FIELD => $id_or_wheres ];
		}

		$column_formats = $this->get_formats( $columns );

		$formats = $this->get_formats( $id_or_wheres );

		return $wpdb->update( $this->get_table(), $columns, $id_or_wheres, $column_formats, $formats );
	}


	/**
	 * Get the sprintf style formats matching an array of columns
	 *
	 * @link https://www.php.net/manual/en/function.sprintf.php
	 *
	 * @param array $columns
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
	 * @param array $columns
	 *
	 * @see Db::COLUMNS
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
	 * date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,,
	 * PRIMARY KEY  (uid),
	 * KEY user_id (user_id),
	 * KEY content_id (content_id),
	 * KEY content_type (content_type)
	 * );";
	 *
	 * dbDelta( $sql );
	 *
	 * @notice dbDelta expects the "CREATE" etc. to be capitalized
	 *         and will not run if not capitalized.
	 *
	 * @return void
	 */
	abstract protected function create_table() : void;

}
