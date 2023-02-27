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
    You will write a set of fuctions to implement a linked list of integers.
    </p>
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
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

void list_add(lst, value)
    struct list *lst;
    int value;
{
}

EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
int main()
{
    struct list mylist;
    void list_add();

    mylist.head = NULL;
    mylist.tail = NULL;

    list_add(&mylist, 10);
    list_add(&mylist, 20);
    list_add(&mylist, 30);

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
bump() returns 0
bump() returns 1
bump() returns 2
bump() returns 42
bump() returns 43
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
EOF
;
}

