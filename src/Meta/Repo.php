<?php

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\Traits\Singleton;

/**
 * Repo to hold the different field types for our meta keys
 * and return the appropriate data based on field type.
 *
 * @author Mat Lipe
 * @since  2.0.0
 *
 */
class Repo {
	use Singleton;

	public const CHECKBOX = 'checkbox';
	public const DEFAULT = 'default';
	public const FILE = 'file';
	public const TAXONOMY = 'taxonomy';

	/**
	 * All fields that have been registered
	 *
	 * @var Field[]
	 */
	protected $fields = [];

	/**
	 * All types of fields that have been registered
	 * mapped to their data type.
	 *
	 * @var array
	 */
	protected $types = [];


	/**
	 * Store a field's id mapped to the field object
	 *
	 * @param Field $field
	 *
	 * @return void
	 */
	public function register_field( Field $field ) : void {
		$this->fields[ $field->get_id() ] = $field;
	}


	/**
	 * When we call the type() method on a CMB2\Field we store that field type
	 * and the type of data it returns here.
	 *
	 * This way we only store field types we are currently using and call the appropriate
	 * data method for fields of this type.
	 * Used to determine which get_<type>_field_value to call.
	 *
	 * @param string $field_type - a CMB2 field type
	 * @param string $data_type  - a type of data to return [Repo::CHECKBOX, Repo::FILE, Repo::TAXONOMY ]
	 *
	 * @return void
	 */
	public function register_field_type( string $field_type, string $data_type ) : void {
		$this->types[ $field_type ] = $data_type;
	}


	/**
	 * Get a registered field by id.
	 *
	 * @param string $field_id
	 *
	 * @return Field
	 */
	protected function get_field( string $field_id ) : Field {
		return $this->fields[ $field_id ];
	}


	/**
	 * Get the data type of a registered field by id
	 *
	 * @param string $field_id
	 *
	 * @return string
	 */
	protected function get_field_data_type( string $field_id ) : string {
		return $this->types[ $this->get_field( $field_id )->get_type() ];
	}


	/**
	 * Get a fields value
	 *
	 * Use the registered fields and registered types to determine the appropriate method to
	 * return the data.
	 *
	 * @param int|string $object_id - id of post, term, user, <custom>
	 * @param string     $field_id  - field id to return
	 * @param string     $meta_type - user, term, post, <custom> (defaults to 'post')
	 *
	 * @return mixed
	 */
	public function get_value( $object_id, string $field_id, string $meta_type = 'post' ) {
		switch ( $this->get_field_data_type( $field_id ) ) {
			case self::CHECKBOX:
				return $this->get_checkbox_field_value( $object_id, $field_id, $meta_type );
			case self::FILE:
				return $this->get_file_field_value( $object_id, $field_id, $meta_type );
			case self::TAXONOMY:
				if ( 'option' === $meta_type ) {
					break; // Terms are saved as meta for settings.
				}

				return $this->get_taxonomy_field_value( $object_id, $this->get_field( $field_id )->taxonomy );
		}

		return $this->get_meta_value( $object_id, $field_id, $meta_type );

	}


	/**
	 * Get a value from the standard WP meta api or the options api.
	 *
	 * @param string|int $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 *
	 * @return mixed
	 */
	protected function get_meta_value( $object_id, string $key, string $meta_type ) {
		// Settings page store all values in one option.
		if ( 'option' === $meta_type ) {
			$values = get_option( $object_id, [] );
			if ( ! isset( $values[ $key ] ) ) {
				return null;
			}

			return $values[ $key ];
		}

		return get_metadata( $meta_type, $object_id, $key, true );
	}


	/**
	 * Get the boolean result from a CMB2 checkbox
	 *
	 * @param int|string $object_id
	 * @param string     $key
	 * @param string     $meta_type
	 *
	 * @return bool
	 */
	public function get_checkbox_field_value( $object_id, string $key, string $meta_type ) : bool {
		$value = $this->get_meta_value( $object_id, $key, $meta_type );

		return ( 'on' === $value );
	}


	/**
	 * CMB2 saves file fields as 2 separate meta keys
	 * This returns and array of both of them.
	 *
	 * @param $object_id
	 * @param $key
	 * @param $meta_type
	 *
	 * @return array|false
	 */
	public function get_file_field_value( $object_id, $key, $meta_type ) : ?array {
		$url = $this->get_meta_value( $object_id, $key, $meta_type );
		if ( ! empty( $url ) ) {
			return [
				'id'  => $this->get_meta_value( $object_id, "{$key}_id", $meta_type ),
				'url' => $url,
			];
		}

		return null;
	}


	/**
	 * CMB2 saves taxonomy fields as terms
	 *
	 * @param $object_id
	 * @param $taxonomy
	 *
	 * @return array|false|\WP_Error
	 */
	public function get_taxonomy_field_value( $object_id, $taxonomy ) {
		return get_the_terms( $object_id, $taxonomy );
	}
}
