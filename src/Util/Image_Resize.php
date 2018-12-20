<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

/**
 * Manage Image resizing on the fly to prevent a bunch of unneeded image sizes for every image uploaded
 * Includes support for the Wp Smush.it plugin and will run the smush on all image sizes when generating the
 * thumbnails. This also allow for smushing image larger than 1mb when using cropped sizes less than 1MB
 *
 * Pretty much automatic - use standard WP add_image_size() and this will pick it up
 *
 * @author   Mat Lipe <mat@matlipe.com>
 * @example  Image_Resize::init();
 * @example  may be tapped in using the public methods as well - however probably not necessary
 *
 * @notice   The image sizes can not be relied on in wp.media when using this.
 *         If you need a custom resized image using normal js wp conventions you will have
 *         to do an ajax call which uses php to retrieve.
 *
 */
class Image_Resize {

	use Singleton;

	private $_image_sizes = []; //Keeps track of all theme and plugins image sizes


	public function hook() : void {
		// convert other add_image_sizes from other plugin, to the attribute of the class
		add_action( 'init', [ $this, 'add_other_image_sizes' ] );

		// use this class to resize on the fly instead of making a copy of each image
		add_filter( 'image_downsize', [ $this, 'convert_image_downsize' ], 10, 3 );
	}


	/**
	 * get_image_sizes
	 *
	 * Get a list of the image sizes from here
	 * because they no longer exist in standard WP global
	 *
	 * @return array
	 */
	public function get_image_sizes() {
		return $this->_image_sizes;
	}


	/**
	 * Convert other add_image_sizes from other plugin, to the attribute of the class
	 *
	 * @since 9.13.13
	 */
	public function add_other_image_sizes() {
		global $_wp_additional_image_sizes;

		do_action( 'lipe/lib/util/before_add_other_image_sizes' );

		if ( empty( $_wp_additional_image_sizes ) ) {
			return;
		}

		foreach ( $_wp_additional_image_sizes as $size => $the_ ) {
			if ( isset( $this->_image_sizes[ $size ] ) ) {
				continue;
			}

			$this->add_image_size( $size, $the_['width'], $the_['height'], $the_['crop'] );
			unset( $_wp_additional_image_sizes[ $size ] );
		}
	}


	/**
	 * Populate image sizes
	 *
	 * @since 9.13.13
	 */
	public function add_image_size( $name, $width, $height, $crop = false ) {
		$this->_image_sizes[ $name ] = [
			'width'  => absint( $width ),
			'height' => absint( $height ),
			'crop'   => (bool) $crop,
		];
	}


	/**
	 * Uses this class to resize an image instead of default wp
	 *
	 * @uses  added to the image_downsize filter by self::__construct()
	 * @since 9.13.13
	 *
	 */
	public function convert_image_downsize( $out, $id, $size ) {
		if ( $size === 'full' ) {
			return $out;
		}

		$new_image = $this->image( [
			'id'     => $id,
			'size'   => $size,
			'output' => 'numeric_array',
		] );

		if ( empty( $new_image ) ) {
			return $out;
		}

		// is_intermediate
		$new_image[] = true;

		return $new_image;
	}


	/**
	 * Get image
	 *
	 * @param array() $args = array(
	 *                      'id' => null,   // the thumbnail ID
	 *                      'post_id' => null,   // thumbnail of specified post ID
	 *                      'src' => '',
	 *                      'alt' => '',
	 *                      'class' => '',
	 *                      'title' => '',
	 *                      'size' => '',
	 *                      'image_scan' => false, //grab image from content if nothing else available
	 *                      'width' => null,
	 *                      'height' => null,
	 *                      'crop' => false,
	 *                      'output' => 'img',   // how print: 'a', with anchor; 'img' without anchor; 'url' only url;
	 *                      'array' array width 'url', 'width' and 'height'
	 *                      'numeric_array' default way wp expects it
	 *                      'link' => '',      // the link of <a> tag. If empty, get from original image url
	 *                      'link_class' => '',      // the class of <a> tag
	 *                      'link_title' => '',      // the title of <a> tag. If empty, get it from "title" attribute.
	 *                      );
	 *
	 * @return string|null|array
	 */
	public function image( $args = [], $echo = true ) {
		$defaults = [
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
			'image_scan' => false,
			'output'     => 'img',
			'link'       => '',
			'link_class' => '',
			'link_title' => '',

		];

		$args = wp_parse_args( $args, $defaults );
		$class = '';
		extract( $args );


		// from explicit thumbnail ID
		if ( ! empty( $args['id'] ) ) {
			$image_id = $args['id'];
			$image_url = wp_get_attachment_url( $args['id']);

			// thumbnail of specified post
		} elseif ( ! empty( $args['post_id'] ) ) {
			$image_id = get_post_thumbnail_id( $args['post_id'] );
			$image_url = wp_get_attachment_url( $image_id );

			// or from SRC
		} elseif ( ! empty( $args['src'] ) ) {
			$image_id = null;
			$image_url = esc_url( $args['src'] );

			// or the post thumbnail of current post
		} elseif ( has_post_thumbnail() ) {
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_url( $image_id );
			// if we are currently on an attachment
		} elseif ( is_attachment() ) {
			global $post;
			$image_id = $post->ID;
			$image_url = wp_get_attachment_url( $image_id );

		}

		//get first image from content
		if ( empty( $image_url ) && $args['image_scan'] ) {
			$image_id = null;
			$image_url = $this->get_image_from_content( $args['post_id'] );
		}


		if ( empty( $image_url ) && empty( $image_id ) ) {
			return null;
		}

		// save original image url for the <a> tag
		$full_image_url = $image_url;

		// get the post attachment
		if ( ! empty( $image_id ) ) {
			$attachment = get_post( $image_id );
		}

		// get size from add_image_size
		if ( ! empty( $args['size'] ) ) {
			global $_wp_additional_image_sizes, $content_width;

			// if is array, put width and height indivudually
			if ( is_array( $args['size'] ) ) {
				$width = $args['size'][0];
				$height = $args['size'][1];
				$crop = empty( $args['size'][2] ) ? false : $args['size'][2];

			} elseif ( isset( $this->_image_sizes[ $args['size'] ] ) ) {

				$width = $this->_image_sizes[ $args['size'] ]['width'];
				$height = $this->_image_sizes[ $args['size'] ]['height'];
				$crop = $this->_image_sizes[ $args['size'] ]['crop'];

			} elseif ( isset( $_wp_additional_image_sizes[ $args['size'] ] ) ) {
				$width = $_wp_additional_image_sizes[ $args['size'] ]['width'];
				$height = $_wp_additional_image_sizes[ $args['size'] ]['height'];
				$crop = $_wp_additional_image_sizes[ $args['size'] ]['crop'];

				// standard sizes of WordPress

				// thumbnail
			} elseif ( $args['size'] == 'thumb' || $args['size'] == 'thumbnail' ) {
				$width = intval( get_option( 'thumbnail_size_w' ) );
				$height = intval( get_option( 'thumbnail_size_h' ) );
				// last chance thumbnail size defaults
				if ( ! $width && ! $height ) {
					$width = 128;
					$height = 96;
				}
				$crop = (bool) get_option( 'thumbnail_crop' );

				// medium
			} elseif ( $args['size'] == 'medium' ) {
				$width = intval( get_option( 'medium_size_w' ) );
				$height = intval( get_option( 'medium_size_h' ) );
				// if no width is set, default to the theme content width if available

				// large
			} elseif ( $args['size'] == 'large' ) {
				// We're inserting a large size image into the editor. If it's a really
				// big image we'll scale it down to fit reasonably within the editor
				// itself, and within the theme's content width if it's known. The user
				// can resize it in the editor if they wish.
				$width = intval( get_option( 'large_size_w' ) );
				$height = intval( get_option( 'large_size_h' ) );
				if ( intval( $content_width ) > 0 ) {
					$width = min( intval( $content_width ), $width );
				}
			}
		}

		// maybe need resize
		if ( ! empty( $width ) || ! empty( $height ) ) {
			$image = $this->resize( $image_id, $image_url, $width, $height, $crop );
			$image_url = $image['url'];
			$width = $image['width'];
			$height = $image['height'];
		}

		/* BEGIN OUTPUT */

		// return null, if there isn't $image_url
		if ( empty( $image_url ) ) {
			return null;
		}


		if ( $args['output'] === 'url' ) {
			if ( $echo ) {
				echo $image_url;
			}
			return $image_url;

		} elseif ( $args['output'] === 'array' ) {
			//@todo set the alt and title from findings above
			return [
				'src'    => $image_url,
				'width'  => $width,
				'height' => $height,
				'alt'    => $alt,
				'title'  => $title,
			];
		} elseif ( $args['output'] === 'numeric_array' ) {
			return [
				0 => $image_url,
				1 => $width,
				2 => $height,
			];
		}

		if ( ! empty( $image_id ) ) {
			$size = empty( $size ) ? $size = [ $width, $height ] : $size;
			if ( $args['output'] != 'a' ) {
				$class .= ' lipe/lib/util/resized-image';
			}
			$html_image = wp_get_attachment_image( $image_id, $size, false, [
				'class' => trim( "$class" . ( ! is_array( $size ) && ! empty( $size ) ? " attachment-$size" : '' ) ),
				'alt'   => empty( $alt ) ? trim( strip_tags( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) ) : $alt,
				'title' => empty( $title ) ? $attachment->post_title : $title,
			] );

		} else {
			$html_image = rtrim( "<img" );
			if ( $args['output'] != 'a' ) {
				$class .= ' lipe/lib/util/resized-image';
			}
			if ( ! is_array( $args['size'] ) && ! empty( $args['size'] ) ) {
				$class .= " attachment-$size";
			}

			//@todo set the alt and title from findings above
			$attr = [
				'src'    => $image_url,
				'width'  => $width,
				'height' => $height,
				'alt'    => $alt,
				'title'  => $title,
				'class'  => trim( $class ),
			];

			foreach ( $attr as $name => $value ) {
				if ( ! empty( $value ) ) {
					$html_image .= " $name=" . '"' . $value . '"';
				}
			}
			$html_image .= ' />';

		}

		// return only image
		if ( $args['output'] == 'img' ) {
			if ( $echo ) {
				echo $html_image;
			}

			return $html_image;

			// return the image wrapper in <a> tag
		} elseif ( $args['output'] == 'a' ) {
			$html_link = rtrim( "<a" );
			$link_class = 'lipe/lib/util/resized-image';
			$attr = [
				'href'  => empty( $link ) ? $full_image_url : $link,
				'title' => empty( $link_title ) ? $title : $link_title,
				'class' => trim( $link_class ),
			];

			foreach ( $attr as $name => $value ) {
				if ( ! empty( $value ) ) {
					$html_link .= " $name=" . '"' . $value . '"';
				}
			}
			$html_link .= '>' . $html_image . '</a>';

			if ( $echo ) {
				echo $html_link;
			}

			return $html_link;
		}
	}


	/**
	 * Resize images dynamically using wp built in functions
	 * Will also run the images through smush.it if available
	 *
	 * @param int    $attach_id
	 * @param string $img_url
	 * @param int    $width
	 * @param int    $height
	 * @param bool   $crop
	 *
	 *
	 * @return array
	 */
	protected function resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {

		// Cast $width and $height to integer
		$width = intval( $width );
		$height = intval( $height );

		// this is an attachment, so we have the ID
		if ( $attach_id ) {
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$file_path = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url
		} elseif ( $img_url ) {
			$uploads_dir = wp_upload_dir();
			if ( strpos( $img_url, $uploads_dir['baseurl'] ) === false ) {
				$file_path = parse_url( esc_url( $img_url ) );
				$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
			} else {
				$file_path = str_replace( $uploads_dir['baseurl'], $uploads_dir['basedir'], $img_url );
			}
			if ( ! file_exists( $file_path ) ) {
				return;
			}
			$orig_size = getimagesize( $file_path );

			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		}

		$file_info = pathinfo( $file_path );

		// check if file exists
		if ( ! isset( $file_info['dirname'] ) || ! isset( $file_info['filename'] ) || ! isset( $file_info['extension'] ) ) {
			return;
		}

		$base_file = $file_info['dirname'] . '/' . $file_info['filename'] . '.' . $file_info['extension'];
		if ( ! file_exists( $base_file ) ) {
			return;
		}

		$extension = '.' . $file_info['extension'];

		// the image path without the extension
		$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

		$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

		// checking if the file size is larger than the target size
		// if it is smaller or the same size, stop right here and return
		if ( $image_src[1] > $width || $image_src[2] > $height ) {

			// $crop = false or no height set
			if ( $crop == false OR ! $height ) {
				// calculate the size proportionally
				$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
				$resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

				if ( file_exists( $resized_img_path ) ) {
					$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

					$image = [
						'url'    => $resized_img_url,
						'width'  => $proportional_size[0],
						'height' => $proportional_size[1],
					];

					return $image;
				}
			} elseif ( file_exists( $cropped_img_path ) ) {
				$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );

				$image = [
					'url'    => $cropped_img_url,
					'width'  => $width,
					'height' => $height,
				];

				return $image;
			}

			//-- file does not exist so lets check the cache and create it

			// check if image width is smaller than set width
			$img_size = getimagesize( $file_path );
			if ( $img_size[0] <= $width ) {
				$width = $img_size[0];
			}

			// Check if GD Library installed
			if ( ! function_exists( 'imagecreatetruecolor' ) ) {
				echo 'GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library';

				return false;
			}

			// no cache files - let's finally resize it
			$image = wp_get_image_editor( $file_path );
			if ( ! is_wp_error( $image ) ) {
				$image->resize( $width, $height, $crop );
				$save_data = $image->save();
				if ( is_wp_error( $save_data ) || empty( $save_data['path'] ) ) {
					$new_img_path = $file_path;
				} else {
					$new_img_path = $save_data['path'];
				}
			} else {
				$new_img_path = false;
			}

			if ( ! file_exists( $new_img_path ) ) {
				return false;
			}

			$new_img_size = getimagesize( $new_img_path );
			$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

			// resized output
			$image = [
				'url'    => $new_img,
				'width'  => $new_img_size[0],
				'height' => $new_img_size[1],
			];

			//If using Wp Smushit
			if ( class_exists( 'WpSmush' ) ) {
				global $WpSmush;
				/** @var \WpSmush $WpSmush */
				if ( method_exists( $WpSmush, 'validate_install' ) ) {
					//new version of wp smush
					$max_size = $WpSmush->validate_install() ? WP_SMUSH_PREMIUM_MAX_BYTES : WP_SMUSH_MAX_BYTES;
				} else {
					$max_size = $WpSmush->is_pro() ? WP_SMUSH_PREMIUM_MAX_BYTES : WP_SMUSH_MAX_BYTES;
				}
				if ( filesize( $new_img_path ) < $max_size ) {
					$WpSmush->do_smushit( $new_img_path );
				}
			}

			return $image;
		}

		// default output - without resizing
		$image = [
			'url'    => $image_src[0],
			'width'  => $image_src[1],
			'height' => $image_src[2],
		];

		return $image;
	}


	public function get_image_from_content( $post_id = 0 ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
			if ( empty( $post_id ) ) {
				return null;
			}
		}

		$first_img = wp_cache_get( __METHOD__ . ':' . $post_id, 'default' );
		if ( $first_img !== false ) {
			return $first_img;
		}

		$content = get_post_field( 'post_content', $post_id );

		if ( is_wp_error( $content ) || empty( $content ) ) {
			$first_img = '';

		} else {

			preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches );
			if ( isset( $matches[1][0] ) ) {
				$first_img = $matches[1][0];
			} else {
				$first_img = '';
			}
		}

		wp_cache_set( __METHOD__ . ':' . $post_id, $first_img, 'default', DAY_IN_SECONDS );

		return $first_img;
	}

}
