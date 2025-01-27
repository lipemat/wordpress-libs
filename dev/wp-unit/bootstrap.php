<?php

$GLOBALS['wp_tests_options']['permalink_structure'] = '%postname%/';

require __DIR__ . '/helpers.php';
require __DIR__ . '/wp-tests-config.php';

// Prevent side effects from the current installation's plugins.
require_once WP_UNIT_DIR . '/includes/functions.php';
tests_add_filter( 'option_active_plugins', '__return_empty_array', 99 );
tests_add_filter( 'site_option_active_sitewide_plugins', '__return_empty_array', 99 );

// Load the WP-Unit environment.
require BOOTSTRAP;

// Our tests require 2 blogs to be available.
if ( null === get_site( 2 ) ) {
	wpmu_create_blog( 'example.com', '/sub', 'Sub Site', 1 );
	wp_installing( false );
}

// Add composer's autoloader.
if ( is_readable( dirname( __DIR__, 4 ) . '/autoload.php' ) ) {
	require_once dirname( __DIR__, 4 ) . '/autoload.php';
}

// Make all Mock classes available.
foreach ( glob( __DIR__ . '/mocks/*.php' ) as $file ) {
	require $file;
}

\CMB2_Bootstrap_2101::initiate()->include_cmb();
