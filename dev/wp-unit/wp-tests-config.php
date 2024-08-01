<?php
declare( strict_types=1 );
/**
 * @version 1.6.4
 */

// Point to local memcache servers (Requirement of sites like WPE).
$GLOBALS['memcached_servers'] = [ '127.0.0.1:11211' ];

$root = dirname( __DIR__, 2 );

if ( file_exists( __DIR__ . '/local-config.php' ) ) {
	require __DIR__ . '/local-config.php';
} else {
	require __DIR__ . '/default-local-config.php';
}

$config_defaults = [
	'ABSPATH'                   => $root . '/wp/',
	'BLOG_ID_CURRENT_SITE'      => 1,
	'BOOTSTRAP'                 => getenv( 'BOOTSTRAP' ),
	'DB_CHARSET'                => 'utf8mb4',
	'DB_COLLATE'                => '',
	'DB_HOST'                   => 'localhost',
	'DB_NAME'                   => getenv( 'DB_NAME' ),
	'DB_PASSWORD'               => getenv( 'DB_PASSWORD' ),
	'DB_USER'                   => getenv( 'DB_USER' ),
	'DOMAIN_CURRENT_SITE'       => getenv( 'HTTP_HOST' ),
	'FORCE_SSL_ADMIN'           => false,
	'FORCE_SSL_LOGIN'           => false,
	'PATH_CURRENT_SITE'         => '/',
	'SAVEQUERIES'               => true,
	'SCRIPT_DEBUG'              => false,
	'SEND_MAIL'                 => false,
	'SITE_ID_CURRENT_SITE'      => 1,
	'WC_USE_TRANSACTIONS'       => false,
	'WP_CACHE_DIR'              => $root . '/wp-content/cache',
	'WP_CONTENT_DIR'            => $root . '/wp-content',
	'WP_CONTENT_URL'            => 'http://' . getenv( 'HTTP_HOST' ) . '/wp-content',
	'WP_DEBUG'                  => true,
	'WP_DEFAULT_THEME'          => 'twentytwentyfour',
	'WP_ENVIRONMENT_TYPE'       => 'local',
	'WP_PHP_BINARY'             => 'php',
	'WP_SITE_ROOT'              => $root . DIRECTORY_SEPARATOR,
	'WP_TESTS_CONFIG_FILE_PATH' => __FILE__,
	'WP_TESTS_DIR'              => $root,
	'WP_TESTS_DOMAIN'           => getenv( 'HTTP_HOST' ),
	'WP_TESTS_EMAIL'            => 'unit-tests@onpointplugins.com',
	'WP_TESTS_MULTISITE'        => true,
	'WP_TESTS_SEND_MAIL'        => false,
	'WP_TESTS_SNAPSHOTS_BASE'   => 'Lipe\Lib',
	'WP_TESTS_SNAPSHOTS_DIR'    => __DIR__ . '/__snapshots__',
	'WP_TESTS_TABLE_PREFIX'     => 'wplibs_',
	'WP_TESTS_TITLE'            => 'WP Libs',
	'WP_UNIT_DIR'               => getenv( 'WP_UNIT_DIR' ),

	// @link https://starting-point.loc/dev/public/salt.php
	'AUTH_KEY'                  => 'P3 wfxg|P}w,)xc4}g:viCqCEqT,^=pn!AP6+kb.[*N56zNyB|CQ; y`ut/V$D]o',
	'SECURE_AUTH_KEY'           => 'o?Lv<Qegk5>IlvBL4p%I{Blr$vN6D}G(wEp!W%QR`h1OlH~-7:[})1elZSe;B6HZ',
	'LOGGED_IN_KEY'             => 'UiZE0{fh+}|l|2$}iVC;:M|U7)q3|RLx+Hv6x+7g#G.!gDY;L<=A1ca-0?2y#|Vr',
	'NONCE_KEY'                 => '^5E~ch i({Yxp#)EGOz<&dSj<#CA.4jl5)6Va=]fcvpFBwh1M!0LKW;4aU.<YQ?_',
	'AUTH_SALT'                 => 'PCja3DF9FdFP|Q2*w,jhnfiM;  N:_:s+LmQ;)NWqV1/#RXz/feBb.c+Xu^dQQ>R',
	'SECURE_AUTH_SALT'          => 'sjViec{Y86{^YmM$KI]0q_r`P4-%Jb&}l8}SQd^# YA1;,0O(7ADpU|X4?+Mho6)',
	'LOGGED_IN_SALT'            => '={zhuj;{z@Z3t}q?Yu-UkkHs+J|u:{2p?(D*,d`@,yBqvTSar$*6^^hOwy0qSN$A',
	'NONCE_SALT'                => 'J}r1Z?J]Ymg|*8DqZ!m9]B5_9zb/+*9-G4~gt >lpUR-9lL&6a-+)z_}y8PMhLkN',
];

foreach ( $config_defaults as $config_default_key => $config_default_value ) {
	if ( ! defined( $config_default_key ) ) {
		define( $config_default_key, $config_default_value );
	}
}
