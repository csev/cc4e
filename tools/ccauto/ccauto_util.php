<?php

// Unique to user + course
function getCode($LAUNCH) {
    return $LAUNCH->user->id*42+$LAUNCH->context->id;
}

// Unique to user + course
function getLinkCode($LAUNCH) {
    return $LAUNCH->link->id*4200+$LAUNCH->user->id*42+$LAUNCH->context->id;
}

// Unique to user + course
function getLinkCodeHour($LAUNCH) {
    $hour = (time() / 3600) % 24;
    return $hour*10000+$LAUNCH->link->id*4200+$LAUNCH->user->id*42+$LAUNCH->context->id;
}

function romeo() {
    return <<< EOF
But soft what light through yonder window breaks
It is the east and Juliet is the sun
Arise fair sun and kill the envious moon
Who is already sick and pale with grief
EOF
;
}

function check_require($code, $require) {
    if ( ! is_array($require) ) return false;

    $retval = array();
    foreach($require as $rule) {
        if ( ! is_array($rule) || count($rule) != 2 ) continue;
        if ( strpos($code, $rule[0]) === false ) {
            $retval[] = $rule[1];
        }
    }

    if ( count($retval) < 1 ) return false;
    return $retval;
}

function check_prohibit($code, $prohibit) {
    if ( ! is_array($prohibit) ) return false;

    $retval = array();
    foreach($prohibit as $rule) {
        if ( ! is_array($rule) || count($rule) != 2 ) continue;
        if ( strpos($code, $rule[0]) !== false ) {
            $retval[] = $rule[1];
        }
    }

    if ( count($retval) < 1 ) return false;
    return $retval;
}

function column_row_start() {
   echo('<div class="row">'."\n");
}

function column_row_end() {
   echo('</div> <!-- class="row" -->'."\n");
}

function  column_editor_start() {
    global $main, $output_compare_fail;
    if ( $output_compare_fail ) {
      echo('<div id="column_editor_start" class="col-sm-12 col-lg-6 col-md-12">'."\n");
    } else if ( is_string($main) && strlen($main) > 0 ) {
      echo('<div id="column_editor_start" class="col-sm-12 col-lg-5 col-md-8">'."\n");
    } else {
      echo('<div id="column_editor_start" class="col-sm-12 col-lg-6 col-md-8">'."\n");
    }
}

function  column_editor_end() {
  echo('</div> <!-- id="column_editor_start" -->'."\n");
}

function  column_io_start() {
    global $main, $output_compare_fail;
    if ( $output_compare_fail ) {
      echo('<div id="column_io_start" class="col-sm-12 col-lg-6 col-md-12">'."\n");
    } else if ( is_string($main) && strlen($main) > 0 ) {
      echo('<div id="column_io_start" class="col-sm-12 col-lg-3 col-md-4">'."\n");
    } else {
      echo('<div id="column_io_start" class="col-sm-12 col-lg-6 col-md-4">'."\n");
    }
}

function  column_io_end() {
   echo('</div> <!-- id="column_io_start" -->'."\n");
}

function  column_main_start() {
    global $main, $output_compare_fail;
    if ( $output_compare_fail ) {
        echo('<div id="column_main_start" class="col-sm-12 col-lg-12 col-md-12">'."\n");
    } else if ( is_string($main) && strlen($main) > 0 ) {
        echo('<div id="column_main_start" class="col-sm-12 col-lg-4 col-md-12">'."\n");
    }
}

function  column_main_end() {
    global $main;
    if ( is_string($main) && strlen($main) > 0 ) {
    	echo('</div> <!-- id="column_main_start" -->'."\n");
    }
}

