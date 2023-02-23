<?php

if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
    header("Location: ../../index.php");
    return;
}

use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;

if ( ! isset($CFG) ) {
    if (!defined('COOKIE_SESSION')) define('COOKIE_SESSION', true);
    require_once "../../tsugi/config.php";
    $LAUNCH = LTIX::session_start();
}

$LOGGED_IN = U::get($_SESSION,'id', null) !== null;

?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once("style.php");
?>
</head>
<body>
<h1>Sample Lecture Code for C Programming</h1>
<p>
This page contains the sample code from the "C Programming
for Everybody" lectures by Dr. Chuck.  You can also look at
the <a href="../../book/code">code samples from the textbook</a>.
</p>
<?php
$lectures_kr = array(
    "Chapter 0: Introduction",
    "Chapter 1: A Tutorial Introduction",
    "Chapter 2: Types, Operators and Expressions",
    "Chapter 3: Control Flow",
    "Chapter 4: Functions and Program Structure",
    "Chapter 5: Pointers and Arrays",
    "Chapter 6: Structures",
    "Chapter 7: Input and Output",
    "Chapter 8: The UNIX System Interface",
);

$lectures_cc = array(
    "N/A",
    "N/A",
    "Rosetta Stone: From Python to C",
);

$chapter = 0;
$chap_title = "Catch Phrase";
$files = scandir(".");

// echo("<pre>\n"); var_dump($files); echo("</pre>\n");

echo("<ul><li>\n");

$inchapter = false;
foreach($files as $file ) {
    if ( strpos($file, "kr_") === 0 || strpos($file, "cc_") === 0 ) {
        // stay
    } else {
        continue;
    }
    $pieces = preg_split("/[_.]/", $file);
    // print_r($pieces);
    if ( count($pieces) != 4 ) continue;
    if ( ! is_numeric($pieces[1]) ) continue;
    if ( ! is_numeric($pieces[2]) ) continue;
    $text = @file_get_contents($file);
    if ( strlen($text) < 1 ) continue;
    $id = str_replace(".", "_", $file);
    $chap = intval($pieces[1]);
    $example = intval($pieces[2]);
    if ( strpos($file, "kr_") === 0 ) {
        $title = U::get($lectures_kr, $chap, "Catch Phrase");
    } else {
        $title = U::get($lectures_cc, $chap, "Catch Phrase");;
    }

    if ( $title != $chap_title ) {
        if ( $inchapter ) echo("</ul></li><li>\n");
        echo('<a href="../../book/chap0'.$chap.'.md">');
        echo(htmlentities($title)."\n");
        echo("</a>\n");
        echo("<ul>\n");
        $chap_title = $title;
        $inchapter = true;
    }

    echo("<li>\n");
    echo(htmlentities($file));
?>
<button style="margin:0.5em;" onclick="myToggle('<?= $id ?>');return false;" id="toggle_<?= $id ?>" >Show</button>
<button style="margin:0.5em;" onclick="myCopy('<?= $id ?>');return false;">Copy</button>
<pre class="code" id="pre_<?= $id ?>" style="display:none;"><code class="language-c" id="<?= $id ?>"><?php
    echo(htmlentities($text));
?></code></pre>
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
function myCopy(id) {
    var code = document.getElementById(id);
    console.log('code', code);
    console.log(code.textContent);
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val(code.textContent).select();
    document.execCommand("copy");
    $temp.remove();
}

function myToggle(id) {
    $('#pre_'+id).toggle();
}

function myEdit(file) {
    window.open("<?= $CFG->apphome ?>/play?sample="+file);
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

