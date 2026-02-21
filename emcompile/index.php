<!DOCTYPE html>
<?php
require_once("../tsugi/config.php");
$code = $_POST['code'] ?? '';
$input = $_POST['input'] ?? '42';
$output = $_POST['output'] ?? '';
if ( strlen($code) > 100000 ) die ('Need less code');
if ( strlen($CFG->getExtension('emcc_secret', '')) < 1 ) die("EmScriptEn Compiles not available on this server");
if ( strlen($CFG->getExtension('emcc_path', '')) < 1 ) die("EmScriptEn Compiles not available on this server");
if ( strlen($code) < 1 ) {
    $code = <<< EOF
#include <stdio.h>

main() { printf("hello world\\n"); }
EOF
;
}
?>
<html>
<head>
</head>
<body>
<h1>EmScriptEn Test Harness</h1>

<form method="post" action="execute.php" id="form">
<label for="emcc_secret">Secret:</label>
<input type="password" name="secret" id="emcc_secret"><br/>
<label for="emcc_code">C code:</label>
<textarea name="code" id="emcc_code" aria-label="C program source code" style="width:95%;" rows="5">
<?= htmlentities($code); ?>
</textarea>
<br/>
<label for="emcc_input">Input:</label>
<textarea name="input" id="emcc_input" aria-label="Program input" style="width:95%;" rows="5">
<?= htmlentities($input); ?>
</textarea>
<br/>
<input type="submit" value="Compile" aria-label="Compile code">
</form>

<?php
if ( strlen($output) > 0 ) {
    echo("<p>Program Output</p>\n");
    echo('<textarea name="code" aria-label="Compiled program output" style="width:95%;" rows="5">'."\n");
    echo($output);
    echo("\n</textarea>\n");
}
?>

</body>
</html>
