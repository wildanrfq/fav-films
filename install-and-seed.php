<?php
/**
 * Automated Installer and Database Seeder for WordPress Film Portfolio
 */

define( 'WP_INSTALLING', true );

require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
require_once ABSPATH . 'wp-admin/includes/post.php';

// Check if already installed
if ( ! is_blog_installed() ) {
    echo "Installing WordPress database schema...\n";
    $install_result = wp_install(
        'my 4 favorite films',      // Site Title
        'admin',                    // Username
        'admin@example.com',        // Email
        true,                       // Public
        '',                         // Deprecated
        'admin123',                 // Password
        'en_US'                     // Language
    );
    echo "WordPress installed successfully!\n";
} else {
    echo "WordPress database is already installed.\n";
}

// Ensure theme is set to our custom theme 'film-portfolio'
update_option( 'template', 'film-portfolio' );
update_option( 'stylesheet', 'film-portfolio' );
update_option( 'blogname', 'my 4 favorite films' );
update_option( 'blogdescription', 'A curated chronicle of my all-time cinema favorites' );
update_option( 'posts_per_page', 10 );

// Enable permalink structure
update_option( 'permalink_structure', '/%postname%/' );

echo "Active theme set to 'film-portfolio'.\n";

// Seed films database automatically
require_once __DIR__ . '/seed-films.php';
