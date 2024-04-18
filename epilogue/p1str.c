#include <stdio.h>
#include <stdlib.h>

struct p1str
{
    int length;
    int alloc; /* the length of *data */
    int refs;
    char *data;
};

/* Constructor - x = str() */
struct p1str * p1str_new() {
    struct p1str *p = malloc(sizeof(*p));
    p->length = 0;
    p->alloc = 10;
    p->data = malloc(10);
    p->data[0] = '\0';
    p->refs = 1;
    return p;
}

/* Destructor - del(x) */
void p1str_del(struct p1str* self) {
    if ( self->refs > 1 ) {
        printf("Decrementing reference %p\n",(void *)self);
        (self->refs)--;
        return;
    }
    printf("Freeing reference %p\n",(void *)self);
    free((void *)self->data); /* free string first */
    free((void *)self);
}

void p1str_dump(const struct p1str* self)
{
    printf("Pystr length=%d alloc=%d data=%s\n",
            self->length, self->alloc, self->data);
}

int p1str_len(const struct p1str* self)
{
    return self->length;
}

char *p1str_str(const struct p1str* self)
{
    return self->data;
}

/* x = x + 'h' */
void p1str_append(struct p1str* self, char ch) {
    /* If we don't have space for 1 character plus
       termination, allocate 10 more */

    if ( self->length >= (self->alloc - 2) ) {
        self->alloc = self->alloc + 10;
        self->data = (char *) realloc(self->data, self->alloc);
    }

    /* Add our character to the end and terminate */
    self->data[self->length] = ch;
    self->length = self->length + 1;    
    self->data[self->length] = '\0';
}

/* x = x + "hello" */
void p1str_appends(struct p1str* self, char *str) {
    char * s;
    for(s = str; *s; s++) p1str_append(self, *s);
}

/* x = "hello" */
void p1str_set(struct p1str* self, char *str) {
    self->length = 0;
    self->data[0] = '\0';
    p1str_appends(self, str);
}

/* y = x */
struct p1str *p1str_assign(struct p1str* self) {
    (self->refs)++;
    return self;
}

int main(void)
{
    struct p1str * x = p1str_new();
    printf("String x = %s @ %p\n", p1str_str(x), (void *) x);
    p1str_dump(x);

    p1str_append(x, 'H');
    p1str_dump(x);

    p1str_appends(x, "ello world");
    p1str_dump(x);

    p1str_set(x, "A completely new string");
    printf("String %s\n", p1str_str(x));
    printf("Length=%d\n", p1str_len(x));

    struct p1str * y = p1str_assign(x);
    printf("String x=%s @ %p\n", p1str_str(x), (void *) x);
    printf("String y=%s @ %p\n", p1str_str(y), (void *) y);
    p1str_del(x);
    printf("String y=%s @ %p\n", p1str_str(y), (void *) y);
    p1str_del(y);
}

// rm -f a.out ; gcc p1str.c; a.out ; rm -f a.out
