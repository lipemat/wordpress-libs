<?php
declare( strict_types=1 );

namespace Lipe\Lib\Settings\Settings_Page;

use Lipe\Lib\Args\ArgsRules;
use Lipe\Lib\Args\ArgsTrait;

/**
 * A fluent interface for additional arguments supported by `add_settings_field`.
 *
 * @author Mat Lipe
 * @since  4.10.0
 *
 * @link   https://developer.wordpress.org/reference/functions/add_settings_field/#parameters
 *
 */
class FieldArgs implements ArgsRules {
	/**
	 * @use ArgsTrait<array{label_for?:string, class?: string}>
	 */
	use ArgsTrait;

	/**
	 * When supplied, the setting title will be wrapped
	 * in a `<label>` element, its `for` attribute populated
	 * with this value.
	 *
	 * @var string
	 */
	public string $label_for;

	/**
	 * CSS Class to be added to the `<tr>` element when the
	 * field is output.
	 *
	 * @var string
	 */
	public string $class;
}
