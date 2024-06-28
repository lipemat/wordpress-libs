<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Field\Type;
use Lipe\Lib\Meta\Repo;
use Lipe\Lib\Traits\Singleton;

/**
 * Utils for working with fields.
 *
 * @author Mat Lipe
 * @since  5.0.0
 */
class Utils {
	use Singleton;

	/**
	 * Is this field repeatable?
	 *
	 * @param Field $field - Field instance.
	 *
	 * @return bool
	 */
	public function is_repeatable( Field $field ): bool {
		return $field->get_field_args()['repeatable'] ?? false;
	}


	/**
	 * Does this field return a value of array type?
	 *
	 * @param Field $field - Field instance.
	 *
	 * @return bool
	 */
	public function is_using_array_data( Field $field ): bool {
		return $this->is_repeatable( $field ) || Type::MULTI_CHECK === $field->get_type() || Type::MULTI_CHECK_INLINE === $field->get_type();
	}


	/**
	 * Does this field return a value of object type?
	 *
	 * @param Field $field - Field instance.
	 *
	 * @return bool
	 */
	public function is_using_object_data( Field $field ): bool {
		return ! $this->is_repeatable( $field ) && Type::FILE_LIST === $field->get_type();
	}


	/**
	 * Get the short name of a field for use in the REST API.
	 *
	 * @param Field $field - Field instance.
	 *
	 * @return string
	 */
	public function get_rest_short_name( Field $field ): string {
		$name = \explode( '/', $field->get_id() );
		return \end( $name );
	}


	/**
	 * Should the field be added to the GET endpoint?
	 *
	 * If we register the meta, it will be available for all methods
	 * so if a method other than `ALLMETHODS` is specified, we
	 * can't add it to the REST api via meta.
	 *
	 * @param Field $field - The field to check.
	 *
	 * @return bool
	 */
	public function is_public_rest_data( Field $field ): bool {
		return (bool) $field->show_in_rest && ( \WP_REST_Server::ALLMETHODS === $field->show_in_rest );
	}


	/**
	 * Is this field allowed to be registered with meta?
	 *
	 * @param Field $field - The field to check.
	 *
	 * @return bool
	 */
	public function is_allowed_to_register_meta( Field $field ): bool {
		return \in_array( $field->data_type, [ Repo::TYPE_CHECKBOX, Repo::TYPE_DEFAULT, Repo::TYPE_FILE ], true );
	}
}
