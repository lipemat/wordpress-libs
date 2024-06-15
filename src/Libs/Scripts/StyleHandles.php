<?php
declare( strict_types=1 );

namespace Lipe\Lib\Libs\Scripts;

/**
 * Handles for internal stylesheets to be enqueued.
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 */
enum StyleHandles: string {
	case CHECKBOX     = 'lipe/lib/libs/styles/checkbox';
	case GROUP_LAYOUT = 'lipe/lib/libs/styles/group-layout';
	case META_BOXES   = 'lipe/lib/libs/styles/meta-boxes';
	case TABS         = 'lipe/lib/libs/styles/tabs';
	case TRUE_FALSE   = 'lipe/lib/libs/styles/true-false';


	/**
	 * Get the file name for this style.
	 *
	 * @return string
	 */
	public function file(): string {
		return match ( $this ) {
			self::CHECKBOX     => 'checkbox',
			self::GROUP_LAYOUT => 'group-layout',
			self::META_BOXES   => 'meta-boxes',
			self::TABS         => 'tabs',
			self::TRUE_FALSE   => 'true-false',
		};
	}
}
