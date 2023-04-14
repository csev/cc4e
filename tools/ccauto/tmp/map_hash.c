#include <stdio.h>
#include <stdlib.h>
#include <string.h>

/*
 * This is our map entry for HashMap<String,Integer>
 *
 * The key is a string / character array which is allocated using malloc()
 * when a new entry is created.
 */
struct HashMapEntry {
    char *key;  /* public */
    int value;  /* public */
    struct HashMapEntry *__prev;
    struct HashMapEntry *__next;
};

/*
 * A HashMapIter contains the current item
 */
struct HashMapIter {
    int __bucket;
    struct HashMap *__map;
    struct HashMapEntry *__current;

    struct HashMapEntry* (*next)(struct HashMapIter* self);
    void (*del)(struct HashMapIter* self);
};

/*
 * This is our HashMap class
 */
struct HashMap {
    /* Attributes */
    int __buckets;
    struct HashMapEntry *__heads[8];
    struct HashMapEntry *__tails[8];
    int __count;

    /* Methods */
    void (*put)(struct HashMap* self, char *key, int value);
    int (*get)(struct HashMap* self, char *key, int def);
    int (*size)(struct HashMap* self);
    void (*dump)(struct HashMap* self);
    struct HashMapIter* (*iter)(struct HashMap* self);
    void (*del)(struct HashMap* self);
};

/**
 * Destructor for the HashMap Class
 *
 * Loops through and frees all the keys and entries in the map.
 * The values are integers and so there is no need to free them.
 */
void __HashMap_del(struct HashMap* self)
{
    int i;
    struct HashMapEntry *cur, *next;

    for(i=0; i<self->__buckets; i++) {
        cur = self->__heads[i];
        while(cur) {
            free(cur->key);
            /* value is just part of the struct */
            next = cur->__next;
            free(cur);
            cur = next;
        }
    }
    free((void *)self);
}

/**
 * Destructor for the HashMapIter Class
 */
void __HashMapIter_del(struct HashMapIter* self) {
    free((void *)self);
}

/** getBucket - Compute a hash bucket from a string */
int getBucket(char *str, int buckets)
{
    int hash = 42;
    if ( str == NULL ) return 0;
    for( ; *str ; str++) {
        hash = ( hash << 3 ) ^ *str;
    }
    return hash % buckets;
}

/**
 * map->dump - In effect a toString() except we print the contents of the HashMap to stdout
 *
 * self - The pointer to the instance of this class.
 */

void __HashMap_dump(struct HashMap* self)
{
    int i;
    struct HashMapEntry *cur;
    printf("Object HashHashMap@%p count=%d buckets=%d\n", self, self->__count, self->__buckets);
    for(i = 0; i < self->__buckets; i++ ) {
        for(cur = self->__heads[i]; cur != NULL ; cur = cur->__next ) {
            printf(" %s=%d [%d]\n", cur->key, cur->value, i);
        }
    }
}

/**
 * map->find - Locate and return the entry with the matching key or NULL if there is no entry
 *
 * self - The pointer to the instance of this class.
 * key - A character pointer to the key value
 * bucket - The hash bucket
 *
 * Returns a HashMapEntry or NULL.
 */
struct HashMapEntry* __HashMap_find(struct HashMap* self, char *key, int bucket)
{
    struct HashMapEntry *cur;
    if ( self == NULL || key == NULL ) return NULL;
    for(cur = self->__heads[bucket]; cur != NULL ; cur = cur->__next ) {
        if(strcmp(key, cur->key) == 0 ) return cur;
    }
    return NULL;
}

/**
 * map->put - Add or update an entry in the HashMap
 *
 * self - The pointer to the instance of this class.
 * key - A character pointer to the key value
 * value - The value to be stored with the associated key
 *
 * If the key is not in the HashMap, an entry is added.  If there
 * is already an entry in the HashMap for the key, the value
 * is updated.
 *
 * Sample call:
 *
 *    map->put(map, "x", 42);
 *
 * This method takes inspiration from the Python code:
 *
 *   map["key"] = value
 */
void __HashMap_put(struct HashMap* self, char *key, int value) {

    int bucket;
    struct HashMapEntry *old, *new;
    char *new_key;

    if ( key == NULL ) return;

    /* First look up */
    bucket = getBucket(key, self->__buckets);
    old = __HashMap_find(self, key, bucket);
    if ( old != NULL ) {
        old->value = value;
        return;
    }

    /* Not found - time to insert */
    new = malloc(sizeof(*new));
    new->__next = NULL;

    if ( self->__heads[bucket] == NULL ) self->__heads[bucket] = new;
    if ( self->__tails[bucket] != NULL ) self->__tails[bucket]->__next = new;
    new->__prev = self->__tails[bucket];
    self->__tails[bucket] = new;

    new_key = malloc(strlen(key)+1);
    strcpy(new_key, key);
    new->key = new_key;

    new->value = value;

    self->__count++;
}

/**
 * map->get - Locate and return the value for the corresponding key or a default value
 *
 * self - The pointer to the instance of this class.
 * key - A character pointer to the key value
 * def - A default value to return if the key is not in the HashMap
 *
 * Returns an integer
 *
 * Sample call:
 * 
 * int ret = map->get(map, "z", 42);
 *
 * This method takes inspiration from the Python code:
 *
 *   value = map.get("key", 42)
 */
int __HashMap_get(struct HashMap* self, char *key, int def)
{
    int bucket = getBucket(key, self->__buckets);
    struct HashMapEntry *retval = __HashMap_find(self, key, bucket);
    if ( retval == NULL ) return def;
    return retval->value;
}

/**
 * map->size - Return the number of entries in the HashMap as an integer
 *
 * self - The pointer to the instance of this class.
 *
 * This medhod is like the Python len() function, but we name it
 * size() to pay homage to Java.
 */
int __HashMap_size(struct HashMap* self)
{
    return self->__count;
}

/**
 * HashMapIter_next - Advance the iterator forwards
 * or backwards and return the next item
 *
 * self - The pointer to the instance of this class.
 *
 * returns NULL when there are no more entries
 *
 * This is inspired by the following Python code:
 *
 *   item = next(iterator, False)
 */
struct HashMapEntry* __HashMapIter_next(struct HashMapIter* self)
{
    struct HashMapEntry* retval;

    // self->__current is the next item, so we grab it
    // to return it and *then* advance the pointer
    if ( self->__current != NULL ) {
        retval = self->__current;
        self->__current = self->__current->__next;
        if ( retval != NULL ) return retval;
    }

    // We might be at the end of a chain so advance the bucket until 
    // we find a non-empty bucket
    while ( self->__current == NULL) {
        if ( self->__bucket >= self->__map->__buckets ) return NULL;
        self->__bucket++;
        self->__current = self->__map->__heads[self->__bucket];
    }
    retval = self->__current;
    self->__current = self->__current->__next;
    return retval;
}

/**
 * map->iter - Create an iterator from the head of the HashMap 
 *
 * self - The pointer to the instance of this class.
 *
 * returns NULL when there are no entries in the HashMap
 *
 * This is inspired by the following Python code
 * that creates an iterator from a dictionary:
 *
 *     x = {'a': 1, 'b': 2, 'c': 3}
 *     it = iter(x)
 */
struct HashMapIter* __HashMap_iter(struct HashMap* map)
{
    struct HashMapIter *iter = malloc(sizeof(*iter));
    iter->__map = map;
    iter->__bucket = 0;
    iter->__current = map->__heads[iter->__bucket];
    iter->next = &__HashMapIter_next;
    iter->del = &__HashMapIter_del;
    return iter;
}

/**
 * Constructor for the HashMap Class
 *
 * Initialized both the attributes and methods
 */
struct HashMap * HashMap_new() {
    struct HashMap *p = malloc(sizeof(*p));

    p->__buckets = 8;
    for(int i=0; i < p->__buckets; i++ ) {
        p->__heads[i] = NULL;
        p->__tails[i] = NULL;
    }

    p->__count = 0;

    p->put = &__HashMap_put;
    p->get = &__HashMap_get;
    p->size = &__HashMap_size;
    p->dump = &__HashMap_dump;
    p->iter = &__HashMap_iter;
    p->del = &__HashMap_del;
    return p;
}

/**
 * The main program to test and exercise the HashMap 
 * and HashMapEntry classes.
 */
int main(void)
{
    struct HashMap * map = HashMap_new();
    struct HashMapEntry *cur;
    struct HashMapIter *iter;

    map->put(map, "z", 8);
    map->put(map, "z", 1);
    map->put(map, "y", 2);
    map->put(map, "b", 3);
    map->put(map, "a", 4);
    map->dump(map);

    printf("z=%d\n", map->get(map, "z", 42));
    printf("x=%d\n", map->get(map, "x", 42));

    printf("\nIterate forwards\n");
    iter = map->iter(map);
    while(1) {
        cur = iter->next(iter);
        if ( cur == NULL ) break;
        printf(" %s=%d\n", cur->key, cur->value);
    }
    iter->del(iter);

    map->del(map);
}

// rm -f a.out ; gcc map_hash.c; a.out ; rm -f a.out

