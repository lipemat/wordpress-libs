<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Variation;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\CMB2\BoxType;
use Lipe\Lib\Meta\DataType;
use Lipe\Lib\Taxonomy\Get_Terms;

/**
 * @author Mat Lipe
 * @since  5.0.0
 *
 */
class Taxonomy extends Field {
	/**
	 * Used for taxonomy fields.
	 *
	 * Set to the taxonomy slug.
	 *
	 * @notice These fields will save terms not meta.
	 *
	 * @link   https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_select
	 *
	 * @var string
	 */
	protected string $taxonomy;

	/**
	 * Whether to show select all button for items
	 * with multi select like multicheck.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck
	 *
	 * @default true
	 *
	 * @var bool
	 */
	protected bool $select_all_button;

	/**
	 * New field parameter for taxonomy fields, 'remove_default'
	 * which allows disabling the default taxonomy metabox.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#remove_default
	 *
	 * @default false
	 *
	 * @var bool
	 */
	protected bool $remove_default;

	/**
	 * Field parameter, which can be used to override the arguments passed to get_terms()
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#query_args
	 *
	 * @var  array<string, mixed>
	 */
	protected array $query_args;

	/**
	 * Save terms assigned to users as meta instead of the default
	 * object terms system.
	 *
	 * Prevent conflicts with User ID and Post ID in the same
	 * `term_relationship` table.
	 *
	 * @notice Required lipemat version of CMB2 to support this argument.
	 *
	 * @see    \CMB2_Type_Taxonomy_Base::get_object_terms
	 *
	 * @var bool
	 */
	protected bool $store_user_terms_in_meta = true;


	/**
	 * New field parameter for taxonomy fields, 'remove_default'
	 * which allows disabling the default taxonomy metabox.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Parameters#remove_default
	 *
	 * @default false
	 *
	 * @param bool $remove_default - Whether to remove the default metabox.
	 */
	public function remove_default( bool $remove_default ): Taxonomy {
		$this->remove_default = $remove_default;
		return $this;
	}


	/**
	 * Whether to show select all button for items
	 * with multi select like multicheck.
	 *
	 * @link    https://github.com/CMB2/CMB2/wiki/Field-Types#taxonomy_multicheck
	 *
	 * @default true
	 *
	 * @param bool $select_all_button - Whether to show the select all button.
	 */
	public function select_all_button( bool $select_all_button ): Taxonomy {
		$this->select_all_button = $select_all_button;
		return $this;
	}


	/**
	 * Field parameter, which can be used by the  'taxonomy_*' field types.
	 * allows overriding the media library query arguments.
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Parameters#query_args
	 *
	 * @param Get_Terms $args - The arguments to pass to get_terms().
	 *
	 * @return Taxonomy
	 */
	public function term_query_args( Get_Terms $args ): Taxonomy {
		$this->query_args = $args->get_args();
		return $this;
	}


	/**
	 * A field for selecting a taxonomy.
	 *
	 * @param string  $taxonomy       - slug.
	 * @param ?string $no_terms_text  - text to display when no terms are found.
	 * @param ?bool   $remove_default - remove default WP terms metabox.
	 *
	 * @return array<string, mixed>
	 */
	public function taxonomy_args( string $taxonomy, ?string $no_terms_text = null, ?bool $remove_default = null ): array {
		$this->taxonomy = $taxonomy;
		$_args = [
			'taxonomy' => $taxonomy,
		];
		if ( null !== $remove_default ) {
			$_args['remove_default'] = $remove_default;
		}
		if ( null !== $no_terms_text ) {
			$_args['text']['no_terms_text'] = $no_terms_text;
		}

		return $_args;
	}


	/**
	 * Save terms assigned to users as meta instead of the default
	 * object terms system.
	 *
	 * Prevent conflicts with User ID and Post ID in the same
	 * `term_relationship` table.
	 *
	 * @note   The meta repo has never supported using object terms so setting
	 *         this to false will not change the behavior of the meta repo.
	 *
	 * @notice The default value is `true` so this need only be called with `false`.
	 *
	 * @param bool $use_meta - Whether to use meta or not.
	 *
	 * @return Taxonomy
	 */
	public function store_user_terms_in_meta( bool $use_meta = true ): Taxonomy {
		if ( ! \in_array( $this->data_type, [ DataType::TAXONOMY, DataType::TAXONOMY_SINGULAR ], true ) || ! \in_array( BoxType::USER->value, $this->box->get_object_types(), true ) ) {
			_doing_it_wrong( __METHOD__, 'Storing user terms in meta only applies to taxonomy fields registered on users.', '3.14.0' );
		}
		$this->store_user_terms_in_meta = $use_meta;

		return $this;
	}


	/**
	 * Get the taxonomy slug.
	 *
	 * @return string
	 */
	public function get_taxonomy(): string {
		return $this->taxonomy;
	}
}
