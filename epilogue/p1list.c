#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct p1list {
  int alloc;
  int length;
  char **items;
};

/* Constructor - lst = list() */
struct p1list * p1list_new() {
    struct p1list *p = malloc(sizeof(*p));
    p->length = 0;
    p->alloc = 2;
    p->items = malloc(p->alloc * sizeof(char *));
    return p;
}

/* Destructor - del(lst) */
void p1list_del(struct p1list* self) {
    int i;
    for(i=0; i< self->length; i++ ) {
        free(self->items[i]);
    }
    free((void *)self->items);
    free((void *)self);
}

/* print(lst) */
void p1list_print(struct p1list* self)
{
    int i;
    int first = 1;
    printf("[");
    for(i=0; i< self->length; i++ ) {
         if ( ! first ) printf(", ");
         printf("'%s'", self->items[i]);
         first = 0;
    }
    printf("]\n");
}

/* len(lst) */
int p1list_len(const struct p1list* self)
{
    return self->length;
}

/* lst.append("Hello world") */
void p1list_append(struct p1list* self, char *str) {
    
    // Extend if necessary
    if ( self->length >= self->alloc ) {
        printf("Extending from %d to %d\n", self->alloc, self->alloc + 10);
        self->alloc = self->alloc + 10;
        self->items = (char **) realloc(self->items, (self->alloc * sizeof(char *)));
    }

    char *saved = malloc(strlen(str)+1);
    strcpy(saved, str);
    self->items[self->length] = saved;
    self->length++;
}

/* lst.index("Hello world") - if not found -1 */
int p1list_index(struct p1list* self, char *str)
{
    int i;
    if ( str == NULL ) return -1;
    for(i=0; i< self->length; i++ ) {
        if ( strcmp(str, self->items[i]) == 0 ) return i;
    }
    return -1;
}

int main(void)
{
    struct p1list * lst = p1list_new();
    p1list_append(lst, "Hello world");
    p1list_print(lst);
    p1list_append(lst, "Catch phrase");
    p1list_print(lst);
    p1list_append(lst, "Brian");
    p1list_print(lst);
    printf("Length=%d\n", p1list_len(lst));
    printf("Brian? %d\n", p1list_index(lst, "Brian"));
    printf("Bob? %d\n", p1list_index(lst, "Bob"));
    p1list_del(lst);
}

// rm -f a.out ; gcc p1list.c; a.out ; rm -f a.out

