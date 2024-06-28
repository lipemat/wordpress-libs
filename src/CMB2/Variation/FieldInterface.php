<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Variation;

use Lipe\Lib\CMB2\Box;
use Lipe\Lib\CMB2\Group;

interface FieldInterface {
	/**
	 * Field constructor.
	 *
	 * @interal
	 *
	 * @see Field_Type
	 *
	 * @param string $id    - ID of the field.
	 * @param string $name  - Field label.
	 * @param Box    $box   - Parent class using this Field.
	 * @param ?Group $group - Group this field is assigned to.
	 */
	public function __construct( string $id, string $name, Box $box, ?Group $group );
}
