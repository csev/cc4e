#include <stdio.h>
#include <stdlib.h>
#include <string.h>

/*
 * This is our map entry for TreeMap<String,Integer>
 *
 * The key is a string / character array which is allocated using malloc()
 * when a new entry is created.
 */
struct TreeMapEntry {
    char *key;  /* public */
    int value;  /* public */
    struct TreeMapEntry *__next;
    struct TreeMapEntry *__left;
    struct TreeMapEntry *__right;
};

/*
 * A TreeMapIter contains the current item.
 */
struct TreeMapIter {
   struct TreeMapEntry *__current;

   struct TreeMapEntry* (*next)(struct TreeMapIter* self);
   void (*del)(struct TreeMapIter* self);
};

/*
 * This is our TreeMap class
 */
struct TreeMap {
   /* Attributes */
   struct TreeMapEntry *__head;
   struct TreeMapEntry *__root;
   int __count;

   /* Methods */
   void (*put)(struct TreeMap* self, char *key, int value);
   int (*get)(struct TreeMap* self, char *key, int def);
   int (*size)(struct TreeMap* self);
   void (*dump)(struct TreeMap* self);
   struct TreeMapIter* (*iter)(struct TreeMap* self);
   void (*del)(struct TreeMap* self);
};

/**
 * Destructor for the TreeMap Class
 *
 * Loops through and frees all the keys and entries in the map.
 * The values are integers and so there is no need to free them.
 */
void __TreeMap_del(struct TreeMap* self) {
    struct TreeMapEntry *cur, *next;
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
 * Destructor for the TreeMapIter Class
 */
void __TreeMapIter_del(struct TreeMapIter* self) {
    free((void *)self);
}

/**
 * __TreeMap_dump_tree - traverse and print the tree
 */
void __TreeMap_dump_tree(struct TreeMapEntry *cur, int depth)
{
    if ( cur == NULL ) return;
    for(int i=0;i<depth;i++) printf("| ");
    printf("%s=%d\n", cur->key, cur->value);
    if ( cur->__left != NULL ) {
        __TreeMap_dump_tree(cur->__left, depth+1);
    }
    if ( cur->__right != NULL ) {
        __TreeMap_dump_tree(cur->__right, depth+1);
    }
}

/**
 * map->dump - In effect a toString() except we print the contents of the TreeMap to stdout
 *
 * self - The pointer to the instance of this class.
 */
void __TreeMap_dump(struct TreeMap* self)
{
    struct TreeMapEntry *cur;
    printf("Object TreeMap@%p count=%d\n", self, self->__count);
    for(cur = self->__head; cur != NULL ; cur = cur->__next ) {
         printf("  %s=%d\n", cur->key, cur->value);
    }
    printf("\n");

    // Recursively print the tree view
    __TreeMap_dump_tree(self->__root, 0);
    printf("\n");
}

/**
 * map->put - Add or update an entry in the TreeMap
 *
 * self - The pointer to the instance of this class.
 * key - A character pointer to the key value
 * value - The value to be stored with the associated key
 *
 * If the key is not in the TreeMap, an entry is added.  If there
 * is already an entry in the TreeMap for the key, the value
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
void __TreeMap_put(struct TreeMap* self, char *key, int value) {

    struct TreeMapEntry *cur, *left, *right;
    int cmp;
    struct TreeMapEntry *old, *new;
    char *new_key;

    if ( key == NULL ) return;

    cur = self->__root;
    left = NULL;
    right = NULL;
    while(cur != NULL ) {
        cmp = strcmp(key, cur->key);
        if(cmp == 0 ) {
            cur->value = value;
            return;
        }
        if( cmp < 0 ) {
            right = cur;
            cur = cur->__left;
        } else {
            left = cur;
            cur = cur->__right;
        }
    }

    /* Not found - time to insert into the linked list after old */
    new = malloc(sizeof(*new));
    new->__next = NULL;
    new->__left = NULL;
    new->__right = NULL;
    new_key = malloc(strlen(key)+1);
    strcpy(new_key, key);
    new->key = new_key;
    new->value = value;
    self->__count++;

    // Empty list - add first entry
    if ( self->__head == NULL ) {
        self->__head = new;
        self->__root = new;
        return;
    }

    printf("%s < %s > %s\n", (left ? left->key : "0"),
            key, (right ? right->key : "0") );

    // Insert into the sorted linked list
    if ( left != NULL ) {
        if ( left->__next != right ) {
            printf("FAIL left->__next != right\n");
        }
        new->__next = right;
        left->__next = new;
    } else {
        if ( self->__head != right ) {
            printf("FAIL self->__head != right\n");
        }
        new->__next = self->__head;
        self->__head = new;
    }

    // Insert into the tree
    if ( right != NULL && right->__left == NULL ) {
        right->__left = new;
    } else if ( left != NULL && left->__right == NULL ) {
        left->__right = new;
    } else {
        printf("FAIL Neither right->__left nor left->__right are available\n");
    }

}

/**
 * map->get - Locate and return the value for the corresponding key or a default value
 *
 * self - The pointer to the instance of this class.
 * key - A character pointer to the key value
 * def - A default value to return if the key is not in the TreeMap
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
int __TreeMap_get(struct TreeMap* self, char *key, int def)
{
    int cmp;
    struct TreeMapEntry *cur;

    if ( self == NULL || key == NULL || self->__root == NULL ) return def;

    cur = self->__root;
    while(cur != NULL ) {
        cmp = strcmp(key, cur->key);
        if(cmp == 0 ) return cur->value;
        else if(cmp < 0 ) cur = cur->__left;
        else cur = cur->__right;

    }
    return def;
}

/**
 * map->size - Return the number of entries in the TreeMap as an integer
 *
 * self - The pointer to the instance of this class.
 *
 * This medhod is like the Python len() function, but we name it
 * size() to pay homage to Java.
 */
int __TreeMap_size(struct TreeMap* self)
{
    return self->__count;
}

/**
 * TreeMapIter_next - Advance the iterator forwards
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
struct TreeMapEntry* __TreeMapIter_next(struct TreeMapIter* self)
{
    struct TreeMapEntry* retval;
    if ( self->__current == NULL) return NULL;
    retval = self->__current;
    self->__current = self->__current->__next;
    return retval;
}

/**
 * map->iter - Create an iterator from the head of the TreeMap 
 *
 * self - The pointer to the instance of this class.
 *
 * returns NULL when there are no entries in the TreeMap
 *
 * This is inspired by the following Python code
 * that creates an iterator from a dictionary:
 *
 *     x = {'a': 1, 'b': 2, 'c': 3}
 *     it = iter(x)
 */
struct TreeMapIter* __TreeMap_iter(struct TreeMap* self)
{
    struct TreeMapIter *iter = malloc(sizeof(*iter));
    iter->__current = self->__head;
    iter->next = &__TreeMapIter_next;
    iter->del = &__TreeMapIter_del;
    return iter;
}

/**
 * Constructor for the TreeMap Class
 *
 * Initialized both the attributes and methods
 */
struct TreeMap * TreeMap_new() {
    struct TreeMap *p = malloc(sizeof(*p));

    p->__head = NULL;
    p->__root = NULL;
    p->__count = 0;

    p->put = &__TreeMap_put;
    p->get = &__TreeMap_get;
    p->size = &__TreeMap_size;
    p->dump = &__TreeMap_dump;
    p->iter = &__TreeMap_iter;
    p->del = &__TreeMap_del;
    return p;
}
