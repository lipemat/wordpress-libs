<?php
require __DIR__ . '/helpers.php';
require __DIR__ . '/wp-tests-config.php';

// Prevent side effects from the current install's plugins.
require WP_UNIT_DIR . '/includes/functions.php';
tests_add_filter( 'option_active_plugins', '__return_empty_array', 99 );

require BOOTSTRAP;

require_once dirname( __DIR__, 4 ) . '/autoload.php';
