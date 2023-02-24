#include <stdio.h>
#include "pystr.c"
#include "pylist.c"

int main(void)
{
    printf("Testing pylist class\n");
    struct pylist * x = pylist_new();
    pylist_dump(x);
    pylist_append(x, "Hello world");
    pylist_dump(x);
    pylist_append(x, "Catch phrase");
    pylist_dump(x);
    pylist_del(x);
}

