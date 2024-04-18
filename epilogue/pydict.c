#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct dnode {
    char *key;
    int value;
    struct dnode *prev;
    struct dnode *next;
};

struct dict {
    int buckets;
    struct dnode *heads[4];
    struct dnode *tails[4];
    int count;
};

void dict_del(struct dict* self)
{
    int i;
    struct dnode *cur, *next;

    for(i=0; i<self->buckets; i++) {
        cur = self->heads[i];
        while(cur) {
            free(cur->key);
            /* value is just part of the struct */
            next = cur->next;
            free(cur);
            cur = next;
        }
    }
    free((void *)self);
}

/** getBucket - Compute a dict bucket from a string */
int getBucket(char *str, int buckets)
{
    int dict = 42;
    if ( str == NULL ) return 0;
    for( ; *str ; str++) {
        dict = ( dict << 3 ) ^ *str;
    }
    return dict % buckets;
}

void dict_dump(struct dict* self)
{
    int i;
    struct dnode *cur;
    printf("Object dict@%p count=%d buckets=%d\n", self, self->count, self->buckets);
    for(i = 0; i < self->buckets; i++ ) {
        for(cur = self->heads[i]; cur != NULL ; cur = cur->next ) {
            printf(" %s=%d [%d]\n", cur->key, cur->value, i);
        }
    }
}

struct dnode* dict_find(struct dict* self, char *key, int bucket)
{
    struct dnode *cur;
    if ( self == NULL || key == NULL ) return NULL;
    for(cur = self->heads[bucket]; cur != NULL ; cur = cur->next ) {
        if(strcmp(key, cur->key) == 0 ) return cur;
    }
    return NULL;
}

void dict_put(struct dict* self, char *key, int value) {

    int bucket;
    struct dnode *old, *new;
    char *new_key;

    if ( key == NULL ) return;

    /* First look up */
    bucket = getBucket(key, self->buckets);
    old = dict_find(self, key, bucket);
    if ( old != NULL ) {
        old->value = value;
        return;
    }

    /* Not found - time to insert */
    new = malloc(sizeof(*new));
    new->next = NULL;

    if ( self->heads[bucket] == NULL ) self->heads[bucket] = new;
    if ( self->tails[bucket] != NULL ) self->tails[bucket]->next = new;
    new->prev = self->tails[bucket];
    self->tails[bucket] = new;

    new_key = malloc(strlen(key)+1);
    strcpy(new_key, key);
    new->key = new_key;

    new->value = value;

    self->count++;
}

int dict_get(struct dict* self, char *key, int def)
{
    int bucket = getBucket(key, self->buckets);
    struct dnode *retval = dict_find(self, key, bucket);
    if ( retval == NULL ) return def;
    return retval->value;
}

int dict_size(struct dict* self)
{
    return self->count;
}

struct dict * dict_new() {
    struct dict *p = malloc(sizeof(*p));

    p->buckets = 4;
    for(int i=0; i < p->buckets; i++ ) {
        p->heads[i] = NULL;
        p->tails[i] = NULL;
    }

    p->count = 0;
    return p;
}

int main(void)
{
    struct dict * d = dict_new();
    struct dnode *cur;

    dict_put(d, "z", 8);
    dict_put(d, "z", 1);
    dict_put(d, "y", 2);
    dict_put(d, "b", 3);
    dict_put(d, "a", 4);
    dict_dump(d);

    printf("z=%d\n", dict_get(d, "z", 42));
    printf("x=%d\n", dict_get(d, "x", 42));

    dict_del(d);
}

// rm -f a.out ; gcc pydict.c; a.out ; rm -f a.out


