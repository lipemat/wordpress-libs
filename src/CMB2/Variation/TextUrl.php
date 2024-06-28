<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Variation;

/**
 * Text URL variation field.
 *
 * @author Mat Lipe
 * @since  5.0.0
 */
class TextUrl extends Text {
	/**
	 * Used by the `text_url` field type to specify the protocols allowed.
	 *
	 * @var ?string[]
	 */
	public ?array $protocols = null;


	/**
	 * Used by the `text_url` field type to specify the protocols allowed.
	 *
	 * @param string[] $protocols - Array of allowed protocols.
	 */
	public function protocols( array $protocols ): TextUrl {
		$this->protocols = $protocols;
		return $this;
	}
}
