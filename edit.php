<?php
// Redirect root edit.php request to /wp-admin/edit.php
$qs = ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '';
header( 'Location: /wp-admin/edit.php' . $qs, true, 302 );
exit;
