<?php
/**
 * Static Site Exporter for GitHub Pages / Vercel
 * Exports the WordPress homepage into a self-contained static site in docs/
 */

$rootDir = dirname(__DIR__);
$docsDir = $rootDir . '/docs';

echo "1. Creating docs/ directory structure...\n";
@mkdir($docsDir, 0755, true);
@mkdir($docsDir . '/assets/js', 0755, true);
@mkdir($docsDir . '/assets/posters', 0755, true);

echo "2. Copying CSS and JS assets...\n";
copy(
    $rootDir . '/wp-content/themes/film-portfolio/style.css',
    $docsDir . '/style.css'
);
copy(
    $rootDir . '/wp-content/themes/film-portfolio/assets/js/main.js',
    $docsDir . '/assets/js/main.js'
);

echo "3. Copying poster images...\n";
$posters = glob($rootDir . '/wp-content/themes/film-portfolio/assets/posters/*');
foreach ($posters as $poster) {
    $filename = basename($poster);
    copy($poster, $docsDir . '/assets/posters/' . $filename);
    echo "   - Copied: $filename\n";
}

echo "4. Fetching rendered homepage from local WordPress...\n";
$html = file_get_contents('http://127.0.0.1:8000/');
if (!$html) {
    die("Error: Could not fetch from http://127.0.0.1:8000/. Ensure local server is running.\n");
}

echo "5. Optimizing HTML for static hosting (GitHub Pages & Vercel)...\n";
// Adjust CSS paths to relative
$html = preg_replace(
    '#http://127\.0\.0\.1:8000/wp-content/themes/film-portfolio/style\.css\?ver=[0-9\.]*#',
    './style.css',
    $html
);
$html = str_replace(
    '/wp-content/themes/film-portfolio/style.css',
    './style.css',
    $html
);

// Adjust JS paths to relative
$html = preg_replace(
    '#http://127\.0\.0\.1:8000/wp-content/themes/film-portfolio/assets/js/main\.js\?ver=[0-9\.]*#',
    './assets/js/main.js',
    $html
);
$html = str_replace(
    '/wp-content/themes/film-portfolio/assets/js/main.js',
    './assets/js/main.js',
    $html
);

// Adjust Poster paths to relative
$html = str_replace(
    '/wp-content/themes/film-portfolio/assets/posters/',
    './assets/posters/',
    $html
);
$html = str_replace(
    'http://127.0.0.1:8000/wp-content/themes/film-portfolio/assets/posters/',
    './assets/posters/',
    $html
);

// Remove any leftover admin quicklinks if present
$html = preg_replace(
    '#<a href="http://127\.0\.0\.1:8000/wp-admin/[^"]*" class="admin-quicklink">.*?</a>#s',
    '',
    $html
);

// Remove local AJAX nonce, speculation rules, and discovery links
$html = preg_replace('#<script id="film-portfolio-script-js-extra">.*?</script>#s', '', $html);
$html = preg_replace('#<script type="speculationrules">.*?</script>#s', '', $html);
$html = preg_replace('#<link rel="https://api\.w\.org/"[^>]*>#', '', $html);
$html = preg_replace('#<link rel="EditURI"[^>]*>#', '', $html);
$html = preg_replace('#<script id="wp-emoji-settings"[^>]*>.*?</script>#s', '', $html);
$html = preg_replace('#<script type="module">.*?wpEmojiSettingsSupports.*?</script>#s', '', $html);

// Remove any remaining http://127.0.0.1:8000 references
$html = str_replace('http://127.0.0.1:8000', '', $html);

// Ensure proper relative base
file_put_contents($docsDir . '/index.html', $html);

echo "6. Export completed successfully!\n";
echo "   Output location: $docsDir/index.html\n";
