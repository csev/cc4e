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

?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once("../book/style.php");

function chapter_title($pageno) {
    $chapters = array(
        array("Chapter 0: Introduction", 0),
        array("Chapter 1: A Tutorial Introduction", 5),
        array("Chapter 2: Types, Operators and Expressions", 33),
        array("Chapter 3: Control Flow", 51),
        array("Chapter 4: Functions and Program Structure", 65),
        array("Chapter 5: Pointers and Arrays", 89),
        array("Chapter 6: Structures", 119),
        array("Chapter 7: Input and Output", 143),
        array("Chapter 8: The UNIX System Interface", 159),
    );

    $title = "TBD";
    foreach($chapters as $chapter) {
        if ($chapter[1] >= $pageno ) return $title;
        $title = $chapter[0];
    }
    return $title;
}

$chapter = 0;
$chap_title = "Catch Phrase";
$files = scandir("../book/code/");

echo("<ul><li>\n");

$inchapter = false;
foreach($files as $file ) {
    if ( strpos($file, "c_") !== 0 ) continue;
    $pieces = preg_split("/[_.]/", $file);
    // print_r($pieces);
    if ( count($pieces) != 4 ) continue;
    if ( $pieces[0] != 'c' ) continue;
    if ( $pieces[3] != 'c' ) continue;
    if ( ! is_numeric($pieces[1]) ) continue;
    if ( ! is_numeric($pieces[2]) ) continue;
    $page = intval($pieces[1]);
    $example = intval($pieces[2]);
    $title = chapter_title($page);
    // echo("$file $page $title\n");
    if ( $title != $chap_title ) {
        if ( $inchapter ) echo("</ul></li><li>\n");
        echo(htmlentities($title)."\n");
        echo("<ul>\n");
        $chap_title = $title;
        $inchapter = true;
    }
    $ref = "Page $page";
    if ( $example > 1 ) $ref = $ref . ' Example ' . $example;
?>
<li>
<a href="#<?= $file ?>" style="margin:0.5em;" class="xyzzy"><?= htmlentities($ref) ?></a>
<button style="margin:0.5em;" onclick="myCopy(this);return false;">Copy</button>
<button style=" margin:0.5em;" onclick="myEdit(this);return false;">Edit</button>
<pre class="code">
<code class="language-c" id="<?= $file ?>">
yada
</code>
</pre>
</li>
<?php

    echo("</li>\n");
}
if ( $inchapter ) {
    echo("</ul>\n");  // End of the files
    echo("</li></ul>\n");  // End of the chapters
}
?>

<script>
function onSelect() {
    console.log($('#chapters').val());
    window.location = $('#chapters').val();
}
// https://www.w3schools.com/howto/howto_js_copy_clipboard.asp
// https://stackoverflow.com/questions/22581345/click-button-copy-to-clipboard-using-jquery
function myCopy(me) {
    var code = me.nextSibling.nextSibling;
    console.log('code', code);
    console.log(code.textContent);
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val(code.textContent).select();
    document.execCommand("copy");
    $temp.remove();
}

function myEdit(me) {
    var code = me.nextSibling.nextSibling.nextSibling.id;
    console.log('code', code);
    window.open("<?= $CFG->apphome ?>/play?sample="+code);
}

$(document).ready(function() {
$("code.language-c").each(function( index ) {
  var filename = $( this ).attr("id");
  $(this).prev("a.xyzzy").attr('href', '#'+filename);
  filename = filename.replace('.c', '');
  $(this).prev("a.xyzzy").text(filename);
});
});
</script>
</body>
</html>

