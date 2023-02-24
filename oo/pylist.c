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
  struct lnode *current;
  int count;
};

/* Constructor */
struct pylist * pylist_new() {
    struct pylist *p = malloc(sizeof(*p));
    p->head = NULL;
    p->tail = NULL;
    p->current = NULL;
    p->count = 0;
    return p;
}

/* Destructor */
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

struct lnode* pylist_start(struct pylist* self)
{
    self->current = self->head;
    return self->current;
}

struct lnode* pylist_next(struct pylist* self)
{
    if ( self->current == NULL) return NULL;
    self->current = self->current->next;
    return self->current;
}


void pylist_dump(struct pylist* self)
{
    struct lnode *cur;
    printf("Object pylist@%p count=%d\n", self, self->count);
    for(cur = self->head; cur != NULL ; cur = cur->next ) {
         printf("  %s\n", cur->text);
    }
}

int pylist_len(const struct pylist* self)
{
    return self->count;
}

// x.append("Hello world")
struct pylist * pylist_append(struct pylist* self, char *str) {
    
    struct lnode *new = malloc(sizeof(*new));
    new->next = NULL;
    if ( self->head == NULL ) self->head = new;
    if ( self->tail != NULL ) self->tail->next = new;
    self->tail = new;

    char *text = malloc(strlen(str)+1);
    strcpy(text, str);
    new->text = text;

    self->count++;

    return self; // To allow chaining
}

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

