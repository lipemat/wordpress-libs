<?php
declare( strict_types=1 );

namespace Lipe\Lib\Settings\Settings_Page;

use Lipe\Lib\Query\Args_Interface;
use Lipe\Lib\Query\Args_Trait;

/**
 * A fluent interface for additional arguments supported by `add_settings_section`
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @link   https://developer.wordpress.org/reference/functions/add_settings_section/
 *
 */
class SectionArgs implements Args_Interface {
	use Args_Trait;

	/**
	 * HTML content to prepend to the section’s HTML output.
	 * Receives the section’s class name as %s.
	 *
	 * @var string
	 */
	public string $before_section;

	/**
	 * HTML content to append to the section’s HTML output.
	 *
	 * @var string
	 */
	public string $after_section;

	/**
	 * The class name to use for the section’s HTML container
	 * provided by `before_section`.
	 *
	 * @var string
	 */
	public string $section_class;
}
