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
</script>
<div style="float:right">
<select id="chapters" onchange="onSelect();">
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
                $newcontent[] = '<div style="padding-left: 5px; padding-bottom: 0.5em; float:right;"><a href="pages/page_'.$pno.'" target="_blank">Page '.($numb+0).'</a></div>'."\n";
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
        $edit_button = '<button style="float:right; margin:0.5em;" onclick="alert(\'Coming soon\');return false;">Edit</button>';
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
