<?php
// Redirect root post.php request to /wp-admin/post.php
$qs = ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '';
header( 'Location: /wp-admin/post.php' . $qs, true, 302 );
exit;
