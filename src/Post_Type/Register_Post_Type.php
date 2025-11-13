<?php
/**
 * Temporary alias until version 6.
 *
 * @todo Move the `Register_Post_Type` class into the "Post_Type" namespace in version 6.
 */

declare( strict_types=1 );

namespace Lipe\Lib\Post_Type;

use Lipe\Lib\Post_Type\Custom_Post_Type\Register_Post_Type;

\class_alias( Register_Post_Type::class, 'Lipe\Lib\Post_Type\Register_Post_Type' );
