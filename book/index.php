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
center {
    padding-bottom: 10px;
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
</script>
<div style="float:right">
<select id="chapters" onchange="onSelect();">
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
                $newcontent[] = '<a style="float:right;" href="pages/page_'.$pno.'.jpg" target="_blank">Page '.($numb+0).'</a>'."\n";
            }
        }
        if ( strpos($line, "[comment]: <> (code") === 0 ) {
            $pieces = preg_split("/[\s,(){}]+/", $line);
            $code = false;
            $file = false;
            foreach($pieces as $piece) {
                if ( $piece == 'code') {
                    $code = true;
                    continue;
                }
                if ( $code ) {
                    $file = $piece;
                    break;
                }
            }
            if ( $file ) {
                $newcontent[] = $line;
                $fn = "code/".$file;
                $code = file_get_contents($fn);
                if ( is_string($code) ) {
                    /*
                    foreach(explode("\n",$code) as $co) {
                        $newcontent[] = '    '.$co;
                    }
                     */
                    $first = -1;
                    $last = 0;
                    $clines = explode("\n",$code);
                    for($i=0; $i<count($clines); $i++ ) {
                        $cl = $clines[$i];
                        if (trim($cl) != "" ) {
                            if ( $first == -1 ) $first = $i;
                            $last = $i+1;
                        }
                    }

                    if ( $first >=0 && $last >= 0 ) {
                        $newcontent[] = "~~~~~~~~~~~~~~~~~~~~~";
                        for($i=$first; $i<$last; $i++) {
                            $newcontent[] = $clines[$i];
                        }
                        $newcontent[] = "~~~~~~~~~~~~~~~~~~~~~";
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
        echo $Parsedown->text($contents);
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
