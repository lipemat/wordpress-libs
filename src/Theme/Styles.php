<?php

namespace Lipe\Lib\Util;

use Lipe\Lib\Traits\Singleton;

class Styles {
	use Singleton;


	/**
	 * Get Version
	 *
	 * You can set it in the wp-config or some dynamic way using grunt like so
	 * define( 'SCRIPTS_VERSION', '9999' );
	 *
	 * Otherwise
	 *
	 * Beanstalk adds a .revision file to deployments this grabs that
	 * revision and return it.
	 * If no .revison file available returns false
	 *
	 * @see lib/build/post-commit for the hook to use locally to increment the .revision and test
	 *
	 *
	 * @return bool|string
	 */
	public function get_version() {
		static $version = null;
		if( $version !== null ){
			return $version;
		}

		if( defined( 'SCRIPTS_VERSION' ) ){
			$version = SCRIPTS_VERSION;
		} else {
			//beanstalk style
			$file = $_SERVER[ 'DOCUMENT_ROOT' ] . '/.revision';
			if( file_exists( $file ) ){
				$version = trim( file_get_contents( $file ) );
			}
		}

		return $version;
	}


	/**
	 * Quick adding of the livereload grunt watch script
	 * Call before wp_enqueue_scripts fires
	 *
	 * @see https://github.com/gruntjs/grunt-contrib-watch#user-content-optionslivereload
	 *
	 * @return void
	 */
	public function live_reload() {
		if( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ){
			add_action( 'wp_enqueue_scripts', function () {
				wp_enqueue_script( 'livereload', '//localhost:35729/livereload.js', [], time(), true );
			} );
		}
	}


	/**
	 * Add Font
	 *
	 * Add a google font the head of the webpage in the front end and admin
	 *
	 *
	 * @param mixed string|array $families - the family to include
	 *
	 * @example Raleway:400,700,600:latin
	 *
	 * @uses    Must be called before the 'wp_head' hook fires
	 */
	function add_font( $families ) {
		if( is_array( $families ) ){
			$families = implode( "','", $families );
		}

		ob_start();
		?>
        <script type="text/javascript">
			WebFontConfig = {
				google : {families : ['<?php echo $families; ?>']}
			};
			(function(){
				var wf   = document.createElement( 'script' );
				wf.src   = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
				wf.type  = 'text/javascript';
				wf.async = 'true';
				var s    = document.getElementsByTagName( 'script' )[0];
				s.parentNode.insertBefore( wf, s );
			})(); </script>
		<?php

		$output = ob_get_clean();

		add_action( 'wp_head', function () use ( $output ) {
			echo $output;
		} );
		add_action( 'admin_print_scripts', function () use ( $output ) {
			echo $output;
		} );
	}
}
    