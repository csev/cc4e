<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Iteration</b>
<p>
    This assignment will add an iterator to your Map class.
    There is a good deal of discussion of iterators in the lecture
    materials associated with this assignment.
</p>
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
/* x[key] = value; Insert or replace the value associated with a key */
void pydict_put(struct pydict* self, char *key, char *value)
{
    malloc(42);
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

struct MapIter {
   struct MapEntry *__current;
   int __reverse;

   struct MapEntry* (*next)(struct MapIter* self);
   void (*del)(struct MapIter* self);
};

/*
 * This is our Map class
 */
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
   struct MapIter* (*iter)(struct Map* self);
   struct MapIter* (*last)(struct Map* self);
   void (*asort)(struct Map* self);
   void (*ksort)(struct Map* self);
   struct MapEntry* (*index)(struct Map* self, int position);
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

void __MapIter_del(struct MapIter* self) {
    free((void *)self);
}

void __Map_dump(struct Map* self)
{
    struct MapEntry *cur;
    printf("Object Map@%p count=%d\\n", self, self->__count);
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

struct MapEntry* __Map_index(struct Map* self, int position)
{
    int i;
    struct MapEntry *cur;
    if ( self == NULL ) return NULL;
    for(cur = self->__head, i=0; cur != NULL ; cur = cur->__next, i++ ) {
        if ( i >= position ) return cur;
    }
    return NULL;
}

void __Map_put(struct Map* self, char *key, int value) {

    struct MapEntry *old, *new;
    char *new_key;

    if ( key == NULL ) return;

    /* First look up */
    old = __Map_find(self, key);
    if ( old != NULL ) {
        old->value = value;
        return;
    }

    /* Not found - time to insert */
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

int __Map_get(struct Map* self, char *key, int def)
{
    struct MapEntry *retval = __Map_find(self, key);
    if ( retval == NULL ) return def;
    return retval->value;
}

int __Map_size(struct Map* self)
{
    return self->__count;
}

struct MapEntry* __MapIter_next(struct MapIter* self)
{
    struct MapEntry * retval = self->__current;

    if ( retval == NULL) return NULL;
    if ( self->__reverse == 0 ) {
        self->__current = self->__current->__next;
    } else {
        self->__current = self->__current->__prev;
    }

    return retval;
}

struct MapIter* __Map_iter(struct Map* self)
{
    struct MapIter *iter = malloc(sizeof(*iter));
    iter->__current = self->__head;
    iter->__reverse = 0;
    iter->next = &__MapIter_next;
    iter->del = &__MapIter_del;
    return iter;
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
    p->iter = &__Map_iter;
    p->del = &__Map_del;
    return p;
}

int main(void)
{
    struct Map * map = Map_new();
    struct MapEntry *cur;
    struct MapIter *iter;

    map->put(map, "z", 8);
    map->put(map, "z", 1);
    map->put(map, "y", 2);
    map->put(map, "b", 3);
    map->put(map, "a", 4);
    map->dump(map);

    printf("z=%d\\n", map->get(map, "z", 42));
    printf("x=%d\\n", map->get(map, "x", 42));

    printf("\\\nIterate\\n");
    iter = map->iter(map);
    while(1) {
        cur = iter->next(iter);
        if ( cur == NULL ) break;
        printf(" %s=%d\\n", cur->key, cur->value);
    }
    iter->del(iter);

    cur = map->index(map, 0);
    printf("The smallest value is %s=%d\\n", cur->key, cur->value);

    int pos = map->size(map) - 1;
    cur = map->index(map, pos);
    printf("The largest value is %s=%d\\n", cur->key, cur->value);

    map->del(map);
}

// rm -f a.out ; gcc map_list.c; a.out ; rm -f a.out

EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) {
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
{'z': 'Catch phrase'}
{'z': 'W'}
{'z': 'W', 'y': 'B', 'c': 'C', 'a': 'D'}
Length =4
z=W
x=(null)

Dump
z=W
y=B
c=C
a=D
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
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
/* print(dct) */
/* {'z': 'W', 'y': 'B', 'c': 'C', 'a': 'D'} */
void pydict_print(struct pydict* self)
{
    int first = 1;
    struct dnode *cur;
    printf("{");
    for(cur = self->head; cur != NULL ; cur = cur->next ) {
         if ( ! first ) printf(", ");
         printf("'%s': ", cur->key);
         printf("'%s'", cur->value);
         first = 0;
    }
    printf("}\\n");
}

int pydict_len(const struct pydict* self)
{
    return self->count;
}

/* find a node - used in get and put */
struct dnode* pydict_find(struct pydict* self, char *key)
{
    struct dnode *cur;
    if ( key == NULL ) return NULL;
    for(cur = self->head; cur != NULL ; cur = cur->next ) {
        if(strcmp(key, cur->key) == 0 ) return cur;
    }
    return NULL;
}

/* x.get(key) - Returns NULL if not found */
char* pydict_get(struct pydict* self, char *key)
{
    struct dnode *retval = pydict_find(self, key);
    if ( retval == NULL ) return NULL;
    return retval->value;
}

/* x[key] = value; Insert or replace the value associated with a key */
void pydict_put(struct pydict* self, char *key, char *value) {

    struct dnode *old, *new;
    char *new_key, *new_value;

    if ( key == NULL || value == NULL ) return;

    // First look up
    old = pydict_find(self, key);
    if ( old != NULL ) {
        free(old->value);
        new_value = malloc(strlen(value)+1);
        strcpy(new_value, value);
        old->value = new_value;
        return;
    }

    // Not found - time to insert
    new = malloc(sizeof(*new));
    new->next = NULL;
    if ( self->head == NULL ) self->head = new;
    if ( self->tail != NULL ) self->tail->next = new;
    self->tail = new;

    new_value = malloc(strlen(value)+1);
    strcpy(new_value, value);
    new->value = new_value;

    new_key = malloc(strlen(key)+1);
    strcpy(new_key, key);
    new->key = new_key;

    self->count++;
}

EOF
;
}

