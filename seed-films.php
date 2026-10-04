<?php
/**
 * Database Seeder for 4 Favorite Films
 * Inserts / updates the 4 curated films into the WordPress database:
 * 1. Drive My Car (2021)
 * 2. Aftersun (2022)
 * 3. Like Father, Like Son (2013)
 * 4. A Separation (2011)
 */

// Load WordPress environment
require_once __DIR__ . '/wp-load.php';

if ( ! function_exists( 'wp_insert_post' ) ) {
    require_once ABSPATH . 'wp-admin/includes/post.php';
}

echo "=== Updating Database with New Curated Films ===\n";

$films = array(
    array(
        'title'       => 'Drive My Car',
        'year'        => '2021',
        'director'    => 'Ryusuke Hamaguchi',
        'genre'       => 'Drama / Mystery',
        'rating'      => '5/5',
        'watch_count' => 2,
        'quote'       => "Those who survive keep thinking about the dead. In one way or another, that will continue. You and I must keep on living like that.",
        'poster'      => '/wp-content/themes/film-portfolio/assets/posters/drive-my-car.jpg',
        'why_love'    => "This film marked the beginning of my journey into Hamaguchi's work. Walking into the cinema on a weekend morning at 10:30 AM knowing virtually nothing about it turned out to be the best decision I ever made, cementing this as my all-time favorite film. Spanning three hours, the film delves into grief, regret, and life itself. Sometimes life doesn't turn out the way we hope, but there is only one way through it: to live it. The long, intimate conversations inside the red Saab 900 traveling across various corners of Japan truly immersed me in the serene, evocative atmosphere Hamaguchi crafted so masterfully.",
        'order'       => 1,
    ),
    array(
        'title'       => 'Aftersun',
        'year'        => '2022',
        'director'    => 'Charlotte Wells',
        'genre'       => 'Drama',
        'rating'      => '5/5',
        'watch_count' => 3,
        'quote'       => "There's this feeling, once you leave where you're from... like you don't quite belong there anymore. But you don't belong anywhere else, either.",
        'poster'      => '/wp-content/themes/film-portfolio/assets/posters/aftersun.jpg',
        'why_love'    => "Aftersun immerses us into the lingering memories of a young girl named Sophie and her father. Set during a summer holiday in Turkey, Sophie and her dad spend their time having fun, sharing the tender moments typical between a father and his daughter. Yet beneath the surface lies something truly heartbreaking. Subtly and quietly, the father reveals glimpses of the deep depression he is grappling with. The film portrays a father who keeps smiling warmly in front of his child, even while carrying a heavy internal turmoil within.",
        'order'       => 2,
    ),
    array(
        'title'       => 'Like Father, Like Son',
        'year'        => '2013',
        'director'    => 'Hirokazu Kore-eda',
        'genre'       => 'Drama / Family',
        'rating'      => '5/5',
        'watch_count' => 1,
        'quote'       => "No one else can do the job of a father except you.",
        'poster'      => '/wp-content/themes/film-portfolio/assets/posters/like-father-like-son.jpg',
        'why_love'    => "Like Father, Like Son carries a relatively simple yet profoundly unique premise. The film explores the perspectives of two families grappling with an unexpected incident: discovering their sons were switched at birth. Both families are pushed to their limits as they navigate this painful reality. Having poured so much love and care into raising their children, they face the agonizing process of letting go and trying to adapt to their biological sons. Through trial after trial, Kore-eda captures their emotional struggle with extraordinary grace and sensitivity. The scene where Ryota, the father, talks with his non-biological son by the riverside during a picnic remains one of my absolute favorite cinematic moments of all time.",
        'order'       => 3,
    ),
    array(
        'title'       => 'A Separation',
        'year'        => '2011',
        'director'    => 'Asghar Farhadi',
        'genre'       => 'Drama / Psychological / Mystery',
        'rating'      => '5/5',
        'watch_count' => 2,
        'quote'       => "What is wrong is wrong, no matter who said it or where it's written.",
        'poster'      => '/wp-content/themes/film-portfolio/assets/posters/a-separation.jpg',
        'why_love'    => "Farhadi, one of the most prominent figures in modern Iranian cinema, crafts a compelling story centered around a married couple going through a divorce. In the midst of their escalating conflict, the husband must also care for his elderly father suffering from Alzheimer's disease. Meanwhile, their young daughter is caught in between, visibly uncomfortable navigating such a complicated and fraught environment. This film deeply captures one of my greatest personal fears: the failure to build and sustain a harmonious family.",
        'order'       => 4,
    ),
);

// Remove old films that are not in this list
$current_films = get_posts( array(
    'post_type'      => 'favorite_film',
    'posts_per_page' => -1,
    'post_status'    => 'any',
) );

$new_titles = array_column( $films, 'title' );

foreach ( $current_films as $cf ) {
    if ( ! in_array( $cf->post_title, $new_titles, true ) ) {
        wp_delete_post( $cf->ID, true );
        echo "Removed old film: {$cf->post_title} (ID #{$cf->ID})\n";
    }
}

// Insert / Update new films
foreach ( $films as $data ) {
    $existing = get_posts( array(
        'post_type'   => 'favorite_film',
        'title'       => $data['title'],
        'post_status' => 'publish',
    ) );

    if ( ! empty( $existing ) ) {
        $post_id = $existing[0]->ID;
        wp_update_post( array(
            'ID'           => $post_id,
            'post_title'   => $data['title'],
            'post_content' => $data['why_love'],
            'menu_order'   => $data['order'],
        ) );
        echo "Updated film: {$data['title']} (ID #{$post_id})\n";
    } else {
        $post_id = wp_insert_post( array(
            'post_title'   => $data['title'],
            'post_content' => $data['why_love'],
            'post_status'  => 'publish',
            'post_type'    => 'favorite_film',
            'menu_order'   => $data['order'],
        ) );
        echo "Created new film: {$data['title']} (ID #{$post_id})\n";
    }

    // Save metadata in database
    update_post_meta( $post_id, '_film_rating', $data['rating'] );
    update_post_meta( $post_id, '_film_watch_count', $data['watch_count'] );
    update_post_meta( $post_id, '_film_year', $data['year'] );
    update_post_meta( $post_id, '_film_director', $data['director'] );
    update_post_meta( $post_id, '_film_genre', $data['genre'] );
    update_post_meta( $post_id, '_film_quote', $data['quote'] );
    update_post_meta( $post_id, '_film_poster', $data['poster'] );
    update_post_meta( $post_id, '_film_why_love', $data['why_love'] );
}

echo "=== Database successfully updated with the 4 films and official posters! ===\n";
