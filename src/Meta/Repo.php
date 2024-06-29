<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\Traits\Singleton;

/**
 * Repo to hold the different field types for our meta keys
 * and return the appropriate data based on field type.
 */
class Repo {
	use Singleton;
	use Translate;

	/**
	 * Store a field's id mapped to the field object
	 *
	 * @param Field $field - The field to register.
	 *
	 * @return Registered
	 */
	public function register_field( Field $field ): Registered {
		$this->registered[ $field->id ] = Registered::factory( $field );
		return $this->registered[ $field->id ];
	}


	/**
	 * Handle any special field validation after all fields are
	 * registered.
	 *
	 * @since 4.10.0
	 *
	 * @interal
	 *
	 * @return void
	 */
	public function validate_fields(): void {
		Validation::in()->warn_for_conflicting_taxonomies( $this->registered );
	}


	/**
	 * Handle any special field validation for a single field.
	 *
	 * @since 4.10.0
	 *
	 * @interal
	 *
	 * @param string $key - ID of the field.
	 *
	 * @return void
	 */
	public function pre_update_field( string $key ): void {
		Validation::in()->warn_for_repeatable_group_sub_fields( $key, $this->get_registered( $key ) );
	}


	/**
	 * Get a registered field by an id.
	 *
	 * @param ?string $field_id - The field id to return.
	 *
	 * @return ?Registered
	 */
	protected function get_registered( ?string $field_id ): ?Registered {
		return $this->registered[ $field_id ] ?? null;
	}


	/**
	 * Get the data type of registered field by an id.
	 *
	 * @param string $field_id - The field id whose type to return.
	 *
	 * @return DataType
	 */
	protected function get_field_data_type( string $field_id ): DataType {
		$field = $this->get_registered( $field_id );
		if ( null !== $field ) {
			return $field->get_data_type();
		}
		return DataType::DEFAULT;
	}


	/**
	 * Get a field's value.
	 *
	 * Use the registered fields and registered types to determine the appropriate method to
	 * return the data.
	 *
	 * @param int|string $object_id - id of post, term, user, <custom>.
	 * @param string     $field_id  - field id to return.
	 * @param MetaType   $meta_type - user, term, post, <custom> (defaults to 'post').
	 *
	 * @return mixed
	 */
	public function get_value( int|string $object_id, string $field_id, MetaType $meta_type = MetaType::POST ): mixed {
		return match ( $this->get_field_data_type( $field_id ) ) {
			DataType::CHECKBOX          => $this->get_checkbox_field_value( $object_id, $field_id, $meta_type ),
			DataType::FILE              => $this->get_file_field_value( $object_id, $field_id, $meta_type ),
			DataType::GROUP             => $this->get_group_field_value( $object_id, $field_id, $meta_type ),
			DataType::TAXONOMY          => $this->get_taxonomy_field_value( $object_id, $field_id, $meta_type ),
			DataType::TAXONOMY_SINGULAR => $this->get_taxonomy_singular_field_value( $object_id, $field_id, $meta_type ),
			default                     => $this->get_meta_value( $object_id, $field_id, $meta_type ),
		};
	}


	/**
	 * Update a field's value
	 *
	 * Use the registered fields and registered types to determine the appropriate method to
	 * set the data.
	 *
	 * @param int|string $object_id - id of post, term, user, <custom>.
	 * @param string     $field_id  - field id to set.
	 * @param mixed      $value     - Value to save.
	 * @param MetaType   $meta_type - user, term, post, <custom> (defaults to 'post').
	 *
	 * @return void
	 */
	public function update_value( int|string $object_id, string $field_id, mixed $value, MetaType $meta_type = MetaType::POST ): void {
		match ( $this->get_field_data_type( $field_id ) ) {
			DataType::CHECKBOX          => $this->update_checkbox_field_value( $object_id, $field_id, $value, $meta_type ),
			DataType::FILE              => $this->update_file_field_value( $object_id, $field_id, (int) $value, $meta_type ),
			DataType::GROUP             => $this->update_group_field_values( $object_id, $field_id, (array) $value, $meta_type ),
			DataType::TAXONOMY          => $this->update_taxonomy_field_value( $object_id, $field_id, (array) $value, $meta_type ),
			DataType::TAXONOMY_SINGULAR => $this->update_taxonomy_field_value( $object_id, $field_id, (array) $value, $meta_type, true ),
			default                     => $this->update_meta_value( $object_id, $field_id, $value, $meta_type ),
		};
	}


	/**
	 * Delete a field's value
	 *
	 * Use the registered fields and registered types to determine the appropriate method to
	 * delete the data.
	 *
	 * @param int|string $object_id - id of post, term, user, <custom>.
	 * @param string     $field_id  - field id to set.
	 * @param MetaType   $meta_type - user, term, post, <custom> (defaults to 'post').
	 *
	 * @return void
	 */
	public function delete_value( int|string $object_id, string $field_id, MetaType $meta_type ): void {
		match ( $this->get_field_data_type( $field_id ) ) {
			DataType::FILE              => $this->delete_file_field_value( $object_id, $field_id, $meta_type ),
			DataType::TAXONOMY,
			DataType::TAXONOMY_SINGULAR => $this->delete_taxonomy_field_value( $object_id, $field_id, $meta_type ),
			default                     => $this->delete_meta_value( $object_id, $field_id, $meta_type ),
		};
	}
}
