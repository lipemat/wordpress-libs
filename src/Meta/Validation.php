<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

use Lipe\Lib\CMB2\Box;
use Lipe\Lib\CMB2\Field;
use Lipe\Lib\CMB2\Field\Term_Select_2;
use Lipe\Lib\CMB2\Field\Term_Select_2\Register;
use Lipe\Lib\CMB2\Field\Type;
use Lipe\Lib\CMB2\Variation\Taxonomy;
use Lipe\Lib\Traits\Singleton;

/**
 * Misc validation methods for meta fields which require the entire field set
 * before they can be validated.
 *
 * @since 4.10.0
 */
trait Validation {
	use Singleton;

	/**
	 * Check if we are accessing a sub-field directly on a repeatable group.
	 *
	 * Using a sub-field directly on a repeatable group will only update the first item
	 * and cause unexpected data integrity issues.
	 *
	 * @param string $field_id - ID of the field to check.
	 *
	 * @return void
	 */
	protected function warn_for_repeatable_group_sub_fields( string $field_id ): void {
		if ( true === $this->get_field( $field_id )?->get_group()?->is_repeatable() ) {
			/* translators: {field id} */
			_doing_it_wrong( __METHOD__, wp_kses_post( \sprintf( __( 'Accessing sub-fields on repeatable groups will only update the first item. Use the group key instead. %s', 'lipe' ), $field_id ) ), '4.10.0' );
		}
	}


	/**
	 * Check to make sure we have only registered on taxonomy field per object type.
	 *
	 * Multiple taxonomy fields on the same object type will cause unexpected assigning of object terms.
	 *
	 * @return void
	 */
	protected function warn_for_conflicting_taxonomies(): void {
		$map = [];
		foreach ( $this->fields as $field ) {
			$box = $field->get_box();
			if ( ! $field instanceof Taxonomy || ! Repo::in()->supports_taxonomy_relationships( $field->get_box()->get_object_type(), $field ) ) {
				continue;
			}
			foreach ( $box->get_object_types() as $object_type ) {
				if ( ! isset( $map[ $object_type ] ) ) {
					$map[ $object_type ][ $field->taxonomy ] = [];
				}
				// Term select 2 can turn off assigning terms which won't conflict.
				if ( Type::TERM_SELECT_2 === $field->get_type() ) {
					$registered = Term_Select_2::in()->get_registered( $field->get_id() );
					if ( $registered instanceof Register && $registered->assign_terms ) {
						$map[ $object_type ][ $field->taxonomy ][] = $field;
					}
				} else {
					$map[ $object_type ][ $field->taxonomy ][] = $field;
				}
			}
		}
		foreach ( $map as $object_type => $taxonomies ) {
			foreach ( $taxonomies as $taxonomy => $tax_fields ) {
				if ( \count( $tax_fields ) > 1 ) {
					_doing_it_wrong( __METHOD__, wp_kses_post( \sprintf(
					/* translators: {field ids} {taxonomy} {post type} */
						__( 'Fields: "%1$s" are conflicting on the taxonomy: %2$s for object type: %3$s. You may only have taxonomy field per an object.', 'lipe' ),
						\implode( ', ', \array_map( fn( Field $field ) => $field->get_id(), $tax_fields ) ),
						$taxonomy,
						$object_type
					) ), '4.10.0' );
				}
			}
		}
	}
}
