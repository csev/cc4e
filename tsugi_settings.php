<?php

/**
 * These are some configuration variables that are not secure / sensitive
 *
 * This file is included at the end of tsugi/config.php
 */

// This is how the system will refer to itself.
$CFG->servicename = 'CC4E';
$CFG->servicedesc = 'C Programming for Everybody';

// Default theme

$CFG->context_title = "C Programming for Everybody";

$CFG->lessons = $CFG->dirroot.'/../lessons.json';

// $CFG->youtube_url = $CFG->apphome . '/mod/youtube/';

$CFG->tdiscus = $CFG->apphome . '/mod/tdiscus/';

// $CFG->launcherror = $CFG->apphome . "/launcherror";
//
$CFG->theme = array(
    "text" => "#0b1117",
    "text-menu" => "#0b1117",
    "primary-darkest" => "#0b1117",
    "primary-darker" => "#05111d",
    "primary" => "#0a2137",
    "primary-menu" => "#0a2137",
    "text-light" => "#0a2137",
    "primary-border" => "#153756",
    "secondary" => "#c2d8ed",
    "background-color" => "#f8fbfd",
    "font-url" => "https://fonts.googleapis.com/css2?family=Open+Sans", // Optional custom font url for using Google fonts
    "font-family" => "'Open Sans', Corbel, Avenir, 'Lucida Grande', 'Lucida Sans', sans-serif", // Font family
    "font-size" => "14px", // This is the base font size used for body copy. Headers,etc. are scaled off this value
/*
    "primary" => "#2e7ac0", //default color for nav background, splash background, buttons, text of tool menu
    "secondary" => "#EEEEEE", // Nav text and nav item border color, background of tool menu
    "text" => "#111111", // Standard copy color
    "text-light" => "#5E5E5E", // A lighter version of the standard text color for elements like "small"
*/
);

$buildmenu = $CFG->dirroot.'/../buildmenu.php';
if ( file_exists($buildmenu) ) {
    require_once $buildmenu;
    $CFG->defaultmenu = buildMenu();
}

