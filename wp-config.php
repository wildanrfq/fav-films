<?php
/**
 * The base configuration for WordPress - Film Portfolio Project
 */

// Define SQLite database engine
define( 'DB_ENGINE', 'sqlite' );
define( 'DB_DIR', __DIR__ . '/wp-content/database/' );
define( 'DB_FILE', '.ht.sqlite' );

// MySQL fallback parameters (required for WP initialization)
define( 'DB_NAME', 'filmwp' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 */
define( 'AUTH_KEY',         'b!c8v#9Pq$L1z%W8*0j&dF2xM5nQ7wE9aZ4rT6yU3iO1pS8dF9gH2jK4l' );
define( 'SECURE_AUTH_KEY',  'X9mK2vL7wQ4zR8tY1uI3oP5aS6dF0gH2jK4lZ7xC9vB1nM3qW5eR8tY0u' );
define( 'LOGGED_IN_KEY',    'pS8dF9gH2jK4lZ7xC9vB1nM3qW5eR8tY0uI3oP5aS6dF0gH2jK4lZ7xC9v' );
define( 'NONCE_KEY',        'Z4rT6yU3iO1pS8dF9gH2jK4lX9mK2vL7wQ4zR8tY1uI3oP5aS6dF0gH2jK' );
define( 'AUTH_SALT',        'wE9aZ4rT6yU3iO1pS8dF9gH2jK4lZ7xC9vB1nM3qW5eR8tY0uI3oP5aS6d' );
define( 'SECURE_AUTH_SALT', 'qW5eR8tY0uI3oP5aS6dF0gH2jK4lZ7xC9vB1nM3qW5eR8tY0uI3oP5aS6dF0' );
define( 'LOGGED_IN_SALT',   '1uI3oP5aS6dF0gH2jK4lZ7xC9vB1nM3qW5eR8tY0uI3oP5aS6dF0gH2jK4' );
define( 'NONCE_SALT',       'jK4lZ7xC9vB1nM3qW5eR8tY0uI3oP5aS6dF0gH2jK4lX9mK2vL7wQ4zR8t' );

/**
 * WordPress database table prefix.
 */
$table_prefix = 'wp_';

/**
 * Dynamic Site URL for seamless local preview across any port.
 */
if ( isset( $_SERVER['HTTP_HOST'] ) ) {
    $protocol = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ) ? 'https://' : 'http://';
    define( 'WP_HOME', $protocol . $_SERVER['HTTP_HOST'] );
    define( 'WP_SITEURL', $protocol . $_SERVER['HTTP_HOST'] );
} else {
    define( 'WP_HOME', 'http://localhost:8000' );
    define( 'WP_SITEURL', 'http://localhost:8000' );
}

/**
 * Automatically enforce trailing slash on /wp-admin under PHP CLI server
 */
if ( isset( $_SERVER['REQUEST_URI'] ) ) {
    $req_path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
    if ( $req_path === '/wp-admin' ) {
        $qs = ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '';
        header( 'Location: /wp-admin/' . $qs, true, 301 );
        exit;
    }
}

/**
 * For developers: WordPress debugging mode.
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
