#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct dnode {
    char *key;
    char *value;
};

struct p1dict {
   int alloc;
   int length;
   struct dnode *items;
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
struct p1dict * p1dict_new() {
    int i;
    struct p1dict *p = malloc(sizeof(*p));
    p->length = 0;
    p->alloc = 2;
    p->items = malloc(p->alloc * sizeof(struct dnode));
    for(i=0; i < p->alloc; i++) {
        p->items[i].key = NULL;
        p->items[i].value = NULL;
    }
    return p;
}

/* Destructor - del(dct) */
void p1dict_del(struct p1dict* self) {
    int i;
    for(i=0; i < self->alloc; i++) {
        if ( self->items[i].key != NULL ) free(self->items[i].key);
        if ( self->items[i].value != NULL ) free(self->items[i].value);
    }
    free((void *) self->items);
    free((void *) self);
}

/* print(dct) */
/* {'z': 'W', 'y': 'B', 'c': 'C', 'a': 'D'} */
void p1dict_print(struct p1dict* self)
{
    int first = 1;
    int i;
    printf("{");
    for(i=0; i < self->alloc; i++) {
        if ( self->items[i].key == NULL ) continue;
        if ( ! first ) printf(", ");
        printf("'%s': ", self->items[i].key);
        printf("'%s'", self->items[i].value);
        first = 0;
        printf(" [%d]", i);
    }
    printf("} [%d, %d]\n", self->length, self->alloc);
}

int p1dict_len(const struct p1dict* self)
{
    return self->length;
}

/* find a node - used in get and put */
struct dnode *p1dict_find(struct p1dict* self, char *key)
{
    int i, bucket, offset;
    if ( key == NULL ) return NULL;
    bucket = getBucket(key, self->alloc);
    for(offset=0; offset < self->alloc; offset++) {
        i = (offset + bucket) % self->alloc;
        if ( self->items[i].key == NULL ) {
            return &(self->items[i]);
        }
        if(strcmp(key, self->items[i].key) == 0 ) {
            return &(self->items[i]);
        }
    }

    /* This should never happen as long as the resize is implemented */

    printf("Could not find slot for key %s\n", key);
    return NULL;
}

/* x.get(key) - Returns NULL if not found */
char* p1dict_get(struct p1dict* self, char *key)
{
    struct dnode *retval = p1dict_find(self, key);
    if ( retval == NULL || retval->key == NULL ) return NULL;
    return retval->value;
}

/* x[key] = value; Insert or replace the value associated with a key */
void p1dict_put(struct p1dict* self, char *key, char *value) {

    int i, old_alloc, bucket;
    struct dnode *old, *new_item, *old_items;

    if ( key == NULL || value == NULL ) return;

    /* First look up */
    old = p1dict_find(self, key);
    if ( old != NULL && old->key != NULL ) {
        free(old->value);
        old->value = malloc(strlen(value)+1);
        strcpy(old->value, value);
        return;
    }

    /* TODO: Check if we need to re-hash the items */
    if ( self->length >= (self->alloc*0.7) ) {
        printf("We are making space for %s\n", key);
        old_alloc = self->alloc;
        old_items = self->items;

        /* make new "empty items" */
        self->alloc = self->alloc * 2;
        self->items = malloc(self->alloc * sizeof(struct dnode));
        for(i=0; i < self->alloc; i++) {
            self->items[i].key = NULL;
            self->items[i].value = NULL;
        }

        /* We need to loop through old items and add them */
        for(i=0; i<old_alloc; i++) {
            if ( old_items[i].key == NULL ) continue;
            new_item = p1dict_find(self, old_items[i].key);
            if ( new_item == NULL || new_item->key != NULL ) {
                printf("Very bad news new_item=%p\n", new_item);
            }
            new_item->key = old_items[i].key;
            new_item->value = old_items[i].value;
        }
        free(old_items);
        old = p1dict_find(self, key);
        if ( old == NULL || old->key != NULL ) {
            printf("Very very bad news!!!!\n");
        }
    }

    /* Not found - time to insert */
    old->value = malloc(strlen(value)+1);
    strcpy(old->value, value);
    old->key =  malloc(strlen(key)+1);
    strcpy(old->key, key);

    self->length++;
}

int main(void)
{
    struct dnode * cur;
    struct p1dict * dct = p1dict_new();
    p1dict_print(dct);
    p1dict_put(dct, "z", "Catch phrase");
    p1dict_print(dct);
    p1dict_put(dct, "z", "W");
    p1dict_print(dct);
    p1dict_put(dct, "SAKAI", "B");
    p1dict_print(dct);
    p1dict_put(dct, "sally", "C");
    p1dict_print(dct);
    p1dict_put(dct, "a", "D");
    p1dict_print(dct);
    printf("Length=%d\n",p1dict_len(dct));

    printf("z=%s\n", p1dict_get(dct, "z"));
    printf("x=%s\n", p1dict_get(dct, "x"));

    /*
    printf("\nDump\n");
    for(cur = dct->head; cur != NULL ; cur = cur->next ) {
        printf("%s=%s\n", cur.key, cur.value);
    }
    */

    p1dict_del(dct);
}

// rm -f a.out ; gcc p1dict.c; a.out ; rm -f a.out


