<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Variation;

use Lipe\Lib\CMB2\Field;

/**
 * @author Mat Lipe
 * @since  5.0.0
 *
 */
class Text extends Field {
	/**
	 * Used with `char_counter` to count character/words remaining.
	 *
	 * @var int
	 */
	public int $char_max;

	/**
	 * Used with `char_max` to enforce length when counting characters.
	 *
	 * @var bool
	 */
	public bool $char_max_enforce;

	/**
	 * Enable a character/word counter for a 'textarea', 'wysiwyg', or 'text' type field.
	 *
	 * @phpstan-var true|'words'
	 *
	 * @var bool|string
	 */
	protected string|bool $char_counter;


	/**
	 * Enable a character/word counter for a 'textarea', 'wysiwyg', or 'text' type field.
	 *
	 * @notice Does not work with repeatable wysiwyg.
	 *
	 * @phpstan-param array{
	 *     words_left_text?: string,
	 *     words_text?: string,
	 *     characters_left_text?: string,
	 *     characters_text?: string,
	 *     characters_truncated_text?: string
	 * }            $labels
	 *
	 *
	 * @param bool  $count_words   - Count words instead of characters.
	 * @param ?int  $max           - Show remaining character/words based on provided limit.
	 * @param bool  $enforce       - Enforce max length using `maxlength` attribute when
	 *                             characters are counted.
	 * @param array $labels        - Override the default text strings associated with these.
	 *                             'words_left_text' - Default: "Words left"
	 *                             'words_text' - Default: "Words"
	 *                             'characters_left_text' - Default: "Characters left"
	 *                             'characters_text' - Default: "Characters"
	 *                             'characters_truncated_text' - Default: "Your text may be truncated.".
	 *
	 * @return Text
	 */
	public function char_counter( bool $count_words = false, ?int $max = null, bool $enforce = false, array $labels = [] ): Text {
		$this->char_counter = $count_words ? 'words' : true;

		if ( null !== $max ) {
			$this->char_max = $max;
			if ( $enforce ) {
				if ( 'words' === $this->char_counter ) {
					\_doing_it_wrong( 'char_counter', esc_html__( 'You cannot enforce max length when counting words', 'lipe' ), '2.17.0' );
				}
				$this->char_max_enforce = true;
			}
		}

		if ( [] !== $labels ) {
			$this->text = \array_merge( $this->text, \array_intersect_key( $labels, \array_flip( [
				'words_left_text',
				'words_text',
				'characters_left_text',
				'characters_text',
				'characters_truncated_text',
			] ) ) );
		}

		return $this;
	}
}
