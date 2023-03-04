<?php

if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
    header("Location: ../index.php");
    return;
}

require_once "../tsugi/config.php";

use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;

if ( ! isset($CFG) ) {
    if (!defined('COOKIE_SESSION')) define('COOKIE_SESSION', true);
    $LAUNCH = LTIX::session_start();
} else {
    session_start();
}

$LOGGED_IN = U::get($_SESSION, 'id', null) !== null;

$OUTPUT->header();
require_once("../book/style.php");
$OUTPUT->bodystart(false);

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
    "Object Oriented Patterns",
    "A Data Structure",
    "Hardware Architecture",
);

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


?>
<h1>Sample Code for C Programming</h1>
<p>This page contains the sample code for C Programming for Everybody - A Historical Perspective.

<ul class="nav nav-tabs">
  <li class="active"><a href="#krbook" data-toggle="tab" aria-expanded="true">K&R Textbook Code</a></li>
  <li><a href="#chapter" data-toggle="tab" aria-expanded="false">K&R Lecture Code</a></li>
  <li><a href="#lectures" data-toggle="tab" aria-expanded="false">CC4E Lecture Code</a></li>
</ul>
<div id="myTabContent" class="tab-content" style="margin-top:10px;">
  <div class="tab-pane fade active in" id="krbook">
<p>
This page contains the sample code elements from "C Programming" by 
Brian W. Kernighan and Dennis M. Ritchie indexed by chapter and page.
The smaller or non-executable sample code segments are simply
left in-line in the text book.
Many of the sample code segments do not run directly from the book.  Also
some of them use older (pre-ANSI) syntax that does not work on modern compilers.  You may
have to adapt the code from the book to make it work.
</p>
<?php

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
<button style="margin:0.5em;" onclick="myToggle('<?= $id ?>');return false;" id="toggle_<?= $id ?>" >Show</button>
<button style="margin:0.5em;" onclick="myCopy('<?= $id ?>');return false;">Copy</button>
<button style=" margin:0.5em;display:none;" onclick="myEdit('<?= $file ?>');return false;"><?= $edit ?></button>
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
</div>
<div class="tab-pane fade" id="chapter">
<p>
This page contains the sample code from the "C Programming
for Everybody" lectures setting the context for each chapter by Dr. Chuck.
</p>
<?php

$chapter = 0;
$files = scandir("../lectures/code/");

$chap_title = "Catch Phrase";
// echo("<pre>\n"); var_dump($files); echo("</pre>\n");

echo("<ul><li>\n");

$inchapter = false;
foreach($files as $file ) {
    if ( strpos($file, "kr_") !== 0 ) continue;
    $pieces = preg_split("/[_.]/", $file);
    // echo("<pre>\n");print_r($pieces);echo("</pre>\n");
    if ( count($pieces) != 4 ) continue;
    if ( ! is_numeric($pieces[1]) ) continue;
    if ( ! is_numeric($pieces[2]) ) continue;
    $text = @file_get_contents("../lectures/code/".$file);
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
        echo('<a href="../book/chap0'.$chap.'.md">');
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

</div>
<div class="tab-pane fade" id="lectures">
<p>
This page contains the sample code from the "C Programming
for Everybody" extra topics by Dr. Chuck.
</p>
<?php

$chapter = 0;
$files = scandir("../lectures/code/");

$chap_title = "Catch Phrase";
// echo("<pre>\n"); var_dump($files); echo("</pre>\n");

echo("<ul><li>\n");

$inchapter = false;
foreach($files as $file ) {
    if ( strpos($file, "cc_") !== 0 ) continue;
    $pieces = preg_split("/[_.]/", $file);
    // echo("<pre>\n");print_r($pieces);echo("</pre>\n");
    if ( count($pieces) != 4 ) continue;
    if ( ! is_numeric($pieces[1]) ) continue;
    if ( ! is_numeric($pieces[2]) ) continue;
    $text = @file_get_contents("../lectures/code/".$file);
    if ( strlen($text) < 1 ) continue;
    $id = str_replace(".", "_", $file);
    $chap = intval($pieces[1]);
    $example = intval($pieces[2]);
    $title = U::get($lectures_cc, $chap, "Catch Phrase");;

    if ( $title != $chap_title ) {
        if ( $inchapter ) echo("</ul></li><li>\n");
        echo(htmlentities($title)."\n");
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

</div>
</div>
<?php

$OUTPUT->footerStart();
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
<?php
$OUTPUT->footerEnd();

