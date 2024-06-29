<?php
declare( strict_types=1 );

namespace Lipe\Lib\Meta;

/**
 * Possible meta types for the Meta repo.
 *
 * @author Mat Lipe
 * @since  5.0.0
 */
enum MetaType: string {
	case BLOG    = 'blog';
	case COMMENT = 'comment';
	case OPTION  = 'option';
	case POST    = 'post';
	case TERM    = 'term';
	case USER    = 'user';
	case SITE    = 'site';
}
