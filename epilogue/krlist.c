#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct lnode {
    char *text;
    struct lnode *next;
};

struct krlist {
  struct lnode *head;
  struct lnode *tail;
  int count;
};

/* Constructor - lst = list() */
struct krlist * krlist_new() {
    struct krlist *p = malloc(sizeof(*p));
    p->head = NULL;
    p->tail = NULL;
    p->count = 0;
    return p;
}

/* Destructor - del(lst) */
void krlist_del(struct krlist* self) {
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
void krlist_print(struct krlist* self)
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
int krlist_len(const struct krlist* self)
{
    return self->count;
}

/* lst.append("Hello world") */
void krlist_append(struct krlist* self, char *str) {
    
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
int krlist_index(struct krlist* self, char *str)
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
    struct krlist * lst = krlist_new();
    krlist_append(lst, "Hello world");
    krlist_print(lst);
    krlist_append(lst, "Catch phrase");
    krlist_print(lst);
    krlist_append(lst, "Brian");
    krlist_print(lst);
    printf("Length = %d\n", krlist_len(lst));
    printf("Brian? %d\n", krlist_index(lst, "Brian"));
    printf("Bob? %d\n", krlist_index(lst, "Bob"));
    krlist_del(lst);
}

// rm -f a.out ; gcc krlist.c; a.out ; rm -f a.out

