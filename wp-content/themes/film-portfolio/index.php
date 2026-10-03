<?php
/**
 * Main Template File for Film Portfolio
 * 
 * Displays the centered title "my 4 favorite films", directly followed by the 4 curated films,
 * personal 5/5 ratings, watch counts, and authentic personal critiques.
 */

// Fetch the 4 films from database using $wpdb
$films = film_portfolio_get_films_from_db( 4 );

// If direct query returned empty, try standard WP_Query as fallback
if ( empty( $films ) ) {
    $args = array(
        'post_type'      => 'favorite_film',
        'posts_per_page' => 4,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
        $films = array();
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();
            $films[] = (object) array(
                'ID'           => $post_id,
                'post_title'   => get_the_title(),
                'rating'       => get_post_meta( $post_id, '_film_rating', true ),
                'watch_count'  => get_post_meta( $post_id, '_film_watch_count', true ),
                'release_year' => get_post_meta( $post_id, '_film_year', true ),
                'director'     => get_post_meta( $post_id, '_film_director', true ),
                'genre'        => get_post_meta( $post_id, '_film_genre', true ),
                'quote'        => get_post_meta( $post_id, '_film_quote', true ),
                'poster_url'   => get_post_meta( $post_id, '_film_poster', true ),
                'why_love'     => get_post_meta( $post_id, '_film_why_love', true ),
            );
        }
        wp_reset_postdata();
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Koleksi kurasi film favorit dengan catatan ulasan personal, rating 5/5, dan statistik tontonan.">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="site-container">

    <!-- Hero Header: Centered title "my 4 favorite films" -->
    <header class="hero-header">
        <h1 class="main-title">my 4 favorite films</h1>
    </header>

    <!-- Films Showcase Grid: Direct placement without sorting bars -->
    <main class="films-grid" id="filmsGrid">
        <?php if ( ! empty( $films ) ) : ?>
            <?php foreach ( $films as $index => $film ) : 
                $rank = $index + 1;
                $genres = array_filter( array_map( 'trim', explode( '/', $film->genre ) ) );
                $poster_url = ! empty( $film->poster_url ) ? $film->poster_url : get_template_directory_uri() . '/assets/posters/drive-my-car.jpg';
                $rating_val = ! empty( $film->rating ) ? $film->rating : '5/5';
            ?>
                <article 
                    class="film-card" 
                    id="film-<?php echo esc_attr( $film->ID ); ?>"
                >
                    <!-- Framed Poster Box: Inside the card with dedicated border & padding (no number overlay) -->
                    <div class="poster-column">
                        <div class="poster-frame">
                            <img 
                                src="<?php echo esc_url( $poster_url ); ?>" 
                                alt="<?php echo esc_attr( $film->post_title ); ?> Poster" 
                                class="poster-image"
                                loading="lazy"
                            />
                        </div>
                    </div>

                    <!-- Info & Review Column -->
                    <div class="info-column">
                        <div class="film-meta-header">
                            <div class="film-year-director">
                                <span><?php echo esc_html( $film->release_year ); ?></span>
                                <span class="bullet">&bull;</span>
                                <span>Dir. <?php echo esc_html( $film->director ); ?></span>
                            </div>

                            <h2 class="film-title"><?php echo esc_html( $film->post_title ); ?></h2>

                            <?php if ( ! empty( $genres ) ) : ?>
                                <div class="film-tags">
                                    <?php foreach ( $genres as $g ) : ?>
                                        <span class="genre-tag"><?php echo esc_html( $g ); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Key Metrics: 5/5 Rating & Watch Count -->
                        <div class="film-metrics-strip">
                            <div class="metric-item">
                                <span class="metric-label">Rating Saya</span>
                                <div class="metric-value-rating">
                                    <span class="stars-gold">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                                    <span class="rating-text"><?php echo esc_html( $rating_val ); ?></span>
                                </div>
                            </div>
                            <div class="metric-item">
                                <span class="metric-label">Sudah Ditonton</span>
                                <div class="metric-value-watch">
                                    <span class="badge-count"><?php echo esc_html( $film->watch_count ); ?>x</span>
                                </div>
                            </div>
                        </div>

                        <!-- Memorable Quote -->
                        <?php if ( ! empty( $film->quote ) ) : ?>
                            <blockquote class="film-quote-snippet">
                                &ldquo;<?php echo esc_html( $film->quote ); ?>&rdquo;
                            </blockquote>
                        <?php endif; ?>

                        <!-- Review Section -->
                        <div class="film-review-section">
                            <h3 class="review-headline">
                                <span>&#9998;</span> My Review
                            </h3>
                            <p class="review-text">
                                <?php echo esc_html( $film->why_love ); ?>
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer">
                            <button class="read-more-btn" type="button">
                                <span>Baca Ulasan Lengkap</span> &rarr;
                            </button>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <p>&copy; 2026 @wildanrfq</p>
        <p class="footer-credit">Made with WordPress</p>
    </footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
