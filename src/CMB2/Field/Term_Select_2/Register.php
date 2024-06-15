<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Field\Term_Select_2;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\CMB2\Field\Term_Select_2;

/**
 * Register a Term Select 2 field.
 *
 * @author Mat Lipe
 * @since  5.0.0
 */
class Register implements \JsonSerializable {
	/**
	 * Register constructor.
	 *
	 * @param Field  $field        - The field to register.
	 * @param string $taxonomy     - The taxonomy to use.
	 * @param bool   $assign_terms - Should the terms be assigned to the post.
	 */
	final protected function __construct(
		public readonly Field $field,
		public readonly string $taxonomy,
		public readonly bool $assign_terms,
	) {
		Term_Select_2::in()->register( $this );
	}


	/**
	 * Is this field repeatable?
	 *
	 * @return bool
	 */
	public function is_repeatable(): bool {
		return $this->field->get_field_args()['repeatable'] ?? false;
	}


	/**
	 * Data passed to the JS Config for the field.
	 *
	 * @return array{id: string, noResultsText: string}
	 */
	public function jsonSerialize(): array {
		return [
			'id'            => $this->field->get_id(),
			'noResultsText' => $this->field->text['no_terms_text'] ?? get_taxonomy( $this->taxonomy )->labels->not_found ?? '',
		];
	}


	/**
	 * Create a new instance of the Register class.
	 *
	 * @param Field  $field        - The field to register.
	 * @param string $taxonomy     - The taxonomy to use.
	 * @param bool   $assign_terms - Should the terms be assigned to the post.
	 *
	 * @return static
	 */
	public static function factory( Field $field, string $taxonomy, bool $assign_terms ): static {
		return new static( $field, $taxonomy, $assign_terms );
	}
}
