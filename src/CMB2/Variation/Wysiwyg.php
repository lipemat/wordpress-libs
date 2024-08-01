<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Variation;

/**
 * Wysiwyg field variation.
 *
 * @author Mat Lipe
 * @since  5.0.0
 *
 * @phpstan-type MCE_OPTIONS array{
 *      wpautop?: bool,
 *      media_buttons?: bool,
 *      textarea_name?: string,
 *      textarea_rows?: int,
 *      tabindex?: int,
 *      editor_css?: string,
 *      editor_class?: string,
 *      teeny?: bool,
 *      dfw?: bool,
 *      tinymce?: bool,
 *      quicktags?: bool,
 *  }
 */
class Wysiwyg extends Text {
	/**
	 * Tinymce options.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#wysiwyg
	 *
	 * @var  MCE_OPTIONS
	 */
	protected array $options = [];
}
