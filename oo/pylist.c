#include <stdio.h>
#include <stdlib.h>


struct lnode {
    struct pystr *text;
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
  // free((void *)self->data);
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
    struct lnode *i;
    printf("Object pylist@%p count=%d\n", self, self->count);
    for(i = pylist_start(self); i != NULL ; i = pylist_next(self) ) {
         struct pystr *line = i->text;
         printf("  %s\n", pystr_str(line));
    }
}

int pylist_len(const struct pylist* self)
{
    return self->count;
}

// x = x + "Hello world"
struct pylist * pylist_append(struct pylist* self, char *str) {
    
    struct lnode *new = malloc(sizeof(*new));
    new->next = NULL;
    if ( self->head == NULL ) self->head = new;
    if ( self->tail != NULL ) self->tail->next = new;
    self->tail = new;

    struct pystr * x = pystr_new();
    pystr_assign(x, str);
    new->text = x;

    self->count++;

    return self; // To allow chaining
}

