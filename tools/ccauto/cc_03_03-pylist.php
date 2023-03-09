<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Python String Class</b> 
<p>
    You will a set of supporting functions using the following structures
    to implement a subset of the Python list class in C.  Some code and
    method signatures have been provided for you as well as a main() program
    and some support routines from the lecture slides.  
    There is a good deal of discussion of this application in the lecture
    materials associated with this assignment.
<pre>
struct lnode {
    char *text;
    struct lnode *next;
};

struct pylist {
  struct lnode *head;
  struct lnode *tail;
  int count;
};
</pre>
</p>
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
/* print(lst) */
void pylist_print(struct pylist* self)
{
    /* About 10 lines of code 
       The output should match Python's
       list output

       ['Hello world', 'Catch phrase']

	Use printf cleverly, *not* string
	concatenation since this is C, not Python.
    */
}

/* len(lst) */
int pylist_len(const struct pylist* self)
{
    /* One line of code */
    return 42;
}

/* lst.append("Hello world") */
void pylist_append(struct pylist* self, char *str) {
    /* Review: Chapter 6 lectures and assignments */
}
/* lst.index("Hello world") - if not found -1 */
int pylist_index(struct pylist* self, char *str)
{
    /* Seven or so lines of code */
    return 42;
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

struct lnode {
    char *text;
    struct lnode *next;
};

struct pylist {
  struct lnode *head;
  struct lnode *tail;
  int count;
};

/* Constructor - lst = list() */
struct pylist * pylist_new() {
    struct pylist *p = malloc(sizeof(*p));
    p->head = NULL;
    p->tail = NULL;
    p->count = 0;
    return p;
}

/* Destructor - del(lst) */
void pylist_del(struct pylist* self) {
    struct lnode *cur, *next;
    cur = self->head;
    while(cur) {
        free(cur->text);
        next = cur->next;
        free(cur);
        cur = next;
    }
    free((void *)self);
}

int main(void)
{
    struct pylist * lst = pylist_new();
    pylist_append(lst, "Hello world");
    pylist_print(lst);
    pylist_append(lst, "Catch phrase");
    pylist_print(lst);
    pylist_append(lst, "Brian");
    pylist_print(lst);
    printf("Length = %d\\n", pylist_len(lst));
    printf("Brian? %d\\n", pylist_index(lst, "Brian"));
    printf("Bob? %d\\n", pylist_index(lst, "Bob"));
    pylist_del(lst);
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
['Hello world']
['Hello world', 'Catch phrase']
['Hello world', 'Catch phrase', 'Brian']
Length = 3
Brian? 2
Bob? -1
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array("main", "Don't include the main() code - the main() code is provided automatically by the autograder."),
        array("exit", "Don't use exit."),
        array("extern", "You should not use the 'extern' keyword."),
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
/* print(lst) */
void pylist_print(struct pylist* self)
{
    int first = 1;
    struct lnode *cur;
    printf("[");
    for(cur = self->head; cur != NULL ; cur = cur->next ) {
         if ( ! first ) printf(", ");
         printf("'%s'", cur->text);
         first = 0;
    }
    printf("]\\n");
}

/* len(lst) */
int pylist_len(const struct pylist* self)
{
    return self->count;
}

/* lst.append("Hello world") */
void pylist_append(struct pylist* self, char *str) {
    
    struct lnode *new = malloc(sizeof(*new));
    new->next = NULL;
    if ( self->head == NULL ) self->head = new;
    if ( self->tail != NULL ) self->tail->next = new;
    self->tail = new;

    char *text = malloc(strlen(str)+1);
    strcpy(text, str);
    new->text = text;

    self->count++;
}

/* lst.index("Hello world") - if not found -1 */
int pylist_index(struct pylist* self, char *str)
{
    struct lnode *cur;
    int i;
    if ( str == NULL ) return -1;
    for(i=0, cur = self->head; cur != NULL ; i++, cur = cur->next ) {
         if ( strcmp(str, cur->text) == 0 ) return i;
    }
    return -1;
}

EOF
;
}

