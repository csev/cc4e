#include <stdio.h>
#include <stdlib.h>

struct krstr
{
    int length;
    int alloc; /* the length of *data */
    char *data;
};

/* Constructor - x = str() */
struct krstr * krstr_new() {
    struct krstr *p = malloc(sizeof(*p));
    p->length = 0;
    p->alloc = 10;
    p->data = malloc(10);
    p->data[0] = '\0';
    return p;
}

/* Destructor - del(x) */
void krstr_del(const struct krstr* self) {
    free((void *)self->data); /* free string first */
    free((void *)self);
}

void krstr_dump(const struct krstr* self)
{
    printf("Pystr length=%d alloc=%d data=%s\n",
            self->length, self->alloc, self->data);
}

int krstr_len(const struct krstr* self)
{
    return self->length;
}

char *krstr_str(const struct krstr* self)
{
    return self->data;
}

/* x = x + 'h'; */
void krstr_append(struct krstr* self, char ch) {
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

/* x = x + "hello"; */
void krstr_appends(struct krstr* self, char *str) {
    char * s;
    for(s = str; *s; s++) krstr_append(self, *s);
}

/* x = "hello"; */
void krstr_assign(struct krstr* self, char *str) {
    self->length = 0;
    self->data[0] = '\0';
    krstr_appends(self, str);
}

int main(void)
{
    struct krstr * x = krstr_new();
    krstr_dump(x);

    krstr_append(x, 'H');
    krstr_dump(x);

    krstr_appends(x, "ello world");
    krstr_dump(x);

    krstr_assign(x, "A completely new string");
    printf("String = %s\n", krstr_str(x));
    printf("Length = %d\n", krstr_len(x));
    krstr_del(x);
}

// rm -f a.out ; gcc krstr.c; a.out ; rm -f a.out
