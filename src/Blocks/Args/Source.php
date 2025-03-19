<?php
declare( strict_types=1 );

namespace Lipe\Lib\Blocks\Args;

/**
 * A fluent interface of the `source` type for a block attribute.
 *
 * @author Mat Lipe
 * @since  5.4.0
 *
 * @link   https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/#value-source
 */
class Source {
	public const SOURCE_ATTRIBUTE = 'attribute';
	public const SOURCE_TEXT      = 'text';
	public const SOURCE_HTML      = 'html';
	public const SOURCE_QUERY     = 'query';


	/**
	 * Constructs a new attribute source.
	 *
	 * @param Prop $prop -- Prop where the source will be stored.
	 */
	public function __construct(
		protected Prop $prop
	) {
	}


	/**
	 * Store/retrieve values from an HTML attribute.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/#attribute-source
	 *
	 * @param string $selector  - A DOM selector supported by `querySelector`.
	 * @param string $attribute - The HTML attribute to get.
	 *
	 * @return Prop
	 */
	public function attribute( string $selector, string $attribute ): Prop {
		$this->prop->selector = $selector;
		$this->prop->attribute = $attribute;
		$this->prop->source = self::SOURCE_ATTRIBUTE;
		return $this->prop;
	}


	/**
	 * Store/retrieve values from the text contents of an HTML element.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/#text-source
	 * @link https://developer.mozilla.org/en-US/docs/Web/API/Node/textContent
	 *
	 * @param string $selector - A DOM selector supported by `querySelector`.
	 *
	 * @return Prop
	 */
	public function text( string $selector ): Prop {
		$this->prop->selector = $selector;
		$this->prop->source = self::SOURCE_TEXT;
		return $this->prop;
	}


	/**
	 * Store/retrieve values from the HTML contents of an HTML element.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/#html-source
	 * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/innerHTML
	 *
	 * @param string $selector - A DOM selector supported by `querySelector`.
	 *
	 * @return Prop
	 */
	public function html( string $selector ): Prop {
		$this->prop->selector = $selector;
		$this->prop->source = self::SOURCE_HTML;
		return $this->prop;
	}


	/**
	 * Store/retrieve values from a list of HTML elements.
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/#query-source
	 *
	 * @param string              $selector - A DOM selector supported by `querySelector`.
	 * @param array<string, Prop> $query    - List of props to query for out of the HTML markup.
	 *
	 * @return Prop
	 */
	public function query( string $selector, array $query ): Prop {
		$this->prop->selector = $selector;
		$this->prop->source = self::SOURCE_QUERY;
		\array_walk( $query, function( $prop ) {
			unset( $prop->selector );
		} );
		$this->prop->query = $query;
		return $this->prop;
	}
}
