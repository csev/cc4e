<?php
if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
    header("Location: ../index.php");
    return;
}


use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;

if ( ! isset($CFG) ) {
    if (!defined('COOKIE_SESSION')) define('COOKIE_SESSION', true);
    require_once "../tsugi/config.php";
    $LAUNCH = LTIX::session_start();
}

if ( U::get($_SESSION,'id', null) === null ) {
    die('Must be logged in');
}

require_once "sandbox.php";
require_once "enable.php";

$ip = $_SERVER['REMOTE_ADDR'] ?? false;
if ( ! is_string($ip) ) die('No REMOTE_ADDR');

$public = filter_var(
    $ip, 
    FILTER_VALIDATE_IP, 
    FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE
);

if ( is_string($public) ) {
	die('bad address');
}

$code = $_POST['code'] ?? false;
$input = $_POST['input'] ?? false;
if ( ! is_string($code) ) die('No code');

$folder = sys_get_temp_dir() . '/compile-' . md5(uniqid());
$folder = '/tmp/compile';
if ( file_exists($folder) ) {
    system('rm $folder/*');
} else {
    mkdir($folder);
}
$env = array(
    'some_option' => 'aeiou',
    'PATH' => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
);

$retval = new \stdClass();
$retval->code = $code;
$retval->input = $input;
$retval->folder = $folder;

$command = 'rm -rf * ; tee student.c | gcc -ansi -S student.c ; [ -f student.s ] && cat student.s';

$pipe1 = cc4e_pipe($command, $code, $folder, $env, 11.0);
$retval->assembly = $pipe1;
$retval->docker = false;

$allowed = false;

if ( $pipe1->status === 0 ) {
    // $assembly = file_get_contents($folder . '/student.s');
    $assembly = $retval->assembly->stdout;
    $lines = explode("\n", $assembly);
    $newlines = array();
    foreach ( $lines as $line) {
        if ( strlen($line) < 1                 // blank lines
            || (! preg_match('/^\s/', $line))  // _main: 
            || preg_match('/^\s+\./', $line)   // 	.cfi_startproc
            || preg_match('/^\s.#/', $line)    // comment
        ) {
            $new[] = $line;
            continue;
        }
        // These should be the remaining executable statements
        // Linux:
        // 	call	puts@PLT
        // 	call	zap@PLT       ## External unknown
        // 	call	zap           ## Internal known
        // 	leaq	fun(%rip), %rax   # Internal known
        // 	movq	puts@GOTPCREL(%rip), %rax   # External unknown

        // Mac:
        //  movq    _puts@GOTPCREL(%rip), %rax
        //  callq	_printf
        //  callq   _zap         ## Both local and external :(
        //  leaq	L_.str(%rip), %rdi
        //  leaq	_fun(%rip), %rax

        // echo($line."\n");
        $pieces = explode("\t", $line);
        // var_dump($pieces);
    }
    $allowed = true;
}

if ( $allowed ) {
    $script = "cd /tmp;\n";
    $script .= "cat > student.c << EOF\n";
    $script .= $code;
    $script .= "\nEOF\n";
    $script .= "/usr/bin/gcc -ansi student.c\n";
    if ( is_string($input) && strlen($input) > 0 ) {
        $script .= "[ -f a.out ] && ./a.out << EOF\n";
        $script .= $input;
        $script .= "\nEOF\n";
    } else {
        $script .= "[ -f a.out ] && ./a.out\n";
    }

    // echo("-----\n");echo($script);echo("-----\n");
    $command = 'docker run --network none --rm -i alpine_gcc:latest "-"';
    $retval->docker = cc4e_pipe($command, $script, $folder, $env, 11.0);
}
    
header("Content-type: application/json; charset=utf-8");
echo(json_encode($retval, JSON_PRETTY_PRINT));
