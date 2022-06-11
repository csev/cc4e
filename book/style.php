<?php
use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;
?>

<style>
body {
    font-family: Helvetica, Arial, sans-serif;
}

center {
    padding-bottom: 10px;
}

p {
    text-align: justify;
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

a.xyzzy, a.xyzzy:hover, a.xyzzy:focus, a.xyzzy:active {
      text-decoration: none;
      color: inherit;
}

</style>

<script src="https://static.tsugi.org/js/jquery-1.11.3.js"></script>

