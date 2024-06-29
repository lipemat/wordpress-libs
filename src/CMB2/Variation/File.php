<?php
declare( strict_types=1 );

namespace Lipe\Lib\CMB2\Variation;

use Lipe\Lib\CMB2\Field;
use Lipe\Lib\CMB2\Field\Type;
use Lipe\Lib\Query\Get_Posts;

/**
 * @author Mat Lipe
 * @since  5.0.0
 *
 */
class File extends Field {
	/**
	 * Special options for the file field type.
	 *
	 * @var array{
	 *     url?: bool,
	 * }
	 */
	protected array $options = [];

	/**
	 * For use with the file fields only to control the preview size
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file
	 *
	 * @var string
	 */
	public string $preview_size;

	/**
	 * Field parameter, which can be used to override the media library query arguments.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Parameters#query_args
	 *
	 * @var  array<string, mixed>
	 */
	protected array $query_args;


	/**
	 * Field parameter, which can be used by the  'file_*' field types.
	 * allows overriding the media library query arguments.
	 *
	 * @link  https://github.com/CMB2/CMB2/wiki/Field-Parameters#query_args
	 *
	 * @param Get_Posts $args - The arguments to pass to get_posts().
	 *
	 * @return File
	 */
	public function file_query_args( Get_Posts $args ): File {
		$this->query_args = $args->get_args();
		return $this;
	}


	/**
	 * A field for uploading a list of files.
	 *
	 * @link https://github.com/CMB2/CMB2/wiki/Field-Types#file_list
	 *
	 * @param string|null $button_text      - (default 'Add File').
	 * @param string|null $file_mime_type   - (default all).
	 * @param ?bool       $show_text_input  - (default true) May not be turned off for required fields.
	 * @param ?string     $preview_size     - (default full).
	 * @param ?string     $remove_item_text - (default 'Remove').
	 * @param ?string     $file_text        - (default 'File').
	 * @param ?string     $download_text    - (default 'Download').
	 * @param ?string     $select_text      - Media manager button label (default: Use this file).
	 *
	 * @return array<string, mixed>
	 */
	public function file_args(
		?string $button_text = null,
		?string $file_mime_type = null,
		?bool $show_text_input = null,
		?string $preview_size = null,
		?string $remove_item_text = null,
		?string $file_text = null,
		?string $download_text = null,
		?string $select_text = null
	): array {
		$_args = [];
		if ( null !== $button_text ) {
			$_args['text']['add_upload_file_text'] = $button_text;
		}
		if ( null !== $remove_item_text ) {
			$_args['text']['remove_image_text'] = $remove_item_text;
			$_args['text']['remove_item_text'] = $remove_item_text;
		}
		if ( null !== $file_text ) {
			$_args['text']['file_text'] = $file_text;
		}
		if ( null !== $download_text ) {
			$_args['text']['file_download_text'] = $download_text;
		}
		if ( null !== $file_mime_type ) {
			$_args['query_args'] = [
				'type' => $file_mime_type,
			];
		}
		if ( null !== $select_text ) {
			$_args['text']['add_upload_media_label'] = $select_text;
		}
		if ( null !== $show_text_input ) {
			$_args['options'] = [
				'url' => $show_text_input,
			];
		}
		if ( null !== $preview_size ) {
			$_args['preview_size'] = $preview_size;
		}

		return $_args;
	}


	/**
	 * Mark this field as 'required'
	 *
	 * @notice As of WP 5.1.1 this has no effect on meta box fields with
	 *         Gutenberg enabled. Possibly will be changed in a future version
	 *         of WP?
	 *
	 * @return static
	 */
	public function required(): static {
		// The only way a file field may be required is if the URL field is showing.
		if ( Type::FILE === $this->type ) {
			$this->options['url'] = true;
		}
		parent::required();
		return $this;
	}
}
