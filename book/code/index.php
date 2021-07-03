<?php

if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
    header("Location: ../../index.php");
    return;
}

if ( ! function_exists('endsWith') ) {
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}
}

$stdout = False;
$stderr = False;
$return_value = False;

if ( isset($_POST['code']) ) {
$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   2 => array("pipe", "w") // stderr is a file to write to
);

$cwd = '/tmp';
$env = array(
    'some_option' => 'aeiou',
    'PATH' => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
);

$process = proc_open('gcc -ansi -x c -c -', $descriptorspec, $pipes, $cwd, $env);

if (is_resource($process)) {
    // $pipes now looks like this:
    // 0 => writeable handle connected to child stdin
    // 1 => readable handle connected to child stdout
    // Any error output will be appended to /tmp/error-output.txt

    fwrite($pipes[0], $_POST['code']);
    fclose($pipes[0]);

    $stdout = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[2]);

    // It is important that you close any pipes before calling
    // proc_close in order to avoid a deadlock
    $return_value = proc_close($process);

}
}

$url = $_SERVER['REQUEST_URI'];

$pieces = explode('/',$url);

$code = false;
if ( isset($_POST['code']) ) $code = $_POST['code'];
if ( ! $code && count($pieces) >= 2 ) {
   $file = $pieces[count($pieces)-1];
   if ( strpos($file, '/') !== false ) $file = false;
   if ( strpos($file, '..') !== false ) $file = false;
   if ( strpos($file, '\\') !== false ) $file = false;
   if ( ! file_exists($file) ) $file = false;
   $code = file_get_contents($file);
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
    } else {
        echo('<pre style="color:white; background-color:black;">'."\n");
        echo("$ gcc -ansi hello.c\n");
        if ( strlen($stdout) > 0 ) echo(htmlentities($stdout));
        if ( strlen($stderr) > 0 ) echo(htmlentities($stderr));
        echo("\n</pre>\n");
    }
}

?>
<form method="post">
<input type="submit" value="Compile">
<script>
if ( window.opener ) {
    document.write('<button onclick="window.close();">Close</button>');
}
</script>
<br/>&nbsp;<br/>
<textarea id="mycode" name="code" rows="<?= $lines ?>" style="height: <?= $lines ?>em; border: 1px black solid;">
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
Executing code needs more security and is coming soon.
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
