<?php
/**
 * Theme functions and definitions for Film Portfolio
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Setup theme features
 */
function film_portfolio_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'film_portfolio_setup' );

/**
 * Enqueue scripts and styles
 */
function film_portfolio_scripts() {
    // Google Fonts: Figtree & JetBrains Mono
    wp_enqueue_style(
        'film-fonts',
        'https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=JetBrains+Mono:wght@400;500&display=swap',
        array(),
        null
    );

    // Theme main stylesheet
    wp_enqueue_style( 'film-portfolio-style', get_stylesheet_uri(), array(), '1.5.0' );

    // Theme interactive JavaScript
    wp_enqueue_script(
        'film-portfolio-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.1.0',
        true
    );

    // Localize script with AJAX URL and nonce
    wp_localize_script( 'film-portfolio-script', 'filmAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'film_portfolio_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'film_portfolio_scripts' );

/**
 * Register Custom Post Type: Favorite Film
 */
function film_portfolio_register_cpt() {
    $labels = array(
        'name'               => 'Favorite Films',
        'singular_name'      => 'Favorite Film',
        'menu_name'          => 'Favorite Films',
        'add_new'            => 'Add New Film',
        'add_new_item'       => 'Add New Favorite Film',
        'edit_item'          => 'Edit Film',
        'new_item'           => 'New Film',
        'view_item'          => 'View Film',
        'search_items'       => 'Search Films',
        'not_found'          => 'No films found',
        'not_found_in_trash' => 'No films found in trash',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-video-alt3',
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'rewrite'             => array( 'slug' => 'film' ),
    );

    register_post_type( 'favorite_film', $args );
}
add_action( 'init', 'film_portfolio_register_cpt' );

/**
 * Add Meta Boxes for Film Details
 */
function film_portfolio_add_meta_boxes() {
    add_meta_box(
        'film_details_meta_box',
        'Informasi & Ulasan Film',
        'film_portfolio_render_meta_box',
        'favorite_film',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'film_portfolio_add_meta_boxes' );

/**
 * Render Meta Box Form
 */
function film_portfolio_render_meta_box( $post ) {
    wp_nonce_field( 'film_portfolio_save_meta', 'film_portfolio_meta_nonce' );

    $rating      = get_post_meta( $post->ID, '_film_rating', true );
    $watch_count = get_post_meta( $post->ID, '_film_watch_count', true );
    $year        = get_post_meta( $post->ID, '_film_year', true );
    $director    = get_post_meta( $post->ID, '_film_director', true );
    $genre       = get_post_meta( $post->ID, '_film_genre', true );
    $quote       = get_post_meta( $post->ID, '_film_quote', true );
    $poster      = get_post_meta( $post->ID, '_film_poster', true );
    $why_love    = get_post_meta( $post->ID, '_film_why_love', true );
    ?>
    <style>
        .film-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px; }
        .film-meta-field { display: flex; flex-direction: column; gap: 5px; }
        .film-meta-field label { font-weight: 600; color: #23282d; }
        .film-meta-field input, .film-meta-field textarea { width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccd0d4; }
        .film-meta-full { grid-column: span 2; }
    </style>
    <div class="film-meta-grid">
        <div class="film-meta-field">
            <label for="film_rating">Rating Saya (skala 5, contoh: 5/5):</label>
            <input type="text" id="film_rating" name="film_rating" value="<?php echo esc_attr( $rating ); ?>" placeholder="5/5" />
        </div>
        <div class="film-meta-field">
            <label for="film_watch_count">Berapa Kali Sudah Ditonton (angka):</label>
            <input type="number" id="film_watch_count" name="film_watch_count" value="<?php echo esc_attr( $watch_count ); ?>" placeholder="8" min="1" />
        </div>
        <div class="film-meta-field">
            <label for="film_year">Tahun Rilis:</label>
            <input type="text" id="film_year" name="film_year" value="<?php echo esc_attr( $year ); ?>" placeholder="2014" />
        </div>
        <div class="film-meta-field">
            <label for="film_director">Sutradara (Director):</label>
            <input type="text" id="film_director" name="film_director" value="<?php echo esc_attr( $director ); ?>" placeholder="Christopher Nolan" />
        </div>
        <div class="film-meta-field">
            <label for="film_genre">Genre:</label>
            <input type="text" id="film_genre" name="film_genre" value="<?php echo esc_attr( $genre ); ?>" placeholder="Sci-Fi / Adventure / Drama" />
        </div>
        <div class="film-meta-field">
            <label for="film_poster">URL Poster Film:</label>
            <input type="text" id="film_poster" name="film_poster" value="<?php echo esc_attr( $poster ); ?>" placeholder="/wp-content/themes/film-portfolio/assets/posters/interstellar.jpg" />
        </div>
        <div class="film-meta-field film-meta-full">
            <label for="film_quote">Kutipan Berkesan (Iconic Quote):</label>
            <input type="text" id="film_quote" name="film_quote" value="<?php echo esc_attr( $quote ); ?>" placeholder="“Love is the one thing we're capable of perceiving that transcends dimensions of time and space.”" />
        </div>
        <div class="film-meta-field film-meta-full">
            <label for="film_why_love">Deskripsi Kenapa Saya Suka Filmnya (Ulasan Personal):</label>
            <textarea id="film_why_love" name="film_why_love" rows="5" placeholder="Tulis alasan personal mendalam kenapa Anda menyukai film ini..."><?php echo esc_textarea( $why_love ); ?></textarea>
        </div>
    </div>
    <?php
}

/**
 * Save Meta Box Data into Database
 */
function film_portfolio_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['film_portfolio_meta_nonce'] ) || ! wp_verify_nonce( $_POST['film_portfolio_meta_nonce'], 'film_portfolio_save_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array(
        'film_rating'      => '_film_rating',
        'film_watch_count' => '_film_watch_count',
        'film_year'        => '_film_year',
        'film_director'    => '_film_director',
        'film_genre'       => '_film_genre',
        'film_quote'       => '_film_quote',
        'film_poster'      => '_film_poster',
        'film_why_love'    => '_film_why_love',
    );

    foreach ( $fields as $input_key => $meta_key ) {
        if ( isset( $_POST[ $input_key ] ) ) {
            $value = ( $input_key === 'film_why_love' ) ? sanitize_textarea_field( $_POST[ $input_key ] ) : sanitize_text_field( $_POST[ $input_key ] );
            update_post_meta( $post_id, $meta_key, $value );
        }
    }
}
add_action( 'save_post_favorite_film', 'film_portfolio_save_meta_box_data' );

/**
 * Direct Database Query Helper: Demonstrates clean PHP Database integration using $wpdb
 */
function film_portfolio_get_films_from_db( $limit = 4 ) {
    global $wpdb;

    // Direct SQL query using $wpdb prepared statement for high performance
    $sql = "
        SELECT p.ID, p.post_title, p.post_content, p.menu_order,
               pm_rating.meta_value AS rating,
               pm_watch.meta_value AS watch_count,
               pm_year.meta_value AS release_year,
               pm_director.meta_value AS director,
               pm_genre.meta_value AS genre,
               pm_quote.meta_value AS quote,
               pm_poster.meta_value AS poster_url,
               pm_why.meta_value AS why_love
        FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->postmeta} pm_rating ON p.ID = pm_rating.post_id AND pm_rating.meta_key = '_film_rating'
        LEFT JOIN {$wpdb->postmeta} pm_watch ON p.ID = pm_watch.post_id AND pm_watch.meta_key = '_film_watch_count'
        LEFT JOIN {$wpdb->postmeta} pm_year ON p.ID = pm_year.post_id AND pm_year.meta_key = '_film_year'
        LEFT JOIN {$wpdb->postmeta} pm_director ON p.ID = pm_director.post_id AND pm_director.meta_key = '_film_director'
        LEFT JOIN {$wpdb->postmeta} pm_genre ON p.ID = pm_genre.post_id AND pm_genre.meta_key = '_film_genre'
        LEFT JOIN {$wpdb->postmeta} pm_quote ON p.ID = pm_quote.post_id AND pm_quote.meta_key = '_film_quote'
        LEFT JOIN {$wpdb->postmeta} pm_poster ON p.ID = pm_poster.post_id AND pm_poster.meta_key = '_film_poster'
        LEFT JOIN {$wpdb->postmeta} pm_why ON p.ID = pm_why.post_id AND pm_why.meta_key = '_film_why_love'
        WHERE p.post_type = 'favorite_film' AND p.post_status = 'publish'
        ORDER BY p.menu_order ASC, p.ID ASC
        LIMIT %d
    ";

    $results = $wpdb->get_results( $wpdb->prepare( $sql, $limit ) );
    return $results;
}

/**
 * AJAX Handler: Increment Watch Count in Database
 */
function film_portfolio_ajax_increment_watch() {
    check_ajax_referer( 'film_portfolio_nonce', 'nonce' );

    $post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
    if ( ! $post_id || get_post_type( $post_id ) !== 'favorite_film' ) {
        wp_send_json_error( array( 'message' => 'Invalid film ID' ) );
    }

    $current_count = intval( get_post_meta( $post_id, '_film_watch_count', true ) );
    $new_count     = $current_count + 1;
    update_post_meta( $post_id, '_film_watch_count', $new_count );

    wp_send_json_success( array(
        'post_id'   => $post_id,
        'new_count' => $new_count,
        'message'   => "Tontonan bertambah menjadi {$new_count}x!",
    ) );
}
add_action( 'wp_ajax_film_increment_watch', 'film_portfolio_ajax_increment_watch' );
add_action( 'wp_ajax_nopriv_film_increment_watch', 'film_portfolio_ajax_increment_watch' );
