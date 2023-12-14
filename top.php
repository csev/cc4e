<?php
use \Tsugi\Core\LTIX;

if ( ! isset($CFG) ) {
    if (!defined('COOKIE_SESSION')) define('COOKIE_SESSION', true);
    require_once "tsugi/config.php";
    $LAUNCH = LTIX::session_start();
}

$OUTPUT->header();

?>
<link rel="apple-touch-icon" sizes="180x180" href="/favicon_io/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon_io/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon_io/favicon-16x16.png">
<link rel="manifest" href="/favicon_io/site.webmanifest">
<style>
body {
    font-family: var(--font-family);
    font-size: 1.2rem;
    line-height: 1.93rem;
    color: var(--text);
    background-color: var(--background-color);
}
</style>

