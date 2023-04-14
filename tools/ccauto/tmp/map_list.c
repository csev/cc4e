#include <stdio.h>
#include <stdlib.h>
#include <string.h>

/*
 * This is our map entry for Map<String,Integer>
 *
 * The key is a string / character array which is allocated using malloc()
 * when a new entry is created.
 */
struct MapEntry {
    char *key;  /* public */
    int value;  /* public */
    struct MapEntry *__prev;
    struct MapEntry *__next;
};

/*
 * A MapIter contains the current item and whether this is a forward or
 * reverse iterator.
 */
struct MapIter {
   struct MapEntry *__current;
   int __reverse;

   struct MapEntry* (*next)(struct MapIter* self);
   void (*del)(struct MapIter* self);
};

/*
 * This is our Map class
 */
struct Map {
   /* Attributes */
   struct MapEntry *__head;
   struct MapEntry *__tail;
   int __count;

   /* Methods */
   void (*put)(struct Map* self, char *key, int value);
   int (*get)(struct Map* self, char *key, int def);
   int (*size)(struct Map* self);
   void (*dump)(struct Map* self);
   struct MapIter* (*iter)(struct Map* self);
   struct MapIter* (*last)(struct Map* self);
   void (*asort)(struct Map* self);
   void (*ksort)(struct Map* self);
   struct MapEntry* (*index)(struct Map* self, int position);
   void (*del)(struct Map* self);
};

/**
 * Destructor for the Map Class
 *
 * Loops through and frees all the keys and entries in the map.
 * The values are integers and so there is no need to free them.
 */
void __Map_del(struct Map* self) {
    struct MapEntry *cur, *next;
    cur = self->__head;
    while(cur) {
        free(cur->key);
        /* value is just part of the struct */
        next = cur->__next;
        free(cur);
        cur = next;
    }
    free((void *)self);
}

/**
 * Destructor for the MapIter Class
 */
void __MapIter_del(struct MapIter* self) {
    free((void *)self);
}

/**
 * map->dump - In effect a toString() except we print the contents of the Map to stdout
 *
 * self - The pointer to the instance of this class.
 */

void __Map_dump(struct Map* self)
{
    struct MapEntry *cur;
    printf("Object Map@%p count=%d\n", self, self->__count);
    for(cur = self->__head; cur != NULL ; cur = cur->__next ) {
         printf("  %s=%d\n", cur->key, cur->value);
    }
}

/**
 * map->find - Locate and return the entry with the matching key or NULL if there is no entry
 *
 * self - The pointer to the instance of this class.
 * key - A character pointer to the key value
 *
 * Returns a MapEntry or NULL.
 */
struct MapEntry* __Map_find(struct Map* self, char *key)
{
    struct MapEntry *cur;
    if ( self == NULL || key == NULL ) return NULL;
    for(cur = self->__head; cur != NULL ; cur = cur->__next ) {
        if(strcmp(key, cur->key) == 0 ) return cur;
    }
    return NULL;
}

/**
 * map->index - Locate and return the entry at the specified in the list
 *
 * self - The pointer to the instance of this class.
 * position - A zero-based position in the list
 *
 * Returns a MapEntry or NULL.
 */
struct MapEntry* __Map_index(struct Map* self, int position)
{
    int i;
    struct MapEntry *cur;
    if ( self == NULL ) return NULL;
    for(cur = self->__head, i=0; cur != NULL ; cur = cur->__next, i++ ) {
        if ( i >= position ) return cur;
    }
    return NULL;
}

/**
 * map->put - Add or update an entry in the Map
 *
 * self - The pointer to the instance of this class.
 * key - A character pointer to the key value
 * value - The value to be stored with the associated key
 *
 * If the key is not in the Map, an entry is added.  If there
 * is already an entry in the Map for the key, the value
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
void __Map_put(struct Map* self, char *key, int value) {

    struct MapEntry *old, *new;
    char *new_key;

    if ( key == NULL ) return;

    /* First look up */
    old = __Map_find(self, key);
    if ( old != NULL ) {
        old->value = value;
        return;
    }

    /* Not found - time to insert */
    new = malloc(sizeof(*new));
    new->__next = NULL;
    if ( self->__head == NULL ) self->__head = new;
    if ( self->__tail != NULL ) self->__tail->__next = new;
    new->__prev = self->__tail;
    self->__tail = new;

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
 * def - A default value to return if the key is not in the Map
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
int __Map_get(struct Map* self, char *key, int def)
{
    struct MapEntry *retval = __Map_find(self, key);
    if ( retval == NULL ) return def;
    return retval->value;
}

/**
 * map->size - Return the number of entries in the Map as an integer
 *
 * self - The pointer to the instance of this class.
 *
 * This medhod is like the Python len() function, but we name it
 * size() to pay homage to Java.
 */
int __Map_size(struct Map* self)
{
    return self->__count;
}

/**
 * MapIter_next - Advance the iterator forwards
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
struct MapEntry* __MapIter_next(struct MapIter* self)
{
    struct MapEntry * retval = self->__current;

    if ( retval == NULL) return NULL;
    if ( self->__reverse == 0 ) {
        self->__current = self->__current->__next;
    } else {
        self->__current = self->__current->__prev;
    }

    return retval;
}

/**
 * map->iter - Create an iterator from the head of the Map
 *
 * self - The pointer to the instance of this class.
 *
 * returns NULL when there are no entries in the Map
 *
 * This is inspired by the following Python code
 * that creates an iterator from a dictionary:
 *
 *     x = {'a': 1, 'b': 2, 'c': 3}
 *     it = iter(x)
 */
struct MapIter* __Map_iter(struct Map* self)
{
    struct MapIter *iter = malloc(sizeof(*iter));
    iter->__current = self->__head;
    iter->__reverse = 0;
    iter->next = &__MapIter_next;
    iter->del = &__MapIter_del;
    return iter;
}

/**
 * map->last - Start an iterator at the tail of the
 * Map and mark the iterator as "going backwards"
 *
 * self - The pointer to the instance of this class.
 *
 * returns NULL when there are no entries in the Map
 *
 * This is inspired by the following Python code:
 *
 *     x = {'a': 1, 'b': 2, 'c': 3}
 *     it = iter(reversed(x))
 */
struct MapIter* __Map_last(struct Map* self)
{
    struct MapIter *iter = malloc(sizeof(*iter));
    iter->__current = self->__tail;
    iter->__reverse = 1;
    iter->next = &__MapIter_next;
    iter->del = &__MapIter_del;
    return iter;
}

/**
 * __Map_swap - Swap the current MapEntry with the its successor in the Map
 *
 * self - The pointer to the instance of this class.
 * cur - A MapEntry in the Map
 *
 * This code must deal with cur being the first item in the Map
 * is the last item in the Map.
 */
void __Map_swap(struct Map* self, struct MapEntry* cur)
{

    struct MapEntry *prev, *next, *rest;

    /* Guardian pattern */
    if ( cur == NULL || cur->__next == NULL ) return;

    /* Grab these before we start changing things */
    next = cur->__next;
    prev = cur->__prev;
    rest = cur->__next->__next;

    if ( prev != NULL ) {
        prev->__next = next;
    } else {
        self->__head = next;
    }

    cur->__next = rest;
    cur->__prev = next;

    next->__next = cur;
    next->__prev = prev;

    if ( rest != NULL ) {
        rest->__prev = cur;
    } else {
        self->__tail = cur;
    }
}

/**
 * map->ksort - Sort the list so that the keys are low to high
 *
 * self - The pointer to the instance of this class.
 *
 * This code uses a lame, N-squared rock sort for simplicity.
 * The outer loop is a conunted loop that runs size() times.
 * The inner loop goes through the map comparing successive
 * elements and when a pair of elements is in the wrong order they
 * are swapped.  The inner loop in effect insures that the largest
 * value tumbles down to the bottom of the Map.  And if this inner
 * loop is done size() times we are assured that the Map is sorted.
 * Is one tiny optimization, if we get through the inner loop with
 * no swaps, we can exit the outer loop.
 *
 * The inspiration for the name of this routine comes from the PHP
 * ksort() function.
 */
void __Map_ksort(struct Map* self) {

    struct MapEntry *prev, *cur, *next, *rest;
    int i, swapped;

    if ( self->__head == NULL ) return;

    for (i=0; i<=self->__count; i++) {
        swapped = 0;
        for(cur = self->__head; cur != NULL ; cur = cur->__next ) {
            if ( cur->__next == NULL ) continue;  // Last item in the list
            // In order already
            if ( strcmp(cur->key, cur->__next->key) <= 0 ) continue;

            // printf("Flipping %s %s\n", cur->key, cur->next->key);
            __Map_swap(self, cur);
            swapped = 1;
        }
        // Stop early if nothing was swapped
        if ( swapped == 0 ) return;
    }
}

/**
 * map->asort - Sort the list so that the values are low to high
 *
 * self - The pointer to the instance of this class.
 *
 * This code uses a lame, N-squared rock sort for simplicity.
 * The outer loop is a conunted loop that runs size() times.
 * The inner loop goes through the map comparing successive
 * elements and when a pair of elements is in the wrong order they
 * are swapped.  The inner loop in effect insures that the largest
 * value tumbles down to the bottom of the Map.  And if this inner
 * loop is done size() times we are assured that the Map is sorted.
 a Is one tiny optimization, if we get through the inner loop with
 * no swaps, we can exit the outer loop.
 *
 * The inspiration for the name of this routine comes from the (poorly
 * named) PHP * asort() function.
 */
void __Map_asort(struct Map* self) {

    struct MapEntry *cur;
    int i;

    if ( self->__head == NULL ) return;

    for (i=0; i<=self->__count; i++) {
        for(cur = self->__head; cur != NULL ; cur = cur->__next ) {
            if ( cur->__next == NULL ) continue;  // Last item in the list
            // In order already
            if ( cur->value <= cur->__next->value ) continue;

            // printf("Flipping %d %d\n", cur->value, cur->__next->value);
            __Map_swap(self, cur);
        }
    }
}

/**
 * Constructor for the Map Class
 *
 * Initialized both the attributes and methods
 */
struct Map * Map_new() {
    struct Map *p = malloc(sizeof(*p));

    p->__head = NULL;
    p->__tail = NULL;
    p->__count = 0;

    p->put = &__Map_put;
    p->get = &__Map_get;
    p->size = &__Map_size;
    p->dump = &__Map_dump;
    p->iter = &__Map_iter;
    p->last = &__Map_last;
    p->asort = &__Map_asort;
    p->ksort = &__Map_ksort;
    p->index = &__Map_index;
    p->del = &__Map_del;
    return p;
}

/**
 * The main program to test and exercise the Map 
 * and MapEntry classes.
 */
int main(void)
{
    struct Map * map = Map_new();
    struct MapEntry *cur;
    struct MapIter *iter;

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

    printf("\nIterate backwards\n");
    iter = map->last(map);
    while(1) {
        cur = iter->next(iter);
        if ( cur == NULL ) break;
        printf(" %s=%d\n", cur->key, cur->value);
    }
    iter->del(iter);

    map->ksort(map);
    printf("\nSorted by key\n");
    map->dump(map);

    printf("\nSorted by value\n");
    map->asort(map);
    map->dump(map);

    cur = map->index(map, 0);
    printf("The smallest value is %s=%d\n", cur->key, cur->value);

    int pos = map->size(map) - 1;
    cur = map->index(map, pos);
    printf("The largest value is %s=%d\n", cur->key, cur->value);

    map->del(map);
}

// rm -f a.out ; gcc map_list.c; a.out ; rm -f a.out

