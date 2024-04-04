<?php

namespace Lipe\Lib\CMB2;

/**
 * CMB2 comments meta box fluent interface.
 */
class Comment_Box extends Box {
	public const CONTEXT_NORMAL = 'normal';
	public const CONTEXT_SIDE   = 'side';


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


	/**
	 * CMB2 comments meta box constructor.
	 *
	 * @param string $id    Metabox ID.
	 * @param string $title Metabox title.
	 */
	public function __construct( $id, $title ) {
		parent::__construct( $id, [ 'comment' ], $title );
		$this->context( static::CONTEXT_NORMAL );
	}
}
