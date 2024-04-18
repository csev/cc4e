#include <stdio.h>
#include <stdlib.h>

struct pystr
{
    int length;
    int alloc; /* the length of *data */
    char *data;
};

/* Constructor - x = str() */
struct pystr * pystr_new() {
    struct pystr *p = malloc(sizeof(*p));
    p->length = 0;
    p->alloc = 10;
    p->data = malloc(10);
    p->data[0] = '\0';
    return p;
}

/* Destructor - del(x) */
void pystr_del(const struct pystr* self) {
    free((void *)self->data); /* free string first */
    free((void *)self);
}

void pystr_dump(const struct pystr* self)
{
    printf("Pystr length=%d alloc=%d data=%s\n",
            self->length, self->alloc, self->data);
}

int pystr_len(const struct pystr* self)
{
    return self->length;
}

char *pystr_str(const struct pystr* self)
{
    return self->data;
}

/* x = x + 'h'; */
void pystr_append(struct pystr* self, char ch) {
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
void pystr_appends(struct pystr* self, char *str) {
    char * s;
    for(s = str; *s; s++) pystr_append(self, *s);
}

/* x = "hello"; */
void pystr_assign(struct pystr* self, char *str) {
    self->length = 0;
    self->data[0] = '\0';
    pystr_appends(self, str);
}

int main(void)
{
    struct pystr * x = pystr_new();
    pystr_dump(x);

    pystr_append(x, 'H');
    pystr_dump(x);

    pystr_appends(x, "ello world");
    pystr_dump(x);

    pystr_assign(x, "A completely new string");
    printf("String = %s\n", pystr_str(x));
    printf("Length = %d\n", pystr_len(x));
    pystr_del(x);
}

// rm -f a.out ; gcc pystr.c; a.out ; rm -f a.out
