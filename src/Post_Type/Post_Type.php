<?php
/**
 * Temporary alias until version 6.
 *
 * @todo Rename `Custom_Post_Type` to `Post_Type` in version 6.
 */

declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

\class_alias( Custom_Post_Type::class, 'Lipe\Lib\Post_Type\Post_Type' );
