<?php
function func($a, &$b)
{   
    $a = 1;
    $b = 2;
}

$x = 42;
$y = 43;
echo 'main x ',$x,' y ',$y, "\n";
func($x, $y);
echo 'back x ',$x,' y ',$y, "\n";

