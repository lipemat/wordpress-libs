<?php

namespace Lipe\Lib\Schema;

/**
 * Interact with custom Database Tables
 *
 * Set the necessary class constants in the child class like so
 *
 * protected const NAME = 'personal'; //table name without prefix (prefix is set during construct)
 * protected const ID_FIELD = 'personal_id';
 * protected const DB_OPTION = "auth_db";
 * protected const DB_VERSION = 1;
 *
 * protected const COLUMNS = []
 *
 * @since 04/18/2018
 *
 *
 */
abstract class Db {

	protected $table;

	/**
	 *
	 * Db columns with corresponding data type
	 * Used to sanitize queries
	 *
	 * @see     May exclude the primary key from this list if it is auto increment
	 * @see     Date should be added to this list even if default current timestamp
	 *
	 * @example array(
	 * 'user_id'      => "%d",
	 * 'content_id'   => "%s",
	 * 'content_type' => "%s",
	 * 'date'         => "%d"
	 * );
	 *
	 *
	 * @var array
	 */
	public const COLUMNS = [];

	public function __construct() {
		if( ! \defined( 'static::NAME' ) ){
			return;
		}
		global $wpdb;
		$this->table = $wpdb->prefix . static::NAME;

		if( $this->update_required() ){
			$this->run_updates();
		}
	}


	/**
	 *
	 * @return string
	 */
	public function get_id_field() : string {
		return static::ID_FIELD ?? $this->id_field;
	}


	/**
	 *
	 * @return string
	 */
	public function get_table() : string {
		return $this->table;
	}


	/**
	 *
	 * Retrieve data from this db table
	 *
	 * @param array|string $columns   - array or csv of columns we want to return
	 *                                If only one column is specified this will return
	 *                                either a single value or an array of single values
	 *                                depending on what $count is set to
	 *
	 * @param array|string [$id_or_wheres] - row id or array or where column => value
	 *
	 * @param              bool       [$count] - number of rows to return.
	 *                                If set to 1 this will return a single var or
	 *                                row depending on the number of columns set in
	 *                                $columns, instead of an array of results
	 *
	 * @param              string     [ $order_by ] - an orderby value used verbatim in query
	 *
	 * @return array|string
	 *
	 */
	public function get( $columns, $id_or_wheres = null, $count = null, $order_by = null ) {
		global $wpdb;

		if ( \is_array( $columns ) ) {
			$columns = implode( ',', $columns );
		}

		if ( is_numeric( $id_or_wheres ) ) {
			$id_or_wheres = [ $this->get_id_field() => $id_or_wheres ];
			$count        = 1;
		}

		$sql = "SELECT $columns FROM {$this->get_table()}";

		if ( null !== $id_or_wheres ) {
			$wheres        = [];
			$values        = [];
			$where_formats = $this->get_formats( $id_or_wheres );
			foreach ( $id_or_wheres as $column => $value ) {
				if ( ! empty( $value ) ) {
					$wheres[ $column ] = "`$column` = " . array_shift( $where_formats );
					$values[]          = $value;
				}
			}

			$where = ' WHERE ' . implode( ' AND ', $wheres );
			$sql   .= $wpdb->prepare( $where, $values );
		}

		if ( null !== $order_by ) {
			$sql .= " ORDER BY $order_by";
		}

		if ( null !== $count ) {
			$sql .= " LIMIT $count";
		}

		if ( '*' === $columns || \substr_count( $columns, ',' ) > 1 ) {
			if ( $count === 1 ) {
				return $wpdb->get_row( $sql );
			}

			return $wpdb->get_results( $sql );

		}
		if ( $count === 1 ) {
			return $wpdb->get_var( $sql );
		}

		return $wpdb->get_col( $sql );


	}


	/**
	 *
	 * Get the sprintf style formats matching an array of columns
	 *
	 * @uses Db::COLUMNS
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	protected function get_formats( array $columns ) : array {
		$formats = [];
		foreach ( $columns as $column => $value ) {
			if ( $column === $this->get_id_field() ) {
				$formats[] = '%d';
			} elseif ( ! empty( $this->get_columns()[ $column ] ) ) {
				$formats[] = $this->get_columns()[ $column ];
			} else {
				$formats[] = '%s';
			}
		}

		return $formats;
	}


	/**
	 *
	 * Add a row to the table
	 *
	 * @param array $columns
	 *
	 * @see Db::COLUMNS
	 *
	 * @return int|bool - insert id on success or false
	 */
	public function add( array $columns ) {
		global $wpdb;

		$columns = $this->sort_columns( $columns );

		if ( $wpdb->insert( $this->get_table(), $columns, $this->get_columns() ) ) {
			return $wpdb->insert_id;
		}

		return false;
	}


	/**
	 * Sort Columns
	 *
	 * Sorts columns to match $this->columns for use with query sanitization
	 *
	 * @uses Db::COLUMNS
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	protected function sort_columns( $columns ) : array {
		$clean = [];

		foreach ( $this->get_columns() as $column => $type ) {
			if ( array_key_exists( $column, $columns ) ) {
				$clean[ $column ] = $columns[ $column ];
			} else {
				//we are always doing default date stuff
				if ( $column !== 'date' ) {
					$clean[ $column ] = null;
				}
			}
		}

		return $clean;
	}


	/**
	 * @see Db::delete();
	 * @deprecated in favor of Db::delete()
	 */
	public function remove( $id_or_wheres ) {
		\_deprecated_function( 'Db::remove', '1.6.1', 'Db::delete' );
	}

	
	/**
	 * Delete a row from the database
	 *
	 * @param int|array $id_or_wheres - row id or array or column => values to use as where
	 *
	 * @return int|false
	 */
	public function delete( $id_or_wheres ) {
		global $wpdb;

		if ( is_numeric( $id_or_wheres ) ) {
			$id_or_wheres = [ $this->get_id_field() => $id_or_wheres ];
		}

		$formats = $this->get_formats( $id_or_wheres );

		return $wpdb->delete( $this->get_table(), $id_or_wheres, $formats );

	}


	/**
	 *
	 * @param int|array $id_or_wheres - row id or array or column => values to use as where
	 * @param array     $columns      - data to change
	 *
	 * @see Db::COLUMNS
	 *
	 * @return int|bool - number of rows updated or false on error
	 */
	public function update( $id_or_wheres, $columns ) {
		global $wpdb;

		if ( is_numeric( $id_or_wheres ) ) {
			$id_or_wheres = [ $this->get_id_field() => $id_or_wheres ];
		}

		$column_formats = $this->get_formats( $columns );

		$formats = $this->get_formats( $id_or_wheres );

		return $wpdb->update( $this->get_table(), $columns, $id_or_wheres, $column_formats, $formats );

	}


	/**
	 *
	 * @since 1.6.1
	 *
	 * @return array
	 */
	public function get_columns() : array {
		return static::COLUMNS ?? $this->columns;
	}

	/**
	 *
	 * @since 1.6.1
	 *
	 * @return string
	 */
	protected function get_db_version() : string {
		return static::DB_VERSION ?? $this->db_version;
	}

	/**
	 *
	 * @since 1.6.1
	 *
	 * @return string
	 */
	protected function get_db_option() : string {
		return static::DB_OPTION ?? $this->db_option;
	}





	/**
	 *
	 * Run specified updates based on db version and update the option to match
	 *
	 * @uses self::DB_OPTION
	 * @uses self::DB_VERSION
	 *
	 * @return void
	 */
	protected function run_updates() : void {
		$this->create_table();
		if ( method_exists( $this, 'update_table' ) ) {
			$this->update_table();
		}

		update_option( $this-$this->get_db_option(), $this->get_db_version() );

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
	 * @return void
	 */
	abstract protected function create_table();


	/**
	 * Update Required ?
	 *
	 * Check if the db version is less than specified by this class
	 *
	 * @uses self::DB_OPTION
	 *
	 * @return bool
	 */
	protected function update_required() : bool {
		if ( \defined( 'static::DB_OPTION' ) && ! \property_exists( $this, 'db_option' ) ) {
			trigger_error( 'You must define a "const DB_OPTION" in class extending db to use update_required' );

			return false;
		}

		if ( \defined( 'static::DB_VERSION' ) && ! \property_exists( $this, 'db_version' ) ) {
			trigger_error( 'You must define a "const DB_VERSION"  in class extending db to use update_required' );

			return false;
		}

		if ( \defined( 'static::NAME' ) && ! \property_exists( $this, 'table' ) ) {
			trigger_error( 'You must define a "const NAME" in class extending db to use update_required' );

			return false;
		}

		if ( \defined( 'static::ID_FIELD' ) && ! \property_exists( $this, 'id_field' ) ) {
			trigger_error( 'You must define a "const ID_FIELD" in class extending db to use update_required' );

			return false;
		}

		$version = get_option( $this->get_db_option(), 0.1 );

		return version_compare( $version, $this->get_db_version(), '<' );
	}

}
