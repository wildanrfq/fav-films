<?php
// Redirect root post-new.php request to /wp-admin/post-new.php
$qs = ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '';
header( 'Location: /wp-admin/post-new.php' . $qs, true, 302 );
exit;
