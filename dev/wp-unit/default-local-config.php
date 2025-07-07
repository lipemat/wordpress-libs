<?php
/**
 * Sensible defaults for local-config.php.
 *
 * Loaded if no local-config.php is provided.
 */

$root = dirname( __DIR__, 8 );

define( 'BOOTSTRAP', 'E:/SVN/wp-unit/includes/bootstrap.php' );
define( 'DB_HOST', 'localhost' );
define( 'DB_NAME', 'wordpress' );
define( 'DB_PASSWORD', 'hle1.qRA8W[BnR03' );
define( 'DB_USER', 'wplibs' );
define( 'DOMAIN_CURRENT_SITE', 'wp-libs.loc' );
define( 'WP_TESTS_DOMAIN', 'wp-libs.loc' );
define( 'WP_TESTS_EMAIL', 'unit-tests@test.com' );
define( 'WP_TESTS_TITLE', 'WP Libs unit tests' );
define( 'WP_UNIT_DIR', 'E:/SVN/wp-unit' );
define( 'WP_DEBUG', true );

define( 'ABSPATH', $root . '/wp/' );

// To suppress PHPStorm inspection errors.
define( 'SCRIPT_DEBUG', false );
