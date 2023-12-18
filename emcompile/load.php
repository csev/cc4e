<?php

require_once("../tsugi/config.php");

$pathinfo = pathinfo($_SERVER['PATH_INFO']);
$extension = $pathinfo['extension'] ?? '';
$pathhex = str_replace('/', '', $pathinfo['dirname'] ?? '');
$basename = $pathinfo['basename'] ?? '';
$filename = $pathinfo['filename'] ?? '';
$path = hex2bin($pathhex);

$file = $path . "/" . $basename;

if ( ! file_exists($file) ) die('File not found'.$file);

if ( $extension == 'js' ) {
    header('Content-Type: application/javascript');
} else if ( $extension = 'wasm' ) {
    header("Content-Type: application/wasm");
} else {
    die('No extension for you!');
}

echo(file_get_contents($file));


