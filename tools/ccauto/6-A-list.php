<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Linked List</b> 
<p>
    You will write a function list_add() to append an integer to the end of
    a linked list.  You will also write a function called list_find() that
    will return the list node containing the integer value or NULL if the value
    is not in the list.
</p>
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
void list_add(lst, value)
    struct list *lst;
    int value;
{
    /* Append the value to the end of the linked list. */
}

struct lnode * list_find(lst, value)
    struct list *lst;
    int value;
{
    return NULL;
}

EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
#include <stdlib.h>

struct lnode {
    int value;
    struct lnode *next;
};

struct list {
  struct lnode *head;
  struct lnode *tail;
};

int main()
{
    void list_add();
    void list_dump();
    struct lnode * list_find();

    struct list mylist;
    struct lnode * mynode;

    mylist.head = NULL;
    mylist.tail = NULL;

    list_add(&mylist, 10);
    list_add(&mylist, 20);
    list_add(&mylist, 30);
    list_dump(&mylist);

    mynode = list_find(&mylist, 42);
    if ( mynode == NULL ) {
        printf("Did not find 42\\n");
    } else {
        printf("Looked for 42, found %d\\n", mynode->value);
    }

    mynode = list_find(&mylist, 30);
    if ( mynode == NULL || mynode->value != 30) {
        printf("Did not find 30\\n");
    } else {
        printf("Found 30\\n");
    }

    list_add(&mylist, 40);
    list_dump(&mylist);

}

void list_dump(lst)
    struct list *lst;
{
    struct lnode *cur;
    printf("\\nDump:\\n");
    for(cur=lst->head; cur != NULL; cur=cur->next) {
        printf("  %d\\n", cur->value);
    }
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
Dump:
  10
  20
  30
Did not find 42
Found 30

Dump:
  10
  20
  30
  40
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array("main", "Don't include the main() code - the main() code is provided automatically by the autograder."),
        array("extern", "You should not use the 'extern' keyword."),
        array("[", "You do not need to use any arrays []."),
        array("]", "You do not need to use any arrays []."),
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
void list_add(lst, value)
    struct list *lst;
    int value;
{
      struct lnode *new = (struct lnode *) malloc(sizeof(struct lnode));
      new->value = value;
      if ( lst->tail != NULL ) lst->tail->next = new;
      new->next = NULL;
      lst->tail = new;
      if ( lst->head == NULL ) lst->head = new;
}

struct lnode * list_find(lst, value)
    struct list *lst;
    int value;
{
    struct lnode *cur;
    for(cur=lst->head; cur != NULL; cur=cur->next) {
        if ( value == cur->value ) return cur;
    }
    return NULL;
}
EOF
;
}

