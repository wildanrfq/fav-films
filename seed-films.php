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
        'why_love'    => "Film ini adalah awal mula saya mengenal karya Hamaguchi. Tanpa disangka, datang ke bioskop di akhir pekan pada pukul setengah 11 pagi dalam keadaan tidak mengetahui apa apa tentang film ini adalah keputusan terbaik saya yang membuat ini adalah film favorit saya sepanjang masa. Film yang berdurasi 3 jam ini menceritakan tentang duka, penyesalan, dan hidup secara umum. Terkadang hidup berjalan tidak sesuai dengan apa yang kita harapkan, tetapi kita hanya punya 1 cara untuk melewati itu: jalani. Percakapan panjang di mobil Saab merah yang membawa kita ke banyak tempat di Jepang membuat saya merasakan atmosfer dan suasana yang disuguhkan oleh Hamaguchi di film ini.",
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
        'why_love'    => "Aftersun adalah film yang membawa kita ke dalam memori seorang anak bernama Sophie dan ayahnya. Berada di saat musim panas di Turki, Sophie dan ayahnya menghabiskan waktu untuk bersenang-senang, melakukan hal-hal layaknya seorang ayah dan anak perempuannya. Tetapi, ada hal yang menusuk hati. Secara tidak langsung, sang ayah menunjukkan bahwa ia sedang mengalami depresi. Film ini menunjukkan seorang ayah yang murah senyum di depan anaknya, tetapi disaat yang bersamaan juga mempunyai hal yang mengganggu dirinya.",
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
        'why_love'    => "Like Father, Like Son adalah film yang mempunyai premis yang cukup simpel, namun unik. Film ini menceritakan tentang sudut pandang dua keluarga yang mengalami insiden tidak terduga, yaitu anak mereka tertukar dengan satu sama lain. Dua keluarga ini mulai dites, bagaimana mereka menghadapi situasi ini. Mereka sudah melakukan yang terbaik selama mengasuh anak mereka. Berat, tetapi mereka harus mencoba ikhlas dan mulai beradaptasi lagi dengan anak mereka yang asli. Cobaan demi cobaan, Kore-eda mampu menggambarkan cara mereka menghadapi situasi ini dengan sangat baik. Adegan dimana Ryota, sang bapak, berbicara dengan anak dia yang tertukar dengan pemandangan suatu sungai tempat mereka piknik adalah salah satu adegan favorit saya sepanjang masa.",
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
        'why_love'    => "Farhadi, salah satu figur penting di sejarah sinema modern di negara Iran, membuat satu film yang membahas mengenai pasangan suami istri yang sedang mengalami perceraian. Ditengah pertikaian mereka, sang suami juga harus mengurus ayahnya yang mengidap penyakit Alzheimer. Mereka juga mempunyai anak yang menunjukkan rasa ketidaknyamanannya berada di suatu lingkungan yang rumit. Film ini sangat menggambarkan ketakutan saya, yaitu gagal membangun rumah tangga yang harmonis.",
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
