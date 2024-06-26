<?php

require_once("../tsugi/config.php");
require_once("../sandbox/sandbox.php");

// global $CFG;

$code = $_POST['code'] ?? '';
$secret = $_POST['secret'] ?? '';
if ( strlen($code) < 1 ) die('Need code');
if ( strlen($code) > 100000 ) die ('Need less code');
if ( strlen($secret) < 1 || $CFG->getExtension('emcc_secret') != $secret ) die("Bletchley Park");

function tempdir() {
    $tempfile=tempnam(sys_get_temp_dir(),'');
    // tempnam creates file on disk
    if (file_exists($tempfile)) { unlink($tempfile); }
    mkdir($tempfile);
    if (is_dir($tempfile)) { return $tempfile; }
}

$tempdir = tempdir();
$tempdir = "/tmp/zap";
$input = $tempdir . "/student.c";
file_put_contents($input, $code);

$command = "/opt/homebrew/bin/emcc -sEXIT_RUNTIME=1 -Wno-implicit-int student.c";
$stdin = null;
$cwd = $tempdir; 
$env = null;
$timeout = 10.0;

$compile = cc4e_pipe($command, $stdin, $cwd, $env, $timeout);

header("Content-type:application/json");

$hexfolder = bin2hex($tempdir);
$js = $CFG->apphome . '/emcompile/load.php/' . $hexfolder . '/a.out.js';
$wasm = $CFG->apphome . '/emcompile/load.php/' . $hexfolder . '/a.out.wasm';

$retval = array('code' => $code, 'tmpdir' => $tempdir, 'command' => $command, 'js' => $js, 'wasm' => $wasm, 'compile' => $compile);
echo(json_encode($retval));
