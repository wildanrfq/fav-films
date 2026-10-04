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
    <meta name="description" content="A curated collection of favorite films featuring personal reviews, 5/5 ratings, and watch statistics.">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🎬</text></svg>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="site-container">

    <!-- Hero Header: Centered title "my 4 favorite films" -->
    <header class="hero-header">
        <h1 class="main-title">my 4 favorite films</h1>
        <div class="hero-subtitle">
            <a href="https://letterboxd.com/wildanrfq/" target="_blank" rel="noopener noreferrer" class="letterboxd-badge" title="Visit wildanrfq on Letterboxd" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg class="letterboxd-logo" width="22" height="8" viewBox="0 0 98 36" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Letterboxd logo" style="width: 22px; height: 8px; max-width: 22px; max-height: 8px; vertical-align: middle; display: inline-block; flex-shrink: 0;">
                    <ellipse fill="#40BCF4" cx="79.21" cy="18" rx="18.03" ry="18"></ellipse>
                    <ellipse fill="#00E054" cx="48.62" cy="18" rx="18.03" ry="18"></ellipse>
                    <ellipse fill="#FF8000" cx="18.03" cy="18" rx="18.03" ry="18"></ellipse>
                    <path d="M33.32 27.53 C31.59 24.77 30.59 21.5 30.59 18 C30.59 14.5 31.59 11.23 33.32 8.47 C35.05 11.23 36.05 14.5 36.05 18 C36.05 21.5 35.05 24.77 33.32 27.53 Z" fill="#FFFFFF"></path>
                    <path d="M63.91 8.47 C65.65 11.23 66.65 14.5 66.65 18 C66.65 21.5 65.65 24.77 63.91 27.53 C62.18 24.77 61.18 21.5 61.18 18 C61.18 14.5 62.18 11.23 63.91 8.47 Z" fill="#FFFFFF"></path>
                </svg>
                <span class="letterboxd-text">letterboxd: <span class="letterboxd-user">wildanrfq</span></span>
            </a>
        </div>
    </header>

    <!-- Films Showcase Grid: Direct placement without sorting bars -->
    <main class="films-grid" id="filmsGrid">
        <?php if ( ! empty( $films ) ) : ?>
            <?php foreach ( $films as $index => $film ) : 
                $rank = $index + 1;
                $genre_str = ! empty( $film->genre ) ? (string) $film->genre : '';
                $genres = array_filter( array_map( 'trim', explode( '/', $genre_str ) ) );
                $poster_url = ! empty( $film->poster_url ) ? $film->poster_url : get_template_directory_uri() . '/assets/posters/drive-my-car.jpg';
                $rating_val = ! empty( $film->rating ) ? $film->rating : '5/5';
                $numeric_rating = floatval( str_replace( '/5', '', $rating_val ) );
                $watch_val = ! empty( $film->watch_count ) ? intval( $film->watch_count ) : 1;
            ?>
                <article 
                    class="film-card" 
                    id="film-<?php echo esc_attr( $film->ID ); ?>"
                    data-order="<?php echo esc_attr( $index ); ?>"
                    data-rating="<?php echo esc_attr( $numeric_rating ); ?>"
                    data-watch="<?php echo esc_attr( $watch_val ); ?>"
                >
                    <!-- Rank Indicator in Top-Right Corner (#1, #2, etc.) -->
                    <div class="film-rank-badge">#<?php echo esc_html( $rank ); ?></div>

                    <!-- Framed Poster Box: Inside the card with dedicated border & padding -->
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

                        <!-- Key Metrics: Rating Stars & Watch Count -->
                        <div class="film-metrics-strip">
                            <div class="metric-rating">
                                <span class="stars-green" title="Rating: <?php echo esc_attr( $rating_val ); ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                            </div>
                            <div class="metric-watch" title="Watched <?php echo esc_attr( $film->watch_count ); ?> times">
                                <svg class="watch-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16" aria-hidden="true">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <span class="badge-count"><?php echo esc_html( $film->watch_count ); ?>x</span>
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
                            <p class="review-text">
                                <?php echo esc_html( $film->why_love ); ?>
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer">
                            <button class="read-more-btn" type="button">
                                <span>Read Full Review</span> &rarr;
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
