<?php
require_once "tsugi/config.php";
use \Tsugi\Util\U;

require_once "sandbox/sandbox.php";
require_once "play_util.php";

$PING_CACHE = 20;

$secret = U::appCacheGet("pingsecret", null);
if ( $secret === null ) {
	U::appCacheSet("pingsecret", "42");
	$secret = U::appCacheGet("pingsecret", null);
}

header("Content-type: application/json; charset=utf-8");
if ( $secret != '42' ) {
	$retval = new \stdCLass();
	$retval->pingstatus = "No APC";
	echo(json_encode($retval, JSON_PRETTY_PRINT));
	return;
}

$prev = U::appCacheGet("pingtime", 0);
$retval = U::appCacheGet("pingretval", null);
if ( $retval == null ) $retval = new \stdCLass();
$now = time();
$delta = $now - $prev;
$retval->pingdelta = $delta;

if ( $delta < $PING_CACHE ) {
	$retval->pingstatus = "Cache";
	echo(json_encode($retval, JSON_PRETTY_PRINT));
	return;
}

U::appCacheSet("pingtime", $now);

$code = <<<EOF
#include <stdio.h>

main() {
   printf("Hello world\\n");
}
EOF;

$input = "";
$main = null;

$retval = cc4e_compile($code, $input, $main, "ping.php");
$retval->pingdelta = $delta;

U::appCacheSet("pingretval", $retval);
$retval->pingstatus = "Compile";

echo(json_encode($retval, JSON_PRETTY_PRINT));
