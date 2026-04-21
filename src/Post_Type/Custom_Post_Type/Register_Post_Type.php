<?php
//phpcs:disable Squiz.Commenting.VariableComment.MissingVar -- Just clutters up typed code.
declare( strict_types=1 );

namespace Lipe\Lib\Post_Type\Custom_Post_Type;

use Lipe\Lib\Args\Args;
use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Post_Type\Capabilities;

/**
 * Deprecated. Use `Post_Type\Register_Post_Type` instead.
 *
 * @deprecated     This class is deprecated and will be removed in version 6. Use `Post_Type\Register_Post_Type` instead.
 *
 * @phpstan-ignore lipemat.classExtendsNotAllowed
 */
class Register_Post_Type extends \Lipe\Lib\Post_Type\Register_Post_Type {
	/**
	 * Constructor.
	 *
	 * @param array<string, mixed> $existing - Existing post type data.
	 */
	public function __construct( array $existing ) {
		_deprecated_class( __CLASS__, '5.10', 'Use `Post_Type\Register_Post_Type` instead.' );
		parent::__construct( $existing );
	}
}
