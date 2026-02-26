<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2;

use Lipe\Lib\CMB2\Box\BoxType;

/**
 * CMB2 comments meta box fluent interface.
 */
class Comment_Box extends Box {
	public const CONTEXT_NORMAL = 'normal';
	public const CONTEXT_SIDE   = 'side';


	/**
	 * CMB2 comments meta box constructor.
	 *
	 * @param string $id    Metabox ID.
	 * @param string $title Metabox title.
	 */
	public function __construct( string $id, string $title ) {
		parent::__construct( $id, [ BoxType::COMMENT->value ], $title );
		$this->context( static::CONTEXT_NORMAL );
	}


	/**
	 * Set the display location of the meta box.
	 *
	 * @phpstan-param self::CONTEXT_* $context
	 *
	 * @param string                  $context - Location the metabox will display.
	 *
	 * @return void
	 */
	public function context( string $context ): void {
		$this->context = $context;
	}
}
