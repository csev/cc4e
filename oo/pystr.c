#include <stdio.h>
#include <stdlib.h>

struct pystr
{
    int length;
    char *data;
    int alloc;
};

/* Constructor */
struct pystr * pystr_new() {
    struct pystr *p = malloc(sizeof(*p));
    p->length = 0;
    p->alloc = 10;
    p->data = malloc(10);
    p->data[0] = '\0';
    return p;
}

/* Destructor */
void pystr_del(const struct pystr* self) {
  free((void *)self->data);
  free((void *)self);
}

void pystr_dump(const struct pystr* self)
{
    printf("Object pystr@%p length=%d alloc=%d data=%p data=%s\n",
            self, self->length, self->alloc, self->data, self->data);
}

int pystr_len(const struct pystr* self)
{
    return self->length;
}

char *pystr_str(const struct pystr* self)
{
    return self->data;
}

// x = x + 'h';
struct pystr * pystr_append(struct pystr* self, char ch) {
    // If we don't have space for 1 character plus termination, allocate 10 more
    if ( self->length >= (self->alloc - 2) ) {
        self->alloc = self->alloc + 10;
        self->data = (char *) realloc(self->data, self->alloc);
    }

    // Add our character to the end and terminate
    self->data[self->length] = ch;
    self->length = self->length + 1;    
    self->data[self->length] = '\0';

    return self; // To allow chaining
}

// x = x + "hello";
struct pystr * pystr_appends(struct pystr* self, char *str) {
    for(char* s = str; *s; s++) pystr_append(self, *s);
    return self;
}

// x = "hello";
struct pystr * pystr_assign(struct pystr* self, char *str) {
    self->length = 0;
    self->data[0] = '\0';
    pystr_appends(self, str);
    return self;
}

