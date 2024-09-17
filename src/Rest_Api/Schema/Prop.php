<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api\Schema;

use Lipe\Lib\Args\Args;

/**
 * Shared properties that a schema property can have.
 *
 * @since 5.2.0
 */
trait Prop {
	/**
	 * @use Args<array<string, mixed>>
	 */
	use Args {
		get_args as parent_get_args;
	}

	/**
	 * Is this property required?
	 *
	 * @var bool
	 */
	public bool $required;

	/**
	 * Description of the property.
	 *
	 * @var string
	 */
	public string $description;

	/**
	 * Title of the property resource.
	 *
	 * @var string
	 */
	public string $title;

	/**
	 * Data type of the property.
	 *
	 * @var Type
	 */
	protected Type $type;


	/**
	 * Mark the identity of the property.
	 *
	 * @param string $title - Title of the resource.
	 *
	 * @return static
	 */
	public function title( string $title ): static {
		$this->title = $title;

		return $this;
	}


	/**
	 * Set a fields description.
	 *
	 * @param string $description - The field's description.
	 *
	 *
	 * @return $this
	 */
	public function description( string $description ): static {
		$this->description = $description;
		return $this;
	}


	/**
	 * Mark a field as required.
	 *
	 * @param bool $is_required - Is this property required?.
	 *
	 * @return static
	 */
	public function required( bool $is_required ): static {
		$this->required = $is_required;
		return $this;
	}


	/**
	 * Define the type of the property.
	 *
	 * @return Type
	 */
	public function type(): Type {
		$this->type = new Type();
		return $this->type;
	}


	/**
	 * @return array<string, mixed>
	 */
	public function get_args(): array {
		$args = $this->parent_get_args();
		if ( ! isset( $this->type ) ) {
			return $args;
		}
		return \array_merge( $args, $this->type->get_args() );
	}
}
