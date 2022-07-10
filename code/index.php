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

$LOGGED_IN = U::get($_SESSION,'id', null) !== null;

?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once("../book/style.php");
?>
</head>
<body>
<h1>Sample Code for C Programming</h1>
<p>
This page contains the sample code elements from "C Programming" by 
Briwan W. Kernighan and Dennis M. Ritchie indexed by chapter and page.
The smaller or non-executable sample code segments are simply
left in-line in the text book.
Many of the sample code segments do not run directly from the book.  Also
some of them use older (pre-ANSI) syntax that does not work on modern compilers.  You may
have to adapt the code from the book to make it work.
</p>
<p>
The coding and compiling envronment on this web site 
(<a href="..">www.cc4e.com</a>)
is quite limited and focused
on supporting the needs of the auto-grader for this course.  You can find 
full-featured 
<a href="../compilers.php" target="_blank">
free online 
C Compilers</a> on other sites.
</p>
<?php

function chapter_title($pageno) {
    $chapters = array(
        array(0, "Chapter 0: Introduction", 0),
        array(1, "Chapter 1: A Tutorial Introduction", 5),
        array(2, "Chapter 2: Types, Operators and Expressions", 33),
        array(3, "Chapter 3: Control Flow", 51),
        array(4, "Chapter 4: Functions and Program Structure", 65),
        array(5, "Chapter 5: Pointers and Arrays", 89),
        array(6, "Chapter 6: Structures", 119),
        array(7, "Chapter 7: Input and Output", 143),
        array(8, "Chapter 8: The UNIX System Interface", 159),
    );

    $prevchapter = array();
    foreach($chapters as $chapter) {
        if ($chapter[2] >= $pageno ) return $prevchapter;
        $prevchapter = $chapter;
    }
    return $prevchapter;
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
    $text = @file_get_contents("../book/code/".$file);
    if ( strlen($text) < 1 ) continue;
    $id = str_replace(".c", "", $file);
    $page = intval($pieces[1]);
    $example = intval($pieces[2]);
    $chapter = chapter_title($page);
    $title = $chapter[1];
    $number = $chapter[0];
    // echo("$file $page $title\n");
    if ( $title != $chap_title ) {
        if ( $inchapter ) echo("</ul></li><li>\n");
        echo('<a href="../book/chap0'.$number.'.md">');
        echo(htmlentities($title)."\n");
        echo("</a>\n");
        echo("<ul>\n");
        $chap_title = $title;
        $inchapter = true;
    }
    $ref = "Page $page";
    if ( $example > 1 ) $ref = $ref . ' Example ' . $example;

    $edit = 'Edit';
    if ( ! $LOGGED_IN ) $edit = 'View';

?>
<li>
<a href="../book/chap0<?= $number ?>.md#pg<?= $page ?>" style="margin:0.5em;" class="xyzzy"><?= htmlentities($ref) ?></a>
<button style="margin:0.5em;display:none;" onclick="myToggle('<?= $id ?>');return false;" id="toggle_<?= $id ?>" >Show</button>
<button style="margin:0.5em;" onclick="myCopy('<?= $id ?>');return false;">Copy</button>
<button style=" margin:0.5em;" onclick="myEdit('<?= $file ?>');return false;"><?= $edit ?></button>
<pre class="code" id="pre_<?= $id ?>" style="display:none;">
<code class="language-c" id="<?= $id ?>">
<?php
    echo(htmlentities($text));
?>
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

