<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Manage Image resizing on the fly to prevent a bunch of unneeded image sizes for every image uploaded
 * Includes support for the Wp Smush plugin and will run smush on all image sizes when generating the
 * thumbnails. This also allow for smushing image larger than 1mb when using cropped sizes less than 1MB
 *
 * Pretty much automatic - use standard WP add_image_size() and this will pick it up.
 *
 * @example  Image_Resize::init();
 * @example  may be tapped in using the public methods as well - however probably not necessary
 *
 * @notice   The image sizes cannot be relied on in wp.media when using this.
 *         If you need a custom resized image using normal JS wp conventions you will have
 *         to do an ajax call, which uses php to retrieve.
 *
 * @deprecated Will be removed in version 5. Port into your local codebase.
 *
 * @phpstan-type META array{file: string, width: string, height: int, mime-type: string}
 */
class Image_Resize {
	use Singleton;

	/**
	 * Image sizes registered via `add_image_size`.
	 *
	 * @var array<string, array{width: int, height: int, crop: bool}>
	 */
	protected array $image_sizes = [];


	/**
	 * Actions and filters.
	 *
	 * @notice If WP-CLI is running we leave the default image handling intact so
	 *         the various media commands will function.
	 *
	 * @return void
	 */
	public function hook(): void {
		if ( \defined( 'WP_CLI' ) && \WP_CLI ) {
			return;
		}

		_deprecated_file( __CLASS__, '4.5.0', 'a local copy' );

		add_action( 'init', [ $this, 'add_other_image_sizes' ] );
		add_filter( 'image_downsize', [ $this, 'convert_image_downsize' ], 10, 3 );
		add_filter( 'wp_calculate_image_srcset_meta', [ $this, 'populate_srcset_sizes' ], 10, 4 );
	}


	/**
	 * Get a list of the image sizes from here
	 * because they no longer exist in standard WP global
	 *
	 * @return array<string, array{width: int, height: int, crop: bool}>
	 */
	public function get_image_sizes(): array {
		return $this->image_sizes;
	}


	/**
	 * Convert other add_image_sizes from other plugins to the attribute of the class.
	 */
	public function add_other_image_sizes(): void {
		global $_wp_additional_image_sizes;

		do_action( 'lipe/lib/util/before_add_other_image_sizes' );

		if ( empty( $_wp_additional_image_sizes ) ) {
			return;
		}

		foreach ( $_wp_additional_image_sizes as $size => $the_ ) {
			$this->add_image_size( $size, $the_['width'], $the_['height'], $the_['crop'] );
			unset( $_wp_additional_image_sizes[ $size ] );
		}
	}


	/**
	 * Populate Image Sizes.
	 *
	 * @param string           $name   - Name of the image size.
	 * @param int|float|string $width  - Width of the image size.
	 * @param int|float|string $height - Height of the image size.
	 * @param bool             $crop   - Hard crop the image to match the size.
	 *
	 * @return void
	 */
	public function add_image_size( string $name, $width, $height, bool $crop = false ): void {
		$this->image_sizes[ $name ] = [
			'width'  => absint( $width ),
			'height' => absint( $height ),
			'crop'   => $crop,
		];
	}


	/**
	 * Generates and populates image sizes during generation
	 * of an image's srcset.
	 *
	 * Support image srcset with dynamic image generation.
	 * Limited to only sizes, which would be used in the srcset to
	 * prevent superfluous image generation.
	 *
	 * @since            3.8.0
	 *
	 * @phpstan-param  array{sizes: array<string, META>} $meta          - Existing image sizes and information.
	 *
	 * @param array                                      $meta          - Image size information.
	 * @param array<int>                                 $size_array    - width,height.
	 * @param string                                     $src           - The image src.
	 * @param int                                        $attachment_id - ID of attachment.
	 *
	 * @filter           wp_calculate_image_srcset_meta 10 4
	 *
	 * @return array{sizes: array<string, META>}
	 */
	public function populate_srcset_sizes( array $meta, array $size_array, string $src, int $attachment_id ): array {
		[ $width, $height ] = $size_array;
		if ( $width < 1 ) {
			return $meta;
		}
		foreach ( $this->get_image_sizes() as $size => $dimensions ) {
			if ( wp_image_matches_ratio( $width, $height, $dimensions['width'], $dimensions['height'] ) ) {
				$image = $this->convert_image_downsize( null, $attachment_id, $size );
				if ( ! empty( $image ) ) {
					$meta['sizes'][ $size ] = [
						'file'      => wp_basename( $image[0] ),
						'width'     => (string) $image[1],
						'height'    => (int) $image[2],
						'mime-type' => (string) wp_get_image_mime( (string) get_attached_file( $attachment_id ) ),
					];
				}
			}
		}

		return $meta;
	}


	/**
	 * Uses this class to resize an image instead of default WP.
	 *
	 * @filter image_downsize 10 3
	 *
	 * @param array|null|string $out  - Resulting image data.
	 * @param int               $id   - Attachment ID for image.
	 * @param string            $size - Size of image, either array or string.
	 *
	 * @return array|null|string
	 */
	public function convert_image_downsize( $out, int $id, string $size ) {
		if ( 'full' === $size ) {
			return $out;
		}

		$image = $this->image( [
			'id'     => $id,
			'size'   => $size,
			'output' => 'numeric_array',
		] );

		if ( empty( $image ) ) {
			return $out;
		}

		if ( \is_array( $image ) ) {
			$image[] = true; // Add `is_intermediate`.
		}

		return $image;
	}


	/**
	 * Get image.
	 *
	 * @param array $args        = array{
	 *                           'id' => null,   // the thumbnail ID
	 *                           'post_id' => null,   // thumbnail of specified post ID
	 *                           'src' => '',
	 *                           'alt' => '',
	 *                           'class' => '',
	 *                           'title' => '',
	 *                           'size' => '',
	 *                           'width' => null,
	 *                           'height' => null,
	 *                           'crop' => false,
	 *                           'output' => 'img',   // how print: 'a', with an anchor; 'img' without an anchor; 'url' only
	 *                           url;
	 *                           'array' array width 'url', 'width' and 'height'
	 *                           'numeric_array' default way wp expects it
	 *                           'link' => '',      // the link of <a> tag. If empty, get from the original image url
	 *                           'link_class' => '',      // the class of <a> tag
	 *                           'link_title' => '',      // the title of <a> tag. If empty, get it from "title" attribute.
	 *                           }.
	 * @param bool  $echo_output - Whether to echo or return the output.
	 *
	 * @return string|null|array
	 */
	public function image( array $args = [], bool $echo_output = true ) {
		$args = wp_parse_args( $args, [
			'id'         => null,
			'post_id'    => null,
			'src'        => '',
			'alt'        => '',
			'class'      => '',
			'title'      => '',
			'size'       => '',
			'width'      => null,
			'height'     => null,
			'crop'       => false,
			'output'     => 'img',
			'link'       => '',
			'link_class' => '',
			'link_title' => '',
		] );

		// From explicit thumbnail ID.
		if ( ! empty( $args['id'] ) ) {
			$image_id = $args['id'];
			$image_url = wp_get_attachment_url( $args['id'] );
			// thumbnail of specified post.
		} elseif ( ! empty( $args['post_id'] ) ) {
			$image_id = get_post_thumbnail_id( $args['post_id'] );
			if ( false !== $image_id ) {
				$image_url = wp_get_attachment_url( $image_id );
			}
			// or from SRC.
		} elseif ( ! empty( $args['src'] ) ) {
			$image_id = null;
			$image_url = esc_url( $args['src'] );
			// or the post thumbnail of current post.
		} elseif ( has_post_thumbnail() ) {
			$image_id = get_post_thumbnail_id();
			if ( false !== $image_id ) {
				$image_url = wp_get_attachment_url( $image_id );
			}
			// if we are currently on an attachment.
		} elseif ( is_attachment() ) {
			global $post;
			$image_id = $post->ID;
			$image_url = wp_get_attachment_url( $image_id );
		}

		if ( ! isset( $image_url ) || ( false === $image_url && empty( $image_id ) ) ) {
			return null;
		}

		// Save the original image url for the <a> tag.
		$full_image_url = $image_url;

		// Get the post attachment.
		if ( ! empty( $image_id ) ) {
			$attachment = get_post( $image_id );
			if ( ! empty( $attachment ) && empty( $args['alt'] ) ) {
				$args['alt'] = esc_attr( $attachment->post_title );
			}
		}

		// get size from add_image_size.
		if ( ! empty( $args['size'] ) ) {
			global $_wp_additional_image_sizes, $content_width;

			// if is array, put width and height individually.
			if ( \is_array( $args['size'] ) ) {
				[ $width, $height ] = $args['size'];
				$crop = empty( $args['size'][2] ) ? false : $args['size'][2];
			} elseif ( isset( $this->image_sizes[ $args['size'] ] ) ) {
				$width = $this->image_sizes[ $args['size'] ]['width'];
				$height = $this->image_sizes[ $args['size'] ]['height'];
				$crop = $this->image_sizes[ $args['size'] ]['crop'];
			} elseif ( isset( $_wp_additional_image_sizes[ $args['size'] ] ) ) {
				$width = $_wp_additional_image_sizes[ $args['size'] ]['width'];
				$height = $_wp_additional_image_sizes[ $args['size'] ]['height'];
				$crop = $_wp_additional_image_sizes[ $args['size'] ]['crop'];
				// thumbnail.
			} elseif ( 'thumb' === $args['size'] || 'thumbnail' === $args['size'] ) {
				$width = (int) get_option( 'thumbnail_size_w' );
				$height = (int) get_option( 'thumbnail_size_h' );
				// last chance thumbnail size defaults.
				if ( 0 === $width && 0 === $height ) {
					$width = 128;
					$height = 96;
				}
				$crop = (bool) get_option( 'thumbnail_crop' );
				// medium.
			} elseif ( 'medium' === $args['size'] ) {
				$width = (int) get_option( 'medium_size_w' );
				$height = (int) get_option( 'medium_size_h' );
				// if no width is set, default to the theme content width if available.

				// large.
			} elseif ( 'large' === $args['size'] ) {
				// We're inserting a large size image into the editor. If it's a really.
				// big image we'll scale it down to fit reasonably within the editor.
				// itself, and within the theme's content width if it's known. The user.
				// can resize it in the editor if they wish.
				$width = (int) get_option( 'large_size_w' );
				$height = (int) get_option( 'large_size_h' );
				if ( (int) $content_width > 0 ) {
					$width = min( (int) $content_width, $width );
				}
			}
		}

		// Maybe need resize.
		if ( false !== $image_url && ( ! empty( $width ) || ! empty( $height ) ) ) {
			if ( isset( $height, $width, $crop, $image_id ) ) {
				$image = $this->resize( (int) $width, (int) $height, (int) $image_id, $image_url, $crop );
			}
			if ( empty( $image ) ) {
				return null;
			}
			$image_url = $image['url'];
			$width = $image['width'];
			$height = $image['height'];
		}

		/* BEGIN OUTPUT */

		// Return null, if no image URL.
		if ( ! \is_string( $image_url ) || '' === $image_url ) {
			return null;
		}

		if ( 'url' === $args['output'] ) {
			if ( $echo_output ) {
				echo esc_url( $image_url );
			}
			return $image_url;
		}

		if ( ! isset( $height, $width ) ) {
			return null;
		}

		if ( 'array' === $args['output'] ) {
			return [
				'src'    => $image_url,
				'width'  => $width,
				'height' => $height,
				'alt'    => $args['alt'],
				'title'  => $args['title'],
			];
		}

		if ( 'numeric_array' === $args['output'] ) {
			return [
				0 => $image_url,
				1 => $width,
				2 => $height,
			];
		}

		if ( ! empty( $attachment ) && ! empty( $image_id ) ) {
			$size = empty( $args['size'] ) ? [ $width, $height ] : $args['size'];
			if ( 'a' === $args['output'] ) {
				$args['class'] .= ' lipe/lib/util/resized-image';
			}
			$html_image = wp_get_attachment_image( $image_id, $size, false, [
				'class' => trim( $args['class'] . ( ! \is_array( $size ) ? " attachment-{$size}" : '' ) ),
				'alt'   => empty( $args['alt'] ) ? trim( wp_strip_all_tags( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) ) : $args['alt'],
				'title' => empty( $args['title'] ) ? $attachment->post_title : $args['title'],
			] );
		} else {
			$html_image = rtrim( '<img' );
			if ( 'a' !== $args['output'] ) {
				$args['class'] .= ' lipe/lib/util/resized-image';
			}
			if ( ! \is_array( $args['size'] ) && ! empty( $args['size'] ) ) {
				$args['class'] .= " attachment-{$args['size']}";
			}

			$attr = [
				'src'    => $image_url,
				'width'  => $width,
				'height' => $height,
				'alt'    => $args['alt'],
				'title'  => $args['title'],
				'class'  => trim( $args['class'] ),
			];

			foreach ( $attr as $name => $value ) {
				if ( ! empty( $value ) ) {
					$html_image .= " $name=" . '"' . $value . '"';
				}
			}
			$html_image .= ' />';
		}

		// Return <img> tag.
		if ( 'img' === $args['output'] ) {
			if ( $echo_output ) {
				echo $html_image; //phpcs:ignore
			}

			return $html_image;
		}

		// Return the image wrapped in <a> tag.
		if ( 'a' === $args['output'] ) {
			$html_link = rtrim( '<a' );
			$link_class = 'lipe/lib/util/resized-image';
			$attr = [
				'href'  => empty( $args['link'] ) ? $full_image_url : $args['link'],
				'title' => empty( $args['link_title'] ) ? $args['title'] : $args['link_title'],
				'class' => trim( $link_class ),
			];

			foreach ( $attr as $name => $value ) {
				if ( ! empty( $value ) ) {
					$html_link .= " $name=" . '"' . $value . '"';
				}
			}
			$html_link .= '>' . $html_image . '</a>';

			if ( $echo_output ) {
				echo $html_link; //phpcs:ignore
				return null;
			}

			return $html_link;
		}

		return null;
	}


	/**
	 * Resize images dynamically using wp built-in functions.
	 * Will also run the images through smush.it if available.
	 *
	 * @param int         $width     - Width of the new image in pixels.
	 * @param int         $height    - Height of the new image in pixels.
	 * @param int         $attach_id - ID of the attachment.
	 * @param string|null $img_url   - Url of the attachment.
	 * @param bool        $crop      - Optional, default is false. Whether to crop image or resize.
	 *
	 * @return array{width: int, height: int, url: string}|array<null>
	 */
	protected function resize( int $width, int $height, int $attach_id, ?string $img_url = null, bool $crop = false ): array {
		$file_path = false;
		$image_src = [];
		if ( 0 !== $attach_id ) {
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$file_path = get_attached_file( $attach_id );
			if ( false === $image_src || false === $file_path ) {
				return [];
			}
			// this is not an attachment, let's use the image url.
		} elseif ( null !== $img_url ) {
			$uploads_dir = wp_upload_dir();
			if ( false !== strpos( $img_url, $uploads_dir['baseurl'] ) ) {
				$file_path = \str_replace( $uploads_dir['baseurl'], $uploads_dir['basedir'], $img_url );
			} else {
				$file_path = wp_parse_url( esc_url( $img_url ) );
				if ( \is_array( $file_path ) ) {
					if ( isset( $file_path['path'] ) ) {
						$file_path = sanitize_text_field( wp_unslash( $_SERVER['DOCUMENT_ROOT'] ?? '' ) ) . $file_path['path'];
					} else {
						$file_path = false;
					}
				}
			}
			if ( false === $file_path || ! file_exists( $file_path ) ) {
				return [];
			}
			$orig_size = getimagesize( $file_path );
			if ( false !== $orig_size ) {
				$image_src[0] = $img_url;
				$image_src[1] = $orig_size[0];
				$image_src[2] = $orig_size[1];
			}
		}

		if ( false === $file_path || '' === $file_path || 0 === \count( $image_src ) ) {
			return [];
		}
		$file_info = pathinfo( $file_path );
		if ( empty( $file_info['filename'] ) ) {
			return [];
		}

		$extension = '.' . $file_info['extension']; // @phpstan-ignore-line -- $file_info['extension'] is always set.
		$base_file = $file_info['dirname'] . '/' . $file_info['filename'] . $extension;
		if ( ! file_exists( $base_file ) ) {
			return [];
		}

		// the image path without the extension.
		$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];
		$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

		// checking if the file size is larger than the target size.
		// if it is smaller, or the same size, stop right here and return.
		if ( $image_src[1] > $width || $image_src[2] > $height ) {
			if ( false === $crop || 0 === $height ) {
				// calculate the size proportionally.
				$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
				$resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

				if ( file_exists( $resized_img_path ) ) {
					$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

					return [
						'url'    => $resized_img_url,
						'width'  => $proportional_size[0],
						'height' => $proportional_size[1],
					];
				}
			} elseif ( file_exists( $cropped_img_path ) ) {
				$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );

				return [
					'url'    => $cropped_img_url,
					'width'  => $width,
					'height' => $height,
				];
			}

			// -- file does not exist so lets check the cache and create it.

			// check if image width is smaller than set width.
			$img_size = getimagesize( $file_path );
			if ( \is_array( $img_size ) && $img_size[0] <= $width ) {
				$width = $img_size[0];
			}

			// Check if GD Library installed.
			if ( ! \function_exists( 'imagecreatetruecolor' ) ) {
				_doing_it_wrong( __METHOD__, 'GD Library Error: imagecreatetruecolor does not exist - please contact your web host and ask them to install the GD library', '3.0.0' );
				return [];
			}

			// no cache files - let's finally resize it.
			$image = wp_get_image_editor( $file_path );
			if ( is_wp_error( $image ) ) {
				$new_img_path = false;
			} else {
				$image->resize( $width, $height, $crop );
				$save_data = $image->save();
				if ( is_wp_error( $save_data ) || empty( $save_data['path'] ) ) {
					$new_img_path = $file_path;
				} else {
					$new_img_path = $save_data['path'];
				}
			}

			if ( false === $new_img_path || ! \file_exists( $new_img_path ) ) {
				return [];
			}

			$new_img_size = (array) getimagesize( $new_img_path );
			if ( [ false ] === $new_img_size ) {
				return [];
			}

			$new_img = \str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

			// resized output.
			$image = [
				'url'    => $new_img,
				'width'  => $new_img_size[0],
				'height' => $new_img_size[1],
			];

			// If using Wp Smush.it.
			if ( class_exists( 'WpSmush' ) ) {
				// phpcs:disable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
				global $WpSmush;
				$max_size = $WpSmush->validate_install() ? WP_SMUSH_PREMIUM_MAX_BYTES : WP_SMUSH_MAX_BYTES;
				if ( filesize( $new_img_path ) < $max_size ) {
					$WpSmush->do_smushit( $new_img_path );
				}
				// phpcs:enable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
			}

			return $image;
		}

		// Default output - without resizing.
		return [
			'url'    => $image_src[0],
			'width'  => $image_src[1],
			'height' => $image_src[2],
		];
	}
}
