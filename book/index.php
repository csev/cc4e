<?php

require_once "Parsedown.php";
require_once "ParsedownExtra.php";

if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
    header("Location: ../index.php");
    return;
}

if ( ! function_exists('endsWith') ) {
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}
}

$url = $_SERVER['REQUEST_URI'];

$pieces = explode('/',$url);

$file = false;
$contents = false;
if ( $pieces >= 2 ) {
   $file = $pieces[count($pieces)-1];
   if ( ! endsWith($file, '.md') ) $file = false;
   if ( ! $file || ! file_exists($file) ) $file = false;
}

if ( $file == false ) $file = 'chap01.md';

if ( $file !== false ) {
    $contents = file_get_contents($file);
    $HTML_FILE = $file;
}

function x_sel($file) {
    global $HTML_FILE;
    $retval = 'value="'.$file.'"';
    if ( strpos($HTML_FILE, $file) === 0 ) {
        $retval .= " selected";
    }
    return $retval;
}


?>
<style>
body {
    font-family: Helvetica, Arial, sans-serif;
}

center {
    padding-bottom: 10px;
}

.note {
    border: 1px solid blue;
    padding-left: 1em;
    padding-right: 1em;
}

.code {
    border: 1px solid gray;
    padding-left: 1em;
    clear: both;
}

@media print {
    #chapters {
        display: none;
    }
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 5px;
}

tr:nth-child(even) {
  background-color: lightgray;
}


</style>
<?php

if ( $contents != false ) {
?>
<script src="https://static.tsugi.org/js/jquery-1.11.3.js"></script>
<script>
function onSelect() {
    console.log($('#chapters').val());
    window.location = $('#chapters').val();
}
// https://www.w3schools.com/howto/howto_js_copy_clipboard.asp
// https://stackoverflow.com/questions/22581345/click-button-copy-to-clipboard-using-jquery
function myCopy(me) {
    var code = me.nextSibling;
    console.log('code', code);
    console.log(code.textContent);
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val(code.textContent).select();
    document.execCommand("copy");
    $temp.remove();
}
function myEdit(me) {
    var code = me.nextSibling.nextSibling.id;
    console.log('code', code);
    window.open("code/"+code);
}
</script>
<div style="float:right">
<select id="chapters" onchange="onSelect();">
  <option <?= x_sel("..") ?>>CC4E</option>
  <option <?= x_sel("about.md") ?>>About</option>
  <option <?= x_sel("chap00.md") ?>>Chapter 0</option>
  <option <?= x_sel("chap01.md") ?>>Chapter 1</option>
  <option <?= x_sel("chap02.md") ?>>Chapter 2</option>
  <option <?= x_sel("chap03.md") ?>>Chapter 3</option>
  <option <?= x_sel("chap04.md") ?>>Chapter 4</option>
  <option <?= x_sel("chap05.md") ?>>Chapter 5</option>
  <option <?= x_sel("chap06.md") ?>>Chapter 6</option>
  <option <?= x_sel("chap07.md") ?>>Chapter 7</option>
  <option <?= x_sel("chap08.md") ?>>Chapter 8</option>
</select>
</div>
<?php

    // Lets do some post processing
    $lines = explode("\n",$contents);
    $newcontent = array();
    foreach($lines as $line) {
        if ( strpos($line, "[comment]: <> (page") === 0 ) {
            $pieces = preg_split("/[\s,(){}]+/", $line);
            $page = false;
            $numb = false;
            foreach($pieces as $piece) {
                if ( $piece == 'page') {
                    $page = true;
                    continue;
                }
                if ( $page ) {
                    $numb = $piece;
                    break;
                }
            }
            if ( $page ) {
                $pno = substr('000'.$numb, -3);
                $newcontent[] = '<div style="padding-left: 5px; padding-bottom: 0.5em; float:right;"><a onclick="window.open(\'pages/page_'.$pno.'\');return false;" href="#">Page '.($numb+0).'</a></div>'."\n";
            }
        }
        if ( strpos($line, "[comment]: <> (code") === 0 || 
             strpos($line, "[comment]: <> (note") === 0 ) {
            $pieces = preg_split("/[\s,(){}]+/", $line);
            $code = false;
            $note = false;
            $file = false;
            foreach($pieces as $piece) {
                if ( $piece == 'code') {
                    $code = true;
                    continue;
                }
                if ( $piece == 'note') {
                    $note = true;
                    continue;
                }
                if ( $code || $note ) {
                    $file = $piece;
                    break;
                }
            }
            if ( $file ) {
                $newcontent[] = $line;
                $fn = $code ? "code/".$file : "notes/".$file;
                $include = file_get_contents($fn);
                if ( is_string($include) ) {
                    /*
                    foreach(explode("\n",$include) as $co) {
                        $newcontent[] = '    '.$co;
                    }
                     */
                    $first = -1;
                    $last = 0;
                    $clines = explode("\n",$include);
                    for($i=0; $i<count($clines); $i++ ) {
                        $cl = $clines[$i];
                        if (trim($cl) != "" ) {
                            if ( $first == -1 ) $first = $i;
                            $last = $i+1;
                        }
                    }

                    if ( $first >=0 && $last >= 0 ) {
                        $newcontent[] = $code ? "~~~ ".$file."" : '-----lt----div id="'.$file.'" class="note"-----gt----';
                        for($i=$first; $i<$last; $i++) {
                            $newcontent[] = $clines[$i];
                        }
                        $newcontent[] = $code ? "~~~" : '-----lt----/div-----gt----';
                    }
                }
                continue;
            }
        }
        $newcontent[] = $line;
        
    }
    $contents = implode("\n", $newcontent);

    $debug = false;
    $Parsedown = new ParsedownExtra();
    if ( $debug ) {
        echo "<pre>\n".$contents."\n</pre>\n";
    } else {
        $md = $Parsedown->text($contents);
        $md = str_replace('-----lt----', '<', $md);
        $md = str_replace('-----gt----', '>', $md);
        $md = str_replace('<p><div', '<div', $md);
        $md = str_replace('class="note">', 'class="note"><p>', $md);
        $md = str_replace('<p></div></p>', '</div>', $md);
        // $md = str_replace('class="language-', 'class="code" id="', $md);
        $copy_button = '<button style="float:right; margin:0.5em;" onclick="myCopy(this);return false;">Copy</button>';
        $edit_button = '<button style="float:right; margin:0.5em;" onclick="myEdit(this);return false;">Edit</button>';
        $md = str_replace('<pre><code class="language-', '<pre class="code">'.$edit_button.$copy_button.'<code class="language-c" id="', $md);
        echo($md);
    }
} else {
?>
<p>
This is a work in progress start here: 
<a href="chap01.md">Chapter 1</a>,
Please feel free to improve this text in 
<a href="https://github.com/csev/cc4e/tree/main/md" target="_blank">Github</a>.
</p>
<?php
}
?>
<hr/>
<small>
<blockquote>
<a href="https://en.wikipedia.org/wiki/The_C_Programming_Language" target="_blank"><img src="pages/front.jpg" style="width:150px; float:right; padding-left: 10px;"></a>
<p>
This web site
(<a href="https://www.cc4e.com">www.cc4e.com</a>) is based on the 1978 
<a href="https://en.wikipedia.org/wiki/The_C_Programming_Language" target="_blank">"C Programming"</a>
book written by Brian Kernighan and
Dennis Ritchie.  The book and the material this site used from the book
is copyright all rights reserved by Prentice-Hall but is being used
in this site under "fair use" because of the book's historical and scholarly significance,
its lack of availablity, and lack of an accessible version of the book.
</p>
<p>
The book is augmented in places to help understand its rightful place in a historical
context amidst the major changes of the 1970's and 1980's as Computer Science evolved from a
hardware-first / vendor-centered aproach to a software-centered approach where
portable operating systems and applications written in C could run on any hardware.
</p>
<p>
This is not the ideal book to learn C programming because the 1978 edition does not reflect the modern
C language.  Using an obsolete book gives us an opportunity to take students back in time and understand
how the C language was evolving as it laid the ground work for a future with portable applications.
</p>
<p>
If you want to learn modern C programming from a book that reflects the modern C language,
I suggest you use the
<a href="https://amzn.to/3hNp6QH" target="_blank">C Programming Language, 2nd Edition</a>,
also written by Brian W. Kernighan and Dennis M. Ritchie, initially published in 
1988 and based on the 
<a href="https://en.wikipedia.org/wiki/ANSI_C" target="_blank">ANSI C</a> (C89) version
of the language.
</p>
</blockquote>
</small>
