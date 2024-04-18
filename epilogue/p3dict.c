#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct dnode {
    char *key;
    char *value;
};

/* Index will always be 2x the length of dnode - load factor 50% */
struct p3dict {
   int alloc;
   int length;
   struct dnode *items;
   int *index;
};

int getBucket(char *str, int buckets)
{
    unsigned int hash = 123456;
    if ( str == NULL ) return 0;
    for( ; *str ; str++) {
        hash = ( hash << 3 ) ^ *str;
    }
    return hash % buckets;
}

/* Constructor - dct = dict() */
struct p3dict * p3dict_new() {
    int i;
    struct p3dict *p = malloc(sizeof(*p));
    p->length = 0;
    p->alloc = 2;
    p->items = malloc(p->alloc * sizeof(struct dnode));
    p->index = malloc(p->alloc * 2 * sizeof(int));
    for(i=0; i < (p->alloc*2); i++ ) p->index[i] = -1;
    return p;
}

/* Destructor - del(dct) */
void p3dict_del(struct p3dict* self) {
    int i;
    for(i=0; i < self->length; i++) {
        free(self->items[i].key);
        free(self->items[i].value);
    }
    free((void *) self->items);
    free((void *) self->index);
    free((void *) self);
}

/* print(dct) */
/* {'z': 'W', 'y': 'B', 'c': 'C', 'a': 'D'} */
void p3dict_print(struct p3dict* self)
{
    int first = 1;
    int i, j;
    printf("{");
    for(i=0; i < self->length; i++) {
         if ( ! first ) printf(", ");
         printf("'%s': ", self->items[i].key);
         printf("'%s'", self->items[i].value);
         for(j=0; j < (self->alloc*2); j++) {
             if ( self->index[j] == i ) {
                 printf(" [%d]", j);
             }
         }
         first = 0;
    }
    printf("}\n");
}

int p3dict_len(const struct p3dict* self)
{
    return self->length;
}

/* find a node - used in get and put */
int p3dict_find(struct p3dict* self, char *key)
{
    int i, bucket, offset;
    bucket = getBucket(key, self->alloc);

    if ( key == NULL ) return -1;

    for(offset=0; offset < (self->alloc*2); offset++) {
        i = (offset + bucket) % (self->alloc*2);
        if ( self->index[i] == -1 ) return i;
        if ( strcmp(key, self->items[self->index[i]].key) == 0 ) return i;
    }

    return -1; // Bad news
}

/* x.get(key) - Returns NULL if not found */
char* p3dict_get(struct p3dict* self, char *key)
{
    int position = p3dict_find(self, key);
    if ( self->index[position] == -1 ) return NULL;
    return self->items[position].value;
}

/* x[key] = value; Insert or replace the value associated with a key */
void p3dict_put(struct p3dict* self, char *key, char *value) {

    int i, position;

    struct dnode node;

    char *new_key, *new_value;

    if ( key == NULL || value == NULL ) return;

    /* First look up */
    position = p3dict_find(self, key);
    if ( self->index[position] != -1 ) {
        node = self->items[self->index[position]];
        free(node.value);
        new_value = malloc(strlen(value)+1);
        strcpy(new_value, value);
        node.value = new_value;
        return;
    }

    /* Not found - time to insert */

    /* Extend if necessary */
    if ( self->length >= self->alloc ) {
        printf("Extending from %d to %d\n", self->alloc, self->alloc*2);

        self->alloc = self->alloc * 2;

        /* Extend items */
        self->items = realloc(self->items, self->alloc * sizeof(struct dnode));

        /* Rebuild empty index */
        free(self->index);
        self->index = malloc(self->alloc * 2 * sizeof(int));
        for(i=0; i < (self->alloc*2); i++ ) self->index[i] = -1;

        /* Refill index - tricky but clever */
        for(i=0; i < self->length; i++ ) {
            position = p3dict_find(self, self->items[i].key);
            self->index[position] = i;
        }
    }

    new_value = malloc(strlen(value)+1);
    strcpy(new_value, value);

    new_key = malloc(strlen(key)+1);
    strcpy(new_key, key);

    self->items[self->length].key = new_key;
    self->items[self->length].value = new_value;
    self->index[position] = self->length;

    self->length++;
}

int main(void)
{
    struct dnode * cur;
    struct p3dict * dct = p3dict_new();
    p3dict_print(dct);
    p3dict_put(dct, "z", "Catch phrase");
    p3dict_print(dct);
    p3dict_put(dct, "z", "W");
    p3dict_print(dct);
    p3dict_put(dct, "y", "B");
    p3dict_put(dct, "c", "C");
    p3dict_put(dct, "a", "D");
    p3dict_print(dct);
    printf("Length=%d\n", p3dict_len(dct));

    printf("z=%s\n", p3dict_get(dct, "z"));
    printf("x=%s\n", p3dict_get(dct, "x"));

    p3dict_del(dct);
}

// rm -f a.out ; gcc p3dict.c; a.out ; rm -f a.out


