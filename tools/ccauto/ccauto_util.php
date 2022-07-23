<?php

// Unique to user + course
function getCode($LAUNCH) {
    return $LAUNCH->user->id*42+$LAUNCH->context->id;
}

// Unique to user + course
function getLinkCode($LAUNCH) {
    return $LAUNCH->link->id*4200+$LAUNCH->user->id*42+$LAUNCH->context->id;
}

