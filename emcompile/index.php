<!DOCTYPE html>
<?php
require_once("../tsugi/config.php");
$code = $_POST['code'] ?? '';
$input = $_POST['input'] ?? '42';
$output = $_POST['output'] ?? '';
if ( strlen($code) > 100000 ) die ('Need less code');
if ( strlen($CFG->getExtension('emscripten_secret', '')) < 1 ) die("EmScriptEn Compiles not available on this server");
if ( strlen($code) < 1 ) {
    $code = <<< EOF
#include <stdio.h>

main() { printf("hello world\n"); }
EOF
;
}
?>
<html>
<head>
</head>
</body>
<h1>EmScriptEn Compiler</h1>

<form method="post" action="execute.php" id="form">
Secret: <input type="password" name="secret"><br/>
<textarea name="code" style="width:95%;" rows="5">
<?= htmlentities($code); ?>
</textarea>
<br/>
<p>Input</p>
<textarea name="input" style="width:95%;" rows="5">
<?= htmlentities($input); ?>
</textarea>
<br/>
<input type="submit" value="Compile">
</form>

<?php
if ( strlen($output) > 0 ) {
    echo("<p>Program Output</p>\n");
    echo('<textarea name="code" style="width:95%;" rows="5">'."\n");
    echo($output);
    echo("\n</textarea>\n");
}
?>

</body>
</html>
