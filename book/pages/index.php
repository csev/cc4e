<?php

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
$pageno = false;
if ( count($pieces) >= 2 ) {
   $page = $pieces[count($pieces)-1];
   $file = $page . '.jpg';
   if ( ! file_exists($file) ) {
       $page = "page_001";
       $file = "page_001.jpg";
    }
   $pieces = explode('_', $page);
   if ( count($pieces) >= 2 && is_numeric($pieces[1]) ) {
       $pageno = $pieces[1]+0;
       $next = $pieces[0] . '_' . substr('000' . ($pageno + 1), -3);
       $prev = $pieces[0] . '_' . substr('000' . ($pageno - 1), -3);
       if ( ! file_exists($prev . '.jpg') ) $prev = false;
       if ( ! file_exists($next . '.jpg') ) $next = false;
    } else {
        $prev = false;
        $next = false;
    }
}
?>
<html>
<head>
<style>
body {
    background-color: gray;
}

.scan {
  height: 100%;
  max-width: 90%;
  display: block;
  margin-left: auto;
  margin-right: auto;
}

.nav-btn {
  display: inline-block;
  padding: 0.25em 0.5em;
  margin: 0 0.25em;
  border: 1px solid #999;
  border-radius: 4px;
  background: #eee;
  color: #333;
  text-decoration: none;
  cursor: pointer;
}

.nav-btn:hover {
  background: #ddd;
}
</style>
</head>
<body>
<?php
if ( $prev || $next ) {
    echo('<div style="float:right">');
}
if ( $prev ) {
    echo('<a href="'.$prev.'" class="nav-btn">Prev</a> ');
}
echo(' Page '.$pageno.' ');
if ( $next ) {
    echo('<a href="'.$next.'" class="nav-btn">Next</a> ');
}
if ( $prev || $next ) {
    echo("</div>\n");
}
?>
<script>
if ( window.opener ) {
    document.write('<button onclick="window.close();" aria-label="Close window">Close</button><br/>');
}
</script>
<img class="scan" src='<?= $file ?>' alt="Page scan">
</body>
