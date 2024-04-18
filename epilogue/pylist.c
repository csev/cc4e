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
    printf("]\n");
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

// rm -f a.out ; gcc pylist.c; a.out ; rm -f a.out

