<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

/**
 * Possible data types for the Meta repo.
 *
 * @author Mat Lipe
 * @since  5.0.0
 *
 */
enum DataType: string {
	case CHECKBOX          = 'checkbox';
	case DEFAULT           = 'default';
	case FILE              = 'file';
	case GROUP             = 'group';
	case TAXONOMY          = 'taxonomy';
	case TAXONOMY_SINGULAR = 'taxonomy-singular';
}
