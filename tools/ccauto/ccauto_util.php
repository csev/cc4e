<?php

// Unique to user + course
function getCode($LAUNCH) {
    return $LAUNCH->user->id*42+$LAUNCH->context->id;
}

// Unique to user + course
function getLinkCode($LAUNCH) {
    return $LAUNCH->link->id*4200+$LAUNCH->user->id*42+$LAUNCH->context->id;
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

