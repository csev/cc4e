<?php

$ip = $_SERVER['REMOTE_ADDR'];

$public = filter_var(
    $ip, 
    FILTER_VALIDATE_IP, 
    FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE
);

if ( is_string($public) ) {
	die('bad address');
}

$content = isset($_POST['content']) ? $_POST['content'] : false;
if ( ! is_string($content) ) die('No content');

$json = json_decode($content);
if ( ! is_object($json)) die ('Bad JSON');
die('Yada');
