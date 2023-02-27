<?php

class Point {
    private $x, $y;

    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }
        
    public function dump() {
        printf("Object point x=%f y=%f\n", $this->x, $this->y);
    }

    public function origin() {
        return sqrt($this->x*$this->x+$this->y*$this->y);
    }
}
        
$pt = new Point(4.0, 5.0);
$pt->dump();
printf("Origin %f\n",$pt->origin());

// php < cc_03_01.php 

