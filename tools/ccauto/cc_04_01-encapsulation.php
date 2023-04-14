<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Encapsulation</b>
<p>
    This assignment will refactor your implementation of your Python
    dict class from a previous assignment following the principle of
    encapsulation.   We will rename member variables and functions to follow
    the Python convention that "private" variables start with a double
    underscore (a.k.a.
<a href="https://en.wikipedia.org/wiki/Naming_convention_(programming)" target="_blank">dunder</a>)
in C.  
    We will also switch the method calls to be stored within the object structure.
    In the previous assignment we called global functions using a naming covention:
<pre>
    pydict_len(self);
</pre>
    and instead call methods using the object instance and the "arrow syntax":
<pre>
    map-&gt;len(self);
</pre>
    Some code and
    method signatures have been provided for you as well as a main() program
    and some support routines from the lecture slides.
    There is a good deal of discussion of this application in the lecture
    materials associated with this assignment.
</p>
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
void __Map_put(struct Map* self, char *key, int value) {
    struct MapEntry *old, *new;
    char *new_key;
    if ( key == NULL ) return;

    old = __Map_find(self, key);
    if ( old != NULL ) {
        old->value = value;
        return;
    }

    new = malloc(sizeof(*new));
    new->__next = NULL;
    if ( self->__head == NULL ) self->__head = new;
    if ( self->__tail != NULL ) self->__tail->__next = new;
    new->__prev = self->__tail;
    self->__tail = new;

    new_key = malloc(strlen(key)+1);
    strcpy(new_key, key);
    new->key = new_key;

    new->value = value;

    self->__count++;
}

int __Map_size(struct Map* self)
{
    return self->__count;
}

struct Map * Map_new() {
    struct Map *p = malloc(sizeof(*p));

    p->__head = NULL;
    p->__tail = NULL;
    p->__count = 0;
    p->put = &__Map_put;
    p->get = &__Map_get;
    p->size = &__Map_size;
    p->dump = &__Map_dump;
    p->del = &__Map_del;
    return p;
}

EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) {
    return <<< EOF
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct MapEntry {
    char *key;  /* public */
    int value;  /* public */
    struct MapEntry *__prev;
    struct MapEntry *__next;
};

struct Map {
   /* Attributes */
   struct MapEntry *__head;
   struct MapEntry *__tail;
   int __count;

   /* Methods */
   void (*put)(struct Map* self, char *key, int value);
   int (*get)(struct Map* self, char *key, int def);
   int (*size)(struct Map* self);
   void (*dump)(struct Map* self);
   void (*del)(struct Map* self);
};

void __Map_del(struct Map* self) {
    struct MapEntry *cur, *next;
    cur = self->__head;
    while(cur) {
        free(cur->key);
        /* value is just part of the struct */
        next = cur->__next;
        free(cur);
        cur = next;
    }
    free((void *)self);
}

void __Map_dump(struct Map* self)
{
    struct MapEntry *cur;
    printf("Object Map count=%d\\n", self->__count);
    for(cur = self->__head; cur != NULL ; cur = cur->__next ) {
         printf("  %s=%d\\n", cur->key, cur->value);
    }
}

struct MapEntry* __Map_find(struct Map* self, char *key)
{
    struct MapEntry *cur;
    if ( self == NULL || key == NULL ) return NULL;
    for(cur = self->__head; cur != NULL ; cur = cur->__next ) {
        if(strcmp(key, cur->key) == 0 ) return cur;
    }
    return NULL;
}

int __Map_get(struct Map* self, char *key, int def)
{
    struct MapEntry *retval = __Map_find(self, key);
    if ( retval == NULL ) return def;
    return retval->value;
}

/* Student code will be inserted here */

int main(void)
{
    struct Map * map = Map_new();
    struct MapEntry *cur;

    /* Make sure we see all output up to an error */
    setvbuf(stdout, NULL, _IONBF, 0); 

    printf("Map test\\n");
    map->put(map, "z", 8);
    map->put(map, "z", 1);
    map->put(map, "y", 2);
    map->put(map, "b", 3);
    map->put(map, "a", 4);
    map->dump(map);

    printf("size=%d\\n", map->size(map));

    printf("z=%d\\n", map->get(map, "z", 42));
    printf("x=%d\\n", map->get(map, "x", 42));

    map->del(map);
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) {
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
Map test
Object Map count=4
  z=1
  y=2
  b=3
  a=4
size=4
z=1
x=42
EOF
;
}

function ccauto_prohibit($LAUNCH) {
    return array(
        array("main", "Don't include the main() code - the main() code is provided automatically by the autograder."),
        array("extern", "You should not use the 'extern' keyword."),
        array("exit", "You should not use 'exit'."),
    );
}

function ccauto_require($LAUNCH) {
    return array (
        array("malloc", "You need to use malloc() to allocate some memory."),
        array("&__Map_get", "You need to initialize map->get() in the constructor (encapsulation)."),
        array("&__Map_put", "You need to initialize map->put() in the constructor. (encapsulation)"),
        array("&__Map_dump", "You need to initialize map->dump() in the constructor. (encapsulation)"),
        array("&__Map_del", "You need to initialize map->del() in the constructor. (encapsulation)"),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
void __Map_put(struct Map* self, char *key, int value) {
    struct MapEntry *old, *new;
    char *new_key;
    if ( key == NULL ) return;

    old = __Map_find(self, key);
    if ( old != NULL ) {
        old->value = value;
        return;
    }

    new = malloc(sizeof(*new));
    new->__next = NULL;
    if ( self->__head == NULL ) self->__head = new;
    if ( self->__tail != NULL ) self->__tail->__next = new;
    new->__prev = self->__tail;
    self->__tail = new;

    new_key = malloc(strlen(key)+1);
    strcpy(new_key, key);
    new->key = new_key;

    new->value = value;

    self->__count++;
}

int __Map_size(struct Map* self)
{
    return self->__count;
}

struct Map * Map_new() {
    struct Map *p = malloc(sizeof(*p));

    p->__head = NULL;
    p->__tail = NULL;
    p->__count = 0;
    p->put = &__Map_put;
    p->get = &__Map_get;
    p->size = &__Map_size;
    p->dump = &__Map_dump;
    p->del = &__Map_del;
    return p;
}
EOF
;
}



