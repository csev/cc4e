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
?>
<h1>Test Harness</h1>
<form method="POST" action="compile.php" target="output">
<input type="submit">
<textarea name="code" style="width:95%;" rows="10">
#include <stdio.h>

main() {
   printf("Hello world\n");
}
</textarea>
<p>Input data (optional)</p>
<textarea name="input" style="width:95%;" rows="5">
</textarea>
<h1>Output</h1>
<iframe name="output" id="output" style="width:95%;height: 500px; border: 1px blue solid">
</iframe>
</form>

