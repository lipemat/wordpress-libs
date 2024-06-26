<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\Traits\Singleton;

/**
 * Repo to hold the different field types for our meta keys
 * and return the appropriate data based on field type.
 */
class Repo extends Translate_Abstract {
	use Singleton;
	use Validation;

	public const TYPE_CHECKBOX          = 'checkbox';
	public const TYPE_DEFAULT           = 'default';
	public const TYPE_FILE              = 'file';
	public const TYPE_GROUP             = 'group';
	public const TYPE_TAXONOMY          = 'taxonomy';
	public const TYPE_TAXONOMY_SINGULAR = 'taxonomy-singular';

	public const META_BLOG    = 'blog';
	public const META_COMMENT = 'comment';
	public const META_OPTION  = 'option';
	public const META_POST    = 'post';
	public const META_TERM    = 'term';
	public const META_USER    = 'user';


	/**
	 * Store a field's id mapped to the field object
	 *
	 * @param Field $field - The field to register.
	 *
	 * @return void
	 */
	public function register_field( Field $field ): void {
		$this->fields[ $field->get_id() ] = $field;
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
		$this->warn_for_conflicting_taxonomies();
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
		$this->warn_for_repeatable_group_sub_fields( $key );
	}


	/**
	 * Get a registered field by an id.
	 *
	 * @param ?string $field_id - The field id to return.
	 *
	 * @return null|Field
	 */
	protected function get_field( ?string $field_id ): ?Field {
		return $this->fields[ $field_id ] ?? null;
	}


	/**
	 * Get the data type of registered field by an id.
	 *
	 * @phpstan-return static::TYPE_*
	 *
	 * @param string $field_id - The field id whose type to return.
	 *
	 * @return string
	 */
	protected function get_field_data_type( string $field_id ): string {
		$field = $this->get_field( $field_id );
		if ( null !== $field ) {
			return $field->data_type;
		}
		return static::TYPE_DEFAULT;
	}


	/**
	 * Get a field's value.
	 *
	 * Use the registered fields and registered types to determine the appropriate method to
	 * return the data.
	 *
	 * @phpstan-param static::META_* $meta_type
	 *
	 * @param int|string             $object_id - id of post, term, user, <custom>.
	 * @param string                 $field_id  - field id to return.
	 * @param string                 $meta_type - user, term, post, <custom> (defaults to 'post').
	 *
	 * @return mixed
	 */
	public function get_value( int|string $object_id, string $field_id, string $meta_type = 'post' ): mixed {
		return match ( $this->get_field_data_type( $field_id ) ) {
			static::TYPE_CHECKBOX          => $this->get_checkbox_field_value( $object_id, $field_id, $meta_type ),
			static::TYPE_FILE              => $this->get_file_field_value( $object_id, $field_id, $meta_type ),
			static::TYPE_GROUP             => $this->get_group_field_value( $object_id, $field_id, $meta_type ),
			static::TYPE_TAXONOMY          => $this->get_taxonomy_field_value( $object_id, $field_id, $meta_type ),
			static::TYPE_TAXONOMY_SINGULAR => $this->get_taxonomy_singular_field_value( $object_id, $field_id, $meta_type ),
			default                        => $this->get_meta_value( $object_id, $field_id, $meta_type ),
		};
	}


	/**
	 * Update a field's value
	 *
	 * Use the registered fields and registered types to determine the appropriate method to
	 * set the data.
	 *
	 * @phpstan-param static::META_* $meta_type
	 *
	 * @param int|string             $object_id - id of post, term, user, <custom>.
	 * @param string                 $field_id  - field id to set.
	 * @param mixed                  $value     - Value to save.
	 * @param string                 $meta_type - user, term, post, <custom> (defaults to 'post').
	 *
	 * @return void
	 */
	public function update_value( int|string $object_id, string $field_id, mixed $value, string $meta_type = 'post' ): void {
		match ( $this->get_field_data_type( $field_id ) ) {
			static::TYPE_CHECKBOX          => $this->update_checkbox_field_value( $object_id, $field_id, $value, $meta_type ),
			static::TYPE_FILE              => $this->update_file_field_value( $object_id, $field_id, (int) $value, $meta_type ),
			static::TYPE_GROUP             => $this->update_group_field_values( $object_id, $field_id, (array) $value, $meta_type ),
			static::TYPE_TAXONOMY          => $this->update_taxonomy_field_value( $object_id, $field_id, (array) $value, $meta_type ),
			static::TYPE_TAXONOMY_SINGULAR => $this->update_taxonomy_field_value( $object_id, $field_id, (array) $value, $meta_type, true ),
			default                        => $this->update_meta_value( $object_id, $field_id, $value, $meta_type ),
		};
	}


	/**
	 * Delete a field's value
	 *
	 * Use the registered fields and registered types to determine the appropriate method to
	 * delete the data.
	 *
	 * @phpstan-param static::META_* $meta_type
	 *
	 * @param int|string             $object_id - id of post, term, user, <custom>.
	 * @param string                 $field_id  - field id to set.
	 * @param string                 $meta_type - user, term, post, <custom> (defaults to 'post').
	 *
	 * @return void
	 */
	public function delete_value( int|string $object_id, string $field_id, string $meta_type ): void {
		match ( $this->get_field_data_type( $field_id ) ) {
			static::TYPE_FILE              => $this->delete_file_field_value( $object_id, $field_id, $meta_type ),
			static::TYPE_TAXONOMY,
			static::TYPE_TAXONOMY_SINGULAR => $this->delete_taxonomy_field_value( $object_id, $field_id, $meta_type ),
			default                        => $this->delete_meta_value( $object_id, $field_id, $meta_type ),
		};
	}
}
