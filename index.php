<?php
if ( isset($_POST['secret']) && $_POST['secret'] == '42' ) {
    setCookie('secret', '42', time() + 15 * 3600 * 24);
} else if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
?>
<form method="post">
Enter the unlock code below.  The unlock code is a number (a very specific, particular and important number) that
was featured throughout Dr. Chuck's other courses (Python, Django, PHP, and PostgreSQL).<br/>
<input type="text" name="secret">
<input type="submit" value="Check Unlock Number">
</form>
<?php
    return;
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

?><html>
<head>
<link href="static/codemirror-5.62.0/lib/codemirror.css" rel="stylesheet"/>
<style>
body {
    font-family: Courier, monospace;
}
</style>
</head>
<body>
<h1>C Programming for Everybody (CC4E)</h1>
<p>
This web site will teach C programming and Computer Architecture using the 1978 
<a href="https://en.wikipedia.org/wiki/The_C_Programming_Language" target="_blank">
C Programming</a> book by 
<a href="https://en.wikipedia.org/wiki/Brian_Kernighan" title="Brian Kernighan">Brian Kernighan</a>
and
<a href="https://en.wikipedia.org/wiki/Dennis_Ritchie" title="Dennis Ritchie">Dennis Ritchie</a>.
</p>
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
<textarea id="mycode" name="code" style="border: 1px black solid;">
<?php
if ( isset($_POST['code']) ) {
    echo(htmlentities($_POST['code']));
} else {
?>
#include <stdio.h>

main() {
  printf("Hello World\n");
}
<?php } ?>
</textarea>
<input type="submit" value="Compile">
</form>
Executing code needs more security and is coming soon.
</p>
<p>
This book is the foundation of all modern computing and advanced the notion that one programming language
could be used to develop high performance systems-level code that was portable across multiple
computer architectures.  In a sense it is like a 
<a href="https://en.wikipedia.org/wiki/Rosetta_Stone" target="_blank">Rosetta Stone</a>
that connects the early hardware-centered phase of computing
with today's software-centered phase of computing.
Since the book for this course is out of print, otherwise unavailable, not available in an accessable format,
and being presented in a historical context, we are providing a copy to
be used in conjunction with this course under
<a href="https://en.wikipedia.org/wiki/Fair_use" target="_blank">Fair Use</a>.
</p>
<p>
Here is our copy of the
<a href="book/chap01.md">book in progress</a> for your use in this course.
You can help us recover and present this historically important book in
<a href="https://github.com/csev/cc4e/" target="_blank">Github</a>.
</p>
<script type="text/javascript" src="static/codemirror-5.62.0/lib/codemirror.js"></script>
<script type="text/javascript" src="static/codemirror-5.62.0/mode/clike/clike.js"></script>
<script>
  var myTextarea = document.getElementById("mycode");
  var editor = CodeMirror.fromTextArea(myTextarea, {
          lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-csrc"
  });
</script>
</body>
