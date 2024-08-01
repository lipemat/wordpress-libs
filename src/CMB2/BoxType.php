<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

/**
 * Types of CMB2 meta boxes.
 *
 * @author Mat Lipe
 * @since  5.0.0
 *
 * @see    Box::get_box_type()
 */
enum BoxType: string {
	case COMMENT = 'comment';
	case OPTIONS = 'options-page';
	case USER    = 'user';
	case TERM    = 'term';
	case POST    = 'post';
}
