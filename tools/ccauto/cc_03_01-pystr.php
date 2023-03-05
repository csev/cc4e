<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Python String Class</b> 
<p>
    You will a set of supporting functions using the following structure
    to implement a subset of the Python str class in C.  Some code and
    method signatures have been prodived for you as well as a main() program.
<pre>
struct pystr
{
    int length;
    int alloc; /* the length of *data */
    char *data;
};
</pre>
</p>
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
void yada() {
 printf("Yada\\n");
}
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
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
    p->data[0] = '\\0';
    return p;
}

/* Destructor - del(x) */
void pystr_del(const struct pystr* self) {
  free((void *)self->data); /* free string first */
  free((void *)self);
}

void pystr_dump(const struct pystr* self)
{
    printf("Object pystr@%p length=%d alloc=%d data=%p data=%s\\n",
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
    self->data[self->length] = '\\0';
}

/* x = x + "hello"; */
void pystr_appends(struct pystr* self, char *str) {
    char *s;
    for(s = str; *s; s++) pystr_append(self, *s);
}

/* x = "hello"; */
void pystr_assign(struct pystr* self, char *str) {
    self->length = 0;
    self->data[0] = '\\0';
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
    printf("String = %s\\n", pystr_str(x));
    printf("Length = %d\\n", pystr_len(x));
    pystr_del(x);
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
Dump:
  10
  20
  30
Did not find 42
Found 30

Dump:
  10
  20
  30
  40
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        // array("main", "Don't include the main() code - the main() code is provided automatically by the autograder."),
        // array("extern", "You should not use the 'extern' keyword."),
        // array("[", "You do not need to use any arrays []."),
        // array("]", "You do not need to use any arrays []."),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        // array("malloc", "You need to use malloc() to allocate some memory."),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
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
    p->data[0] = '\\0';
    return p;
}

/* Destructor - del(x) */
void pystr_del(const struct pystr* self) {
  free((void *)self->data); /* free string first */
  free((void *)self);
}

void pystr_dump(const struct pystr* self)
{
    printf("Object pystr@%p length=%d alloc=%d data=%p data=%s\\n",
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
    self->data[self->length] = '\\0';
}

/* x = x + "hello"; */
void pystr_appends(struct pystr* self, char *str) {
    char *s;
    for(s = str; *s; s++) pystr_append(self, *s);
}

/* x = "hello"; */
void pystr_assign(struct pystr* self, char *str) {
    self->length = 0;
    self->data[0] = '\\0';
    pystr_appends(self, str);
}

int main()
{
    struct pystr * x = pystr_new();
    pystr_dump(x);

    pystr_append(x, 'H');
    pystr_dump(x);

    pystr_appends(x, "ello world");
    pystr_dump(x);

    pystr_assign(x, "A completely new string");
    printf("String = %s\\n", pystr_str(x));
    printf("Length = %d\\n", pystr_len(x));
    pystr_del(x);
}

// rm -f a.out ; gcc pystr.c; a.out ; rm -f a.out
EOF
;
}

