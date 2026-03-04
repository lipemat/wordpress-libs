<?php
//phpcs:disable
declare( strict_types=1 );

/**
 * Temporary placeholder for classes which are deprecated or moved.
 *
 * @todo Log to Wiki and remove in version 6.
 */
namespace Lipe\Lib\CMB2 {

	use Lipe\Lib\CMB2\Box\BoxType;
	use Lipe\Lib\CMB2\Field\Display;

	/**
	 * @deprecated Use Lipe\Lib\CMB2\Field\Default_Callback instead
	 */
	class Event_Callbacks extends Field\Event_Callbacks {
	}

	/**
	 * @deprecated Use Lipe\Lib\CMB2\Field\Field_Type instead
	 */
	class Field_Type extends Field\Field_Type {
	}

	/**
	 * @deprecated Use Lipe\Lib\CMB2\Field\Default_Callback instead
	 */
	class Default_Callback extends Field\Default_Callback {
	}

	// Cannot extend traits and enums.
	\class_alias( BoxType::class, 'Lipe\Lib\CMB2\BoxType' );
	\class_alias( Display::class, 'Lipe\Lib\CMB2\Display' );
}
