#include <stdio.h>
#include <stdlib.h>
#include <string.h>

/* This code is incomplete - it serves as the starting
 * point for the assigment */

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


int main(void)
{
    struct pylist * lst = pylist_new();
    pylist_append(lst, "Hello world");
    pylist_print(lst);
    pylist_append(lst, "Catch phrase");
    pylist_print(lst);
    pylist_append(lst, "Brian");
    pylist_print(lst);
    printf("Length = %d\n", pylist_len(lst));
    printf("Brian? %d\n", pylist_index(lst, "Brian"));
    printf("Bob? %d\n", pylist_index(lst, "Bob"));
    pylist_del(lst);
}

// rm -f a.out ; gcc cc_03_02.c; a.out ; rm -f a.out

