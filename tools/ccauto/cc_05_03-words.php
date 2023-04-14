<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>LinkedTreeMap</b>
<p>
There is a good deal of discussion of this assignment in the lecture
materials associated with this assignment.
</p>
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
/* You have to build everything except the main program here 
 * You should not need to write any new code - just gather your 
 * working TreeMap code and the supplied code together from the previous
 * assignment and combine them together.
 */
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) {
    return <<< EOF
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>

#include "student.c"

/**
 * The main program to read, parse, and count words
 */
int main(void)
{
    struct TreeMap * map = TreeMap_new();
    struct TreeMapEntry *cur;
    struct TreeMapIter *iter;
    char word[100];  /* Yes, this is dangerous */
    int i,j;
    int count, maxvalue;
    char *maxkey;

    setvbuf(stdout, NULL, _IONBF, 0);  /* Internal */

    /* Loop over each word in the file */
    while (scanf("%s", word) != EOF) {
        for (i=0, j=0; word[i] != '\\0'; i++) {
            if ( ! isalpha(word[i]) ) continue;
            word[j++] = tolower(word[i]);
        }
        word[j] = '\\0';
        count = map->get(map, word, 0);
        map->put(map, word, count+1);
    }

    maxkey = NULL;
    maxvalue = -1;
    iter = map->iter(map);
    while(1) {
        cur = iter->next(iter);
        if ( cur == NULL ) break;
        if ( maxkey == NULL || cur->value > maxvalue ) {
            maxkey = cur->key;
            maxvalue = cur->value;
        }
    }
    iter->del(iter);
    printf("\\n%s %d\\n", maxkey, maxvalue);

    map->del(map);
}

EOF
;

}

function ccauto_input($LAUNCH) { 
	return <<< EOF
But soft what light through yonder window breaks
It is the east and Juliet is the sun
Arise fair sun and kill the envious moon
Who is already sick and pale with grief
EOF
;
}

function ccauto_output($LAUNCH) {
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
Yada
EOF
;
}

function ccauto_prohibit($LAUNCH) {
    return array(
        array("extern", "You should not use the 'extern' keyword."),
        array("exit", "You should not use 'exit'."),
    );
}

function ccauto_require($LAUNCH) {
    return array (
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF

struct TreeMapEntry {
    char *key;  /* public */
    int value;  /* public */
    struct TreeMapEntry *__next;
    struct TreeMapEntry *__left;
    struct TreeMapEntry *__right;
};

struct TreeMapIter {
   struct TreeMapEntry *__current;

   struct TreeMapEntry* (*next)(struct TreeMapIter* self);
   void (*del)(struct TreeMapIter* self);
};

struct TreeMap {
   /* Attributes */
   struct TreeMapEntry *__head;
   struct TreeMapEntry *__root;
   int __count;

   /* Methods */
   void (*put)(struct TreeMap* self, char *key, int value);
   int (*get)(struct TreeMap* self, char *key, int def);
   int (*size)(struct TreeMap* self);
   void (*dump)(struct TreeMap* self);
   struct TreeMapIter* (*iter)(struct TreeMap* self);
   void (*del)(struct TreeMap* self);
};

void __TreeMap_del(struct TreeMap* self) {
    struct TreeMapEntry *cur, *next;
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

void __TreeMapIter_del(struct TreeMapIter* self) {
    free((void *)self);
}

void __TreeMap_dump_tree(struct TreeMapEntry *cur, int depth)
{
    int i;
    if ( cur == NULL ) return;
    for(i=0;i<depth;i++) printf("| ");
    printf("%s=%d\\n", cur->key, cur->value);
    if ( cur->__left != NULL ) {
        __TreeMap_dump_tree(cur->__left, depth+1);
    }
    if ( cur->__right != NULL ) {
        __TreeMap_dump_tree(cur->__right, depth+1);
    }
}

void __TreeMap_dump(struct TreeMap* self)
{
    struct TreeMapEntry *cur;
    printf("Object TreeMap count=%d\\n", self->__count);
    for(cur = self->__head; cur != NULL ; cur = cur->__next ) {
         printf("  %s=%d\\n", cur->key, cur->value);
    }
    printf("\\n");
    __TreeMap_dump_tree(self->__root, 0);
    printf("\\n");
}

/* Run a check to see if left and right are broken */
void __Map_check(struct TreeMap* self, struct TreeMapEntry *left, char *key, struct TreeMapEntry *right)
{
    /* printf("Check position: %s < %s > %s\\n", (left ? left->key : "0"), key, (right ? right->key : "0") ); */

    /* Check our location in the linked list */
    if ( left != NULL ) {
        if ( left->__next != right ) {
            printf("FAIL left->__next != right\\n");
        }
    } else {
        if ( self->__head != right ) {
            printf("FAIL self->__head != right\\n");
        }
    }

    /* Check our location in the tree */
    if ( right != NULL && right->__left == NULL ) {
        /* OK */
    } else if ( left != NULL && left->__right == NULL ) {
        /* OK */
    } else {
        printf("FAIL Neither right->__left nor left->__right are available\\n");
    }
}

void __TreeMap_put(struct TreeMap* self, char *key, int value) {

    struct TreeMapEntry *cur, *left, *right;
    int cmp;
    struct TreeMapEntry *old, *new;
    char *new_key;

    if ( key == NULL ) return;

    cur = self->__root;
    left = NULL;
    right = NULL;
    while(cur != NULL ) {
        cmp = strcmp(key, cur->key);
        if(cmp == 0 ) {
            cur->value = value;
            return;
        }
        if( cmp < 0 ) {
            right = cur;
            cur = cur->__left;
        } else {
            left = cur;
            cur = cur->__right;
        }
    }

    /* Not found - time to insert into the linked list after old */
    new = malloc(sizeof(*new));
    new->__next = NULL;
    new->__left = NULL;
    new->__right = NULL;
    new_key = malloc(strlen(key)+1);
    strcpy(new_key, key);
    new->key = new_key;
    new->value = value;
    self->__count++;

    /* Empty list - add first entry */
    if ( self->__head == NULL ) {
        self->__head = new;
        self->__root = new;
        return;
    }

    /* Keep this in here */
    __Map_check(self, left, key, right);

    /* Insert into the sorted linked list */
    if ( left != NULL ) {
        if ( left->__next != right ) {
            printf("FAIL left->__next != right\\n");
        }
        new->__next = right;
        left->__next = new;
    } else {
        if ( self->__head != right ) {
            printf("FAIL self->__head != right\\n");
        }
        new->__next = self->__head;
        self->__head = new;
    }

    /* Insert into the tree */
    if ( right != NULL && right->__left == NULL ) {
        right->__left = new;
    } else if ( left != NULL && left->__right == NULL ) {
        left->__right = new;
    } else {
        printf("FAIL Neither right->__left nor left->__right are available\\n");
    }

}

int __TreeMap_get(struct TreeMap* self, char *key, int def)
{
    int cmp;
    struct TreeMapEntry *cur;

    if ( self == NULL || key == NULL || self->__root == NULL ) return def;

    cur = self->__root;
    while(cur != NULL ) {
        cmp = strcmp(key, cur->key);
        if(cmp == 0 ) return cur->value;
        else if(cmp < 0 ) cur = cur->__left;
        else cur = cur->__right;

    }
    return def;
}

struct TreeMapEntry* __TreeMapIter_next(struct TreeMapIter* self)
{
    struct TreeMapEntry* retval;
    if ( self->__current == NULL) return NULL;
    retval = self->__current;
    self->__current = self->__current->__next;
    return retval;
}

int __TreeMap_size(struct TreeMap* self)
{
    return self->__count;
}

struct TreeMapIter* __TreeMap_iter(struct TreeMap* self)
{
    struct TreeMapIter *iter = malloc(sizeof(*iter));
    iter->__current = self->__head;
    iter->next = &__TreeMapIter_next;
    iter->del = &__TreeMapIter_del;
    return iter;
}

struct TreeMap * TreeMap_new() {
    struct TreeMap *p = malloc(sizeof(*p));

    p->__head = NULL;
    p->__root = NULL;
    p->__count = 0;

    p->put = &__TreeMap_put;
    p->get = &__TreeMap_get;
    p->size = &__TreeMap_size;
    p->dump = &__TreeMap_dump;
    p->iter = &__TreeMap_iter;
    p->del = &__TreeMap_del;
    return p;
}
EOF
;
}

