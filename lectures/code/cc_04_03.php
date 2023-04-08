<?php

$a = array();

print("Testing php arrays\n");
$a["z"] = 8;
$a["z"] = 1;
$a["y"] = 9;
$a["b"] = 3;
$a["a"] = 4;
print_r($a);

printf("z=%d\n", $a["z"] ?? 42);
printf("x=%d\n", $a["x"] ?? 42);

printf("\nIterate\n");
foreach( $a as $k => $v ) {
    printf(" %s=%d\n", $k, $v);
}

// php cc_04_03.php

