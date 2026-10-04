<?php
/**
 * Database Seeder for 4 Favorite Films
 * Inserts / updates the 4 curated films into the WordPress database:
 * 1. Drive My Car (2021)
 * 2. Bound (1996)
 * 3. Aftersun (2022)
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
        'watch_count' => 5,
        'quote'       => "Those who survive keep thinking about the dead. In one way or another, that will continue. You and I must keep on living like that.",
        'poster'      => '/wp-content/themes/film-portfolio/assets/posters/drive-my-car.jpg',
        'why_love'    => "Hamaguchi menciptakan meditasi tiga jam yang begitu hening namun menghantam sanubari tentang duka, rasa bersalah, dan ketidakmungkinan memahami orang yang paling kita cintai secara utuh. Melalui ritme perjalanan mobil Saab 900 merah menyusuri Hiroshima dan latihan teater multibahasa 'Paman Vanya', film ini menunjukkan bahwa percakapan paling jujur sering kali terjadi saat kita memandang lurus ke jalanan aspal, bukan ke mata lawan bicara. Sekuens pelukan di tengah hamparan salju Hokkaido antara Kafuku dan Watari adalah salah satu momen katarsis terindah dalam sejarah sinema modern.",
        'order'       => 1,
    ),
    array(
        'title'       => 'Like Father, Like Son',
        'year'        => '2013',
        'director'    => 'Hirokazu Kore-eda',
        'genre'       => 'Drama / Family',
        'rating'      => '5/5',
        'watch_count' => 6,
        'quote'       => "No one else can do the job of a father except you.",
        'poster'      => '/wp-content/themes/film-portfolio/assets/posters/like-father-like-son.jpg',
        'why_love'    => "Kore-eda memiliki kepekaan luar biasa dalam membedah kerapuhan institusi keluarga tanpa sedikit pun terjebak dalam melodrama murahan. Premis tentang dua anak yang tertukar saat lahir di rumah sakit ditransformasikan menjadi perenungan eksistensial yang tenang namun menyayat hati: apakah seorang ayah ditentukan oleh ikatan genetika, atau oleh akumulasi waktu, sentuhan, dan kebersamaan sehari-hari? Adegan ketika Ryota tanpa sengaja melihat foto-foto dirinya yang sedang tertidur di dalam kamera digital sang anak adalah salah satu momen paling sunyi dan menghancurkan dalam sejarah sinema kontemporer—sebuah pukulan telak yang menyadarkan bahwa cinta anak tidak menuntut kesempurnaan, melainkan kehadiran yang tulus.",
        'order'       => 2,
    ),
    array(
        'title'       => 'Aftersun',
        'year'        => '2022',
        'director'    => 'Charlotte Wells',
        'genre'       => 'Drama',
        'rating'      => '5/5',
        'watch_count' => 6,
        'quote'       => "There's this feeling, once you leave where you're from... like you don't quite belong there anymore. But you don't belong anywhere else, either.",
        'poster'      => '/wp-content/themes/film-portfolio/assets/posters/aftersun.jpg',
        'why_love'    => "Aftersun adalah lukisan duka dan ingatan yang menghancurkan hati justru karena ia menolak untuk menjadi melodramatis. Melalui fragmen rekaman MiniDV liburan musim panas di Turki, kita menyaksikan seorang anak perempuan yang kini telah dewasa berusaha merekonstruksi sosok ayahnya yang tenggelam dalam depresi terselubung. Penggunaan lagu 'Under Pressure' di lantai dansa stroboskopik adalah salah satu penyuntingan paling emosional yang pernah dibuat—sebuah pelukan perpisahan tanpa suara di ambang pintu memori yang tak akan pernah bisa dibuka kembali.",
        'order'       => 3,
    ),
    array(
        'title'       => 'A Separation',
        'year'        => '2011',
        'director'    => 'Asghar Farhadi',
        'genre'       => 'Drama / Psychological / Mystery',
        'rating'      => '5/5',
        'watch_count' => 5,
        'quote'       => "What is wrong is wrong, no matter who said it or where it's written.",
        'poster'      => '/wp-content/themes/film-portfolio/assets/posters/a-separation.jpg',
        'why_love'    => "Farhadi merancang skenario paling kedap cela dalam sinema abad ke-21. Berawal dari gugatan cerai pasangan di Teheran, perselisihan berkembang menjadi labirin moral, etika agama, dan benturan kelas sosial di mana penonton dibuat mustahil menyalahkan salah satu pihak. Setiap karakter memiliki alasan yang sah dan sangat manusiawi atas tindakan mereka, namun kebanggaan dan tekanan peradilan justru memperparah luka. Adegan akhir di koridor pengadilan yang sunyi meninggalkan dilema etis yang terus menghantui pikiran lama setelah layar menghitam.",
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
