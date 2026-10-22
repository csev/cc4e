<?php

if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
    header("Location: ../../index.php");
    return;
}

require_once "../../tsugi/config.php";
require_once "../../sandbox/sandbox.php";

$stdout = '';
$stderr = '';
$return_value = false;

if ( isset($_POST['code']) ) {
    $emcc = $CFG->getExtension('emcc_path', '/opt/homebrew/bin/emcc');
    $out = tempnam(sys_get_temp_dir(), 'cc4e');
    $command = $emcc . ' -c -ansi -x c -o ' . escapeshellarg($out) . ' -';
    $pipe = cc4e_pipe($command, $_POST['code'], sys_get_temp_dir(), null, 10.0);
    @unlink($out);
    $stdout = is_string($pipe->stdout) ? $pipe->stdout : '';
    $stderr = is_string($pipe->stderr) ? $pipe->stderr : '';
    $return_value = $pipe->status;
    if ( $return_value === false ) $return_value = 1;
}

$url = $_SERVER['REQUEST_URI'];

$pieces = explode('/',$url);

$code = false;
if ( isset($_POST['code']) ) $code = $_POST['code'];
if ( ! $code && count($pieces) >= 2 ) {
   $file = $pieces[count($pieces)-1];
   if ( $file === '' || strpos($file, '/') !== false || strpos($file, '..') !== false || strpos($file, '\\') !== false || ! is_file($file) ) {
       $file = false;
   }
   if ( is_string($file) ) $code = file_get_contents($file);
}

$lines = $code ? count(explode("\n", $code)) : 15;
?><html>
<head>
<link href="../../static/codemirror-5.62.0/lib/codemirror.css" rel="stylesheet"/>
<style>
body {
    font-family: Courier, monospace;
}
  .CodeMirror { height: auto; border: 1px solid #ddd; }
  .CodeMirror-scroll { max-height: <?= intval(($lines/13)*20) ?>em; }

</style>
</head>
<body>
<p>
You can write and compile some C code below.
</p>
<p>
<?php
if ( $return_value !== False ) {
    if ( $return_value === 0 ) {
        echo('<p style="color:green;">Your code compiled successfully.  </p>'."\n");
        echo('<pre style="color:white; background-color:black;">'."\n");
        echo("$ emcc -ansi -c hello.c\n");
        if ( strlen($stdout) > 0 ) echo(htmlentities($stdout));
        echo("\n</pre>\n");
    } else {
        echo('<pre style="color:white; background-color:black;">'."\n");
        echo("$ emcc -ansi -c hello.c\n");
        if ( strlen($stdout) > 0 ) echo(htmlentities($stdout));
        if ( strlen($stderr) > 0 ) echo(htmlentities($stderr));
        echo("\n</pre>\n");
    }
}

?>
<form method="post">
<label for="mycode">C code</label>
<input type="submit" value="Compile" aria-label="Compile code">
<script>
if ( window.opener ) {
    document.write('<button onclick="window.close();" aria-label="Close window">Close</button>');
}
</script>
<br/>&nbsp;<br/>
<textarea id="mycode" name="code" rows="<?= $lines ?>" style="height: <?= $lines ?>em; border: 1px black solid;" aria-label="C code to compile">
<?php
if ( $code ) {
    echo(htmlentities($code));
} else {
?>
#include <stdio.h>

main() {
  printf("Hello World\n");
}
<?php } ?>
</textarea>
</form>
This page uses Emscripten to check that the code compiles. Run a program from the playground.
</p>
<h1>
C Programming for Everybody (<a href="../..">CC4E</a>)
</h1>
<script type="text/javascript" src="../../static/codemirror-5.62.0/lib/codemirror.js"></script>
<script type="text/javascript" src="../../static/codemirror-5.62.0/mode/clike/clike.js"></script>
<script>
  var myTextarea = document.getElementById("mycode");
  var editor = CodeMirror.fromTextArea(myTextarea, {
          lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-csrc",
  });
</script>
</body>
