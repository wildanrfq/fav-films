<?php
/**
 * WordPress CLI Web Server Router
 * 
 * Handles routing, trailing slashes, permalinks, and catches missing /wp-admin/ prefixes.
 */

$uri = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

// 1. If someone accesses /wp-admin without a trailing slash, redirect to /wp-admin/
if ( $uri === '/wp-admin' ) {
    $qs = ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '';
    header( 'Location: /wp-admin/' . $qs, true, 301 );
    exit;
}

// 2. If an admin script is called without /wp-admin/ prefix (e.g. /edit.php, /post.php), redirect to /wp-admin/
$admin_scripts = array(
    'edit.php',
    'post.php',
    'post-new.php',
    'edit-tags.php',
    'options-general.php',
    'options-writing.php',
    'options-reading.php',
    'options-discussion.php',
    'options-media.php',
    'options-permalink.php',
    'options-privacy.php',
    'plugins.php',
    'plugin-install.php',
    'themes.php',
    'theme-install.php',
    'users.php',
    'user-new.php',
    'profile.php',
    'tools.php',
    'import.php',
    'export.php',
    'site-health.php',
    'admin-ajax.php',
    'admin-post.php',
    'upload.php',
    'media-new.php',
    'customize.php',
);

$trimmed_uri = ltrim( $uri, '/' );
if ( in_array( $trimmed_uri, $admin_scripts, true ) ) {
    $qs = ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '';
    header( 'Location: /wp-admin/' . $trimmed_uri . $qs, true, 302 );
    exit;
}

// 3. If file or directory exists physically on disk, let PHP serve it
$target_file = __DIR__ . $uri;
if ( $uri !== '/' && file_exists( $target_file ) ) {
    // If it is a directory without trailing slash, redirect with trailing slash
    if ( is_dir( $target_file ) && substr( $uri, -1 ) !== '/' ) {
        $qs = ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '';
        header( 'Location: ' . $uri . '/' . $qs, true, 301 );
        exit;
    }
    return false; // Built-in server serves static file or script directly
}

// 4. Fallback for all other requests (permalinks, REST API) to WordPress front controller
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';
require_once __DIR__ . '/index.php';
