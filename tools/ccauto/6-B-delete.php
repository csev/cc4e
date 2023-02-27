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
    You will write a fuction list_add() to append an integer to the end of
    a linked list.  You will also write a function called list_delete() that
    will find and remove the node containing the integer value if it is in the list.
    The structure of the list and the node are already defined for you:
<pre>
struct lnode {
    int value;
    struct lnode *next;
};

struct list {
  struct lnode *head;
  struct lnode *tail;
};
</pre>
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

void list_remove(lst, value)
    struct list *lst;
    int value;
{
    /* Remove the value from the linked list. */
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

    list_remove(&mylist, 42);

    list_remove(&mylist, 10);
    list_dump(&mylist);

    list_remove(&mylist, 30);
    list_dump(&mylist);

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

Dump:
  20
  30

Dump:
  20

Dump:
  20
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

int list_remove(lst, value)
    struct list *lst;
    int value;
{
    struct lnode *cur;
    struct lnode *prev = NULL;
    for(cur=lst->head; cur != NULL; cur=cur->next) {
        if ( value == cur->value ) {
            if ( prev == NULL ) {
                lst->head = cur->next;
            } else {
                prev->next = cur->next;
                if ( cur->next == NULL) {
                    lst->tail = prev;
                }
            }
            free(cur);
            return 1;
        }
        prev = cur;
    }
    return 0;
}
EOF
;
}

